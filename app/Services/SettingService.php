<?php

namespace App\Services;

use App\Models\Account;
use App\Models\Biller;
use App\Models\Currency;
use App\Models\Customer;
use App\Models\CustomerGroup;
use App\Models\GeneralSetting;
use App\Models\HrmSetting;
use App\Models\MailSetting;
use App\Models\PosSetting;
use App\Models\RewardPointSetting;
use App\Models\Warehouse;
use App\Traits\CacheForget;
use App\Traits\TenantInfo;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class SettingService
{
    use CacheForget;
    use TenantInfo;

    /**
     * Clear application cached data.
     */
    public function clearApplicationCache(): void
    {
        $this->cacheForget('biller_list');
        $this->cacheForget('brand_list');
        $this->cacheForget('category_list');
        $this->cacheForget('coupon_list');
        $this->cacheForget('customer_list');
        $this->cacheForget('customer_group_list');
        $this->cacheForget('product_list');
        $this->cacheForget('product_list_with_variant');
        $this->cacheForget('warehouse_list');
        $this->cacheForget('tax_list');
        $this->cacheForget('currency');
        $this->cacheForget('general_setting');
        $this->cacheForget('pos_setting');
        $this->cacheForget('user_role');
        $this->cacheForget('permissions');
        $this->cacheForget('role_has_permissions');
        $this->cacheForget('role_has_permissions_list');
    }

    /**
     * Get General Setting form data.
     *
     * @return array
     */
    public function getGeneralSettingData(): array
    {
        $lims_general_setting_data = GeneralSetting::latest()->first();
        $lims_account_list = Account::where('is_active', true)->get();
        $lims_currency_list = Currency::all();
        $zones_array = [];
        $timestamp = time();

        foreach (timezone_identifiers_list() as $key => $zone) {
            date_default_timezone_set($zone);
            $zones_array[$key]['zone'] = $zone;
            $zones_array[$key]['diff_from_GMT'] = 'UTC/GMT ' . date('P', $timestamp);
        }

        return compact('lims_general_setting_data', 'lims_account_list', 'zones_array', 'lims_currency_list');
    }

    /**
     * Update general settings.
     *
     * @param array $requestData
     * @param UploadedFile|null $logo
     * @return GeneralSetting
     */
    public function updateGeneralSetting(array $requestData, ?UploadedFile $logo): GeneralSetting
    {
        $data = $requestData;

        // Writing timezone info in .env
        $path = app()->environmentFilePath();
        $searchArray = ['APP_TIMEZONE=' . env('APP_TIMEZONE')];
        $replaceArray = ['APP_TIMEZONE=' . ($data['timezone'] ?? 'UTC')];
        @file_put_contents($path, str_replace($searchArray, $replaceArray, file_get_contents($path)));

        $general_setting = GeneralSetting::latest()->first() ?? new GeneralSetting();
        $general_setting->id = 1;
        $general_setting->site_title = $data['site_title'] ?? $general_setting->site_title;
        $general_setting->is_rtl = isset($data['is_rtl']);
        $general_setting->is_zatca = isset($data['is_zatca']);
        $general_setting->currency = $data['currency'] ?? $general_setting->currency;
        $general_setting->currency_position = $data['currency_position'] ?? $general_setting->currency_position;
        $general_setting->decimal = $data['decimal'] ?? $general_setting->decimal;
        $general_setting->staff_access = $data['staff_access'] ?? $general_setting->staff_access;
        $general_setting->date_format = $data['date_format'] ?? $general_setting->date_format;
        $general_setting->developed_by = $data['developed_by'] ?? $general_setting->developed_by;
        $general_setting->invoice_format = $data['invoice_format'] ?? $general_setting->invoice_format;
        $general_setting->state = $data['state'] ?? $general_setting->state;
        $general_setting->account_id = $data['account_id'] ?? $general_setting->account_id;
        $general_setting->without_stock = $data['without_stock'] ?? $general_setting->without_stock;

        if ($logo) {
            $ext = pathinfo($logo->getClientOriginalName(), PATHINFO_EXTENSION);
            $logoName = date("Ymdhis");
            if (!config('database.connections.saas_landlord')) {
                $logoName = $logoName . '.' . $ext;
                $logo->move(public_path('logo'), $logoName);
            } else {
                $logoName = $this->getTenantId() . '_' . $logoName . '.' . $ext;
                $logo->move(public_path('logo'), $logoName);
            }
            $general_setting->site_logo = $logoName;
        }

        $general_setting->save();
        $this->cacheForget('general_setting');

        return $general_setting;
    }

    /**
     * Get POS Setting form data.
     *
     * @return array
     */
    public function getPosSettingData(): array
    {
        $lims_customer_list = Customer::where('is_active', true)->get();
        $lims_warehouse_list = Warehouse::where('is_active', true)->get();
        $lims_biller_list = Biller::where('is_active', true)->get();
        $lims_pos_setting_data = PosSetting::latest()->first();

        return compact('lims_customer_list', 'lims_warehouse_list', 'lims_biller_list', 'lims_pos_setting_data');
    }

    /**
     * Update POS setting.
     *
     * @param array $requestData
     * @return PosSetting
     */
    public function updatePosSetting(array $requestData): PosSetting
    {
        $data = $requestData;
        $pos_setting = PosSetting::firstOrNew(['id' => 1]);
        $pos_setting->customer_id = $data['customer_id'];
        $pos_setting->warehouse_id = $data['warehouse_id'];
        $pos_setting->biller_id = $data['biller_id'];
        $pos_setting->product_number = $data['product_number'];
        $pos_setting->stripe_public_key = $data['stripe_public_key'] ?? null;
        $pos_setting->stripe_secret_key = $data['stripe_secret_key'] ?? null;
        $pos_setting->paypal_live_api_username = $data['paypal_username'] ?? null;
        $pos_setting->paypal_live_api_password = $data['paypal_password'] ?? null;
        $pos_setting->paypal_live_api_secret = $data['paypal_signature'] ?? null;
        $pos_setting->payment_options = !empty($data['payment_options']) ? implode(',', $data['payment_options']) : '';
        $pos_setting->invoice_option = $data['invoice_size'] ?? 'pos';
        $pos_setting->keybord_active = isset($data['keybord_active']);
        $pos_setting->is_table = isset($data['is_table']);
        $pos_setting->save();

        $this->cacheForget('pos_setting');

        return $pos_setting;
    }
}

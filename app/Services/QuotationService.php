<?php

namespace App\Services;

use App\Models\Biller;
use App\Models\Customer;
use App\Models\Product;
use App\Models\ProductBatch;
use App\Models\ProductQuotation;
use App\Models\ProductVariant;
use App\Models\Quotation;
use App\Models\Supplier;
use App\Models\Tax;
use App\Models\Unit;
use App\Models\Warehouse;
use App\Repositories\Contracts\QuotationRepositoryInterface;
use App\Traits\TenantInfo;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;

class QuotationService
{
    use TenantInfo;

    protected QuotationRepositoryInterface $quotationRepository;

    /**
     * QuotationService constructor.
     *
     * @param QuotationRepositoryInterface $quotationRepository
     */
    public function __construct(QuotationRepositoryInterface $quotationRepository)
    {
        $this->quotationRepository = $quotationRepository;
    }

    /**
     * Process DataTables server-side response for quotation list.
     *
     * @param Request $request
     * @param array $allPermissions
     * @return array
     */
    public function getQuotationDataTable(Request $request, array $allPermissions): array
    {
        $columns = [
            1 => 'created_at',
            2 => 'reference_no',
        ];

        $warehouseId = $request->input('warehouse_id');
        $startDate = $request->input('starting_date');
        $endDate = $request->input('ending_date');
        $searchValue = $request->input('search.value');

        $totalData = $this->quotationRepository->countTotalQuotations($warehouseId, $startDate, $endDate);
        $limit = ($request->input('length') != -1) ? (int) $request->input('length') : $totalData;
        $start = (int) $request->input('start');
        $orderColumn = $request->input('order.0.column');
        $order = 'quotations.' . ($columns[$orderColumn] ?? 'created_at');
        $dir = $request->input('order.0.dir') ?? 'desc';

        $quotations = $this->quotationRepository->getFilteredQuotationsForDataTable($start, $limit, $order, $dir, $warehouseId, $startDate, $endDate, $searchValue);
        $totalFiltered = $this->quotationRepository->countFilteredQuotationsForDataTable($warehouseId, $startDate, $endDate, $searchValue);

        $data = [];
        $dateFormat = config('date_format') ?: 'd-m-Y';

        foreach ($quotations as $key => $quotation) {
            $nestedData = [];
            $nestedData['id'] = $quotation->id;
            $nestedData['key'] = $key;
            $nestedData['date'] = date($dateFormat, strtotime($quotation->created_at));
            $nestedData['reference_no'] = $quotation->reference_no;
            $nestedData['warehouse'] = $quotation->warehouse ? $quotation->warehouse->name : 'N/A';
            $nestedData['biller'] = $quotation->biller ? ($quotation->biller->name . ' (' . $quotation->biller->company_name . ')') : 'N/A';
            $nestedData['customer'] = $quotation->customer ? ($quotation->customer->name . ' (' . $quotation->customer->phone_number . ')') : 'N/A';
            $nestedData['supplier'] = $quotation->supplier ? ($quotation->supplier->name . ' (' . $quotation->supplier->company_name . ')') : 'N/A';

            if ($quotation->quotation_status == 1) {
                $nestedData['status'] = '<div class="badge badge-danger">' . trans('file.Pending') . '</div>';
            } else {
                $nestedData['status'] = '<div class="badge badge-success">' . trans('file.Sent') . '</div>';
            }

            $nestedData['grand_total'] = number_format($quotation->grand_total, (int) (config('decimal') ?: 2));

            $options = '<div class="btn-group">
                        <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' . trans("file.action") . '
                          <span class="caret"></span>
                          <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                            <li>
                                <button type="button" class="btn btn-link view"><i class="fa fa-eye"></i> ' . trans('file.View') . '</button>
                            </li>';

            if (in_array("quotes-edit", $allPermissions)) {
                $options .= '<li>
                    <a href="' . route('quotations.edit', $quotation->id) . '" class="btn btn-link"><i class="dripicons-document-edit"></i> ' . trans('file.edit') . '</a>
                    </li>';
            }
            $options .= '<li>
                <a href="' . route('quotation.create_sale', ['id' => $quotation->id]) . '" class="btn btn-link"><i class="fa fa-shopping-cart"></i> ' . trans('file.Create Sale') . '</a>
                </li>';
            $options .= '<li>
                <a href="' . route('quotation.create_purchase', ['id' => $quotation->id]) . '" class="btn btn-link"><i class="fa fa-shopping-basket"></i> ' . trans('file.Create Purchase') . '</a>
                </li>';

            if (in_array("quotes-delete", $allPermissions)) {
                $options .= \Form::open(["route" => ["quotations.destroy", $quotation->id], "method" => "DELETE"]) . '
                        <li>
                          <button type="submit" class="btn btn-link" onclick="return confirmDelete()"><i class="dripicons-trash"></i> ' . trans("file.delete") . '</button>
                        </li>' . \Form::close();
            }

            $options .= '</ul></div>';
            $nestedData['options'] = $options;

            $nestedData['quotation'] = [
                '[ "' . date($dateFormat, strtotime($quotation->created_at)) . '"',
                ' "' . $quotation->reference_no . '"',
                ' "' . $quotation->quotation_status . '"',
                ' "' . ($quotation->biller ? $quotation->biller->name : 'N/A') . '"',
                ' "' . ($quotation->biller ? $quotation->biller->company_name : 'N/A') . '"',
                ' "' . ($quotation->biller ? $quotation->biller->email : 'N/A') . '"',
                ' "' . ($quotation->biller ? $quotation->biller->phone_number : 'N/A') . '"',
                ' "' . ($quotation->biller ? $quotation->biller->address : 'N/A') . '"',
                ' "' . ($quotation->biller ? $quotation->biller->city : 'N/A') . '"',
                ' "' . ($quotation->customer ? $quotation->customer->name : 'N/A') . '"',
                ' "' . ($quotation->customer ? $quotation->customer->phone_number : 'N/A') . '"',
                ' "' . ($quotation->customer ? $quotation->customer->address : 'N/A') . '"',
                ' "' . ($quotation->customer ? $quotation->customer->city : 'N/A') . '"',
                ' "' . $quotation->id . '"',
                ' "' . $quotation->total_tax . '"',
                ' "' . $quotation->total_discount . '"',
                ' "' . $quotation->total_price . '"',
                ' "' . $quotation->order_tax . '"',
                ' "' . $quotation->order_tax_rate . '"',
                ' "' . $quotation->order_discount . '"',
                ' "' . $quotation->shipping_cost . '"',
                ' "' . $quotation->grand_total . '"',
                ' "' . preg_replace('/\s+/S', " ", (string) $quotation->note) . '"',
                ' "' . ($quotation->user ? $quotation->user->name : 'N/A') . '"',
                ' "' . ($quotation->user ? $quotation->user->email : 'N/A') . '"',
                ' "' . $quotation->document . '" ]'
            ];

            $data[] = $nestedData;
        }

        return [
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        ];
    }

    /**
     * Get data required for create quotation form.
     *
     * @return array
     */
    public function getCreateFormData(): array
    {
        $lims_biller_list = Biller::where('is_active', true)->get();
        $lims_warehouse_list = Warehouse::where('is_active', true)->get();
        $lims_customer_list = Customer::where('is_active', true)->get();
        $lims_supplier_list = Supplier::where('is_active', true)->get();
        $lims_tax_list = Tax::where('is_active', true)->get();

        return compact(
            'lims_biller_list',
            'lims_warehouse_list',
            'lims_customer_list',
            'lims_supplier_list',
            'lims_tax_list'
        );
    }

    /**
     * Create a new quotation.
     *
     * @param array $requestData
     * @param UploadedFile|null $document
     * @return Quotation
     */
    public function createQuotation(array $requestData, ?UploadedFile $document): Quotation
    {
        $data = $requestData;
        $data['user_id'] = Auth::id();

        if (isset($data['created_at'])) {
            $data['created_at'] = date("Y-m-d H:i:s", strtotime($data['created_at']));
        } else {
            $data['created_at'] = date("Y-m-d H:i:s");
        }

        if ($document) {
            $ext = pathinfo($document->getClientOriginalName(), PATHINFO_EXTENSION);
            $documentName = date("Ymdhis");
            if (!config('database.connections.saas_landlord')) {
                $documentName = $documentName . '.' . $ext;
                $document->move(public_path('documents/quotation'), $documentName);
            } else {
                $documentName = $this->getTenantId() . '_' . $documentName . '.' . $ext;
                $document->move(public_path('documents/quotation'), $documentName);
            }
            $data['document'] = $documentName;
        }

        if (!isset($data['reference_no'])) {
            $data['reference_no'] = 'qr-' . date("Ymd") . '-' . date("his");
        }

        $quotation = $this->quotationRepository->create($data);

        $productIds = $data['product_id'] ?? [];
        $productBatchIds = $data['product_batch_id'] ?? [];
        $productCodes = $data['product_code'] ?? [];
        $qtys = $data['qty'] ?? [];
        $saleUnitIds = $data['sale_unit_id'] ?? [];
        $netUnitPrices = $data['net_unit_price'] ?? [];
        $discounts = $data['discount'] ?? [];
        $taxRates = $data['tax_rate'] ?? [];
        $taxes = $data['tax'] ?? [];
        $totals = $data['subtotal'] ?? [];

        foreach ($productIds as $i => $id) {
            $product = Product::find($id);
            if (!$product) {
                continue;
            }

            $productVariantId = null;
            if ($product->is_variant) {
                $productVariant = ProductVariant::where([
                    ['product_id', $id],
                    ['item_code', $productCodes[$i]]
                ])->first();
                if ($productVariant) {
                    $productVariantId = $productVariant->variant_id;
                }
            }

            ProductQuotation::create([
                'quotation_id'     => $quotation->id,
                'product_id'       => $id,
                'product_batch_id' => $productBatchIds[$i] ?? null,
                'variant_id'       => $productVariantId,
                'qty'              => $qtys[$i] ?? 0,
                'sale_unit_id'     => $saleUnitIds[$i] ?? null,
                'net_unit_price'   => $netUnitPrices[$i] ?? 0,
                'discount'         => $discounts[$i] ?? 0,
                'tax_rate'         => $taxRates[$i] ?? 0,
                'tax'              => $taxes[$i] ?? 0,
                'total'            => $totals[$i] ?? 0,
            ]);
        }

        return $quotation;
    }

    /**
     * Get data required for edit quotation form.
     *
     * @param int|string $id
     * @return array
     */
    public function getEditFormData($id): array
    {
        $lims_biller_list = Biller::where('is_active', true)->get();
        $lims_warehouse_list = Warehouse::where('is_active', true)->get();
        $lims_customer_list = Customer::where('is_active', true)->get();
        $lims_supplier_list = Supplier::where('is_active', true)->get();
        $lims_tax_list = Tax::where('is_active', true)->get();
        $lims_quotation_data = Quotation::find($id);
        $lims_product_quotation_data = ProductQuotation::where('quotation_id', $id)->get();

        return compact(
            'lims_biller_list',
            'lims_warehouse_list',
            'lims_customer_list',
            'lims_supplier_list',
            'lims_tax_list',
            'lims_quotation_data',
            'lims_product_quotation_data'
        );
    }

    /**
     * Update an existing quotation.
     *
     * @param int|string $id
     * @param array $requestData
     * @param UploadedFile|null $document
     * @return Quotation
     */
    public function updateQuotation($id, array $requestData, ?UploadedFile $document): Quotation
    {
        $quotation = $this->quotationRepository->findOrFail($id);
        $data = $requestData;

        if (isset($data['created_at'])) {
            $data['created_at'] = date("Y-m-d H:i:s", strtotime($data['created_at']));
        }

        if ($document) {
            $ext = pathinfo($document->getClientOriginalName(), PATHINFO_EXTENSION);
            $documentName = date("Ymdhis");
            if (!config('database.connections.saas_landlord')) {
                $documentName = $documentName . '.' . $ext;
                $document->move(public_path('documents/quotation'), $documentName);
            } else {
                $documentName = $this->getTenantId() . '_' . $documentName . '.' . $ext;
                $document->move(public_path('documents/quotation'), $documentName);
            }
            $data['document'] = $documentName;
        }

        ProductQuotation::where('quotation_id', $id)->delete();
        $quotation->update($data);

        $productIds = $data['product_id'] ?? [];
        $productBatchIds = $data['product_batch_id'] ?? [];
        $productCodes = $data['product_code'] ?? [];
        $qtys = $data['qty'] ?? [];
        $saleUnitIds = $data['sale_unit_id'] ?? [];
        $netUnitPrices = $data['net_unit_price'] ?? [];
        $discounts = $data['discount'] ?? [];
        $taxRates = $data['tax_rate'] ?? [];
        $taxes = $data['tax'] ?? [];
        $totals = $data['subtotal'] ?? [];

        foreach ($productIds as $i => $proId) {
            $product = Product::find($proId);
            if (!$product) {
                continue;
            }

            $productVariantId = null;
            if ($product->is_variant) {
                $productVariant = ProductVariant::where([
                    ['product_id', $proId],
                    ['item_code', $productCodes[$i]]
                ])->first();
                if ($productVariant) {
                    $productVariantId = $productVariant->variant_id;
                }
            }

            ProductQuotation::create([
                'quotation_id'     => $quotation->id,
                'product_id'       => $proId,
                'product_batch_id' => $productBatchIds[$i] ?? null,
                'variant_id'       => $productVariantId,
                'qty'              => $qtys[$i] ?? 0,
                'sale_unit_id'     => $saleUnitIds[$i] ?? null,
                'net_unit_price'   => $netUnitPrices[$i] ?? 0,
                'discount'         => $discounts[$i] ?? 0,
                'tax_rate'         => $taxRates[$i] ?? 0,
                'tax'              => $taxes[$i] ?? 0,
                'total'            => $totals[$i] ?? 0,
            ]);
        }

        return $quotation;
    }

    /**
     * Delete a quotation and its items.
     *
     * @param int|string $id
     * @return bool
     */
    public function deleteQuotation($id): bool
    {
        $quotation = Quotation::findOrFail($id);
        ProductQuotation::where('quotation_id', $id)->delete();

        if ($quotation->document) {
            @unlink(public_path('documents/quotation/' . $quotation->document));
        }

        return $quotation->delete();
    }

    /**
     * Delete multiple quotations.
     *
     * @param array $ids
     * @return bool
     */
    public function deleteMultipleQuotations(array $ids): bool
    {
        foreach ($ids as $id) {
            $this->deleteQuotation($id);
        }
        return true;
    }
}

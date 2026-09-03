<?php

namespace App\Services;

use App\Enums\DeliveryStatus;
use App\Models\Courier;
use App\Models\Customer;
use App\Models\Delivery;
use App\Models\Product;
use App\Models\ProductBatch;
use App\Models\ProductVariant;
use App\Models\Product_Sale;
use App\Models\Sale;
use App\Repositories\Contracts\DeliveryRepositoryInterface;
use App\Traits\TenantInfo;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeliveryService
{
    use TenantInfo;

    protected DeliveryRepositoryInterface $deliveryRepository;
    protected ?PathaoService $pathaoService;

    /**
     * DeliveryService constructor.
     *
     * @param DeliveryRepositoryInterface $deliveryRepository
     * @param PathaoService|null $pathaoService
     */
    public function __construct(DeliveryRepositoryInterface $deliveryRepository, ?PathaoService $pathaoService = null)
    {
        $this->deliveryRepository = $deliveryRepository;
        $this->pathaoService = $pathaoService;
    }

    /**
     * Get all deliveries with couriers.
     *
     * @return array
     */
    public function getIndexData(): array
    {
        $lims_delivery_all = $this->deliveryRepository->getAllDeliveries();
        $lims_courier_list = Courier::where('is_active', true)->get();

        return compact('lims_delivery_all', 'lims_courier_list');
    }

    /**
     * Get delivery data for creating or editing delivery on a sale.
     *
     * @param int|string $saleId
     * @return array
     */
    public function getDeliveryDataForSale($saleId): array
    {
        $lims_delivery_data = $this->deliveryRepository->getDeliveryBySaleId($saleId);

        if ($lims_delivery_data) {
            $customer_sale = DB::table('sales')
                ->join('customers', 'sales.customer_id', '=', 'customers.id')
                ->where('sales.id', $saleId)
                ->select('sales.reference_no', 'customers.name')
                ->get();

            $delivery_data[] = $lims_delivery_data->reference_no;
            $delivery_data[] = $customer_sale[0]->reference_no ?? '';
            $delivery_data[] = $lims_delivery_data->status;
            $delivery_data[] = $lims_delivery_data->delivered_by;
            $delivery_data[] = $lims_delivery_data->recieved_by;
            $delivery_data[] = $customer_sale[0]->name ?? '';
            $delivery_data[] = $lims_delivery_data->address;
            $delivery_data[] = $lims_delivery_data->note;
            $delivery_data[] = $lims_delivery_data->courier_id;
        } else {
            $customer_sale = DB::table('sales')
                ->join('customers', 'sales.customer_id', '=', 'customers.id')
                ->where('sales.id', $saleId)
                ->select('sales.reference_no', 'sales.sale_note', 'customers.name', 'customers.address', 'customers.city', 'customers.country')
                ->get();

            $delivery_data[] = 'dr-' . date("Ymd") . '-' . date("his");
            $delivery_data[] = $customer_sale[0]->reference_no ?? '';
            $delivery_data[] = '';
            $delivery_data[] = '';
            $delivery_data[] = '';
            $delivery_data[] = $customer_sale[0]->name ?? '';
            $delivery_data[] = ($customer_sale[0]->address ?? '') . ' ' . ($customer_sale[0]->city ?? '') . ' ' . ($customer_sale[0]->country ?? '');
            $delivery_data[] = $customer_sale[0]->sale_note ?? '';
        }

        return $delivery_data;
    }

    /**
     * Create delivery for a sale.
     *
     * @param array $requestData
     * @param UploadedFile|null $file
     * @return Delivery
     */
    public function createDelivery(array $requestData, ?UploadedFile $file): Delivery
    {
        $data = $requestData;

        if ($file) {
            $ext = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
            $documentName = date("Ymdhis");
            if (!config('database.connections.saas_landlord')) {
                $documentName = $documentName . '.' . $ext;
                $file->move(public_path('documents/delivery'), $documentName);
            } else {
                $documentName = $this->getTenantId() . '_' . $documentName . '.' . $ext;
                $file->move(public_path('documents/delivery'), $documentName);
            }
            $data['file'] = $documentName;
        }

        $sale = Sale::find($data['sale_id']);
        if ($sale) {
            $sale->delivery_status = $data['status'] ?? DeliveryStatus::PACKING->value;
            $sale->save();
        }

        $data['user_id'] = Auth::id();

        // Pathao courier integration if selected
        if (!empty($data['courier_id']) && $this->pathaoService) {
            $courier = Courier::find($data['courier_id']);
            if ($courier && strtolower($courier->name) == 'pathao' && $sale) {
                try {
                    $customer = Customer::find($sale->customer_id);
                    $pathaoCityId = $this->pathaoService->getCityIdByName($customer ? $customer->city : '');
                    $pathaoZoneId = $this->pathaoService->getZoneIdByName($pathaoCityId ?? 1, $customer ? $customer->state : '');

                    $pathaoOrderData = [
                        'store_id'            => config('pathao.store_id', 1),
                        'recipient_name'      => $customer ? $customer->name : 'Customer',
                        'recipient_phone'     => $customer ? $customer->phone_number : '01700000000',
                        'recipient_address'   => $data['address'] ?? ($customer ? $customer->address : ''),
                        'recipient_city'      => $pathaoCityId ?? 1,
                        'recipient_zone'      => $pathaoZoneId ?? 1,
                        'amount_to_collect'   => (int) ($sale->grand_total - $sale->paid_amount),
                        'item_type'           => 2,
                        'item_quantity'       => 1,
                        'item_weight'         => 0.5,
                        'item_description'    => $sale->reference_no,
                        'merchant_order_id'   => $sale->reference_no,
                    ];

                    $pathaoRes = $this->pathaoService->sendOrder($pathaoOrderData);
                    if (!empty($pathaoRes['data']['consignment_id'])) {
                        $data['consignment_id'] = $pathaoRes['data']['consignment_id'];
                    }
                } catch (\Exception $e) {
                    // Pathao error handled silently without breaking local delivery
                }
            }
        }

        return $this->deliveryRepository->create($data);
    }

    /**
     * Get product delivery details for modal view.
     *
     * @param int|string $id
     * @return array
     */
    public function getProductDeliveryData($id): array
    {
        $lims_delivery_data = $this->deliveryRepository->findOrFail($id);
        $lims_product_sale_data = Product_Sale::where('sale_id', $lims_delivery_data->sale_id)->get();

        $product_sale = [];
        foreach ($lims_product_sale_data as $key => $product_sale_data) {
            $product = Product::select('name', 'code')->find($product_sale_data->product_id);
            if (!$product) {
                continue;
            }

            $product_batch = null;
            if ($product_sale_data->product_batch_id) {
                $product_batch = ProductBatch::select('batch_no')->find($product_sale_data->product_batch_id);
            }

            $product_variant = null;
            if ($product_sale_data->variant_id) {
                $product_variant = ProductVariant::select('item_code')->FindExactProduct($product_sale_data->product_id, $product_sale_data->variant_id)->first();
            }

            if ($product_batch) {
                $product_sale[0][$key] = $product->name . ' [' . trans("file.Batch No") . ':' . $product_batch->batch_no . ']';
            } else {
                $product_sale[0][$key] = $product->name;
            }

            if ($product_variant) {
                $product_sale[1][$key] = $product_variant->item_code;
            } else {
                $product_sale[1][$key] = $product->code;
            }

            $product_sale[2][$key] = $product_sale_data->qty;
        }

        return $product_sale;
    }

    /**
     * Update delivery.
     *
     * @param array $requestData
     * @param UploadedFile|null $file
     * @return Delivery
     */
    public function updateDelivery(array $requestData, ?UploadedFile $file): Delivery
    {
        $data = $requestData;
        $delivery = $this->deliveryRepository->findOrFail($data['delivery_id']);

        if ($file) {
            $ext = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
            $documentName = date("Ymdhis");
            if (!config('database.connections.saas_landlord')) {
                $documentName = $documentName . '.' . $ext;
                $file->move(public_path('documents/delivery'), $documentName);
            } else {
                $documentName = $this->getTenantId() . '_' . $documentName . '.' . $ext;
                $file->move(public_path('documents/delivery'), $documentName);
            }
            $data['file'] = $documentName;
        }

        $sale = Sale::find($delivery->sale_id);
        if ($sale) {
            $sale->delivery_status = $data['status'] ?? $delivery->status;
            $sale->save();
        }

        $delivery->update($data);

        return $delivery;
    }

    /**
     * Delete a delivery.
     *
     * @param int|string $id
     * @return bool
     */
    public function deleteDelivery($id): bool
    {
        $delivery = $this->deliveryRepository->findOrFail($id);
        if ($delivery->file) {
            @unlink(public_path('documents/delivery/' . $delivery->file));
        }

        return $this->deliveryRepository->delete($id);
    }

    /**
     * Delete multiple deliveries.
     *
     * @param array $ids
     * @return bool
     */
    public function deleteMultipleDeliveries(array $ids): bool
    {
        foreach ($ids as $id) {
            $this->deleteDelivery($id);
        }
        return true;
    }
}

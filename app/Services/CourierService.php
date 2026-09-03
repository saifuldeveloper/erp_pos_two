<?php

namespace App\Services;

use App\Models\Courier;
use App\Repositories\Contracts\CourierRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CourierService
{
    protected CourierRepositoryInterface $courierRepository;

    /**
     * CourierService constructor.
     *
     * @param CourierRepositoryInterface $courierRepository
     */
    public function __construct(CourierRepositoryInterface $courierRepository)
    {
        $this->courierRepository = $courierRepository;
    }

    /**
     * Get all active couriers.
     *
     * @return Collection
     */
    public function getActiveCouriers(): Collection
    {
        return $this->courierRepository->getActiveCouriers();
    }

    /**
     * Create a new courier.
     *
     * @param array $requestData
     * @return Courier
     */
    public function createCourier(array $requestData): Courier
    {
        $data = $requestData;
        $data['is_active'] = true;

        return $this->courierRepository->create($data);
    }

    /**
     * Update an existing courier.
     *
     * @param int|string $id
     * @param array $requestData
     * @return Courier
     */
    public function updateCourier($id, array $requestData): Courier
    {
        $courier = $this->courierRepository->findOrFail($id);
        $courier->update($requestData);

        return $courier;
    }

    /**
     * Deactivate a courier.
     *
     * @param int|string $id
     * @return bool
     */
    public function deleteCourier($id): bool
    {
        $courier = $this->courierRepository->findOrFail($id);
        $courier->is_active = false;

        return (bool) $courier->save();
    }
}

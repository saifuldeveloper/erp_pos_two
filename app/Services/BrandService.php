<?php

namespace App\Services;

use App\Repositories\Contracts\BrandRepositoryInterface;
use App\Traits\CacheForget;
use App\Traits\TenantInfo;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

class BrandService
{
    use CacheForget;
    use TenantInfo;

    protected BrandRepositoryInterface $brandRepository;

    /**
     * BrandService constructor.
     *
     * @param BrandRepositoryInterface $brandRepository
     */
    public function __construct(BrandRepositoryInterface $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }

    /**
     * Get all active brands.
     *
     * @return Collection
     */
    public function getActiveBrands(): Collection
    {
        return $this->brandRepository->getActiveBrands();
    }

    /**
     * Get brand by ID.
     *
     * @param int|string $id
     * @return Model
     */
    public function getBrandById($id): Model
    {
        return $this->brandRepository->findOrFail($id);
    }

    /**
     * Create a new brand with image processing.
     *
     * @param array $data
     * @param UploadedFile|null $image
     * @return Model
     */
    public function createBrand(array $data, ?UploadedFile $image = null): Model
    {
        $data['is_active'] = true;

        if ($image) {
            $data['image'] = $this->uploadImage($image);
        }

        $brand = $this->brandRepository->create($data);
        $this->cacheForget('brand_list');

        return $brand;
    }

    /**
     * Update an existing brand.
     *
     * @param int|string $id
     * @param array $data
     * @param UploadedFile|null $image
     * @return Model
     */
    public function updateBrand($id, array $data, ?UploadedFile $image = null): Model
    {
        $brand = $this->brandRepository->findOrFail($id);

        if ($image) {
            $this->unlinkImage($brand->image);
            $data['image'] = $this->uploadImage($image);
        }

        $updatedBrand = $this->brandRepository->update($id, $data);
        $this->cacheForget('brand_list');

        return $updatedBrand;
    }

    /**
     * Deactivate brand and delete its image.
     *
     * @param int|string $id
     * @return bool
     */
    public function deleteBrand($id): bool
    {
        $brand = $this->brandRepository->findOrFail($id);
        $this->unlinkImage($brand->image);

        $result = $this->brandRepository->deactivate($id);
        $this->cacheForget('brand_list');

        return $result;
    }

    /**
     * Deactivate multiple brands and delete their images.
     *
     * @param array $ids
     * @return bool
     */
    public function deleteMultipleBrands(array $ids): bool
    {
        $brands = $this->brandRepository->getByIds($ids);

        foreach ($brands as $brand) {
            $this->unlinkImage($brand->image);
        }

        $result = $this->brandRepository->deactivateMultiple($ids);
        $this->cacheForget('brand_list');

        return $result;
    }

    /**
     * Import brands from a CSV file.
     *
     * @param UploadedFile $file
     * @return void
     */
    public function importBrands(UploadedFile $file): void
    {
        $filePath = $file->getRealPath();
        $handle = fopen($filePath, 'r');
        $header = fgetcsv($handle);
        $escapedHeader = [];

        foreach ($header as $value) {
            $lheader = strtolower($value);
            $escapedItem = preg_replace('/[^a-z]/', '', $lheader);
            $escapedHeader[] = $escapedItem;
        }

        while ($columns = fgetcsv($handle)) {
            if ($columns[0] == '') {
                continue;
            }

            foreach ($columns as $key => $value) {
                $columns[$key] = preg_replace('/\D/', '', $value);
            }

            $data = array_combine($escapedHeader, $columns);
            $brand = $this->brandRepository->firstOrCreate(
                ['title' => $data['title'], 'is_active' => true],
                ['image' => $data['image'] ?? null, 'is_active' => true]
            );

            $brand->title = $data['title'];
            $brand->image = $data['image'] ?? null;
            $brand->is_active = true;
            $brand->save();
        }

        fclose($handle);
        $this->cacheForget('brand_list');
    }

    /**
     * Export selected brands to a CSV file and return the file URL.
     *
     * @param array $brandIds
     * @return string
     */
    public function exportBrands(array $brandIds): string
    {
        $ids = array_filter($brandIds, fn($id) => $id > 0);
        $brands = $this->brandRepository->getByIds($ids);

        $csvData = ['Brand Title, Image'];
        foreach ($brands as $brand) {
            $csvData[] = $brand->title . ',' . $brand->image;
        }

        $filename = date('Y-m-d') . '.csv';
        $directory = public_path('downloads');
        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }

        $filePath = $directory . '/' . $filename;
        $fileUrl = url('/') . '/downloads/' . $filename;

        $file = fopen($filePath, 'w+');
        foreach ($csvData as $expData) {
            fputcsv($file, explode(',', $expData));
        }
        fclose($file);

        return $fileUrl;
    }

    /**
     * Upload brand image to designated storage directory.
     *
     * @param UploadedFile $image
     * @return string
     */
    protected function uploadImage(UploadedFile $image): string
    {
        $ext = pathinfo($image->getClientOriginalName(), PATHINFO_EXTENSION);
        $imageName = date('Ymdhis');

        if (!config('database.connections.saas_landlord')) {
            $imageName = $imageName . '.' . $ext;
        } else {
            $imageName = $this->getTenantId() . '_' . $imageName . '.' . $ext;
        }

        $image->move('public/images/brand', $imageName);

        return $imageName;
    }

    /**
     * Unlink image from filesystem if exists.
     *
     * @param string|null $image
     * @return void
     */
    protected function unlinkImage(?string $image): void
    {
        if (!$image) {
            return;
        }

        if (!config('database.connections.saas_landlord') && file_exists('public/images/brand/' . $image)) {
            unlink('public/images/brand/' . $image);
        } elseif (file_exists('images/brand/' . $image)) {
            unlink('images/brand/' . $image);
        }
    }
}

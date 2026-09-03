<?php

namespace App\Services;

use App\Repositories\Contracts\ColorRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ColorService
{
    protected ColorRepositoryInterface $colorRepository;

    /**
     * ColorService constructor.
     *
     * @param ColorRepositoryInterface $colorRepository
     */
    public function __construct(ColorRepositoryInterface $colorRepository)
    {
        $this->colorRepository = $colorRepository;
    }

    /**
     * Get all colors.
     *
     * @return Collection
     */
    public function getAllColors(): Collection
    {
        return $this->colorRepository->all();
    }

    /**
     * Get color by ID.
     *
     * @param int|string $id
     * @return Model|null
     */
    public function getColorById($id): ?Model
    {
        return $this->colorRepository->find($id);
    }

    /**
     * Create a new color.
     *
     * @param array $data
     * @return Model
     */
    public function createColor(array $data): Model
    {
        return $this->colorRepository->create([
            'name' => $data['name'],
            'code' => $data['code'] ?? null,
        ]);
    }

    /**
     * Update an existing color and synchronize related products/variants if name changes.
     *
     * @param int|string $id
     * @param array $data
     * @return Model|null
     */
    public function updateColor($id, array $data): ?Model
    {
        $color = $this->colorRepository->find($id);
        if (!$color) {
            return null;
        }

        $newName = $data['name'];
        if ($color->name !== $newName) {
            $this->colorRepository->updateColorRelations($color, $newName);
        }

        $color->name = $newName;
        $color->code = $data['code'] ?? null;
        $color->save();

        return $color;
    }

    /**
     * Delete a single color by ID.
     *
     * @param int|string $id
     * @return bool
     */
    public function deleteColor($id): bool
    {
        $color = $this->colorRepository->find($id);
        if ($color) {
            return (bool) $color->delete();
        }
        return false;
    }

    /**
     * Delete multiple colors by IDs.
     *
     * @param array $ids
     * @return bool
     */
    public function deleteMultipleColors(array $ids): bool
    {
        return $this->colorRepository->deleteMultiple($ids);
    }
}

<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;

trait CacheForget
{
    /**
     * Invalidate specific cache key or array of keys.
     *
     * @param string|array $forget
     * @return void
     */
    public function cacheForget($forget): void
    {
        if (is_array($forget)) {
            foreach ($forget as $key) {
                Cache::forget($key);
            }
        } else {
            Cache::forget($forget);
        }
    }

    /**
     * Invalidate all setting-related cache keys.
     *
     * @return void
     */
    public function forgetAllSettingsCache(): void
    {
        $this->cacheForget([
            'general_setting',
            'currency',
            'pos_setting',
            'mail_setting',
            'reward_point_setting',
            'hrm_setting',
        ]);
    }

    /**
     * Invalidate static master data caches.
     *
     * @return void
     */
    public function forgetMasterDataCache(): void
    {
        $this->cacheForget([
            'active_taxes',
            'active_units',
            'active_categories',
            'active_brands',
            'active_warehouses',
        ]);
    }
}
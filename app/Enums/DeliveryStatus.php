<?php

namespace App\Enums;

enum DeliveryStatus: int
{
    case PACKING    = 1;
    case DELIVERING = 2;
    case DELIVERED  = 3;

    public function label(): string
    {
        return match ($this) {
            self::PACKING    => trans('file.Packing'),
            self::DELIVERING => trans('file.Delivering'),
            self::DELIVERED  => trans('file.Delivered'),
        };
    }

    public function badge(): string
    {
        return match ($this) {
            self::PACKING    => '<div class="badge badge-info">' . trans('file.Packing') . '</div>',
            self::DELIVERING => '<div class="badge badge-warning">' . trans('file.Delivering') . '</div>',
            self::DELIVERED  => '<div class="badge badge-success">' . trans('file.Delivered') . '</div>',
        };
    }
}

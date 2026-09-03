<?php

namespace App\Enums;

enum PurchaseStatus: int
{
    case RECEIVED = 1;
    case PARTIAL  = 2;
    case PENDING  = 3;
    case ORDERED  = 4;

    public function label(): string
    {
        return match ($this) {
            self::RECEIVED => trans('file.Received'),
            self::PARTIAL  => trans('file.Partial'),
            self::PENDING  => trans('file.Pending'),
            self::ORDERED  => trans('file.Ordered'),
        };
    }

    public function badge(): string
    {
        return match ($this) {
            self::RECEIVED => '<div class="badge badge-success">' . trans('file.Received') . '</div>',
            self::PARTIAL  => '<div class="badge badge-warning">' . trans('file.Partial') . '</div>',
            self::PENDING  => '<div class="badge badge-danger">' . trans('file.Pending') . '</div>',
            self::ORDERED  => '<div class="badge badge-danger">' . trans('file.Ordered') . '</div>',
        };
    }
}

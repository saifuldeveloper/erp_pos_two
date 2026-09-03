<?php

namespace App\Enums;

enum PaymentStatus: int
{
    case PENDING = 1;
    case DUE = 2;
    case PARTIAL = 3;
    case PAID = 4;

    public function label(): string
    {
        return match ($this) {
            self::PENDING => trans('file.Pending'),
            self::DUE     => trans('file.Due'),
            self::PARTIAL => trans('file.Partial'),
            self::PAID    => trans('file.Paid'),
        };
    }

    public function badge(): string
    {
        return match ($this) {
            self::PENDING => '<div class="badge badge-danger">' . trans('file.Pending') . '</div>',
            self::DUE     => '<div class="badge badge-danger">' . trans('file.Due') . '</div>',
            self::PARTIAL => '<div class="badge badge-warning">' . trans('file.Partial') . '</div>',
            self::PAID    => '<div class="badge badge-success">' . trans('file.Paid') . '</div>',
        };
    }
}

<?php

namespace App\Enums;

enum TransferStatus: int
{
    case COMPLETED = 1;
    case PENDING   = 2;
    case SENT      = 3;

    public function label(): string
    {
        return match ($this) {
            self::COMPLETED => trans('file.Completed'),
            self::PENDING   => trans('file.Pending'),
            self::SENT      => trans('file.Sent'),
        };
    }

    public function badge(): string
    {
        return match ($this) {
            self::COMPLETED => '<div class="badge badge-success">' . trans('file.Completed') . '</div>',
            self::PENDING   => '<div class="badge badge-danger">' . trans('file.Pending') . '</div>',
            self::SENT      => '<div class="badge badge-warning">' . trans('file.Sent') . '</div>',
        };
    }
}

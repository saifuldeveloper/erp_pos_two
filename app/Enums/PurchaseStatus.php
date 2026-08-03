<?php

namespace App\Enums;

enum PurchaseStatus: int
{
    case RECEIVED = 1;
    case PENDING = 2;
    case ORDERED = 3;
}

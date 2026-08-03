<?php

namespace App\Enums;

enum PaymentStatus: int
{
    case PENDING = 1;
    case DUE = 2;
    case PARTIAL = 3;
    case PAID = 4;
}

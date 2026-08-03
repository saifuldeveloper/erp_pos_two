<?php

namespace App\Enums;

enum DiscountType: string
{
    case FLAT = 'flat';
    case PERCENTAGE = 'percentage';
}

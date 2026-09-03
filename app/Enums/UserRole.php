<?php

namespace App\Enums;

enum UserRole: int
{
    case ADMIN = 1;
    case OWNER = 2;
    case CASHIER = 3;
    case STAFF = 4;
    case CUSTOMER = 5;
}

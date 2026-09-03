<?php

namespace App\Enums;

enum PaymentMethod: int
{
    case CASH        = 1;
    case GIFT_CARD   = 2;
    case CREDIT_CARD = 3;
    case CHEQUE      = 4;
    case PAYPAL      = 5;
    case DEPOSIT     = 6;
    case POINTS      = 7;

    public function label(): string
    {
        return match ($this) {
            self::CASH        => 'Cash',
            self::GIFT_CARD   => 'Gift Card',
            self::CREDIT_CARD => 'Credit Card',
            self::CHEQUE      => 'Cheque',
            self::PAYPAL      => 'Paypal',
            self::DEPOSIT     => 'Deposit',
            self::POINTS      => 'Points',
        };
    }

    public function isCash(): bool
    {
        return $this === self::CASH;
    }

    public function isCreditCard(): bool
    {
        return $this === self::CREDIT_CARD;
    }

    public function isCheque(): bool
    {
        return $this === self::CHEQUE;
    }

    public function isGiftCard(): bool
    {
        return $this === self::GIFT_CARD;
    }

    public function isDeposit(): bool
    {
        return $this === self::DEPOSIT;
    }

    public function isPoints(): bool
    {
        return $this === self::POINTS;
    }
}

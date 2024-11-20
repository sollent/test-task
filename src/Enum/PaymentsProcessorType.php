<?php

declare(strict_types=1);

namespace App\Enum;

enum PaymentsProcessorType: string
{
    case Stripe = 'stripe';

    case Paypal = 'paypal';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}

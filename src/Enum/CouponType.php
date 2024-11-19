<?php

declare(strict_types=1);

namespace App\Enum;

enum CouponType: string
{
    case Fixed = "F";

    case Percent = "P";
}

<?php

declare(strict_types=1);

namespace App\Dto\Response;

final class ProductPriceCalculateResponseDto
{
    public function __construct(
        public float $calculatedPrice,
    )
    {
    }
}
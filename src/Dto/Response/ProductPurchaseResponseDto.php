<?php

declare(strict_types=1);

namespace App\Dto\Response;

final class ProductPurchaseResponseDto
{
    public function __construct(
        public string $purchaseMessage
    ) {
    }
}
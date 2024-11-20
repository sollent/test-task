<?php

declare(strict_types=1);

namespace App\Dto\Request;

use App\Enum\PaymentsProcessorType;
use App\Validator\TaxNumber;
use Symfony\Component\Validator\Constraints as Assert;

final class ProductPurchaseRequestDto
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Type('integer')]
        public int $product,
        #[Assert\NotBlank]
        #[TaxNumber]
        public string $taxNumber,
        #[Assert\NotBlank]
        #[Assert\Type('string')]
        public string $couponCode,
        #[Assert\NotBlank]
        #[Assert\Type('string')]
        #[Assert\Choice(callback: [PaymentsProcessorType::class, 'values'])]
        public string $paymentProcessorType,
    ) {
    }
}
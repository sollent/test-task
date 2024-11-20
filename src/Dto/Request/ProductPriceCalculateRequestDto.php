<?php

declare(strict_types=1);

namespace App\Dto\Request;

use App\Validator\TaxNumber;
use Symfony\Component\Validator\Constraints as Assert;


final class ProductPriceCalculateRequestDto
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
    )
    {
    }
}
<?php

declare(strict_types=1);

namespace App\Service;

use App\Enum\PaymentsProcessorType;
use App\Exception\ProductPriceCalculationException;
use App\Exception\ProductPurchaseException;

final readonly class ProductPurchaseService
{
    /**
     * Services with PaymentServiceInterface will be injected automatically
     * @param PaymentServiceInterface[] $paymentServices
     */
    public function __construct(
        private iterable $paymentServices,
        private ProductPriceCalculator $productPriceCalculator,
    ) {
    }

    /**
     * @throws ProductPriceCalculationException
     * @throws ProductPurchaseException
     */
    public function purchase(
        int $productId,
        string $taxNumber,
        string $couponCode,
        PaymentsProcessorType $processorType
    ): void {
        $calculatedPrice = $this->productPriceCalculator->calculate($productId, $taxNumber, $couponCode);

        foreach ($this->paymentServices as $paymentService) {
            if ($paymentService->supports($processorType)) {
                $paymentService->paymentExecute($calculatedPrice);
            }
        }
    }
}
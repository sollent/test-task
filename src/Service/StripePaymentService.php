<?php

declare(strict_types=1);

namespace App\Service;

use App\Enum\PaymentsProcessorType;
use App\Exception\ProductPurchaseException;
use Systemeio\TestForCandidates\PaymentProcessor\StripePaymentProcessor;

final readonly class StripePaymentService implements PaymentServiceInterface
{
    public function __construct(
        private StripePaymentProcessor $stripePaymentProcessor
    )
    {
    }

    public function paymentExecute(float $price): void
    {
        $paymentResult = $this->stripePaymentProcessor->processPayment($price);

        if ($paymentResult === false) {
            throw new ProductPurchaseException('Payment failed');
        }
    }

    public function supports(PaymentsProcessorType $processorType): bool
    {
        return $processorType === PaymentsProcessorType::Stripe;
    }
}
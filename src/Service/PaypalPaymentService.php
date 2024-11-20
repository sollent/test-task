<?php

declare(strict_types=1);

namespace App\Service;

use App\Enum\PaymentsProcessorType;
use App\Exception\ProductPurchaseException;
use Systemeio\TestForCandidates\PaymentProcessor\PaypalPaymentProcessor;

final readonly class PaypalPaymentService implements PaymentServiceInterface
{
    public function __construct(
        private PaypalPaymentProcessor $paypalPaymentProcessor
    )
    {
    }

    public function paymentExecute(float $price): void
    {
        try {
            $this->paypalPaymentProcessor->pay(intval($price * 100));
        } catch (\Exception) {
            throw new ProductPurchaseException('Payment failed');
        }
    }

    public function supports(PaymentsProcessorType $processorType): bool
    {
        return $processorType === PaymentsProcessorType::Paypal;
    }
}
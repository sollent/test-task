<?php

declare(strict_types=1);

namespace App\Service;

use App\Enum\PaymentsProcessorType;
use App\Exception\ProductPurchaseException;

interface PaymentServiceInterface
{
    public function supports(PaymentsProcessorType $processorType): bool;

    /**
     * @param float $price payment amount in currency
     *
     * @throws ProductPurchaseException
     */
    public function paymentExecute(float $price): void;
}
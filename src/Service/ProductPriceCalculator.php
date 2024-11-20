<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Coupon;
use App\Entity\Product;
use App\Enum\CouponType;
use App\Exception\ProductPriceCalculationException;
use App\Repository\CouponRepositoryInterface;
use App\Repository\ProductRepositoryInterface;

final class ProductPriceCalculator
{
    /**
     * @var float[]
     */
    private const array TAX_RATES = [
        'DE' => 0.19,
        'IT' => 0.22,
        'FR' => 0.20,
        'GR' => 0.24,
    ];

    public function __construct(
        private readonly ProductRepositoryInterface $productRepository,
        private readonly CouponRepositoryInterface $couponRepository,
    ) {
    }

    /**
     * @throws ProductPriceCalculationException
     */
    public function calculate(int $productId, string $taxNumber, string $couponCode): float
    {
        /** @var Product $product */
        $product = $this->productRepository->find($productId);

        if (null === $product) {
            throw new ProductPriceCalculationException('Product not found');
        }

        $coupon = $this->couponRepository->findOneBy(['code' => $couponCode]);

        if (null === $coupon) {
            throw new ProductPriceCalculationException(sprintf('Coupon "%s" not found', $couponCode));
        }

        $price = $product->getPrice();

        $calculatedPrice = $this->applyCoupon($price, $coupon);
        $calculatedPrice = $this->applyTax($calculatedPrice, $taxNumber);

        return round($calculatedPrice, 3);
    }

    private function applyCoupon(float $price, Coupon $coupon): float
    {
        return match ($coupon->getType()) {
            CouponType::Percent => $price - ($price * $coupon->getValue() / 100),
            CouponType::Fixed => max(0, $price - $coupon->getValue()),
        };
    }

    private function applyTax(float $price, string $taxNumber): float
    {
        $countryCode = substr($taxNumber, 0, 2);
        $taxRate = self::TAX_RATES[$countryCode] ?? 0;

        return $price + ($price * $taxRate);
    }
}
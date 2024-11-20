<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Coupon;
use App\Enum\CouponType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CouponFixtures extends Fixture
{
    private const array COUPONS = [
        ['type' => CouponType::Fixed, 'value' => 5],
        ['type' => CouponType::Fixed, 'value' => 7],
        ['type' => CouponType::Fixed, 'value' => 8],
        ['type' => CouponType::Percent, 'value' => 10],
        ['type' => CouponType::Percent, 'value' => 20],
        ['type' => CouponType::Percent, 'value' => 50],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::COUPONS as $couponItem) {
            $manager->persist(new Coupon($couponItem['type'], $couponItem['value']));
        }

        $manager->flush();
    }
}

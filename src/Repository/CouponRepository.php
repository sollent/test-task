<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Coupon;

final class CouponRepository extends AbstractRepository implements CouponRepositoryInterface
{
    protected function getEntityClass(): string
    {
        return Coupon::class;
    }
}
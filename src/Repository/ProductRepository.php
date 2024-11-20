<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Product;

final class ProductRepository extends AbstractRepository implements ProductRepositoryInterface
{
    protected function getEntityClass(): string
    {
        return Product::class;
    }
}
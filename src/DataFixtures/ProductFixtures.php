<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    private const array PRODUCTS = [
        ['name' => 'Iphone', 'price' => 100],
        ['name' => 'Наушники', 'price' => 20],
        ['name' => 'Чехол', 'price' => 10],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::PRODUCTS as $productItem) {
            $manager->persist(new Product($productItem['name'], $productItem['price']));
        }

        $manager->flush();
    }
}

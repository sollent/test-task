<?php

declare(strict_types=1);

namespace App\Entity;

use App\Enum\CouponType;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Coupon
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\Column(type: '', unique: true, enumType: CouponType::class)]
    private CouponType $type;

    #[ORM\Column(type: "integer")]
    private int $value;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): Coupon
    {
        $this->id = $id;

        return $this;
    }

    public function getType(): CouponType
    {
        return $this->type;
    }

    public function setType(CouponType $type): Coupon
    {
        $this->type = $type;

        return $this;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function setValue(int $value): Coupon
    {
        $this->value = $value;

        return $this;
    }
}
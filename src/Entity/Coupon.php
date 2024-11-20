<?php

declare(strict_types=1);

namespace App\Entity;

use App\Enum\CouponType;
use App\Repository\CouponRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CouponRepository::class)]
class Coupon
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\Column(type: 'string', enumType: CouponType::class)]
    private CouponType $type;

    #[ORM\Column(type: "integer")]
    private int $value;

    #[ORM\Column(type: "string", unique: true)]
    private string $code;

    public function __construct(CouponType $type, int $value)
    {
        $this->type = $type;
        $this->value = $value;

        $this->code = sprintf('%s%s', $type->value, $value);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getType(): CouponType
    {
        return $this->type;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function getCode(): string
    {
        return $this->code;
    }
}
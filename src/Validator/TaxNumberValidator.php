<?php

declare(strict_types=1);

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class TaxNumberValidator extends ConstraintValidator
{
    private const array PATTERNS = [
        'DE' => '/^DE\d{9}$/',
        'IT' => '/^IT\d{11}$/',
        'GR' => '/^GR\d{9}$/',
        'FR' => '/^FR[A-Z]{2}\d{9}$/',
    ];

    /**
     * @param TaxNumber $constraint
     */
    public function validate($value, Constraint $constraint): void
    {
        if (null === $value || '' === $value) {
            return;
        }

        $countryCode = substr($value, 0, 2);
        $pattern = self::PATTERNS[$countryCode] ?? null;

        if (!$pattern || !preg_match($pattern, $value)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }
    }
}
<?php


namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class DoubleLetterValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        if (null === $value || '' === $value) {
            return;
        }

        $value = strtoupper($value);
        $counts = [];

        for ($i = 0; $i < strlen($value); $i++) {
            $char = $value[$i];
            if (!ctype_alpha($char)) {
                $this->context->buildViolation($constraint->message)->addViolation();
                return;
            }
            $counts[$char] = ($counts[$char] ?? 0) + 1;
        }

        foreach ($counts as $count) {
            if ($count !== 2) {
                $this->context->buildViolation($constraint->message)->addViolation();
                return;
            }
        }
    }
}

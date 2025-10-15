<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class DoubleLetter extends Constraint
{
    public string $message = 'Each letter must occur exactly twice (e.g., "AABB").';
}

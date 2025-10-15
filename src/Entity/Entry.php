<?php

namespace App\Entity;

use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator as AppAssert;

class Entry
{
    #[Assert\NotBlank(message: "Name cannot be empty.")]
    #[Assert\Length(min: 1, minMessage: "Name must have at least 1 character.")]
    public ?string $name = null;

    #[Assert\NotBlank(message: "Birthday cannot be empty.")]
    #[Assert\Date(message: "Please enter a valid date.")]
    #[Assert\LessThan("today", message: "Birthday must be in the past.")]
    public ?string $birthday = null;

    #[Assert\NotBlank(message: "Score cannot be empty.")]
    #[Assert\Type(type: 'numeric', message: "Score must be a number.")]
    public $score;

    #[Assert\NotBlank(message: "Custom field cannot be empty.")]
    #[AppAssert\DoubleLetter]
    public ?string $customField = null;
}

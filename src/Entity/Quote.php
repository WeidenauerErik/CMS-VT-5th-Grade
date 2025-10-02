<?php

namespace App\Entity;

use App\Repository\QuoteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuoteRepository::class)]
class Quote
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $msg = null;

    #[ORM\ManyToOne(inversedBy: 'quotes')]
    private ?Movie $movieRelation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getMsg(): ?string
    {
        return $this->msg;
    }

    public function setMsg(string $msg): static
    {
        $this->msg = $msg;

        return $this;
    }

    public function getMovieRelation(): ?Movie
    {
        return $this->movieRelation;
    }

    public function setMovieRelation(?Movie $movieRelation): static
    {
        $this->movieRelation = $movieRelation;

        return $this;
    }
}

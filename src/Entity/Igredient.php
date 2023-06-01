<?php

namespace App\Entity;

use App\Repository\IgredientRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Generator;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: IgredientRepository::class)]
class Igredient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Assert\Length(
        min:2,
        max:50,
        minMessage:'Your first name must be at least {{ limit }} characters long',
        maxMessage:'Your first name cannot be longer than {{ limit }} characters',
    )]
    #[Assert\NotBlank()]
    private ?string $name = null;

    #[ORM\Column]
    #[Assert\Positive()]
    #[Assert\LessThan(200)]
    #[Assert\NotNull()]

    private ?float $price = null;

    #[ORM\Column]
    #[Assert\NotNull]
    private ?\DateTimeImmutable $createdAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();

    }
  

}
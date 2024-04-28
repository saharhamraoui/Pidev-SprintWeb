<?php

namespace App\Entity;

use App\Repository\IngredientsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;





 #[ORM\Entity(repositoryClass: IngredientsRepository::class)]

class Ingredients
{   
    #[ORM\Id]
    #[ORM\Column]
    #[ORM\GeneratedValue]
    private $iding;

    #[Assert\NotBlank(message: ' the bame cannot be null ')]
    #[Assert\Length(max: 50, maxMessage: 'you cant pass the {{ limit }} character.')]
    #[ORM\Column(length:50)]
    private ?string $nameing;

    #[Assert\NotBlank(message: ' the amount cant be null ')]
    #[Assert\Length(max: 50, maxMessage: 'you cant pass the {{ limit }} character.')]
    #[ORM\Column(length:50)]
    private ?string $amount;

    #[ORM\ManyToOne(targetEntity: Recette::class)]
    #[ORM\JoinColumn(name: "idrec", referencedColumnName: "idrec")]
    private $idrec;

    public function getIding(): ?int
    {
        return $this->iding;
    }

    public function getNameing(): ?string
    {
        return $this->nameing;
    }

    public function setNameing(string $nameing): static
    {
        $this->nameing = $nameing;

        return $this;
    }

    public function getAmount(): ?string
    {
        return $this->amount;
    }

    public function setAmount(string $amount): static
    {
        $this->amount = $amount;

        return $this;
    }

    public function getIdrec(): ?Recette
    {
        return $this->idrec;
    }

    public function setIdrec(?Recette $idrec): static
    {
        $this->idrec = $idrec;

        return $this;
    }


}

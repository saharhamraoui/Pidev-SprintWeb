<?php

namespace App\Entity;

use App\Repository\IngredientsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Ingredients
 *
 * @ORM\Table(name="ingredients", indexes={@ORM\Index(name="idRec", columns={"idRec"})})
 * @ORM\Entity(repositoryClass=App\Repository\IngredientsRepository::class)
 */

 #[ORM\Entity(repositoryClass: IngredientsRepository::class)]

class Ingredients
{   
    #[ORM\Id]
    #[ORM\Column]
    #[ORM\GeneratedValue]
    private $iding;

    /**
     * @var string
     *
     * @ORM\Column(name="nameIng", type="string", length=50, nullable=false)
     */
    private $nameing;

    /**
     * @var string
     *
     * @ORM\Column(name="amount", type="string", length=50, nullable=false)
     */
    private $amount;

    /**
     * @var \Recette
     *
     * @ORM\ManyToOne(targetEntity="Recette")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idRec", referencedColumnName="idRec")
     * })
     */
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

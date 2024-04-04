<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenuRepository;

/**
 * Menu
 *
 * @ORM\Table(name="menu", indexes={@ORM\Index(name="restaurantId", columns={"restaurantId"})})
 * @ORM\Entity
 */
#[ORM\Entity(repositoryClass:MenuRepository::class)]
class Menu
{
    /**
     * @var int
     *
     * @ORM\Column(name="idP", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idp;

    /**
     * @var string
     *
     * @ORM\Column(name="nameP", type="string", length=30, nullable=false)
     */
    private $namep;

    /**
     * @var float
     *
     * @ORM\Column(name="priceP", type="float", precision=10, scale=0, nullable=false)
     */
    private $pricep;

    /**
     * @var string
     *
     * @ORM\Column(name="categoryP", type="string", length=100, nullable=false)
     */
    private $categoryp;

    /**
     * @var string
     *
     * @ORM\Column(name="ingredientsP", type="string", length=255, nullable=false)
     */
    private $ingredientsp;

    /**
     * @var string
     *
     * @ORM\Column(name="imageP", type="string", length=255, nullable=false)
     */
    private $imagep;

    /**
     * @var \Restaurant
     *
     * @ORM\ManyToOne(targetEntity="Restaurant")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="restaurantId", referencedColumnName="restaurantId")
     * })
     */
    private $restaurantid;

    public function getIdp(): ?int
    {
        return $this->idp;
    }

    public function getNamep(): ?string
    {
        return $this->namep;
    }

    public function setNamep(string $namep): static
    {
        $this->namep = $namep;

        return $this;
    }

    public function getPricep(): ?float
    {
        return $this->pricep;
    }

    public function setPricep(float $pricep): static
    {
        $this->pricep = $pricep;

        return $this;
    }

    public function getCategoryp(): ?string
    {
        return $this->categoryp;
    }

    public function setCategoryp(string $categoryp): static
    {
        $this->categoryp = $categoryp;

        return $this;
    }

    public function getIngredientsp(): ?string
    {
        return $this->ingredientsp;
    }

    public function setIngredientsp(string $ingredientsp): static
    {
        $this->ingredientsp = $ingredientsp;

        return $this;
    }

    public function getImagep(): ?string
    {
        return $this->imagep;
    }

    public function setImagep(string $imagep): static
    {
        $this->imagep = $imagep;

        return $this;
    }

    public function getRestaurantid(): ?Restaurant
    {
        return $this->restaurantid;
    }

    public function setRestaurantid(?Restaurant $restaurantid): static
    {
        $this->restaurantid = $restaurantid;

        return $this;
    }


}

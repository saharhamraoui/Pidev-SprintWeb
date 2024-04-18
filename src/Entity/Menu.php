<?php

namespace App\Entity;

use App\Repository\MenuRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;



 #[ORM\Entity(repositoryClass: MenuRepository::class)]

class Menu
{
    #[ORM\Id]
    #[ORM\Column]
    #[ORM\GeneratedValue]
    private $idp;

    #[Assert\NotBlank(message: ' the name cant be null ')]
    #[Assert\Length(max: 30, maxMessage: 'you cant pass the {{ limit }} character.')]
    #[ORM\Column(length:30)]
    private ?string $namep;


     #[ORM\Column(type: "float", options: ["precision" => 10, "scale" => 0])]
     #[Assert\NotBlank(message: 'The price cannot be null')]
    private ?float $pricep;

    #[Assert\NotBlank(message: ' the category cannot be null ')]
    #[Assert\Length(max: 100, maxMessage: 'you cant pass the {{ limit }} character.')]
    #[ORM\Column(length:100)]
    private ?string $categoryp;

    #[Assert\NotBlank(message: ' this field cannot be null ')]
    #[Assert\Length(max: 255, maxMessage: 'you cant pass the {{ limit }} character.')]
    #[ORM\Column(length:255)]
    private ?string $ingredientsp;

    #[Assert\NotBlank(message: ' the image cant be null ')]
    #[Assert\Length(max: 255, maxMessage: 'you cant pass the {{ limit }} character.')]
    #[ORM\Column(length:255)]
    private ?string $imagep;

    #[ORM\ManyToOne(targetEntity: Restaurant::class)]
    #[ORM\JoinColumn(name: "restaurantid", referencedColumnName: "restaurantid")]
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

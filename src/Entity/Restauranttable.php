<?php

namespace App\Entity;
use App\Repository\restauranttableRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;



 #[ORM\Entity(repositoryClass: RestauranttableRepository::class)]

class Restauranttable
{
    #[ORM\Id]
    #[ORM\Column]
    #[ORM\GeneratedValue]
    private ?int $tableid;



    /**
     * @var bool|null
     *
     * @ORM\Column(name="isOccupied", type="boolean", nullable=true)
     */
    private $isoccupied;

    /**
     * @var \Restaurant
     *
     * @ORM\ManyToOne(targetEntity="Restaurant")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="restaurantId", referencedColumnName="restaurantId")
     * })
     */
    private $restaurantid;

    public function getTableid(): ?int
    {
        return $this->tableid;
    }

    public function isIsoccupied(): ?bool
    {
        return $this->isoccupied;
    }

    public function setIsoccupied(?bool $isoccupied): static
    {
        $this->isoccupied = $isoccupied;

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

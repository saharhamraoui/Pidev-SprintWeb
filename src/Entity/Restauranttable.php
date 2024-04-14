<?php

namespace App\Entity;

use Doctrine\ORM\Repository;
use Doctrine\ORM\Mapping as ORM;

use App\Repository\RestauranttableRepository;

#[ORM\Entity(RepositoryClass: RestauranttableRepository::class)]
class Restauranttable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private $tableid;

    #[ORM\Column]
    private $isoccupied;

    #[ORM\ManyToMany(inversedBy: 'Restauranttable')]
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

<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\RestaurantTableRepository;

/**
 * Restauranttable
 *
 * @ORM\Table(name="restauranttable", indexes={@ORM\Index(name="restaurantId", columns={"restaurantId"})})
 * @ORM\Entity
 */
#[ORM\Entity(repositoryClass:RestaurantTableRepository::class)]
class Restauranttable
{
    /**
     * @var int
     *
     * @ORM\Column(name="tableId", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $tableid;

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

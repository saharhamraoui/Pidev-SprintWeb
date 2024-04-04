<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ReservationRepository;

/**
 * Reservation
 *
 * @ORM\Table(name="reservation", indexes={@ORM\Index(name="tableId", columns={"tableId"}), @ORM\Index(name="idUser", columns={"userId"})})
 * @ORM\Entity
 */
#[ORM\Entity(repositoryClass:ReservationRepository::class)]
class Reservation
{
    /**
     * @var int
     *
     * @ORM\Column(name="reservationId", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $reservationid;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="dateTime", type="datetime", nullable=true)
     */
    private $datetime;

    /**
     * @var int|null
     *
     * @ORM\Column(name="numberOfPersons", type="integer", nullable=true)
     */
    private $numberofpersons;

    /**
     * @var \Restauranttable
     *
     * @ORM\ManyToOne(targetEntity="Restauranttable")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tableId", referencedColumnName="tableId")
     * })
     */
    private $tableid;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="userId", referencedColumnName="idUser")
     * })
     */
    private $userid;

    public function getReservationid(): ?int
    {
        return $this->reservationid;
    }

    public function getDatetime(): ?\DateTimeInterface
    {
        return $this->datetime;
    }

    public function setDatetime(?\DateTimeInterface $datetime): static
    {
        $this->datetime = $datetime;

        return $this;
    }

    public function getNumberofpersons(): ?int
    {
        return $this->numberofpersons;
    }

    public function setNumberofpersons(?int $numberofpersons): static
    {
        $this->numberofpersons = $numberofpersons;

        return $this;
    }

    public function getTableid(): ?Restauranttable
    {
        return $this->tableid;
    }

    public function setTableid(?Restauranttable $tableid): static
    {
        $this->tableid = $tableid;

        return $this;
    }

    public function getUserid(): ?User
    {
        return $this->userid;
    }

    public function setUserid(?User $userid): static
    {
        $this->userid = $userid;

        return $this;
    }


}

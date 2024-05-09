<?php

namespace App\Entity;

use Doctrine\ORM\Repository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

use App\Repository\ReservationRepository;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private $reservationid;

    #[ORM\Column]
    private $datetime;

    #[ORM\Column]
    private $numberofpersons;

    #[ORM\ManyToOne(targetEntity: Restauranttable::class)]
    #[ORM\JoinColumn(name: "tableId", referencedColumnName: "tableid")]
    private $tableid;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: "userId", referencedColumnName: "iduser")]
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

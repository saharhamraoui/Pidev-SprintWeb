<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\RdvRepository;

/**
 * Rdv
 *
 * @ORM\Table(name="rdv")
 * @ORM\Entity
 */
#[ORM\Entity(repositoryClass:RdvRepository::class)]
class Rdv
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255, nullable=false)
     */
    private $prenom;

    /**
     * @var int
     *
     * @ORM\Column(name="numTel", type="integer", nullable=false)
     */
    private $numtel;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    private $email;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateRdv", type="date", nullable=false)
     */
    private $daterdv;

    /**
     * @var int
     *
     * @ORM\Column(name="id_cabinet", type="integer", nullable=false)
     */
    private $idCabinet;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNumtel(): ?int
    {
        return $this->numtel;
    }

    public function setNumtel(int $numtel): static
    {
        $this->numtel = $numtel;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getDaterdv(): ?\DateTimeInterface
    {
        return $this->daterdv;
    }

    public function setDaterdv(\DateTimeInterface $daterdv): static
    {
        $this->daterdv = $daterdv;

        return $this;
    }

    public function getIdCabinet(): ?int
    {
        return $this->idCabinet;
    }

    public function setIdCabinet(int $idCabinet): static
    {
        $this->idCabinet = $idCabinet;

        return $this;
    }


}

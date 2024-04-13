<?php

namespace App\Entity;

use App\Repository\RdvRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\RestaurantRepository;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Rdv
 *
 * @ORM\Table(name="rdv", indexes={@ORM\Index(name="id_cabinetFK", columns={"id_cabinet"})})
 * @ORM\Entity(repositoryClass=App\Repository\RdvRepository::class)
 */

 #[ORM\Entity(repositoryClass: RdvRepository::class)]

class Rdv
{
    #[ORM\Id]
    #[ORM\Column]
    #[ORM\GeneratedValue]
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
     * @var \Cabinet
     *
     * @ORM\ManyToOne(targetEntity="Cabinet")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_cabinet", referencedColumnName="id")
     * })
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

    public function getIdCabinet(): ?Cabinet
    {
        return $this->idCabinet;
    }

    public function setIdCabinet(?Cabinet $idCabinet): static
    {
        $this->idCabinet = $idCabinet;

        return $this;
    }


}

<?php

namespace App\Entity;

use App\Repository\RdvRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\RestaurantRepository;
use DateTime;
use Symfony\Component\Validator\Constraints as Assert;



 #[ORM\Entity(repositoryClass: RdvRepository::class)]

class Rdv
{
    #[ORM\Id]
    #[ORM\Column]
    #[ORM\GeneratedValue]
    private $id;

    #[Assert\NotBlank(message: ' the first name cant be null ')]
    #[Assert\Length(max: 255, maxMessage: 'you cant pass the {{ limit }} character.')]
    #[ORM\Column(length:255)]
    private ?string $nom;

    #[Assert\NotBlank(message: ' the last name cant be null ')]
    #[Assert\Length(max: 255, maxMessage: 'you cant pass the {{ limit }} character.')]
    #[ORM\Column(length:255)]
    private ?string $prenom;

    #[Assert\NotBlank(message: ' the tel cant be null ')]
    #[ORM\Column(type: "integer")]
    private $numtel;

    #[Assert\NotBlank(message: '  "Email" cant be null .')]
    #[Assert\Email(message: 'please enter a valid email.')]
    #[ORM\Column(length: 50)]
    private ?string $email;

    #[ORM\Column(type: "date", nullable: true)]

    private ?DateTime $daterdv;

    #[ORM\ManyToOne(targetEntity: Cabinet::class)]
    #[ORM\JoinColumn(name: "id_cabinet", referencedColumnName: "id")]
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

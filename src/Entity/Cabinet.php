<?php

namespace App\Entity;
use App\Repository\CabinetRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;



 #[ORM\Entity(repositoryClass: CabinetRepository::class)]

class Cabinet
{
    #[ORM\Id]
    #[ORM\Column]
    #[ORM\GeneratedValue]
    private $id;

    #[Assert\NotBlank(message: ' the name cant be null ')]
    #[Assert\Length(max: 255, maxMessage: 'you cant pass the {{ limit }} character.')]
    #[ORM\Column(length:255)]
    private ?string $nom;

    #[Assert\NotBlank(message: ' the address cant be null ')]
    #[Assert\Length(max: 255, maxMessage: 'you cant pass the {{ limit }} character.')]
    #[ORM\Column(length:255)]
    private ?string $adresse;

    #[Assert\NotBlank(message: ' the code cant be null ')]
    #[ORM\Column(type: "integer")]
    private $codepostal;

    #[Assert\NotBlank(message: '  "Email" cannot be null .')]
    #[Assert\Email(message: 'please enter a valid email.')]
    #[ORM\Column(length: 255)] 
    private ?string $adressemail;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: "id_medecin", referencedColumnName: "iduser")]
    private $idMedecin;

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

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getCodepostal(): ?int
    {
        return $this->codepostal;
    }

    public function setCodepostal(int $codepostal): static
    {
        $this->codepostal = $codepostal;

        return $this;
    }

    public function getAdressemail(): ?string
    {
        return $this->adressemail;
    }

    public function setAdressemail(string $adressemail): static
    {
        $this->adressemail = $adressemail;

        return $this;
    }

    public function getIdMedecin(): ?User
    {
        return $this->idMedecin;
    }

    public function setIdMedecin(?User $idMedecin): static
    {
        $this->idMedecin = $idMedecin;

        return $this;
    }


}

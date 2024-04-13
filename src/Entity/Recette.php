<?php

namespace App\Entity;

use App\Repository\RecetteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


 #[ORM\Entity(repositoryClass: RecetteRepository::class)]

class Recette
{
    #[ORM\Id]
    #[ORM\Column]
    #[ORM\GeneratedValue]
    private ?int $idrec;

    #[Assert\NotBlank(message: ' the  name cant be null ')]
    #[Assert\Length(max: 35, maxMessage: 'you cant pass the {{ limit }} character.')]
    #[ORM\Column(length:35)]
    private ?string $nomrec;

    #[Assert\NotBlank(message: ' the category cant be null ')]
    #[Assert\Length(max: 35, maxMessage: 'you cant pass the {{ limit }} character.')]
    #[ORM\Column(length:35)]
    private ?string $categoryr;

    #[Assert\NotBlank(message: ' the difficulty cant be null ')]
    #[Assert\Length(max: 30, maxMessage: 'you cant pass the {{ limit }} character.')]
    #[ORM\Column(length:30)]
    private ?string $difficulty;



    #[Assert\NotBlank(message: ' the serves cant be null ')]
    #[ORM\Column(type: "integer")]
    private ?int $serves;

    #[Assert\NotBlank(message: ' the prep cant be null ')]
    #[Assert\Length(max: 35, maxMessage: 'you cant pass the {{ limit }} character.')]
    #[ORM\Column(length:35)]
    private ?string  $prep;

    #[Assert\NotBlank(message: ' the description cant be null ')]
    #[Assert\Length(max: 6000, maxMessage: 'you cant pass the {{ limit }} character.')]
    #[ORM\Column(length:6000)]
    private ?string $description;

    #[Assert\NotBlank(message: ' the date cant be null ')]
    #[Assert\Length(max: 35, maxMessage: 'you cant pass the {{ limit }} character.')]
    #[ORM\Column(length:35)]
    private ?string $date;



    #[ORM\Column(type: "integer")]
    #[Assert\NotBlank(message: ' the rating cant be null ')]
    private ?int $rating;



    #[Assert\NotBlank(message: ' the image cant be null ')]
    #[Assert\Length(max: 35, maxMessage: 'you cant pass the {{ limit }} character.')]
    #[ORM\Column(length:35)]
    private ?string $imagerec;



    #[ORM\ManyToOne(User::class)]
    #[ORM\JoinColumn(name: "idUser", referencedColumnName: "idUser")]
    #[Assert\NotBlank(message:'cant be null')]
    private $iduser;



    public function getIdrec(): ?int
    {
        return $this->idrec;
    }

    public function getNomrec(): ?string
    {
        return $this->nomrec;
    }

    public function setNomrec(string $nomrec): static
    {
        $this->nomrec = $nomrec;

        return $this;
    }

    public function getCategoryr(): ?string
    {
        return $this->categoryr;
    }

    public function setCategoryr(string $categoryr): static
    {
        $this->categoryr = $categoryr;

        return $this;
    }

    public function getDifficulty(): ?string
    {
        return $this->difficulty;
    }

    public function setDifficulty(string $difficulty): static
    {
        $this->difficulty = $difficulty;

        return $this;
    }

    public function getServes(): ?int
    {
        return $this->serves;
    }

    public function setServes(int $serves): static
    {
        $this->serves = $serves;

        return $this;
    }

    public function getPrep(): ?string
    {
        return $this->prep;
    }

    public function setPrep(string $prep): static
    {
        $this->prep = $prep;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(string $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(int $rating): static
    {
        $this->rating = $rating;

        return $this;
    }

    public function getImagerec(): ?string
    {
        return $this->imagerec;
    }

    public function setImagerec(string $imagerec): static
    {
        $this->imagerec = $imagerec;

        return $this;
    }

    public function getIduser(): ?User
    {
        return $this->iduser;
    }

    public function setIduser(?User $iduser): static
    {
        $this->iduser = $iduser;

        return $this;
    }


}

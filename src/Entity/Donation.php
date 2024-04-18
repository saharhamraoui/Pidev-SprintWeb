<?php

namespace App\Entity;

use App\Repository\DonationRepository;
use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: DonationRepository::class)]

class Donation
{
    #[ORM\Id]
    #[ORM\Column]
    #[ORM\GeneratedValue]
    private ?int $iddon;
    

    #[Assert\NotBlank(message: ' the value cant be null ')]
    #[ORM\Column(type: "integer")]
    private ?int $valeurdon;



    #[ORM\Column(type: "date", nullable: true)]
    private ?DateTime $history;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: "idDonator", referencedColumnName: "idUser")]
    private ?int $iddonator;


    #[ORM\ManyToOne(targetEntity: Campaign::class)]
    #[ORM\JoinColumn(name: "idCamp", referencedColumnName: "idCamp")]
     private ?int $idcamp; 


     


    public function getIddon(): ?int
    {
        return $this->iddon;
    }

    public function getValeurdon(): ?int
    {
        return $this->valeurdon;
    }

    public function setValeurdon(int $valeurdon): static
    {
        $this->valeurdon = $valeurdon;

        return $this;
    }

    public function getHistory(): ?\DateTimeInterface
    {
        return $this->history;
    }

    public function setHistory(?\DateTimeInterface $history): static
    {
        $this->history = $history;

        return $this;
    }

    public function getIddonator(): ?User
    {
        return $this->iddonator;
    }

    public function setIddonator(?User $iddonator): static
    {
        $this->iddonator = $iddonator;

        return $this;
    }

    public function getIdcamp(): ?Campaign
    {
        return $this->idcamp;
    }

    public function setIdcamp(?Campaign $idcamp): static
    {
        $this->idcamp = $idcamp;

        return $this;
    }


}

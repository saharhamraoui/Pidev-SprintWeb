<?php

namespace App\Entity;

use App\Repository\LivraisonRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: LivraisonRepository::class)]

class Livraison
{
    #[ORM\Id]
    #[ORM\Column]
    #[ORM\GeneratedValue]
    private $idlivraison;

   
    #[Assert\NotBlank(message: ' the id cant be null ')]
    #[ORM\Column(type: "integer")]
    private $idcommande;



    #[Assert\NotBlank(message: ' the status cant be null ')]
    #[Assert\Length(max: 255, maxMessage: 'you cant pass the {{ limit }} character.')]
    #[ORM\Column(length:255)]
    private $statut;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumns([
    new ORM\JoinColumn(name: "idLivreur", referencedColumnName: "idUser")])]
    private $idlivreur;

    public function getIdlivraison(): ?int
    {
        return $this->idlivraison;
    }

    public function getIdcommande(): ?int
    {
        return $this->idcommande;
    }

    public function setIdcommande(int $idcommande): static
    {
        $this->idcommande = $idcommande;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): static
    {
        $this->statut = $statut;

        return $this;
    }

    public function getIdlivreur(): ?User
    {
        return $this->idlivreur;
    }

    public function setIdlivreur(?User $idlivreur): static
    {
        $this->idlivreur = $idlivreur;

        return $this;
    }


}

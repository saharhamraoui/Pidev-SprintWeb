<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CommandeRepository;
use Symfony\Component\Validator\Constraints as Assert;
use DateTime;



#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\Column]
    #[ORM\GeneratedValue]
    private $idcommande;


    #[ORM\Column(type: "datetime")]
    #[Assert\NotBlank(message: "La date de reclamation doit être remplie ")]
    private ?DateTime $datecommande = null;


    #[Assert\NotBlank(message: ' the address cant be null ')]
    #[Assert\Length(max: 30, maxMessage: 'you cant pass the {{ limit }} character.')]
    #[ORM\Column(length: 30)]
    private ?string $adresselivraison;

    #[ORM\Column(type: "float")]
    #[Assert\NotBlank(message: 'The total price cannot be null')]
    private ?string $montanttotalcommande;

    #[Assert\NotBlank(message: ' the plate cant be null ')]
    #[Assert\Length(max: 255, maxMessage: 'you cant pass the {{ limit }} character.')]
    #[ORM\Column(length: 255)]
    private ?string $plats;



    #[ORM\ManyToOne(targetEntity: "Restaurant")]
    #[ORM\JoinColumn(name: "restaurantid", referencedColumnName: "restaurantid")]
    private ?Restaurant $restaurantid;

    #[ORM\ManyToOne(targetEntity: "User")]
    #[ORM\JoinColumn(name: "iduser", referencedColumnName: "iduser")]
    private ?User $iduser;

    public function getIdcommande(): ?int
    {
        return $this->idcommande;
    }

    public function getDatecommande(): ?\DateTimeInterface
    {
        return $this->datecommande;
    }

    public function setDatecommande(\DateTimeInterface $datecommande): static
    {
        $this->datecommande = $datecommande;

        return $this;
    }

    public function getAdresselivraison(): ?string
    {
        return $this->adresselivraison;
    }

    public function setAdresselivraison(string $adresselivraison): static
    {
        $this->adresselivraison = $adresselivraison;

        return $this;
    }

    public function getMontanttotalcommande(): ?float
    {
        return $this->montanttotalcommande;
    }

    public function setMontanttotalcommande(float $montanttotalcommande): static
    {
        $this->montanttotalcommande = $montanttotalcommande;

        return $this;
    }

    public function getPlats(): ?string
    {
        return $this->plats;
    }

    public function setPlats(string $plats): static
    {
        $this->plats = $plats;

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

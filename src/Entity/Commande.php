<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Commande
 *
 * @ORM\Table(name="commande", indexes={@ORM\Index(name="frK_idUser", columns={"idUser"}), @ORM\Index(name="restaurantId", columns={"restaurantId"})})
 * @ORM\Entity(repositoryClass=App\Repository\CommandeRepository::class)
 */
class Commande
{
    /**
     * @var int
     *
     * @ORM\Column(name="idCommande", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idcommande;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCommande", type="datetime", nullable=false)
     */
    private $datecommande;

    /**
     * @var string
     *
     * @ORM\Column(name="adresseLivraison", type="string", length=30, nullable=false)
     */
    private $adresselivraison;

    /**
     * @var float
     *
     * @ORM\Column(name="montantTotalCommande", type="float", precision=10, scale=0, nullable=false)
     */
    private $montanttotalcommande;

    /**
     * @var string
     *
     * @ORM\Column(name="plats", type="string", length=255, nullable=false)
     */
    private $plats;

    /**
     * @var \Restaurant
     *
     * @ORM\ManyToOne(targetEntity="Restaurant")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="restaurantId", referencedColumnName="restaurantId")
     * })
     */
    private $restaurantid;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idUser", referencedColumnName="idUser")
     * })
     */
    private $iduser;

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

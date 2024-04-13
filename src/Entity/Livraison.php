<?php

namespace App\Entity;

use App\Repository\LivraisonRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Livraison
 *
 * @ORM\Table(name="livraison", indexes={@ORM\Index(name="frk_idLivreur", columns={"idLivreur"}), @ORM\Index(name="fk_keyIdCommande", columns={"idCommande"})})
 * @ORM\Entity(repositoryClass=App\Repository\LivraisonRepository::class)
 */
#[ORM\Entity(repositoryClass: LivraisonRepository::class)]

class Livraison
{
    #[ORM\Id]
    #[ORM\Column]
    #[ORM\GeneratedValue]
    private $idlivraison;

    /**
     * @var int
     *
     * @ORM\Column(name="idCommande", type="integer", nullable=false)
     */
    private $idcommande;

    /**
     * @var string
     *
     * @ORM\Column(name="statut", type="string", length=255, nullable=false)
     */
    private $statut;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idLivreur", referencedColumnName="idUser")
     * })
     */
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

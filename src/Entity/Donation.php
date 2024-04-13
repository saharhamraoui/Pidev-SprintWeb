<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Donation
 *
 * @ORM\Table(name="donation", indexes={@ORM\Index(name="idCamp", columns={"idCamp"}), @ORM\Index(name="idDonator_FK", columns={"idDonator"})})
 * @ORM\Entity(repositoryClass=App\Repository\DonationRepository::class)
 */
class Donation
{
    /**
     * @var int
     *
     * @ORM\Column(name="idDon", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $iddon;

    /**
     * @var int
     *
     * @ORM\Column(name="valeurDon", type="integer", nullable=false)
     */
    private $valeurdon;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="history", type="date", nullable=true)
     */
    private $history;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idDonator", referencedColumnName="idUser")
     * })
     */
    private $iddonator;

    /**
     * @var \Campaign
     *
     * @ORM\ManyToOne(targetEntity="Campaign")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idCamp", referencedColumnName="idCamp")
     * })
     */
    private $idcamp;

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

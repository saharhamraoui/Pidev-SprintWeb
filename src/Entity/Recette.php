<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Recette
 *
 * @ORM\Table(name="recette", indexes={@ORM\Index(name="idUser", columns={"idUser"})})
 * @ORM\Entity(repositoryClass=App\Repository\RecetteRepository::class)
 */
class Recette
{
    /**
     * @var int
     *
     * @ORM\Column(name="idRec", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idrec;

    /**
     * @var string
     *
     * @ORM\Column(name="nomRec", type="string", length=30, nullable=false)
     */
    private $nomrec;

    /**
     * @var string
     *
     * @ORM\Column(name="categoryR", type="string", length=50, nullable=false)
     */
    private $categoryr;

    /**
     * @var string
     *
     * @ORM\Column(name="difficulty", type="string", length=30, nullable=false)
     */
    private $difficulty;

    /**
     * @var int
     *
     * @ORM\Column(name="serves", type="integer", nullable=false)
     */
    private $serves;

    /**
     * @var string
     *
     * @ORM\Column(name="prep", type="string", length=15, nullable=false)
     */
    private $prep;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=false)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="date", type="string", length=30, nullable=false)
     */
    private $date;

    /**
     * @var int
     *
     * @ORM\Column(name="rating", type="integer", nullable=false)
     */
    private $rating;

    /**
     * @var string
     *
     * @ORM\Column(name="imageRec", type="string", length=255, nullable=false)
     */
    private $imagerec;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idUser", referencedColumnName="idUser")
     * })
     */
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

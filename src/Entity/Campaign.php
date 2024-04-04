<?php

namespace App\Entity;
use App\Repository\CampaignRepository;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Campaign
 *
 * @ORM\Table(name="campaign")
 * @ORM\Entity
 */
#[ORM\Entity(repositoryClass:CampaignRepository::class)]
class Campaign
{
    /**
     * @var int
     *
     * @ORM\Column(name="idCamp", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idcamp;

    /**
     * @var int
     *
     * @ORM\Column(name="number", type="integer", nullable=false)
     */
    private $number;

    /**
     * @var int
     *
     * @ORM\Column(name="goal", type="integer", nullable=false)
     */
    private $goal;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255, nullable=false)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="associationName", type="string", length=255, nullable=false)
     */
    private $associationname;

    /**
     * @var string
     *
     * @ORM\Column(name="campaignType", type="string", length=255, nullable=false)
     */
    private $campaigntype;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=false)
     */
    private $description;

    /**
     * @var string|null
     *
     * @ORM\Column(name="image", type="blob", length=65535, nullable=true)
     */
    private $image;

    /**
     * @var float
     *
     * @ORM\Column(name="current", type="float", precision=10, scale=0, nullable=false)
     */
    private $current = '0';

    public function getIdcamp(): ?int
    {
        return $this->idcamp;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): static
    {
        $this->number = $number;

        return $this;
    }

    public function getGoal(): ?int
    {
        return $this->goal;
    }

    public function setGoal(int $goal): static
    {
        $this->goal = $goal;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getAssociationname(): ?string
    {
        return $this->associationname;
    }

    public function setAssociationname(string $associationname): static
    {
        $this->associationname = $associationname;

        return $this;
    }

    public function getCampaigntype(): ?string
    {
        return $this->campaigntype;
    }

    public function setCampaigntype(string $campaigntype): static
    {
        $this->campaigntype = $campaigntype;

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

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getCurrent(): ?float
    {
        return $this->current;
    }

    public function setCurrent(float $current): static
    {
        $this->current = $current;

        return $this;
    }


}

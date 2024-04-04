<?php

namespace App\Entity;

use App\Repository\CabinetRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Cabinet
 *
 * @ORM\Table(name="cabinet")
 * @ORM\Entity
 */
 #[ORM\Entity(repositoryClass:UserRepository::class)]

class Cabinet
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=255, nullable=false)
     */
    private $adresse;

    /**
     * @var int
     *
     * @ORM\Column(name="codePostal", type="integer", nullable=false)
     */
    private $codepostal;

    /**
     * @var string
     *
     * @ORM\Column(name="adresseMail", type="string", length=255, nullable=false)
     */
    private $adressemail;

    /**
     * @var int
     *
     * @ORM\Column(name="id_medecin", type="integer", nullable=false)
     */
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

    public function getIdMedecin(): ?int
    {
        return $this->idMedecin;
    }

    public function setIdMedecin(int $idMedecin): static
    {
        $this->idMedecin = $idMedecin;

        return $this;
    }


}

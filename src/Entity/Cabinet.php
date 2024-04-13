<?php

namespace App\Entity;
use App\Repository\CabinetRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;



 #[ORM\Entity(repositoryClass: CabinetRepository::class)]

class Cabinet
{
    #[ORM\Id]
    #[ORM\Column]
    #[ORM\GeneratedValue]
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
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_medecin", referencedColumnName="idUser")
     * })
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

    public function getIdMedecin(): ?User
    {
        return $this->idMedecin;
    }

    public function setIdMedecin(?User $idMedecin): static
    {
        $this->idMedecin = $idMedecin;

        return $this;
    }


}

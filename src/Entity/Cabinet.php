<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\CabinetRepository;
use App\Entity\User;


#[ORM\Entity(repositoryClass: CabinetRepository::class)]
class Cabinet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $adresse = null;

    #[ORM\Column]
    private ?int $codepostal = null;

    #[ORM\Column(length: 255)]
    private ?string $adressemail = null;

    #[ORM\ManyToOne(inversedBy: 'cabinets')]
    #[ORM\JoinColumn(name: 'id_medecin', referencedColumnName: 'id')]
    private ?User $id_medecin = null;

    #[ORM\OneToMany(mappedBy: 'id_cabinet', targetEntity: Rdv::class, cascade:["persist","remove"])]
    private Collection $rdvs;

    public function __toString():string{
        return $this->nom;
    }

    public function __construct()
    {
        $this->rdvs = new ArrayCollection();
    }

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
        return $this->id_medecin;
    }

    public function setIdMedecin(?User $id_medecin): static
    {
        $this->id_medecin = $id_medecin;

        return $this;
    }

    /**
     * @return Collection<int, Rdv>
     */
    public function getRdvs(): Collection
    {
        return $this->rdvs;
    }

    public function addRdv(Rdv $rdv): static
    {
        if (!$this->rdvs->contains($rdv)) {
            $this->rdvs->add($rdv);
            $rdv->setIdCabinet($this);
        }

        return $this;
    }

    public function removeRdv(Rdv $rdv): static
    {
        if ($this->rdvs->removeElement($rdv)) {
            // set the owning side to null (unless already changed)
            if ($rdv->getIdCabinet() === $this) {
                $rdv->setIdCabinet(null);
            }
        }

        return $this;
    }

    public function addIdMedecin(User $id_medecin): static
    {
        if (!$this->id_medecin->contains($id_medecin)) {
            $this->id_medecin->add($id_medecin);
            $id_medecin->setIdMedecin($this);
        }

        return $this;
    }

    public function removeIdMedecin(User $id_medecin): static
    {
        if ($this->id_medecin->removeElement($id_medecin)) {
            // set the owning side to null (unless already changed)
            if ($id_medecin->getIdMedecin() === $this) {
                $id_medecin->setIdMedecin(null);
            }
        }

        return $this;
    }



}

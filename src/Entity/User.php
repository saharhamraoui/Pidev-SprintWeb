<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Repository\UserRepository;
use App\Entity\Cabinet;



#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\OneToMany(mappedBy: 'id_medecin', targetEntity: Cabinet::class, cascade:["persist","remove"])]
    private Collection $cabinets;
    

    public function __toString():string{
        return $this->nom;
    }

    public function __construct()
    {
        $this->cabinets = new ArrayCollection();
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

    /**
     * @return Collection<int, Cabinet>
     */
    public function getCabinets(): Collection
    {
        return $this->cabinets;
    }

    public function addCabinet(Cabinet $cabinet): static
    {
        if (!$this->cabinets->contains($cabinet)) {
            $this->cabinets->add($cabinet);
            $cabinet->setIdMedecin($this);
        }

        return $this;
    }

    public function removeCabinet(Cabinet $cabinet): static
    {
        if ($this->cabinets->removeElement($cabinet)) {
            // set the owning side to null (unless already changed)
            if ($cabinet->getIdMedecin() === $this) {
                $cabinet->setIdMedecin(null);
            }
        }

        return $this;
    }

    public function setCabinets(?Collection $cabinets): static
    {
        $this->cabinets = $cabinets;

        return $this;
    }


}

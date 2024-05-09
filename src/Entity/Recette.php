<?php

namespace App\Entity;

use App\Repository\RecetteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;


 #[ORM\Entity(repositoryClass: RecetteRepository::class)]

class Recette
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "idRec", type: "integer")]
    private ?int $idrec;

    #[Assert\NotBlank(message: ' the  name cant be null ')]
    #[Assert\Length(max: 35, maxMessage: 'you cant pass the {{ limit }} character.')]
    #[Assert\Regex(pattern: '/^[a-zA-Z\s]+$/', message: 'The name can only contain letters and spaces.')]
    #[ORM\Column(length:35)]
    private ?string $nomrec;

    #[Assert\NotBlank(message: ' the category cant be null ')]
    #[Assert\Length(max: 35, maxMessage: 'you cant pass the {{ limit }} character.')]
    #[ORM\Column(length:35)]
    private ?string $categoryr;

    #[Assert\NotBlank(message: ' the difficulty cant be null ')]
    #[Assert\Length(max: 30, maxMessage: 'you cant pass the {{ limit }} character.')]
    #[ORM\Column(length:30)]
    private ?string $difficulty;


    #[Assert\NotBlank(message: ' the serves cant be null ')]
    #[ORM\Column(type: "integer")]
    #[Assert\Length(min: 1, max: 3, minMessage: 'The serves must be at least 1 character long.', maxMessage: 'The serves cannot be longer than 3 characters.')]
    #[Assert\Regex(pattern: '/[0-9]+/', match: true, message: 'The serves must only contain numbers.')]
    private ?int $serves;

    #[Assert\NotBlank(message: ' the prep cant be null ')]
    #[Assert\Length(max: 35, maxMessage: 'you cant pass the {{ limit }} character.')]
    #[ORM\Column(length:35)]
    private ?string  $prep;

    #[Assert\NotBlank(message: ' the description cant be null ')]
    #[Assert\Length(max: 6000, maxMessage: 'you cant pass the {{ limit }} character.')]
    #[ORM\Column(length:6000)]
    private ?string $description;

    #[Assert\NotBlank(message: ' the date cant be null ')]
    #[Assert\Length(max: 35, maxMessage: 'you cant pass the {{ limit }} character.')]
    #[ORM\Column(length:35)]
    private ?string $date;


    #[ORM\Column(type: "integer")]
    #[Assert\NotBlank(message: ' the rating cant be null ')]
    #[Assert\Regex(pattern: '/[0-9]+/', match: true, message: 'The rating must only contain numbers.')]
    private ?int $rating;


    #[Assert\NotBlank(message: ' the image cant be null ')]
    #[Assert\Length(max: 35, maxMessage: 'you cant pass the {{ limit }} character.')]
    #[ORM\Column(length:35)]
    private ?string $imagerec;


    #[Assert\Length(max: 35, maxMessage: 'you cant pass the {{ limit }} character.')]
    #[ORM\Column(length:35)]
    private ?string $etatvalide;


    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: "idUser", referencedColumnName: "iduser")]
    #[Assert\NotBlank(message:'cant be null')]
    #[ORM\Column(type: 'integer')]
    private $iduser;


    #[ORM\OneToMany(targetEntity: Ingredients::class, mappedBy: 'idrec', cascade: ['persist'])]
    private $ingredients;

    public function __construct()
    {
        $this->iduser = 2;
        $this->etatvalide = 'non valide';
        $this->ingredients = new ArrayCollection();
        $this->prep = '';
    }

    /**
     * @return Collection|Ingredients[]
     */
    public function getIngredients(): Collection
    {
        return $this->ingredients;
    }


    public function addIngredient(Ingredients $ingredient): self
    {
        if (!$this->ingredients->contains($ingredient)) {
            $this->ingredients[] = $ingredient;
            $ingredient->setIdrec($this);
        }

        return $this;
    }

    public function removeIngredient(Ingredients $ingredient): self
    {
        if ($this->ingredients->contains($ingredient)) {
            $this->ingredients->removeElement($ingredient);
            // set the owning side to null (unless already changed)
            if ($ingredient->getIdrec() === $this) {
                $ingredient->setIdrec(null);
            }
        }

        return $this;
    }

    // ...



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

    public function getPrepHour(): ?string
    {
        return substr($this->prep, 0, 3); // Extract the first 3 characters (prepHour)
    }

    public function setPrepHour(string $prepHour): self
    {
        // Concatenate prepHour with prepMin and update the prep attribute
        $this->prep = $prepHour . substr($this->prep, 3);

        return $this;
    }

    // Getter and setter for prepMin

    public function getPrepMin(): ?string
    {
        return substr($this->prep, 3); // Extract characters after the first 3 characters (prepMin)
    }

    public function setPrepMin(string $prepMin): self
    {
        // Concatenate prepHour with prepMin and update the prep attribute
        $this->prep = substr($this->prep, 0, 3) . $prepMin;

        return $this;
    }
    public function setPrep( $prepHour, $prepMin): static
    {
    $this->prep = $prepHour . $prepMin;

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

    public function getEtatvalide(): ?string
    {
        return $this->etatvalide;
    }

    public function setEtatvalide(string $etatvalide): static
    {
        $this->etatvalide = $etatvalide;

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

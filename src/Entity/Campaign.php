<?php

namespace App\Entity;
use App\Repository\CampaignRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: CampaignRepository::class)]

class Campaign
{   
    
    #[ORM\Id]
    #[ORM\Column]
    #[ORM\GeneratedValue]
    private $idcamp;



    #[ORM\Column(type: "integer")]
    #[Assert\NotBlank(message: ' the number cant be null ')]
    private ?int $number;



    #[Assert\NotBlank(message: ' the goal cant be null ')]
    #[ORM\Column(type: "integer")]
    private ?int $goal;

    #[Assert\NotBlank(message: ' the title cant be null ')]
    #[Assert\Length(max: 35, maxMessage: 'you cant pass the {{ limit }} character.')]
    #[ORM\Column(length:35)]
    private ?string $titre;

    #[Assert\NotBlank(message: ' the association name cant be null ')]
    #[Assert\Length(max: 255, maxMessage: 'you cant pass the {{ limit }} character.')]
    #[ORM\Column(length:255)]
    private ?string $associationname;

    #[Assert\NotBlank(message: ' the campaign type cant be null ')]
    #[Assert\Length(max: 255, maxMessage: 'you cant pass the {{ limit }} character.')]
    #[ORM\Column(length:255)]
    private ?string $campaigntype;

    
    #[Assert\NotBlank(message: ' the description cant be null ')]
    #[Assert\Length(max: 6000, maxMessage: 'you cant pass the {{ limit }} character.')]
    #[ORM\Column(length:6000)]
    private ?string $description;



    #[ORM\Column(name: "image", type: "blob", length: 65535, nullable: true)]
    private ?string $image;

   

     #[ORM\Column(type: "float", options: ["precision" => 10, "scale" => 0])]
     #[Assert\NotBlank(message: 'The current cannot be null')]
    private ?float $current = '0';

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

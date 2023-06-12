<?php

namespace App\Entity;

use App\Repository\AnimalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnimalRepository::class)]
class Animal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $breed = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dob = null;

    #[ORM\Column]
    private ?bool $gender = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column(length: 50)]
    private ?string $color = null;

    #[ORM\Column(nullable: true)]
    private ?int $idChip = null;

    #[ORM\Column(nullable: true)]
    private ?bool $sterelisation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $medicalHistory = null;

    #[ORM\Column]
    private ?bool $activate = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Specie $specie = null;

    #[ORM\ManyToOne]
    private ?Veterinary $veterinary = null;

    #[ORM\OneToMany(mappedBy: 'animal', targetEntity: Vaccination::class)]
    private Collection $vaccineList;

    #[ORM\ManyToOne(inversedBy: 'animalList')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $owner = null;

    #[ORM\Column(nullable: true)]
    private ?float $weight = null;

    public function __construct()
    {
        $this->vaccineList = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBreed(): ?string
    {
        return $this->breed;
    }

    public function setBreed(string $breed): self
    {
        $this->breed = $breed;

        return $this;
    }

    public function getDob(): ?\DateTimeInterface
    {
        return $this->dob;
    }

    public function setDob(\DateTimeInterface $dob): self
    {
        $this->dob = $dob;

        return $this;
    }

    public function isGender(): ?bool
    {
        return $this->gender;
    }

    public function setGender(bool $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getIdChip(): ?int
    {
        return $this->idChip;
    }

    public function setIdChip(?int $idChip): self
    {
        $this->idChip = $idChip;

        return $this;
    }

    public function isSterelisation(): ?bool
    {
        return $this->sterelisation;
    }

    public function setSterelisation(?bool $sterelisation): self
    {
        $this->sterelisation = $sterelisation;

        return $this;
    }

    public function getMedicalHistory(): ?string
    {
        return $this->medicalHistory;
    }

    public function setMedicalHistory(?string $medicalHistory): self
    {
        $this->medicalHistory = $medicalHistory;

        return $this;
    }

    public function isActivate(): ?bool
    {
        return $this->activate;
    }

    public function setActivate(bool $activate): self
    {
        $this->activate = $activate;

        return $this;
    }

    public function getSpecie(): ?Specie
    {
        return $this->specie;
    }

    public function setSpecie(?Specie $specie): self
    {
        $this->specie = $specie;

        return $this;
    }

    public function getVeterinary(): ?Veterinary
    {
        return $this->veterinary;
    }

    public function setVeterinary(?Veterinary $veterinary): self
    {
        $this->veterinary = $veterinary;

        return $this;
    }

    /**
     * @return Collection<int, Vaccination>
     */
    public function getVaccineList(): Collection
    {
        return $this->vaccineList;
    }

    public function addVaccineList(Vaccination $vaccineList): self
    {
        if (!$this->vaccineList->contains($vaccineList)) {
            $this->vaccineList->add($vaccineList);
            $vaccineList->setAnimal($this);
        }

        return $this;
    }

    public function removeVaccineList(Vaccination $vaccineList): self
    {
        if ($this->vaccineList->removeElement($vaccineList)) {
            // set the owning side to null (unless already changed)
            if ($vaccineList->getAnimal() === $this) {
                $vaccineList->setAnimal(null);
            }
        }

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    public function getWeight(): ?float
    {
        return $this->weight;
    }

    public function setWeight(?float $weight): self
    {
        $this->weight = $weight;

        return $this;
    }
}

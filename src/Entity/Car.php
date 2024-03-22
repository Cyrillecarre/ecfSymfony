<?php

namespace App\Entity;

use App\Repository\CarRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: CarRepository::class)]
class Car
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $date = null;

    #[ORM\Column(length: 255)]
    private ?string $energie = null;

    #[ORM\Column]
    private ?int $power = null;

    #[ORM\Column]
    private ?int $gate = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\Column(nullable:true)]
    private $imagePath = null;

    /**
     * @ORM\OneToMany(targetEntity=CarPhoto::class, mappedBy="car")
     */
     private $carPhotos;

     public function __construct()
     {
         $this->carPhotos = new ArrayCollection();
     }

     /**
     * @return Collection|CarPhoto[]
     */
    public function getCarPhotos(): Collection
    {
        return $this->carPhotos;
    }

    public function addCarPhoto(CarPhoto $carPhoto): self
    {
        if (!$this->carPhotos->contains($carPhoto)) {
            $this->carPhotos[] = $carPhoto;
            $carPhoto->setCar($this);
        }

        return $this;
    }

    public function removeCarPhoto(CarPhoto $carPhoto): self
    {
        if ($this->carPhotos->removeElement($carPhoto)) {
            if ($carPhoto->getCar() === $this) {
                $carPhoto->setCar(null);
            }
        }

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDate(): ?int
    {
        return $this->date;
    }

    public function setDate(int $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getEnergie(): ?string
    {
        return $this->energie;
    }

    public function setEnergie(string $energie): static
    {
        $this->energie = $energie;

        return $this;
    }

    public function getPower(): ?int
    {
        return $this->power;
    }

    public function setPower(int $power): static
    {
        $this->power = $power;

        return $this;
    }

    public function getGate(): ?int
    {
        return $this->gate;
    }

    public function setGate(int $gate): static
    {
        $this->gate = $gate;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getImagePath(): ?string
    {
        return $this->imagePath;
    }

    public function setImagePath(string $imagePath): static
    {
        $this->imagePath = $imagePath;

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\CarPhotoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarPhotoRepository::class)]
class CarPhoto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @ORM\ManyToOne(targetEntity=Car::class, inversedBy="carPhotos")
     * @ORM\JoinColumn(nullable=false)
     */
    
    private $car;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $imagePath;


    public function getId(): ?int
    {
        return $this->id;
    }
    public function getCar(): ?Car
    {
        return $this->car;
    }

    public function setCar(?Car $car): self
    {
        $this->car = $car;

        return $this;
    }

    public function getImagePath(): ?string
    {
        return $this->imagePath;
    }

    public function setImagePath(string $imagePath): self
    {
        $this->imagePath = $imagePath;

        return $this;
    }
}

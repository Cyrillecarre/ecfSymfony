<?php

namespace App\Entity;

use App\Repository\ScheduleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ScheduleRepository::class)]
class Schedule
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $day = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $hours_o_matin = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $hours_f_matin = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $hours_o_a = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $hours_f_a = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDay(): ?string
    {
        return $this->day;
    }

    public function setDay(string $day): static
    {
        $this->day = $day;

        return $this;
    }

    public function getHoursOMatin(): ?\DateTimeInterface
    {
        return $this->hours_o_matin;
    }

    public function setHoursOMatin(\DateTimeInterface $hours_o_matin): static
    {
        $this->hours_o_matin = $hours_o_matin;

        return $this;
    }

    public function getHoursFMatin(): ?\DateTimeInterface
    {
        return $this->hours_f_matin;
    }

    public function setHoursFMatin(\DateTimeInterface $hours_f_matin): static
    {
        $this->hours_f_matin = $hours_f_matin;

        return $this;
    }

    public function getHoursOA(): ?\DateTimeInterface
    {
        return $this->hours_o_a;
    }

    public function setHoursOA(\DateTimeInterface $hours_o_a): self
    {
        $this->hours_o_a = $hours_o_a;

        return $this;
    }

    public function getHoursFA(): ?\DateTimeInterface
    {
        return $this->hours_f_a;
    }

    public function setHoursFA(\DateTimeInterface $hours_f_a): self
    {
        $this->hours_f_a = $hours_f_a;

        return $this;
    }

    // Getters formatés

    public function getFormattedHoursOMatin(): ?string
    {
        if (!$this->hours_o_matin) {
            return null;
        }

        return $this->hours_o_matin->format('H:i');
    }

    public function getFormattedHoursFMatin(): ?string
    {
        if (!$this->hours_f_matin) {
            return null;
        }

        return $this->hours_f_matin->format('H:i');
    }

    public function getFormattedHoursOA(): ?string
    {
        if (!$this->hours_o_a) {
            return null;
        }

        return $this->hours_o_a->format('H:i');
    }

    public function getFormattedHoursFA(): ?string
    {
        if (!$this->hours_f_a) {
            return null;
        }

        return $this->hours_f_a->format('H:i');
    }
}

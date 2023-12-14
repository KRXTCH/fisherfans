<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\OutletRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OutletRepository::class)]
#[ApiResource]
class Outlet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $informations = null;

    #[ORM\Column]
    private ?int $type = null;

    #[ORM\Column]
    private ?int $amountType = null;

    #[ORM\Column(type: Types::ARRAY)]
    private array $startDayDates = [];

    #[ORM\Column(type: Types::ARRAY)]
    private array $endDayDates = [];

    #[ORM\Column(type: Types::ARRAY)]
    private array $startHourDates = [];

    #[ORM\Column(type: Types::ARRAY)]
    private array $endHourDates = [];

    #[ORM\Column]
    private ?int $capacity = null;

    #[ORM\Column]
    private ?int $price = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getInformations(): ?string
    {
        return $this->informations;
    }

    public function setInformations(string $informations): static
    {
        $this->informations = $informations;

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getAmountType(): ?int
    {
        return $this->amountType;
    }

    public function setAmountType(int $amountType): static
    {
        $this->amountType = $amountType;

        return $this;
    }

    public function getStartDayDates(): array
    {
        return $this->startDayDates;
    }

    public function setStartDayDates(array $startDayDates): static
    {
        $this->startDayDates = $startDayDates;

        return $this;
    }

    public function getEndDayDates(): array
    {
        return $this->endDayDates;
    }

    public function setEndDayDates(array $endDayDates): static
    {
        $this->endDayDates = $endDayDates;

        return $this;
    }

    public function getStartHourDates(): array
    {
        return $this->startHourDates;
    }

    public function setStartHourDates(array $startHourDates): static
    {
        $this->startHourDates = $startHourDates;

        return $this;
    }

    public function getEndHourDates(): array
    {
        return $this->endHourDates;
    }

    public function setEndHourDates(array $endHourDates): static
    {
        $this->endHourDates = $endHourDates;

        return $this;
    }

    public function getCapacity(): ?int
    {
        return $this->capacity;
    }

    public function setCapacity(int $capacity): static
    {
        $this->capacity = $capacity;

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
}

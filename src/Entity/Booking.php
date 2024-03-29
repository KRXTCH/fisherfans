<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\BookingRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;

use App\Exception\BusinessLogicException;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BookingRepository::class)]
#[ApiFilter(SearchFilter::class, strategy: 'partial')]
#[ApiResource(operations: [
    new GetCollection(security: "is_granted('ROLE_USER')"),
    new Post(security: "is_granted('ROLE_USER')"),
    new Get(security: "is_granted('ROLE_USER')"),
    new Put(security: "is_granted('ROLE_USER')"),
    new Patch(security: "is_granted('ROLE_USER')"),
    new Delete(security: "is_granted('ROLE_USER')"),
])]

class Booking
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column]
    private ?int $bookedPlaces = null;

    #[ORM\Column]
    private ?float $totalPrice = null;

    #[ORM\ManyToOne(inversedBy: 'bookings')]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getBookedPlaces(): ?int
    {
        return $this->bookedPlaces;
    }

    public function setBookedPlaces(int $bookedPlaces): static
    {
        $this->bookedPlaces = $bookedPlaces;

        return $this;
    }

    public function getTotalPrice(): ?float
    {
        return $this->totalPrice;
    }

    public function setTotalPrice(float $totalPrice): static
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    #[Assert\Callback]
    public function validateBooking(ExecutionContextInterface $context): void
    {
        // Vérifier la date de réservation
        if ($this->getDate() <= new \DateTime()) {
            throw new BusinessLogicException('La date de réservation doit être dans le futur.');
        }

        // Vérifier le nombre de places réservées
        if ($this->getBookedPlaces() < 0) {
            throw new BusinessLogicException('Le nombre de places réservées doit être supérieur ou égale à zéro.');
        }

        // Vérifier le prix total
        if ($this->getTotalPrice() < 0) {
            throw new BusinessLogicException('Le prix total doit être supérieur ou égale à zéro.');
        }

        // Vérifier si l'utilisateur est manquant
        if ($this->getUser() === null) {
            throw new BusinessLogicException('La réservation doit être associée à un utilisateur.');
        }
    }
}

<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\OutletRepository;
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

#[ORM\Entity(repositoryClass: OutletRepository::class)]
#[ApiFilter(SearchFilter::class, strategy: 'partial')]
#[ApiResource(operations: [
    new GetCollection(security: "is_granted('ROLE_USER')"),
    new Post(security: "is_granted('ROLE_USER')"),
    new Get(security: "is_granted('ROLE_USER')"),
    new Put(security: "is_granted('ROLE_USER')"),
    new Patch(security: "is_granted('ROLE_USER')"),
    new Delete(security: "is_granted('ROLE_USER')"),
])]

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

    #[ORM\ManyToOne(inversedBy: 'outlets')]
    private ?User $user = null;

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
    public function validation(ExecutionContextInterface $context): void
    {
        // Vérifier le titre
        if (empty($this->getTitle())) {
            throw new BusinessLogicException('Le titre est obligatoire.');
        }

        // Vérifier les informations
        if (empty($this->getInformations())) {
            throw new BusinessLogicException('Les informations sont obligatoires.');
        }

        // Vérifier le type
        if ($this->getType() === null) {
            throw new BusinessLogicException('Le type est obligatoire.');
        }

        // Vérifier le montant
        if ($this->getAmountType() === null) {
            throw new BusinessLogicException('Le montant est obligatoire.');
        }

        foreach ($this->startDayDates as $index => $startDate) {
            $endDate = $this->endDayDates[$index];

            if ($endDate < $startDate) {
                throw new BusinessLogicException('La date de fin doit être après la date de début.');
            }
        }

        // Valider le prix
        if ($this->getPrice() <= 0) {
            throw new BusinessLogicException('Le prix doit être supérieur à zéro.');
        }

        // Vérifier si l'utilisateur est manquant
        if ($this->getUser() === null) {
            throw new BusinessLogicException("L'outlet doit être associé à un utilisateur.");
        }

        $boats = $this->getUser()->getBoats();

        if (count($boats) < 1) {
            $context->buildViolation('Cet utilisateur ne possède aucun bateau.')
                ->atPath('user.boats')
                ->addViolation();
        }
    }
}

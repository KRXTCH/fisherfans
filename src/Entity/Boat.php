<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\OpenApi\Model\Operation;
use ApiPlatform\OpenApi\Model\Parameter;
use App\Controller\BoatController;
use App\Repository\BoatRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

#[ORM\Entity(repositoryClass: BoatRepository::class)]

#[ApiResource(operations: [
    new GetCollection(
        name: 'boats_localize',
        uriTemplate: '/boats/localize',
        controller: BoatController::class,
        openapi: new Operation(
            summary: 'Locate boats within a bounding box',
            parameters: [
                new Parameter(
                    name: 'latitudeMin',
                    in: 'query',
                    description: 'Minimum latitude of the bounding box',
                    required: true
                ),
                new Parameter(
                    name: 'latitudeMax',
                    in: 'query',
                    description: 'Maximum latitude of the bounding box',
                    required: true
                ),
                new Parameter(
                    name: 'longitudeMin',
                    in: 'query',
                    description: 'Minimum longitude of the bounding box',
                    required: true
                ),
                new Parameter(
                    name: 'longitudeMax',
                    in: 'query',
                    description: 'Maximum longitude of the bounding box',
                    required: true
                )
            ]
        )
    )
])]

#[ApiFilter(SearchFilter::class, strategy: 'partial')]
#[ApiResource(operations: [
    new GetCollection(security: "is_granted('ROLE_USER')"),
    new Post(security: "is_granted('ROLE_USER')"),
    new Get(security: "is_granted('ROLE_USER')"),
    new Put(security: "is_granted('ROLE_USER')"),
    new Patch(security: "is_granted('ROLE_USER')"),
    new Delete(security: "is_granted('ROLE_USER')"),
])]
class Boat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $model = null;

    #[ORM\Column(length: 255)]
    private ?string $yearOfManufacture = null;

    #[ORM\Column(length: 255)]
    private ?string $imageUrl = null;

    #[ORM\Column]
    private ?int $licenseType = null;

    #[ORM\Column]
    private ?int $type = null;

    #[ORM\Column(type: Types::ARRAY)]
    private array $equipment = [];

    #[ORM\Column]
    private ?int $depositAmount = null;

    #[ORM\Column]
    private ?int $maximumCapacity = null;

    #[ORM\Column]
    private ?int $numberOfBeds = null;

    #[ORM\Column(length: 255)]
    private ?string $portCityOrigin = null;

    #[ORM\Column(length: 255)]
    private ?string $origin = null;

    #[ORM\Column(length: 255)]
    private ?string $latitude = null;

    #[ORM\Column(length: 255)]
    private ?string $longitude = null;

    #[ORM\Column]
    private ?int $motorizationType = null;

    #[ORM\ManyToOne(inversedBy: 'boats')]
    private ?User $user = null;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): static
    {
        $this->model = $model;

        return $this;
    }

    public function getYearOfManufacture(): ?string
    {
        return $this->yearOfManufacture;
    }

    public function setYearOfManufacture(string $yearOfManufacture): static
    {
        $this->yearOfManufacture = $yearOfManufacture;

        return $this;
    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(string $imageUrl): static
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    public function getLicenseType(): ?int
    {
        return $this->licenseType;
    }

    public function setLicenseType(int $licenseType): static
    {
        $this->licenseType = $licenseType;

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

    public function getEquipment(): array
    {
        return $this->equipment;
    }

    public function setEquipment(array $equipment): static
    {
        $this->equipment = $equipment;

        return $this;
    }

    public function getDepositAmount(): ?int
    {
        return $this->depositAmount;
    }

    public function setDepositAmount(int $depositAmount): static
    {
        $this->depositAmount = $depositAmount;

        return $this;
    }

    public function getMaximumCapacity(): ?int
    {
        return $this->maximumCapacity;
    }

    public function setMaximumCapacity(int $maximumCapacity): static
    {
        $this->maximumCapacity = $maximumCapacity;

        return $this;
    }

    public function getNumberOfBeds(): ?int
    {
        return $this->numberOfBeds;
    }

    public function setNumberOfBeds(int $numberOfBeds): static
    {
        $this->numberOfBeds = $numberOfBeds;

        return $this;
    }

    public function getPortCityOrigin(): ?string
    {
        return $this->portCityOrigin;
    }

    public function setPortCityOrigin(string $portCityOrigin): static
    {
        $this->portCityOrigin = $portCityOrigin;

        return $this;
    }

    public function getOrigin(): ?string
    {
        return $this->origin;
    }

    public function setOrigin(string $origin): static
    {
        $this->origin = $origin;

        return $this;
    }

    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    public function setLatitude(string $latitude): static
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    public function setLongitude(string $longitude): static
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getMotorizationType(): ?int
    {
        return $this->motorizationType;
    }

    public function setMotorizationType(int $motorizationType): static
    {
        $this->motorizationType = $motorizationType;

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
    public function validate(ExecutionContextInterface $context)
    {
        $licenseNumber = $this->getUser()->getBoatLicenseNumber();

        if (empty($licenseNumber)) {
            $context->buildViolation('Le numéro de licence de bateau ne peut pas être vide.')
                ->atPath('user.boatLicenseNumber')
                ->addViolation();
        }
    }
}
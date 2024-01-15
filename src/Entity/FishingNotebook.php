<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\FishingNotebookRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use App\Exception\BusinessLogicException;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

#[ORM\Entity(repositoryClass: FishingNotebookRepository::class)]
#[ApiFilter(SearchFilter::class, strategy: 'partial')]
#[ApiResource(operations: [
    new GetCollection(security: "is_granted('ROLE_USER')"),
    new Post(security: "is_granted('ROLE_USER')"),
    new Get(security: "is_granted('ROLE_USER')"),
    new Put(security: "is_granted('ROLE_USER')"),
    new Patch(security: "is_granted('ROLE_USER')"),
    new Delete(security: "is_granted('ROLE_USER')"),
])]
#[Assert\Callback(callback: 'validateFishingNotebook')]
class FishingNotebook
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $fishName = null;

    #[ORM\Column(length: 255)]
    private ?string $imageUrl = null;

    #[ORM\Column(length: 255)]
    private ?string $comment = null;

    #[ORM\Column]
    private ?float $size = null;

    #[ORM\Column]
    private ?float $weight = null;

    #[ORM\Column(length: 255)]
    private ?string $location = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column]
    private ?bool $isReleased = null;

    #[ORM\ManyToOne(inversedBy: 'fishingNotebooks')]
    private ?User $user = null;

    public function __construct()
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFishName(): ?string
    {
        return $this->fishName;
    }

    public function setFishName(string $fishName): static
    {
        $this->fishName = $fishName;

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

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): static
    {
        $this->comment = $comment;

        return $this;
    }

    public function getSize(): ?float
    {
        return $this->size;
    }

    public function setSize(float $size): static
    {
        $this->size = $size;

        return $this;
    }

    public function getWeight(): ?float
    {
        return $this->weight;
    }

    public function setWeight(float $weight): static
    {
        $this->weight = $weight;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): static
    {
        $this->location = $location;

        return $this;
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

    public function isIsReleased(): ?bool
    {
        return $this->isReleased;
    }

    public function setIsReleased(bool $isReleased): static
    {
        $this->isReleased = $isReleased;

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

    /**
     * @Assert\Callback(callback="validateFishingNotebook")
     */
    public function validateFishingNotebook(ExecutionContextInterface $context): void
    {
        // Vérifier le nom du poisson
        if (empty($this->getFishName())) {
            throw new BusinessLogicException('Le nom du poisson est obligatoire.');
        }

        // Vérifier l'URL de l'image
        if (empty($this->getImageUrl())) {
            throw new BusinessLogicException("L'URL de l'image est obligatoire.");
        }

        // Vérifier le commentaire
        if (empty($this->getComment())) {
            throw new BusinessLogicException('Le commentaire est obligatoire.');
        }

        // Vérifier la taille
        if ($this->getSize() <= 0) {
            throw new BusinessLogicException('La taille doit être supérieure à zéro.');
        }

        // Vérifier le poids
        if ($this->getWeight() <= 0) {
            throw new BusinessLogicException('Le poids doit être supérieur à zéro.');
        }

        // Vérifier l'emplacement
        if (empty($this->getLocation())) {
            throw new BusinessLogicException("L'emplacement est obligatoire.");
        }

        // Vérifier la date
        if ($this->getDate() <= new \DateTime()) {
            throw new BusinessLogicException('La date doit être dans le futur.');
        }

        // Vérifier si l'utilisateur est manquant
        if ($this->getUser() === null) {
            throw new BusinessLogicException('Le carnet de pêche doit être associé à un utilisateur.');
        }
    }
}

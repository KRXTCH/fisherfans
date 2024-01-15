<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use App\State\UserPasswordHasher;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use App\Exception\BusinessLogicException;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ApiFilter(SearchFilter::class, strategy: 'partial')]
#[ApiResource(
    operations: [
        new GetCollection(security: "is_granted('ROLE_USER')"),
        new Post(processor: UserPasswordHasher::class, validationContext: ['groups' => ['Default', 'user:create']]),
        new Get(security: "is_granted('ROLE_USER')"),
        new Put(processor: UserPasswordHasher::class, security: "is_granted('ROLE_USER')"),
        new Patch(processor: UserPasswordHasher::class, security: "is_granted('ROLE_USER')"),
        new Delete(security: "is_granted('ROLE_USER')"),
    ],
    normalizationContext: ['groups' => ['user:read']],
    denormalizationContext: ['groups' => ['user:create', 'user:update']],
)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['user:create', 'user:read'])]
    #[ORM\Column(length: 255)]
    private ?string $firstname = null;

    #[Groups(['user:create', 'user:read'])]
    #[ORM\Column(length: 255)]
    private ?string $lastname = null;

    #[Groups(['user:create', 'user:read'])]
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $birthdate = null;

    #[Groups(['user:create'])]
    private ?string $plainPassword = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[Groups(['user:create', 'user:read'])]
    #[ORM\Column]
    private ?string $phone = null;

    #[Groups(['user:create', 'user:read'])]
    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[Groups(['user:create', 'user:read'])]
    #[ORM\Column]
    private ?string $postalCode = null;

    #[Groups(['user:create', 'user:read'])]
    #[ORM\Column(length: 255)]
    private ?string $city = null;

    #[Groups(['user:create', 'user:read'])]
    #[ORM\Column(type: Types::ARRAY)]
    private array $languages = [];

    #[Groups(['user:create', 'user:read'])]
    #[ORM\Column(length: 255)]
    private ?string $avatarUrl = null;

    #[Groups(['user:create', 'user:read'])]
    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Regex(
        pattern: '/^\d{8}$/',
        message: "Le numéro de permis bateau doit contenir exactement 8 chiffres.",
    )]
    private ?string $boatLicenseNumber = null;

    #[Groups(['user:create', 'user:read'])]
    #[ORM\Column(length: 255)]
    private ?string $insuranceNumber = null;

    #[Groups(['user:create', 'user:read'])]
    #[ORM\Column]
    private ?int $status = null;

    #[Groups(['user:create', 'user:read'])]
    #[ORM\Column(length: 255)]
    private ?string $companyName = null;

    #[Groups(['user:create', 'user:read'])]
    #[ORM\Column(length: 255)]
    private ?string $siretNumber = null;

    #[Groups(['user:create', 'user:read'])]
    #[ORM\Column(length: 255)]
    private ?string $rcNumber = null;

    #[Groups(['user:read'])]
    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Boat::class)]
    private Collection $boats;

    #[Groups(['user:read'])]
    #[ORM\OneToMany(mappedBy: 'user', targetEntity: FishingNotebook::class)]
    private Collection $fishingNotebooks;

    #[Groups(['user:read'])]
    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Outlet::class)]
    private Collection $outlets;

    #[Groups(['user:read'])]
    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Booking::class)]
    private Collection $bookings;

    #[Groups(['user:create', 'user:read'])]
    #[ORM\Column(length: 150, unique: true)]
    private ?string $email = null;

    public function __construct()
    {
        $this->boats = new ArrayCollection();
        $this->fishingNotebooks = new ArrayCollection();
        $this->outlets = new ArrayCollection();
        $this->bookings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(\DateTimeInterface $birthdate): static
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): static
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getLanguages(): array
    {
        return $this->languages;
    }

    public function setLanguages(array $languages): static
    {
        $this->languages = $languages;

        return $this;
    }

    public function getAvatarUrl(): ?string
    {
        return $this->avatarUrl;
    }

    public function setAvatarUrl(string $avatarUrl): static
    {
        $this->avatarUrl = $avatarUrl;

        return $this;
    }

    public function getBoatLicenseNumber(): ?string
    {
        return $this->boatLicenseNumber;
    }

    public function setBoatLicenseNumber(string $boatLicenseNumber): static
    {
        $this->boatLicenseNumber = $boatLicenseNumber;

        return $this;
    }

    public function getInsuranceNumber(): ?string
    {
        return $this->insuranceNumber;
    }

    public function setInsuranceNumber(string $insuranceNumber): static
    {
        $this->insuranceNumber = $insuranceNumber;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    public function setCompanyName(string $companyName): static
    {
        $this->companyName = $companyName;

        return $this;
    }

    public function getSiretNumber(): ?string
    {
        return $this->siretNumber;
    }

    public function setSiretNumber(string $siretNumber): static
    {
        $this->siretNumber = $siretNumber;

        return $this;
    }

    public function getRcNumber(): ?string
    {
        return $this->rcNumber;
    }

    public function setRcNumber(string $rcNumber): static
    {
        $this->rcNumber = $rcNumber;

        return $this;
    }

     /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(?string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

     /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        $this->plainPassword = null;
    }


    /**
     * @return Collection<int, Boat>
     */
    public function getBoats(): Collection
    {
        return $this->boats;
    }

    public function addBoat(Boat $boat): static
    {
        if (!$this->boats->contains($boat)) {
            $this->boats->add($boat);
            $boat->setUser($this);
        }

        return $this;
    }

    public function removeBoat(Boat $boat): static
    {
        if ($this->boats->removeElement($boat)) {
            // set the owning side to null (unless already changed)
            if ($boat->getUser() === $this) {
                $boat->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, FishingNotebook>
     */
    public function getFishingNotebooks(): Collection
    {
        return $this->fishingNotebooks;
    }

    public function addFishingNotebook(FishingNotebook $fishingNotebook): static
    {
        if (!$this->fishingNotebooks->contains($fishingNotebook)) {
            $this->fishingNotebooks->add($fishingNotebook);
            $fishingNotebook->setUser($this);
        }

        return $this;
    }

    public function removeFishingNotebook(FishingNotebook $fishingNotebook): static
    {
        if ($this->fishingNotebooks->removeElement($fishingNotebook)) {
            // set the owning side to null (unless already changed)
            if ($fishingNotebook->getUser() === $this) {
                $fishingNotebook->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Outlet>
     */
    public function getOutlets(): Collection
    {
        return $this->outlets;
    }

    public function addOutlet(Outlet $outlet): static
    {
        if (!$this->outlets->contains($outlet)) {
            $this->outlets->add($outlet);
            $outlet->setUser($this);
        }

        return $this;
    }

    public function removeOutlet(Outlet $outlet): static
    {
        if ($this->outlets->removeElement($outlet)) {
            // set the owning side to null (unless already changed)
            if ($outlet->getUser() === $this) {
                $outlet->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Booking>
     */
    public function getBookings(): Collection
    {
        return $this->bookings;
    }

    public function addBooking(Booking $booking): static
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings->add($booking);
            $booking->setUser($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): static
    {
        if ($this->bookings->removeElement($booking)) {
            // set the owning side to null (unless already changed)
            if ($booking->getUser() === $this) {
                $booking->setUser(null);
            }
        }

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Check if the user has a boat.
     *
     * @return bool
     */
    public function hasBoat(): bool
    {
        return !$this->boats->isEmpty(); // Assuming you have a $boats property in  User entity.
    }

   /**
     * @Assert\Callback
     */
    public function validateBoatLicenseNumber(ExecutionContextInterface $context): void
    {
        // if ($this->getBoatLicenseNumber() === null) {
        //     $context->buildViolation("Le numéro de permis bateau est obligatoire.")
        //         ->atPath('boatLicenseNumber')
        //         ->addViolation();
        // }
        if ($this->getBoatLicenseNumber() === null) {
            // Lance une exception métier si le numéro de permis bateau est manquant
            throw new BusinessLogicException('Le numéro de permis bateau est obligatoire.');
        }
    }
}

<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ApiResource]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    private ?string $lastname = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $birthdate = null;

    #[ORM\Column(length: 255)]
    private ?string $mail = null;

    #[ORM\Column]
    private ?string $phone = null;

    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[ORM\Column]
    private ?string $postalCode = null;

    #[ORM\Column(length: 255)]
    private ?string $city = null;

    #[ORM\Column(type: Types::ARRAY)]
    private array $languages = [];

    #[ORM\Column(length: 255)]
    private ?string $avatarUrl = null;

    #[ORM\Column(length: 255)]
    private ?string $boatLicenseNumber = null;

    #[ORM\Column(length: 255)]
    private ?string $insuranceNumber = null;

    #[ORM\Column]
    private ?int $status = null;

    #[ORM\Column(length: 255)]
    private ?string $companyName = null;

    #[ORM\Column(length: 255)]
    private ?string $siretNumber = null;

    #[ORM\Column(length: 255)]
    private ?string $rcNumber = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Boat::class)]
    private Collection $boats;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: FishingNotebook::class)]
    private Collection $fishingNotebooks;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Outlet::class)]
    private Collection $outlets;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Booking::class)]
    private Collection $bookings;

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

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): static
    {
        $this->mail = $mail;

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
}

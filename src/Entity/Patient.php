<?php

namespace App\Entity;

use App\Repository\PatientRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: PatientRepository::class)]
class Patient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'uuid', unique: true)]
    private ?Uuid $patientCode = null;

    #[ORM\Column(length: 100)]
    private ?string $firstName = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $lastName = null;

    #[ORM\Column(length: 1)]
    private ?string $sex = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $birthDate = null;

    #[ORM\Column(length: 13, nullable: true)]
    private ?string $contactNo = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $address = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\OneToOne(mappedBy: 'patient', cascade: ['persist', 'remove'])]
    private ?User $user = null;

    public function __construct()
    {
        $this->patientCode = Uuid::v4();
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPatientCode(): ?Uuid
    {
        return $this->patientCode;
    }

    public function setPatientCode(Uuid $patientCode): static
    {
        $this->patientCode = $patientCode;
        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): static
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function getFullName(): string
    {
        return trim($this->firstName . ' ' . ($this->lastName ?? ''));
    }

    public function getSex(): ?string
    {
        return $this->sex;
    }

    public function setSex(string $sex): static
    {
        $this->sex = $sex;
        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(?\DateTimeInterface $birthDate): static
    {
        $this->birthDate = $birthDate;
        return $this;
    }

    public function getAge(): ?int
    {
        if (!$this->birthDate) {
            return null;
        }

        $now = new \DateTime();
        $interval = $now->diff($this->birthDate);
        return $interval->y;
    }

    public function getContactNo(): ?string
    {
        return $this->contactNo;
    }

    public function setContactNo(?string $contactNo): static
    {
        $this->contactNo = $contactNo;
        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): static
    {
        $this->address = $address;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        if ($user === null && $this->user !== null) {
            $this->user->setPatient(null);
        }

        $this->user = $user;

        if ($user !== null && $user->getPatient() !== $this) {
            $user->setPatient($this);
        }

        return $this;
    }

    // Add this method to your Patient entity
    public function __toString(): string
    {
        // Customize this based on what fields you have in Patient
        // Example if you have a 'name' or 'firstName'/'lastName' field:
        if ($this->getFirstName() && $this->getLastName()) {
            return $this->getFirstName() . ' ' . $this->getLastName();
        }

        if ($this->getFullName()) {
            return $this->getFullName();
        }

        // Fallback to ID or other identifier
        return 'Patient #' . $this->getId() ?? 'New Patient';
    }

    public function generatePatientCode(): static
    {
        $this->patientCode = Uuid::v4();
        return $this;
    }
}
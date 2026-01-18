<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
#[ORM\Table(name: 'client')]
#[ORM\UniqueConstraint(name: 'UNIQ_CLIENT_EMAIL', columns: ['email'])]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank]
    #[Assert\Regex(
        pattern: '/^[a-zA-ZÀ-ÿ\- ]+$/',
        message: 'Le prénom ne doit pas contenir de caractères spéciaux.'
    )]
    private ?string $firstname = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank]
    #[Assert\Regex(
        pattern: '/^[a-zA-ZÀ-ÿ\- ]+$/',
        message: 'Le nom ne doit pas contenir de caractères spéciaux.'
    )]
    private ?string $lastname = null;

    #[ORM\Column(length: 100, unique: true)]
    #[Assert\NotBlank]
    #[Assert\Email(message: 'Format email invalide (xxx@xxx.xx).')]
    private ?string $email = null;

    #[ORM\Column(length: 20)]
    #[Assert\NotBlank]
    private ?string $phoneNumber = null;

    #[ORM\Column(type: 'text')]
    #[Assert\NotBlank]
    private ?string $address = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    /* ================= GETTERS / SETTERS ================= */

    public function getId(): ?int { return $this->id; }

    public function getFirstname(): ?string { return $this->firstname; }
    public function setFirstname(string $firstname): self {
        $this->firstname = $firstname;
        return $this;
    }

    public function getLastname(): ?string { return $this->lastname; }
    public function setLastname(string $lastname): self {
        $this->lastname = $lastname;
        return $this;
    }

    public function getEmail(): ?string { return $this->email; }
    public function setEmail(string $email): self {
        $this->email = $email;
        return $this;
    }

    public function getPhoneNumber(): ?string { return $this->phoneNumber; }
    public function setPhoneNumber(string $phoneNumber): self {
        $this->phoneNumber = $phoneNumber;
        return $this;
    }

    public function getAddress(): ?string { return $this->address; }
    public function setAddress(string $address): self {
        $this->address = $address;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable { return $this->createdAt; }
    public function setCreatedAt(\DateTimeImmutable $createdAt): self {
        $this->createdAt = $createdAt;
        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\EntityListeners(['App\EntityListener\UserListener'])]
#[UniqueEntity(fields: ['email'], message: 'This email is already used !')]
#[UniqueEntity(fields: ['username'], message: 'There is already an account with this username !')]
#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 25)]
    #[Assert\NotBlank(message: 'Please enter a username !')]
    private ?string $username = null;

    #[ORM\Column(type: 'string', length: 60)]
    #[Assert\NotBlank(message: 'Please enter an email address !')]
    #[Assert\Email(message: 'The email is not a valid email address.')]
    private ?string $email = null;

    #[ORM\Column(type: 'json')]
    private $roles = [];

    #[Assert\NotBlank(message: 'Please enter a password !')]
    #[Assert\Regex(
        pattern: '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$#!%*?&])[A-Za-z\d@$#!%*?&]{8,}$/',
        message: 'Your password must contain at least 8 characters, one lowercase letter, one uppercase letter, one number, and one special character.'
    )]
    private $plainPassword;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $password;

    public function __construct()
    {
        $this->roles = ['ROLE_USER'];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

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

    public function getRoles(): array
    {
        return array_unique($this->roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;

        return $this->plainPassword;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    public function eraseCredentials():void
    {
        $this->plainPassword = null;
    }
}

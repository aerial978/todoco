<?php

namespace App\EntityListener;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserListener
{
    private UserPasswordHasherInterface $hasher;

    /**
     * Constructor to initialize the password hasher.
     */
    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    /**
     * Automatically hashes the user's password before persisting a new user entity.
     */
    public function prePersist(User $user): void
    {
        if ($user->getPlainPassword() !== null) {
            $this->encodePassword($user);
        }
    }

    /**
     * Automatically hashes the user's password before updating an existing user entity.
     */
    public function preUpdate(User $user): void
    {
        if ($user->getPlainPassword() !== null) {
            $this->encodePassword($user);
        }
    }

    /**
     * Encodes the user's plain password and sets it as the hashed password.
     * Also ensures the plain password is removed after hashing.
     */
    private function encodePassword(User $user): void
    {
        $hashedPassword = $this->hasher->hashPassword(
            $user,
            $user->getPlainPassword()
        );

        $user->setPassword($hashedPassword);
        $user->setPlainPassword(null);
    }
}


<?php

namespace App\EntityListener;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserListener
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function prePersist(User $user): void
    {
        // Appelle encodePassword uniquement si un mot de passe en clair est fourni
        if ($user->getPlainPassword() !== null) {
            $this->encodePassword($user);
        }
    }

    public function preUpdate(User $user): void
    {
        // Appelle encodePassword uniquement si un mot de passe en clair est fourni
        if ($user->getPlainPassword() !== null) {
            $this->encodePassword($user);
        }
    }

    private function encodePassword(User $user): void
    {
        // Ne hache que si un mot de passe en clair est fourni (condition vérifiée plus haut)
        $hashedPassword = $this->hasher->hashPassword(
            $user,
            $user->getPlainPassword()
        );

        $user->setPassword($hashedPassword);
        $user->setPlainPassword(null);
    }
}


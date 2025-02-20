<?php

namespace App\Tests\Entity;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testUserAttributes()
    {
        $user = new User();

        $this->assertNull($user->getId());

         // Définir le nom de l'utilisateur
        $user->setUsername('test_username');
        // Vérifier que le nom de l'utilisateur est correctement défini
        $this->assertEquals('test_username', $user->getUsername()); 

        $user->setEmail('test@example.com');
        $this->assertEquals('test@example.com', $user->getEmail());

        // Vérifier que le rôle 'ROLE_USER' est présent par défaut
        $this->assertContains('ROLE_USER', $user->getRoles());

        $user->setRoles(['ROLE_USER', 'ROLE_ADMIN']);
        $this->assertEquals(['ROLE_USER', 'ROLE_ADMIN'], $user->getRoles());

        $user->setPassword('test_password');
        $this->assertEquals('test_password', $user->getPassword());

        $user->setPlainPassword('plain_password');
        $this->assertEquals('plain_password', $user->getPlainPassword());
    
        $user->setUsername('test_username');
        // Vérifier que l'identifiant de l'utilisateur correspond au nom d'utilisateur
        $this->assertEquals('test_username', $user->getUserIdentifier());
    }

    public function testEraseCredentials()
    {
        $user = new User();
        $user->setPlainPassword('plain_password');
        // Supprimer le password (identifiant registration & authentification)
        $user->eraseCredentials();
        // Vérifier que le password a été supprimé
        $this->assertNull($user->getPlainPassword());
    }
}

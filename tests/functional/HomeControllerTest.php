<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeControllerTest extends WebTestCase
{
    public function testIndexForAnonymousUser(): void
    {
        // Créez un client pour simuler un utilisateur non connecté
        $client = static::createClient();

        // Accéder à la page '/home' en tant qu'utilisateur non connecté
        $client->request('GET', '/home');

        // Vérifie que la réponse est bien un succès (HTTP 200)
        $this->assertResponseIsSuccessful();
    }

    public function testIndexForAuthenticatedUser(): void
    {
        // Créez un client pour simuler un utilisateur connecté
        $client = static::createClient();

        // Simulez la connexion d'un utilisateur ayant le rôle 'ROLE_USER'
        $user = $client->getContainer()->get('doctrine')->getRepository(\App\Entity\User::class)->findOneBy(['email' => 'mary.anne@sfr.fr']);
        $client->loginUser($user);

        // Accéder à la page '/home' en tant qu'utilisateur connecté
        $client->request('GET', '/home');

        // Vérifie que la réponse est une redirection vers '/task_list'
        $this->assertResponseRedirects('/tasks/list');
    }
}

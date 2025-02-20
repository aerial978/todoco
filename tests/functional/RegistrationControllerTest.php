<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegistrationControllerTest extends WebTestCase
{
    public function testRegisterUser(): void
    {
        $client = static::createClient();
        
        // Requête HTTP GET à l'URL de l'inscription
        $crawler = $client->request('GET', '/registration');

        // Vérification si le formulaire est bien affiché
        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('button[type="submit"]');
        
        // Selection et saisie le formulaire
        $form = $crawler->selectButton("Go")->form([
            'user[username]' => 'testUser',
            'user[email]' => 'test@user.fr',
            'user[roles]' => 'ROLE_ADMIN',
            'user[plainPassword][first]' => 'patate4$C',
            'user[plainPassword][second]' => 'patate4$C',
        ]);

        // Soumettre le formulaire
        $client->submit($form);
        /*
        $em = self::getContainer()->get(ObjectManager::class);
        
        $em->persist($client);
        $em->flush();
        */
        // Vérification si la soumission du formulaire est réussie
        $this->assertTrue($client->getResponse()->isRedirect());
        
        // Vérification si la redirection a eu lieu
        $this->assertTrue($client->getResponse()->isRedirect('/login'), 'The client is not redirected to /login.');
    
        // Suivre la redirection
        $crawler = $client->followRedirect();
    }
}



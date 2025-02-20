<?php

namespace App\Tests\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function testUserList(): void
    {
        $client = static::createClient();

        $urlGenerator = $client->getContainer()->get('router');
    
        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');    
    
        $user = $entityManager->find(User::class, 1);

        $client->loginUser($user);

        $client->request(Request::METHOD_GET, $urlGenerator->generate('user_list'));

        $this->assertResponseIsSuccessful();

        $this->assertRouteSame('user_list');
    }

    public function testUserEdit(): void
    {
        $client = static::createClient();

        $urlGenerator = $client->getContainer()->get('router');

        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');    

        $user = $entityManager->find(User::class, 1);

        $client->request('GET', '/users/999/edit');
        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);

        //$this->assertSelectorExists('.flash-error', 'User do not exist !');

        $client->loginUser($user);

        $crawler = $client->request(Request::METHOD_GET, $urlGenerator->generate('user_edit', ['id' => $user->getId()]));

        $this->assertResponseIsSuccessful();

        $form = $crawler->selectButton("Submit")->form([
            'user[username]' => 'testUser2',
            'user[email]' => 'test@user.fr',
            'user[roles]' => 'ROLE_USER',
            'user[plainPassword][first]' => 'patateS6?9',
            'user[plainPassword][second]' => 'patateS6?9',
        ]);

        $client->submit($form);

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $client->followRedirect();    
    }
}
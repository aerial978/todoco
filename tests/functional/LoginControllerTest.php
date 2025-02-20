<?php

namespace App\Tests\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginControllerTest extends WebTestCase
{
    public function testLoginUser(): void
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'Audrey Dijoux', 
            'PHP_AUTH_PW'   => 'password', 
        ]);

        $urlGenerator = $client->getContainer()->get("router");

        $crawler = $client->request('GET', $urlGenerator->generate('login'));

        $form = $crawler->selectButton("Go")->form([
            '_username' => 'Audrey Dijoux',
            '_password' => 'password'
        ]);

        $client->submit($form);

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $client->followRedirect();

        $this->assertRouteSame('task_list');
    }
}

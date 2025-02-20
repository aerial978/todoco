<?php

namespace App\Tests\Controller;

use App\Entity\Task;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskControllerTest extends WebTestCase
{
    public function testTaskCreate(): void
    {
        $client = static::createClient();

        $urlGenerator = $client->getContainer()->get('router');
    
        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');    
    
        $user = $entityManager->find(User::class, 1);

        $client->loginUser($user);

        $crawler = $client->request(Request::METHOD_GET, $urlGenerator->generate('task_create'));

        $form = $crawler->selectButton("Add Task")->form([
            'task[title]' => 'Title_test',
            'task[content]' => 'Content_test',
        ]);

        $client->submit($form);

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $client->followRedirect();

        $this->assertSelectorExists('.alert-success:contains("Task has been added successfully.")');
    }

    public function testTaskEdit(): void
    {
        $client = static::createClient();

        $urlGenerator = $client->getContainer()->get('router');

        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');    

        $user = $entityManager->find(User::class, 1);

        $task = $entityManager->getRepository(Task::class)->findOneBy([
            'user' => $user
        ]);

        $client->loginUser($user);

        $crawler = $client->request(Request::METHOD_GET, $urlGenerator->generate('task_edit', ['id' => $task->getId()]));

        $this->assertResponseIsSuccessful();

        $form = $crawler->selectButton("Submit")->form([
            'task[title]' => 'Title_test 2',
            'task[content]' => 'Content_test 2',
        ]);

        $client->submit($form);

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $client->followRedirect();  
        
        $this->assertSelectorExists('.alert-success:contains("Task has been modified.")');
    }

    public function testTaskDelete(): void 
    {
        $client = static::createClient();

        $urlGenerator = $client->getContainer()->get('router');

        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');    

        $user = $entityManager->find(User::class, 1);

        $task = $entityManager->getRepository(Task::class)->findOneBy([
            'user' => $user
        ]);

        $client->loginUser($user);

        $client->request(Request::METHOD_GET, $urlGenerator->generate('task_delete', ['id' => $task->getId()]));

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $client->followRedirect();

        //$this->assertSelectorExists('.alert-danger:contains("You do not have the necessary permissions to delete this task !")');
    }

    public function testTaskToggle(): void
    {
        $client = static::createClient();

        $urlGenerator = $client->getContainer()->get('router');

        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');    

        $user = $entityManager->find(User::class, 1);

        $task = $entityManager->getRepository(Task::class)->findOneBy([
            'user' => $user
        ]);

        $client->loginUser($user);

        $client->request(Request::METHOD_GET, $urlGenerator->generate('task_toggle', ['id' => $task->getId()]));
        
        $this->assertResponseRedirects('/tasks/list');

        $client->followRedirect();

        //this->assertSelectorExists('.alert-success:contains("Task has been marked as done.")');

    }

    public function testTaskCompleted(): void
    {
        $client = static::createClient();

        $urlGenerator = $client->getContainer()->get('router');

        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');    

        $user = $entityManager->find(User::class, 1);

        $entityManager->getRepository(Task::class)->findOneBy([
            'user' => $user
        ]);

        $client->loginUser($user);

        $client->request(Request::METHOD_GET, $urlGenerator->generate('task_completed'));

        $this->assertResponseIsSuccessful();
    }
}



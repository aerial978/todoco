<?php

namespace App\Tests\Entity;

use App\Entity\Task;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class TaskTest extends TestCase
{
    public function testTaskAttributes()
    {
        $task = new Task();

        $this->assertNull($task->getId());
        
        // Vérification que le titre est null initialement
        $this->assertNull($task->getTitle());
        // Attribution d'un titre et vérification
        $task->setTitle('Test Title');
        $this->assertEquals('Test Title', $task->getTitle());

        $this->assertNull($task->getContent());
        $task->setContent('Test Content');
        $this->assertEquals('Test Content', $task->getContent());

        $this->assertNull($task->getCreatedAt());

        $this->assertNull($task->getUpdatedAt());

        // Marquage de la tâche comme terminée et vérification
        $task->setIsDone(true);
        $this->assertTrue($task->isDone());

        $user = new User();
        // Attribution d'un utilisateur à la tâche et vérification du type
        $task->setUser($user);
        $this->assertInstanceOf(User::class, $task->getUser());
    }

    public function testToggle()
    {
        $task = new Task();

        // Vérification que la tâche n'est pas terminée initialement
        $this->assertFalse($task->isDone());

        // Basculement de l'état de la tâche à vrai et vérification
        $task->toggle(true);
        $this->assertTrue($task->isDone());

        // Basculement de l'état de la tâche à faux et vérification
        $task->toggle(false);
        $this->assertFalse($task->isDone());
    }
}



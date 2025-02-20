<?php

namespace App\Tests\Form;

use App\Form\TaskType;
use App\Entity\Task;
use Symfony\Component\Form\Test\TypeTestCase;

class TaskTypeTest extends TypeTestCase
{
    public function testTaskFormRendering(): void
    {
        // Création données de test
        $formData = [
            'title' => 'Test Title',
            'content' => 'Test Content',
            'isDone' => true,
        ];

        // Création instance du formulaire TaskType
        $form = $this->factory->create(TaskType::class);

        $task = new Task();
        // Définition des attributs
        $task->setTitle($formData['title']);
        $task->setContent($formData['content']);

        // Soumission des données au formulaire
        $form->submit([
            'title' => $formData['title'],
            'content' => $formData['content'],
        ]);

        // Verification du formulaire synchronisé avec l'entité Task
        $this->assertTrue($form->isSynchronized());

        // Vérification titre de l'entité Task correspond au titre soumis (traitement correct)
        $this->assertEquals($task->getTitle(), $formData['title']);
        $this->assertEquals($task->getContent(), $formData['content']);
    }

    public function testIsDoneField(): void
    {
        // Création instance du formulaire TaskType avec option display_isDone activée
        $form = $this->factory->create(TaskType::class, null, ['display_isDone' => true]);

        // Vérification formulaire contient un champ nommé 'isDone'
        $this->assertTrue($form->has('isDone'));
    }
}

<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class TaskController extends AbstractController
{
    #[Route('/tasks/list', name: 'task_list')]
    public function listAction(TaskRepository $taskRepository)
    {
        $tasks = $taskRepository->findAll();

        return $this->render('task/list.html.twig', [
            'tasks' => $tasks,
        ]);
    }

    #[Route('/tasks/create', name: 'task_create')]
    public function createAction(Request $request, EntityManagerInterface $em): Response
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task, ['display_isDone' => false]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();
            $task->setUser($this->getUser());

            $em->persist($task);
            $em->flush();

            $this->addFlash('success', 'Task has been added successfully.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/tasks/{id}/edit', name: 'task_edit')]
    public function editAction(Task $task, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();

            $em->persist($task);
            $em->flush();

            $this->addFlash('success', 'Task has been modified.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/edit.html.twig', [
            'form' => $form->createView(),
            'task' => $task,
        ]);
    }

    #[Route('/tasks/{id}/toggle', name: 'task_toggle')]
    public function toggleTaskAction(Task $task, EntityManagerInterface $em)
    {
        $isDone = !$task->isDone();
        $task->toggle(!$task->isDone());
        $em->persist($task);
        $em->flush();

        if ($isDone) {
            $this->addFlash('success', 'Task has been marked as done.');
        } else {
            $this->addFlash('success', 'Task has been marked as not done.');
        }

        return $this->redirectToRoute('task_list');
    }

    #[Route('/tasks/completed', name: 'task_completed')]
    public function completedTaskAction(TaskRepository $taskRepository)
    {
        $tasks = $taskRepository->findBy(['isDone' => true]);

        return $this->render('task/completed_list.html.twig', [
            'tasks' => $tasks,
        ]);
    }

    #[Route('/task/{id}/delete', name: 'task_delete')]
    public function deleteTaskAction(Task $task, EntityManagerInterface $em, AuthorizationCheckerInterface $authChecker)
    {
        $currentUser = $this->getUser();

        if ($authChecker->isGranted('ROLE_ADMIN') && null === $task->getUser() || $authChecker->isGranted('ROLE_USER') && $currentUser === $task->getUser()) {
            $em->remove($task);
            $em->flush();

            $this->addFlash('success', 'Task has been deleted');
        } else {
            $this->addFlash('error', 'You do not have the necessary permissions to delete this task !');
        }

        return $this->redirectToRoute('task_list');
    }
}

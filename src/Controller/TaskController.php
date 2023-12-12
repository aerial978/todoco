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
    public function listAction()
    {
        return $this->render('task/task_list.html.twig');
    }

    #[Route('/task/create', name: 'create_task')]
    public function createAction(Request $request, EntityManagerInterface $em): Response
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();
            $task->setUser($this->getUser());

            $em->persist($task);
            $em->flush();

            $this->addFlash('success', 'La tâche a été bien été ajoutée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/create_task.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/task/{id}/edit', name: 'edit_task')]
    public function editAction(Task $task, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();

            $em->persist($task);
            $em->flush();

            $this->addFlash('success', 'La tâche a bien été modifiée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/edit_task.html.twig', [
            'form' => $form->createView(),
            'task' => $task,
        ]);
    }

    #[Route('/task/{id}/toggle', name: 'toggle_task')]
    public function toggleTaskAction(Task $task, EntityManagerInterface $em)
    {
        $task->toggle(!$task->isDone());
        $em->persist($task);
        $em->flush();

        $this->addFlash('success', sprintf('La tâche %s a bien été marquée comme faite.', $task->getTitle()));

        return $this->redirectToRoute('task_list');
    }

    #[Route('/task/completed', name: 'completed_task_list')]
    public function completedTaskListAction(TaskRepository $taskRepository)
    {
        $tasks = $taskRepository->findBy(['isDone' => true]);

        return $this->render('task/completed_task_list.html.twig', [
            'tasks' => $tasks,
        ]);
    }

    #[Route('/task/{id}/delete', name: 'delete_task')]
    public function deleteTaskAction(Task $task, EntityManagerInterface $em, AuthorizationCheckerInterface $authChecker)
    {
        $currentUser = $this->getUser();

        if (($authChecker->isGranted('ROLE_ADMIN') && null === $task->getUser()) || ($authChecker->isGranted('ROLE_USER') && $currentUser === $task->getUser())) {
            $em->remove($task);
            $em->flush();

            $this->addFlash('success', 'La tâche a bien été supprimée.');
        } else {
            $this->addFlash('error', 'Vous n\'avez pas les autorisations nécessaires pour supprimer cette tâche.');
        }

        return $this->redirectToRoute('task_list');
    }
}

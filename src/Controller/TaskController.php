<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class TaskController extends AbstractController
{
    #[Route('/tasks/list', name: 'task_list')]
    #[IsGranted('ROLE_USER')]
    public function listAction(TaskRepository $taskRepository, PaginatorInterface $paginator, Request $request)
    {
        $data = $taskRepository->findAll();
        $tasks = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            6
        );

        return $this->render('task/list.html.twig', [
            'tasks' => $tasks,
        ]);
    }

    #[Route('/tasks/create', name: 'task_create')]
    #[IsGranted('ROLE_USER')]
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
    #[IsGranted('ROLE_USER')]
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
    #[IsGranted('ROLE_USER')]
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
    #[IsGranted('ROLE_USER')]
    public function completedTaskAction(TaskRepository $taskRepository, PaginatorInterface $paginator, Request $request)
    {
        $data = $taskRepository->findBy(['isDone' => true]);
        $tasks = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            2
        );

        return $this->render('task/completed_list.html.twig', [
            'tasks' => $tasks,
        ]);
    }

    #[Route('/tasks/{id}/delete', name: 'task_delete')]
    #[IsGranted('ROLE_USER')]
    public function deleteTaskAction(Task $task, EntityManagerInterface $em, AuthorizationCheckerInterface $authChecker)
    {
        $currentUser = $this->getUser();

        if ($authChecker->isGranted('ROLE_ADMIN') && null === $task->getUser()
        || $authChecker->isGranted('ROLE_USER') && $currentUser === $task->getUser()) {
            $em->remove($task);
            $em->flush();

            $this->addFlash('success', 'Task has been deleted');
        } else {
            $this->addFlash('error', 'You do not have the necessary permissions to delete this task !');
        }

        return $this->redirectToRoute('task_list');
    }
}

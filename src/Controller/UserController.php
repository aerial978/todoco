<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class UserController extends AbstractController
{
    /**
     * Constructor to initialize dependencies.
     */
    public function __construct(private UserPasswordHasherInterface $passwordHasher, private EntityManagerInterface $em)
    {
    }

    /**
     * Displays a paginated list of users.
     */
    #[Route('/users/list', name: 'user_list')]
    #[IsGranted('ROLE_ADMIN')]
    public function listAction(UserRepository $userRepository, PaginatorInterface $paginator, request $request)
    {
        $data = $userRepository->findAll();
        $users = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            6
        );

        return $this->render('user/list.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * Handles user editing.
     * 
     * Administrators can update a user's role. If an admin removes their own admin rights, they will be logged out.
     */
    #[Route('/users/{id}/edit', name: 'user_edit')]
    #[IsGranted('ROLE_ADMIN')]
    public function editAction(User $user, Request $request): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newRoles = $form->get('roles')->getData();
            $user->setRoles([$newRoles]);
            $this->em->persist($user);
            $this->em->flush();

            $this->addFlash('success', 'User has been modified');

            if ($this->getUser() === $user && !in_array('ROLE_ADMIN', [$newRoles])) {                
                return $this->redirectToRoute('logout');
            }

            return $this->redirectToRoute('user_list');
        }

        return $this->render('user/edit.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }
}

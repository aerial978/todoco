<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher, private EntityManagerInterface $em)
    {
    }

    #[Route('/user', name: 'list_user')]
    public function listAction(UserRepository $userRepository)
    {
        $users = $userRepository->findAll();

        return $this->render('user/user_list.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/user/create', name: 'create_user')]
    public function createAction(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $password = $this->passwordHasher->hashPassword($user, $user->getPassword());
            $user->setPassword($password);
            $user->setRoles([$request->request->all()['user']['roles']]);

            $this->em->persist($user);
            $this->em->flush();

            $this->addFlash('success', "L'utilisateur a bien été ajouté.");

            return $this->redirectToRoute('list_user');
        }

        return $this->render('user/create_user.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/user/{id}/edit', name: 'edit_user')]
    public function editAction(User $user, Request $request): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $password = $this->passwordHasher->hashPassword($user, $user->getPassword());
            $user->setPassword($password);
            $user->setRoles([$request->request->all()['user']['roles']]);

            $this->em->persist($user);
            $this->em->flush();

            $this->addFlash('success', "L'utilisateur a bien été modifié");

            return $this->redirectToRoute('list_user');
        }

        return $this->render('user/edit_user.html.twig', [
            'form' => $form->createView(),
             'user' => $user,
        ]);
    }
}

<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher, private EntityManagerInterface $em)
    {
    }

    #[Route('/registration', name: 'registration')]
    public function registerUser(Request $request): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('task_list');
        }

        $user = new User();
        $form = $this->createForm(UserType::class, $user, ['includePlaceholder' => false]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $plainPassword = $form->get('plainPassword')->getData();
            $password = $this->passwordHasher->hashPassword($user, $plainPassword);
            $user->setPassword($password);
            $user->setRoles([$request->request->all()['user']['roles']]);

            $this->em->persist($user);
            $this->em->flush();

            $this->addFlash('success', 'User has been added successfully. Please, login now !');

            return $this->redirectToRoute('login');
        }

        return $this->render('security/registration.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function indexAction(AuthorizationCheckerInterface $authChecker): Response
    {
        // Vérifiez si l'utilisateur est connecté
        if ($authChecker->isGranted('ROLE_USER')) {
            // Utilisateur connecté, redirigez-le vers la page de liste des tâches
            return $this->redirectToRoute('task_list');
        }

        return $this->render('home/index.html.twig');
    }
}

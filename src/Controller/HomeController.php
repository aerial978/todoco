<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function indexAction(AuthorizationCheckerInterface $authChecker): Response
    {
        if ($authChecker->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('task_list');
        }

        return $this->render('home/index.html.twig');
    }
}

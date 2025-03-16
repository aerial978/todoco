<?php

namespace App\EntityListener;

use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

class UserRedirectListener
{
    private $authorizationChecker;
    private $urlGenerator;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker, UrlGeneratorInterface $urlGenerator)
    {
        $this->authorizationChecker = $authorizationChecker;
        $this->urlGenerator = $urlGenerator;
    }

    public function onKernelRequest(RequestEvent $event)
    {
        $request = $event->getRequest();
        $route = $request->attributes->get('_route');

        if ($this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {
            // Liste des routes interdites aux utilisateurs connectés
            $restrictedRoutes = ['login', 'registration'];

            if (in_array($route, $restrictedRoutes)) {
                // Redirige l'utilisateur vers la page d'accueil
                $response = new RedirectResponse($this->urlGenerator->generate('app_home'));
                $event->setResponse($response);
            }
        }
    }
}
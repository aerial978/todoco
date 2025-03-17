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

    /**
     * Constructor to initialize dependencies.
     */
    public function __construct(AuthorizationCheckerInterface $authorizationChecker, UrlGeneratorInterface $urlGenerator)
    {
        $this->authorizationChecker = $authorizationChecker;
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * Handles redirection of authenticated users away from login and registration pages.
     *
     * If the user is fully authenticated and tries to access the login or registration page,
     * they will be redirected to the home page.
     */
    public function onKernelRequest(RequestEvent $event)
    {
        $request = $event->getRequest();
        $route = $request->attributes->get('_route');

        if ($this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {
            $restrictedRoutes = ['login', 'registration'];

            if (in_array($route, $restrictedRoutes)) {
                $response = new RedirectResponse($this->urlGenerator->generate('app_home'));
                $event->setResponse($response);
            }
        }
    }
}
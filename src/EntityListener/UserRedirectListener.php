<?php

namespace App\EntityListener;

use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

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

        if ($route === 'login' && $this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {
            //$response = new RedirectResponse($this->urlGenerator->generate('app_home'));
            //$event->setResponse($response);
        }
    }
}
<?php
// src/EventSubscriber/OutletEventSubscriber.php

namespace App\EventSubscriber;

use ApiPlatform\Symfony\EventListener\EventPriorities;
use App\Entity\Outlet;
use App\Entity\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use App\Repository\UserRepository;

class OutletEventSubscriber implements EventSubscriberInterface
{
    public function __construct(private readonly TokenStorageInterface $tokenStorage)
    {
        
    }

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::VIEW => ['validateOutlet', EventPriorities::PRE_WRITE],
        ];
    }

    public function validateOutlet(ViewEvent $event): void
    {
        $entity = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if ($this->isOutlet($entity)) {
            if (Request::METHOD_POST === $method) {
                $this->validateBoatOwnership($entity, $this->tokenStorage->getToken()->getUser());
                
            }
        }
    }

    private function isOutlet($entity): bool
    {
        return $entity instanceof Outlet;
    }

    private function validateBoatOwnership(Outlet $outlet, User $user): void
    {
        // Check if the user has at least one associated boat
        $boats = $user->getBoats();
        if ($boats->isEmpty()) {
            throw new \Exception('Vous devez posséder un bateau pour créer une sortie pêche.');
        }
    }
}

<?php
declare(strict_types=1);

namespace WernerDweight\CORSBundle\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use WernerDweight\CORSBundle\Service\CORSResolver;
use WernerDweight\CORSBundle\Service\TargetControllerResolver;

final class CORSEventSubscriber implements EventSubscriberInterface
{
    /** @var CORSResolver */
    private $resolver;

    /** @var TargetControllerResolver */
    private $targetControllerResolver;

    /**
     * CORSEventSubscriber constructor.
     *
     * @param CORSResolver             $resolver
     * @param TargetControllerResolver $targetControllerResolver
     */
    public function __construct(CORSResolver $resolver, TargetControllerResolver $targetControllerResolver)
    {
        $this->resolver = $resolver;
        $this->targetControllerResolver = $targetControllerResolver;
    }

    /**
     * @param ControllerEvent $event
     */
    public function resolveRequest(ControllerEvent $event): void
    {
        $controller = $event->getController();
        if (true === $this->targetControllerResolver->isTargeted($controller)) {
            $this->resolver->resolve($event->getRequest());
        }
    }

    /**
     * @param FilterResponseEvent $event
     */
    public function enhanceResponse(FilterResponseEvent $event): void
    {
        $request = $event->getRequest();
        if (Request::METHOD_OPTIONS === $request->getMethod()) {
            // already handled by CORSResolver
            return;
        }

        $event->getResponse()->headers->add(
            $this->resolver->getHeaders($request)
        );
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => 'resolveRequest',
            KernelEvents::RESPONSE => 'enhanceResponse',
        ];
    }
}

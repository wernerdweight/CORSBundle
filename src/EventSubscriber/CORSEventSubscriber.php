<?php
declare(strict_types=1);

namespace WernerDweight\CORSBundle\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use WernerDweight\CORSBundle\Controller\CORSControllerInterface;
use WernerDweight\CORSBundle\Service\CORSResolver;

final class CORSEventSubscriber implements EventSubscriberInterface
{
    /** @var CORSResolver */
    private $resolver;

    /**
     * CORSSubscriber constructor.
     *
     * @param CORSResolver $resolver
     */
    public function __construct(CORSResolver $resolver)
    {
        $this->resolver = $resolver;
    }

    /**
     * @param ControllerEvent $event
     */
    public function resolveRequest(ControllerEvent $event): void
    {
        $controller = $event->getController();
        // TOOD: allow configurable interfaces/classes
        if ($controller instanceof CORSControllerInterface) {
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

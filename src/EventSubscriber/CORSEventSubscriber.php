<?php
declare(strict_types=1);

namespace WernerDweight\CORSBundle\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Contracts\Service\ServiceSubscriberInterface;
use WernerDweight\CORSBundle\Service\CORSResolver;
use WernerDweight\CORSBundle\Service\TargetControllerResolver;

final class CORSEventSubscriber implements EventSubscriberInterface
{
    /** @var bool */
    private $shouldBeEnhanced = false;

    /** @var CORSResolver */
    private $resolver;

    /** @var TargetControllerResolver */
    private $targetControllerResolver;

    /**
     * CORSEventSubscriber constructor.
     */
    public function __construct(CORSResolver $resolver, TargetControllerResolver $targetControllerResolver)
    {
        $this->resolver = $resolver;
        $this->targetControllerResolver = $targetControllerResolver;
    }

    private function getControllerFromEvent(ControllerEvent $event): ServiceSubscriberInterface
    {
        $controller = $event->getController();
        if (true === is_array($controller)) {
            $controller = $controller[0];
        }
        return $controller;
    }

    public function resolveRequest(ControllerEvent $event): void
    {
        $controller = $this->getControllerFromEvent($event);
        if (true === $this->targetControllerResolver->isTargeted($controller)) {
            $request = $event->getRequest();
            if (Request::METHOD_OPTIONS !== $request->getMethod()) {
                // only intercept OPTIONS calls, only enhance other calls
                $this->shouldBeEnhanced = true;
                return;
            }

            $this->resolver->resolve($request);
        }
    }

    public function enhanceResponse(ResponseEvent $event): void
    {
        if (true !== $this->shouldBeEnhanced) {
            return;
        }

        $event->getResponse()->headers->add(
            $this->resolver->getHeaders($event->getRequest())
        );
    }

    /**
     * @return string[]
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => 'resolveRequest',
            KernelEvents::RESPONSE => 'enhanceResponse',
        ];
    }
}

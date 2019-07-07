<?php
declare(strict_types=1);

namespace WernerDweight\CORSBundle\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use WernerDweight\CORSBundle\Exception\PreflightRequestInterceptedException;

final class PreflightRequestInterceptedEventSubscriber implements EventSubscriberInterface
{
    /**
     * @param GetResponseForExceptionEvent $event
     */
    public function interceptException(GetResponseForExceptionEvent $event): void
    {
        $exception = $event->getException();
        if ($exception instanceof PreflightRequestInterceptedException) {
            $event->allowCustomResponseCode();
            $event->setResponse($exception->getResponse());
        }
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => [
                ['interceptException', 2]
            ],
        ];
    }
}

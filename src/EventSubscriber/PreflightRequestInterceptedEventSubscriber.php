<?php
declare(strict_types=1);

namespace WernerDweight\CORSBundle\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use WernerDweight\CORSBundle\Exception\PreflightRequestInterceptedException;

/**
 * @SuppressWarnings(PHPMD.LongClassName)
 */
final class PreflightRequestInterceptedEventSubscriber implements EventSubscriberInterface
{
    public function interceptException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        if ($exception instanceof PreflightRequestInterceptedException) {
            $event->allowCustomResponseCode();
            $event->setResponse($exception->getResponse());
        }
    }

    /**
     * @return mixed[]
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => [
                ['interceptException', 2],
            ],
        ];
    }
}

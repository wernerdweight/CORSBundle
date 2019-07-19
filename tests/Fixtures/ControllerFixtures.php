<?php
declare(strict_types=1);

namespace WernerDweight\CORSBundle\Tests\Fixtures;

use Symfony\Contracts\Service\ServiceSubscriberInterface;
use WernerDweight\CORSBundle\Controller\CORSControllerInterface;
use WernerDweight\CORSBundle\Tests\Helpers\TestTargetedControllerInterface;

class ControllerFixtures
{
    /**
     * @return ServiceSubscriberInterface
     */
    public static function createCORSController(): ServiceSubscriberInterface
    {
        return new class() implements CORSControllerInterface, ServiceSubscriberInterface {
            public static function getSubscribedServices(): array
            {
                return [];
            }
        };
    }

    /**
     * @return ServiceSubscriberInterface
     */
    public static function createTargetedController(): ServiceSubscriberInterface
    {
        return new class() implements TestTargetedControllerInterface {
            public static function getSubscribedServices(): array
            {
                return [];
            }
        };
    }

    /**
     * @return ServiceSubscriberInterface
     */
    public static function createNotTargetedController(): ServiceSubscriberInterface
    {
        return new class() implements ServiceSubscriberInterface {
            public static function getSubscribedServices(): array
            {
                return [];
            }
        };
    }
}

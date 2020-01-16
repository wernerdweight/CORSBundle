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
            /**
             * @return mixed[]
             */
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
            /**
             * @return mixed[]
             */
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
            /**
             * @return mixed[]
             */
            public static function getSubscribedServices(): array
            {
                return [];
            }
        };
    }
}

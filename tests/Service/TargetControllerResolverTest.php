<?php
declare(strict_types=1);

namespace WernerDweight\CORSBundle\Tests\Service;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Contracts\Service\ServiceSubscriberInterface;
use WernerDweight\CORSBundle\Service\TargetControllerResolver;
use WernerDweight\CORSBundle\Tests\Fixtures\ControllerFixtures;

class TargetControllerResolverTest extends KernelTestCase
{
    /**
     * @param bool                       $expected
     * @param ServiceSubscriberInterface $controller
     *
     * @dataProvider provideValues
     */
    public function testIsTargeted(
        bool $expected,
        ServiceSubscriberInterface $controller
    ): void {
        self::bootKernel();
        /** @var TargetControllerResolver $resolver */
        $resolver = self::$container->get(TargetControllerResolver::class);
        $value = $resolver->isTargeted($controller);
        $this->assertEquals($expected, $value);
    }

    /**
     * @return mixed[]
     */
    public function provideValues(): array
    {
        return [
            [true, ControllerFixtures::createCORSController()],
            [true, ControllerFixtures::createTargetedController()],
            [false, ControllerFixtures::createNotTargetedController()],
        ];
    }
}

<?php
declare(strict_types=1);

namespace WernerDweight\CORSBundle\Tests\Service;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\Request;
use WernerDweight\CORSBundle\Service\RoutingHeaderResolver;
use WernerDweight\CORSBundle\Tests\Fixtures\RequestFixtures;
use WernerDweight\RA\RA;

class RoutingHeaderResolverTest extends KernelTestCase
{
    /**
     * @dataProvider provideValues
     */
    public function testResolveAllowedMethods(
        ?RA $expected,
        Request $request
    ): void {
        self::bootKernel();
        /** @var RoutingHeaderResolver $resolver */
        $resolver = self::$container->get(RoutingHeaderResolver::class);
        $value = $resolver->resolveAllowedMethods($request);
        $this->assertEquals($expected, $value);
    }

    /**
     * @return mixed[]
     */
    public function provideValues(): array
    {
        return [
            [null, RequestFixtures::createEmptyRequest()],
            [new RA([1 => 'GET']), RequestFixtures::createValidGetRequest()],
            [new RA([1 => 'POST']), RequestFixtures::createValidPostRequest()],
            [new RA([1 => 'POST']), RequestFixtures::createInvalidGetRequest()],
            [new RA([1 => 'GET']), RequestFixtures::createInvalidPostRequest()],
        ];
    }
}

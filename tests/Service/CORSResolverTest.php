<?php
declare(strict_types=1);

namespace WernerDweight\CORSBundle\Tests\Service;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\Request;
use WernerDweight\CORSBundle\Exception\PreflightRequestInterceptedException;
use WernerDweight\CORSBundle\Service\CORSResolver;
use WernerDweight\CORSBundle\Tests\Fixtures\RequestFixtures;

class CORSResolverTest extends KernelTestCase
{
    /**
     * @dataProvider provideResolveValues
     */
    public function testResolve(Request $request): void
    {
        self::bootKernel();
        /** @var CORSResolver $resolver */
        $resolver = self::$container->get(CORSResolver::class);
        $this->expectException(PreflightRequestInterceptedException::class);
        $resolver->resolve($request);
    }

    /**
     * @param mixed[] $expected
     *
     * @dataProvider provideGetHeadersValues
     */
    public function testGetHeaders(
        array $expected,
        Request $request
    ): void {
        self::bootKernel();
        /** @var CORSResolver $resolver */
        $resolver = self::$container->get(CORSResolver::class);
        $value = $resolver->getHeaders($request);
        $this->assertEquals($expected, $value);
    }

    /**
     * @return mixed[]
     */
    public function provideResolveValues(): array
    {
        return [
            [
                RequestFixtures::createEmptyRequest(),
                RequestFixtures::createValidGetRequest(),
                RequestFixtures::createValidPostRequest(),
                RequestFixtures::createInvalidGetRequest(),
                RequestFixtures::createInvalidPostRequest(),
            ],
        ];
    }

    /**
     * @return mixed[]
     */
    public function provideGetHeadersValues(): array
    {
        return [
            [
                [
                    'Access-Control-Allow-Credentials' => 'true',
                    'Access-Control-Allow-Origin' => '*',
                    'Access-Control-Allow-Headers' => 'Authorization, Content-Type, Cache-Control, X-Requested-With',
                    'Access-Control-Expose-Headers' => 'Content-Disposition',
                ],
                RequestFixtures::createEmptyRequest(),
            ],
            [
                [
                    'Access-Control-Allow-Credentials' => 'true',
                    'Access-Control-Allow-Origin' => '*',
                    'Access-Control-Allow-Headers' => 'Authorization, Content-Type, Cache-Control, X-Requested-With',
                    'Access-Control-Expose-Headers' => 'Content-Disposition',
                    'Access-Control-Allow-Methods' => 'GET',
                ],
                RequestFixtures::createValidGetRequest(),
            ],
            [
                [
                    'Access-Control-Allow-Credentials' => 'true',
                    'Access-Control-Allow-Origin' => '*',
                    'Access-Control-Allow-Headers' => 'Authorization, Content-Type, Cache-Control, X-Requested-With',
                    'Access-Control-Expose-Headers' => 'Content-Disposition',
                    'Access-Control-Allow-Methods' => 'POST',
                ],
                RequestFixtures::createValidPostRequest(),
            ],
            [
                [
                    'Access-Control-Allow-Credentials' => 'true',
                    'Access-Control-Allow-Origin' => '*',
                    'Access-Control-Allow-Headers' => 'Authorization, Content-Type, Cache-Control, X-Requested-With',
                    'Access-Control-Expose-Headers' => 'Content-Disposition',
                    'Access-Control-Allow-Methods' => 'POST',
                ],
                RequestFixtures::createInvalidGetRequest(),
            ],
            [
                [
                    'Access-Control-Allow-Credentials' => 'true',
                    'Access-Control-Allow-Origin' => '*',
                    'Access-Control-Allow-Headers' => 'Authorization, Content-Type, Cache-Control, X-Requested-With',
                    'Access-Control-Expose-Headers' => 'Content-Disposition',
                    'Access-Control-Allow-Methods' => 'GET',
                ],
                RequestFixtures::createInvalidPostRequest(),
            ],
        ];
    }
}

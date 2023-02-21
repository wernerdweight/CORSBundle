<?php
declare(strict_types=1);

namespace WernerDweight\CORSBundle\Tests\Service;

use PHPUnit\Framework\TestCase;
use WernerDweight\CORSBundle\Service\ConfigurationProvider;
use WernerDweight\RA\RA;

class ConfigurationProviderTest extends TestCase
{
    /**
     * @dataProvider provideValues
     */
    public function testGetAllowCredentials(ConfigurationProvider $configurationProvider): void
    {
        $this->assertEquals(true, $configurationProvider->getAllowCredentials());
    }

    /**
     * @dataProvider provideValues
     */
    public function testGetAllowOrigin(ConfigurationProvider $configurationProvider): void
    {
        $this->assertEquals(new RA(['http://localhost']), $configurationProvider->getAllowOrigin());
    }

    /**
     * @dataProvider provideValues
     */
    public function testGetAllowHeaders(ConfigurationProvider $configurationProvider): void
    {
        $this->assertEquals(new RA(['Content-Type', 'X-Requested-With']), $configurationProvider->getAllowHeaders());
    }

    /**
     * @dataProvider provideValues
     */
    public function testGetExposeHeaders(ConfigurationProvider $configurationProvider): void
    {
        $this->assertEquals(new RA(['Cache-Control']), $configurationProvider->getExposeHeaders());
    }

    /**
     * @dataProvider provideValues
     */
    public function testGetTargetControllers(ConfigurationProvider $configurationProvider): void
    {
        $this->assertEquals(new RA(['SomeNamespace']), $configurationProvider->getTargetControllers());
    }

    /**
     * @return mixed[]
     */
    public static function provideValues(): array
    {
        return [
            [
                new ConfigurationProvider(
                    true,
                    ['http://localhost'],
                    ['Content-Type', 'X-Requested-With'],
                    ['Cache-Control'],
                    ['SomeNamespace']
                ),
            ],
        ];
    }
}

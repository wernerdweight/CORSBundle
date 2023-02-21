<?php
declare(strict_types=1);

namespace WernerDweight\CORSBundle\Tests;

use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
use WernerDweight\CORSBundle\CORSBundle;
use WernerDweight\CORSBundle\Tests\Helpers\TestTargetedControllerInterface;

class TestKernel extends Kernel
{
    use MicroKernelTrait;

    /**
     * @return BundleInterface[]
     */
    public function registerBundles(): array
    {
        return [
            new FrameworkBundle(),
            new CORSBundle(),
        ];
    }

    protected function configureRoutes(RoutingConfigurator $routes): void
    {
        $routes->import(__DIR__ . '/Resources/config/routes.yaml');
    }

    protected function configureContainer(ContainerBuilder $builder, LoaderInterface $loader): void
    {
        $loader->load(__DIR__ . '/../vendor/symfony/framework-bundle/Resources/config/test.php');
        $loader->load(__DIR__ . '/../src/Resources/config/services.yaml');

        $builder->setParameter('session.storage.options', []);

        $builder->loadFromExtension('framework', [
            'secret' => 'not-so-secret',
            'test' => true,
            'router' => [
                'utf8' => true,
            ],
            'session' => [
                'enabled' => false,
            ],
            'http_method_override' => false,
        ]);
        $builder->loadFromExtension('cors', [
            'access_control' => [
                'allow_credentials' => true,
                'allow_origin' => [
                    '*',
                ],
                'allow_headers' => [
                    'Authorization',
                    'Content-Type',
                    'Cache-Control',
                    'X-Requested-With',
                ],
                'expose_headers' => [
                    'Content-Disposition',
                ],
            ],
            'target_controllers' => [
                TestTargetedControllerInterface::class,
            ],
        ]);
    }
}

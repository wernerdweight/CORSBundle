<?php
declare(strict_types=1);

namespace WernerDweight\CORSBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class CORSExtension extends Extension
{
    /**
     * @param array            $configs
     * @param ContainerBuilder $container
     *
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter(
            'cors.access_control.allow_credentials',
            $config['access_control']['allow_credentials'] ?? []
        );
        $container->setParameter(
            'cors.access_control.allow_origin',
            $config['access_control']['allow_origin'] ?? []
        );
        $container->setParameter(
            'cors.access_control.allow_headers',
            $config['access_control']['allow_headers'] ?? []
        );
        $container->setParameter(
            'cors.access_control.expose_headers',
            $config['access_control']['expose_headers'] ?? []
        );
        $container->setParameter(
            'cors.target_controllers',
            $config['target_controllers'] ?? []
        );

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yaml');
    }
}

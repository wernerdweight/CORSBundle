<?php
declare(strict_types=1);

namespace WernerDweight\CORSBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('cors');
        /** @var ArrayNodeDefinition $rootNode */
        $rootNode = $treeBuilder->getRootNode();

        $this->addConfiguration($rootNode);

        return $treeBuilder;
    }

    private function addConfiguration(ArrayNodeDefinition $node): void
    {
        $node
            ->children()
                ->arrayNode('access_control')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->booleanNode('allow_credentials')
                            ->defaultFalse()
                        ->end()
                        ->arrayNode('allow_origin')
                            ->scalarPrototype()
                            ->end()
                        ->end()
                        ->arrayNode('allow_headers')
                            ->scalarPrototype()
                            ->end()
                        ->end()
                        ->arrayNode('expose_headers')
                            ->scalarPrototype()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('target_controllers')
                    ->scalarPrototype()
                    ->end()
                ->end()
            ->end()
        ;
    }
}

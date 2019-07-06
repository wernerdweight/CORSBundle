<?php
declare(strict_types=1);

namespace WernerDweight\CORSBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    /**
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('cors');

        $this->addConfiguration($rootNode);

        return $treeBuilder;
    }

    /**
     * @param ArrayNodeDefinition $node
     */
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

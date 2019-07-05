<?php
declare(strict_types=1);

namespace WernerDweight\CORSBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
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
        $rootNode = $treeBuilder->root('wds_cors');

        $this->addConfiguration($rootNode);

        return $treeBuilder;
    }

    /**
     * @param NodeDefinition $node
     */
    private function addConfiguration(NodeDefinition $node): void
    {
        $node
            ->children()
                // TODO:
            ->end()
        ;
    }
}

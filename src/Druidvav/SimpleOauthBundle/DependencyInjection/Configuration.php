<?php

namespace Druidvav\SimpleOauthBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('dv_simple_oauth');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
                ->scalarNode('redirect_uri_route')
                    ->cannotBeEmpty()
                    ->isRequired()
                ->end()
            ->end()
            ->append($this->addServicesSection())
        ;

        return $treeBuilder;
    }

    private function addServicesSection(): ArrayNodeDefinition
    {
        $tree = new TreeBuilder('services');
        $node = $tree->getRootNode();

        $node
            ->requiresAtLeastOneElement()
            ->prototype('array')
                ->children()
                    ->scalarNode('title')
                        ->cannotBeEmpty()
                        ->isRequired()
                    ->end()
                    ->scalarNode('resource_owner')
                        ->cannotBeEmpty()
                        ->isRequired()
                    ->end()
                    ->variableNode('options')
                        ->cannotBeEmpty()
                        ->isRequired()
                    ->end()
                ->end()
            ->end()
        ->end();
        return $node;
    }
}

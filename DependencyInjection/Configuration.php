<?php

namespace Malwarebytes\GeneratorBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('malwarebytes_test_data');

        $rootNode
            ->fixXmlConfig('scenario')
            ->children()
                ->arrayNode('scenarios')
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                        ->prototype('array')
                            ->children()
                                ->scalarNode('entity')->isRequired()->end()
                                ->scalarNode('category')->isRequired()->end()
                                ->integerNode('quantity')->isRequired()->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->enumNode('populator')
                    ->values(array('csv', 'doctrine', 'propel', 'mandango'))
                    ->defaultValue('csv')
                ->end()
                ->integerNode('seed')->end()
            ->end();

        return $treeBuilder;
    }
}

<?php
/**
 * Copyright 2015 Jonathan Bouzekri. All rights reserved.
 *
 * @copyright Copyright 2015 Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
 * @license https://github.com/jbouzekri/OpSiteBundle/blob/master/LICENSE
 * @link https://github.com/jbouzekri/OpSiteBundle
 */

namespace OpSiteBuilder\Bundle\CoreBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 *
 * @package OpSiteBuilder\Bundle\CoreBundle\DependencyInjection
 * @author jobou
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('op_site_builder_core');

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->arrayNode('page_map')
                    ->useAttributeAsKey('name')
                    ->defaultValue(array())
                    ->prototype('scalar')
                    ->end()
                ->end()
                ->arrayNode('block_map')
                    ->useAttributeAsKey('name')
                    ->defaultValue(array())
                    ->prototype('scalar')
                    ->end()
                ->end()
                ->append($this->addRoutingNode())
                ->append($this->addBlockConfigurationNode())
                ->append($this->addToolsNode())
            ->end();

        return $treeBuilder;
    }

    /**
     * Configure routing node
     *
     * @return ArrayNodeDefinition|NodeDefinition
     */
    protected function addRoutingNode()
    {
        $builder = new TreeBuilder();
        $node = $builder->root('routing');

        $node
            ->addDefaultsIfNotSet()
            ->children()
                ->arrayNode('routes')
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('prefix')->isRequired()->end()
                            ->scalarNode('controller')->isRequired()->end()
                            ->scalarNode('regex')->defaultNull()->end()
                            ->scalarNode('path')->defaultNull()->end()
                        ->end()
                    ->end()
                    ->defaultValue(array(
                        'edit' => array(
                            'prefix' => 'opsite_page_tree_edit_',
                            'regex' => '/(.+)\/edit$/',
                            'controller' => 'OpSiteBuilderCoreBundle:Page:edit',
                            'path' => '%s/edit'
                        ),
                        'view' => array(
                            'prefix' => 'opsite_page_tree_view_',
                            'regex' => null,
                            'controller' => 'OpSiteBuilderCoreBundle:Page:index'
                        )
                    ))
                ->end()
            ->end()
        ;

        return $node;
    }

    /**
     * Configure block_configuration node
     *
     * @return ArrayNodeDefinition|NodeDefinition
     */
    protected function addBlockConfigurationNode()
    {
        $builder = new TreeBuilder();
        $node = $builder->root('block_configuration');

        $node
            ->useAttributeAsKey('name')
            ->defaultValue(array())
            ->prototype('array')
                ->children()
                    ->scalarNode('view_template')
                        ->defaultValue('OpSiteBuilderWebBundle:Block:View/default_view.html.twig')
                    ->end()
                    ->scalarNode('view_controller')
                        ->defaultValue('OpSiteBuilderCoreBundle:Block:default')
                    ->end()
                    ->scalarNode('view_route')
                        ->defaultValue('opsite_builder_api_view_block')
                    ->end()
                    ->scalarNode('edit_controller')
                        ->defaultValue('OpSiteBuilderCoreBundle:Block:defaultEdit')
                    ->end()
                    ->scalarNode('edit_route')
                        ->defaultValue('opsite_builder_api_edit_no_form_block')
                    ->end()
                    ->scalarNode('edit_template')
                        ->defaultValue('OpSiteBuilderWebBundle:Block:View/default_edit.html.twig')
                    ->end()
                    ->scalarNode('edit_form_type')
                        ->defaultNull()
                    ->end()
                    ->arrayNode('options')
                        ->validate()
                            ->ifTrue(function ($v) {
                                return !is_array($v);
                            })
                            ->thenInvalid('Options for block configuration should always be an array')
                        ->end()
                        ->defaultValue(array())
                        ->prototype('variable')
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $node;
    }

    /**
     * Configure tools node
     *
     * @return ArrayNodeDefinition|NodeDefinition
     */
    protected function addToolsNode()
    {
        $builder = new TreeBuilder();
        $node = $builder->root('tools');

        $node
            ->useAttributeAsKey('name')
            ->defaultValue(array())
            ->prototype('array')
                ->children()
                    ->booleanNode('enabled')
                        ->defaultTrue()
                    ->end()
                    ->arrayNode('pages')
                        ->defaultValue(array())
                        ->prototype('scalar')
                        ->end()
                    ->end()
                    ->integerNode('priority')
                        ->defaultValue(100)
                    ->end()
                ->end()
            ->end()
        ;

        return $node;
    }
}

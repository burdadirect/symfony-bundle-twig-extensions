<?php

namespace HBM\TwigExtensionsBundle\DependencyInjection;

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
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('hbm_twig_extensions');
        $rootNode    = $treeBuilder->getRootNode();

        $rootNode
          ->children()
            ->arrayNode('base_url')->addDefaultsIfNotSet()
              ->children()
                ->scalarNode('images')->defaultValue('')->end()
                ->scalarNode('videos')->defaultValue('')->end()
              ->end()
            ->end()
            ->arrayNode('responsive_svg')->addDefaultsIfNotSet()
              ->children()
                ->scalarNode('inline')->defaultFalse()->info('Setting this requires you to use responsiveSourceSVG to include the svg stack in the page.')->end()
                ->scalarNode('public_dir')->info('Set this to the name of the public directory. (Symfony 3: "web", Symfony 4: "public")')->end()
                ->arrayNode('styles')->addDefaultsIfNotSet()
                  ->children()
                    ->scalarNode('wrapper')->defaultValue('position: relative;')->end()
                    ->scalarNode('filler')->defaultValue('width: 100%; height: 0; overflow: hidden;')->end()
                    ->scalarNode('svg')->defaultValue('position: absolute; top: 0; bottom: 0; left: 0; right: 0;')->end()
                  ->end()
                ->end()
                ->arrayNode('aliases')
                  ->prototype('array')
                    ->children()
                      ->scalarNode('path')->end()
                    ->end()
                  ->end()
                ->end()
              ->end()
            ->end()
          ->end()
        ->end();

        return $treeBuilder;
    }
}

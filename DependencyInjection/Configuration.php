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
  public function getConfigTreeBuilder()
  {
    $treeBuilder = new TreeBuilder();
    $rootNode = $treeBuilder->root('hbm_twig_extensions');

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

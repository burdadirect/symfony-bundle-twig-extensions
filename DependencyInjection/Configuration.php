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
    $treeBuilder = new TreeBuilder('hbm_twig_extensions');

    if (method_exists($treeBuilder, 'getRootNode')) {
      $rootNode = $treeBuilder->getRootNode();
    } else {
      $rootNode = $treeBuilder->root('hbm_twig_extensions');
    }

    $rootNode
      ->children()
        ->arrayNode('base_url')->addDefaultsIfNotSet()
          ->children()
            ->scalarNode('images')->defaultValue('')->end()
            ->scalarNode('videos')->defaultValue('')->end()
          ->end()
        ->end()
        ->arrayNode('bootstrap')->addDefaultsIfNotSet()
          ->children()
            ->arrayNode('fontawesome')->addDefaultsIfNotSet()
              ->children()
                ->scalarNode('default_class')->defaultValue('fas')->end()
              ->end()
            ->end()
          ->end()
        ->end()
        ->arrayNode('responsive_svg')->addDefaultsIfNotSet()
          ->children()
            ->scalarNode('inline')->defaultFalse()->info('Setting this requires you to use responsiveSourceSVG to include the svg stack in the page.')->end()
            ->scalarNode('public_dir')->info('Set this to the name of the public directory. (Symfony 3: "web", Symfony 4: "public")')->end()
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

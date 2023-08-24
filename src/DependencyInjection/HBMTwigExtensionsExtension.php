<?php

namespace HBM\TwigExtensionsBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class HBMTwigExtensionsExtension extends Extension {

  /**
   * {@inheritdoc}
   */
  public function load(array $configs, ContainerBuilder $container): void {
    $configuration = new Configuration();
    $config = $this->processConfiguration($configuration, $configs);

    $configToUse = $config;

    $container->setParameter('hbm.twig_extensions.base_url', $configToUse['base_url']);
    $container->setParameter('hbm.twig_extensions.responsive_svg', $configToUse['responsive_svg']);

    $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../../config'));
    $loader->load('services.yaml');
  }

}

<?php

namespace HBM\TwigExtensionsBundle\Twig\Runtime;

use HBM\TwigExtensionsBundle\Interfaces\SettingContentProviderInterface;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\SyntaxError;
use Twig\Extension\RuntimeExtensionInterface;

class SettingContentRuntime implements RuntimeExtensionInterface
{
  public function __construct(
    private readonly SettingContentProviderInterface $settingContentProvider,
    private readonly Environment $environment
  ) {}

  /**
   * @param string $key
   *
   * @return string
   *
   * @throws LoaderError
   * @throws SyntaxError
   */
  public function renderContentFromSettings(string $key): string
  {
    $setting = $this->settingContentProvider->getVarValueParsed($key, 'content');

    return $this->environment->createTemplate($setting ?? '', 'Template from '.$key)->render();
  }

}

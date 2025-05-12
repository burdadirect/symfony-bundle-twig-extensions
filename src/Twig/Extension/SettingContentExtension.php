<?php

namespace HBM\TwigExtensionsBundle\Twig\Extension;

use HBM\TwigExtensionsBundle\Twig\Runtime\SettingContentRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class SettingContentExtension extends AbstractExtension
{

    public function getFilters(): array {
        return [
          new TwigFilter('hbmContentFromSettings', [SettingContentRuntime::class, 'renderContentFromSettings']),
        ];
    }

}

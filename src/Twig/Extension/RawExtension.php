<?php

namespace HBM\TwigExtensionsBundle\Twig\Extension;

use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\Markup;
use Twig\TwigFilter;

class RawExtension extends AbstractExtension
{
    /* DEFINITIONS */

    public function getFilters(): array
    {
        return [
            'hbmRaw' => new TwigFilter('hbmRaw', $this->hbmRaw(...), ['needs_environment' => true]),
        ];
    }

    /* FILTERS */

    public function hbmRaw(Environment $environment, mixed $var, $outputRaw = true): mixed
    {
        if ($outputRaw) {
            return new Markup($var, $environment->getCharset());
        }

        return $var;
    }
}

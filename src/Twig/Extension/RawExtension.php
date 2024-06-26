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

    /**
     * @return Markup
     */
    public function hbmRaw(Environment $environment, $var, $outputRaw = true)
    {
        if ($outputRaw) {
            return new Markup($var, $environment->getCharset());
        }

        return $var;
    }
}

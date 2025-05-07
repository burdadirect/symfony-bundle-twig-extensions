<?php

namespace HBM\TwigExtensionsBundle\Twig\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class NumberExtension extends AbstractExtension
{
    /* DEFINITIONS */

    public function getFilters(): array
    {
        return [
          new TwigFilter('numberFormatOrDefault', $this->numberFormatOrDefault(...)),
        ];
    }

    /* FILTERS */

    public function numberFormatOrDefault(mixed $number, mixed $default = null, int $decimals = 0, ?string $decimal_separator = ',', ?string $thousands_separator = '.', int $decimalsOnInt = null)
    {
        if (is_numeric($number)) {
            if (is_int($number)) {
                return number_format($number, $decimalsOnInt ?? $decimals, $decimal_separator, $thousands_separator);
            }
            return number_format($number, $decimals, $decimal_separator, $thousands_separator);
        }

        return $default;
    }

}

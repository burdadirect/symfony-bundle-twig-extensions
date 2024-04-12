<?php

namespace HBM\TwigExtensionsBundle\Twig\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class UrlExtension extends AbstractExtension
{
    /* DEFINITIONS */

    public function getFilters(): array
    {
        return [
          'hbmParseUrl'       => new TwigFilter('hbmParseUrl', $this->hbmParseUrl(...)),
          'hbmParseUrlHost'   => new TwigFilter('hbmParseUrlHost', $this->hbmParseUrlHost(...)),
          'hbmParseUrlDomain' => new TwigFilter('hbmParseUrlDomain', $this->hbmParseUrlHost(...)),
          'hbmParseUrlPath'   => new TwigFilter('hbmParseUrlPath', $this->hbmParseUrlPath(...)),
          'hbmParseUrlQuery'  => new TwigFilter('hbmParseUrlQuery', $this->hbmParseUrlQuery(...)),
        ];
    }

    /* FILTERS */

    /**
     * @param mixed $var
     *
     * @return null|array|false|int|string
     */
    public function hbmParseUrl(string $var, int $component = -1)
    {
        return parse_url($var, $component);
    }

    public function hbmParseUrlHost($var): string
    {
        return $this->hbmParseUrl($var, PHP_URL_HOST) ?: '';
    }

    public function hbmParseUrlPath($var): string
    {
        return $this->hbmParseUrl($var, PHP_URL_PATH) ?: '';
    }

    public function hbmParseUrlQuery($var): string
    {
        return $this->hbmParseUrl($var, PHP_URL_QUERY) ?: '';
    }
}

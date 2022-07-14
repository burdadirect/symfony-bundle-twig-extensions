<?php

namespace HBM\TwigExtensionsBundle\Twig;

use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\Markup;
use Twig\TwigFilter;

class UrlExtension extends AbstractExtension {

  /****************************************************************************/
  /* DEFINITIONS                                                              */
  /****************************************************************************/

  public function getFilters() : array {
    return [
      'hbmParseUrl'       => new TwigFilter('hbmParseUrl',       [$this, 'hbmParseUrl']),
      'hbmParseUrlHost'   => new TwigFilter('hbmParseUrlHost',   [$this, 'hbmParseUrlHost']),
      'hbmParseUrlDomain' => new TwigFilter('hbmParseUrlDomain', [$this, 'hbmParseUrlHost']),
      'hbmParseUrlPath'   => new TwigFilter('hbmParseUrlPath',   [$this, 'hbmParseUrlPath']),
      'hbmParseUrlQuery'  => new TwigFilter('hbmParseUrlQuery',  [$this, 'hbmParseUrlQuery']),
    ];
  }

  /****************************************************************************/
  /* FILTERS                                                                  */
  /****************************************************************************/

  /**
   * @param mixed $var
   *
   * @return int|string|array|null|false
   */
  public function hbmParseUrl(string $var, int $component = -1) {
    return parse_url($var, $component);
  }

  /**
   * @param mixed $var
   *
   * @return string
   */
  public function hbmParseUrlHost($var): string {
    return $this->hbmParseUrl($var, PHP_URL_HOST) ?: '';
  }

  /**
   * @param mixed $var
   *
   * @return string
   */
  public function hbmParseUrlPath($var): string {
    return $this->hbmParseUrl($var, PHP_URL_PATH) ?: '';
  }

  /**
   * @param mixed $var
   *
   * @return string
   */
  public function hbmParseUrlQuery($var): string {
    return $this->hbmParseUrl($var, PHP_URL_QUERY) ?: '';
  }

}

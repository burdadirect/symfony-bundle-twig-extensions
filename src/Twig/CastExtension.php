<?php

namespace HBM\TwigExtensionsBundle\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class CastExtension extends AbstractExtension {

  /****************************************************************************/
  /* DEFINITIONS                                                              */
  /****************************************************************************/

  public function getFilters() : array {
    return [
      new TwigFilter('castInt', $this->castInt(...)),
      new TwigFilter('castFloat', $this->castFloat(...)),
      new TwigFilter('castBool', $this->castBool(...)),
      new TwigFilter('castArray', $this->castArray(...)),
      new TwigFilter('castString', $this->castString(...)),
    ];
  }

  /****************************************************************************/
  /* FILTER                                                                   */
  /****************************************************************************/

  public function castString($var) : string {
    return (string) $var;
  }

  public function castInt($var) : int {
    return (int) $var;
  }

  public function castFloat($var) : float {
    return (float) $var;
  }

  public function castBool($var) : bool {
    return (bool) $var;
  }

  public function castArray($var) : array {
    return (array) $var;
  }

}

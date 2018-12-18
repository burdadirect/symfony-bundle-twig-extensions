<?php

namespace HBM\TwigExtensionsBundle\Twig;

class CastExtension extends \Twig_Extension {

  public function getFilters() : array {
    return [
      new \Twig_SimpleFilter('castInt', [$this, 'castInt']),
      new \Twig_SimpleFilter('castFloat', [$this, 'castFloat']),
      new \Twig_SimpleFilter('castBool', [$this, 'castBool']),
      new \Twig_SimpleFilter('castArray', [$this, 'castArray']),
      new \Twig_SimpleFilter('castString', [$this, 'castString']),
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

<?php

namespace HBM\TwigExtensionsBundle\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class ArrayExtension extends AbstractExtension {

  /****************************************************************************/
  /* DEFINITIONS                                                              */
  /****************************************************************************/

  public function getFilters() : array {
    return [
      new TwigFilter('hbmEnumeration', [$this, 'hbmEnumeration']),
    ];
  }

  /****************************************************************************/
  /* FILTERS                                                                  */
  /****************************************************************************/

  public function hbmEnumeration($vars, $sep = ', ', $sepLast = ' und ', $empty = '') : string {
    if (\count($vars) === 0) {
      return $empty;
    }

    $last = array_pop($vars);

    $string = implode($sep, $vars);
    if ($string && $last) {
      $string .= $sepLast;
    }
    if ($last) {
      $string .= $last;
    }

    return $string;
  }

}

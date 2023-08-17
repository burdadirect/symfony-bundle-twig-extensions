<?php

namespace HBM\TwigExtensionsBundle\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class DatetimeExtension extends AbstractExtension {

  /****************************************************************************/
  /* DEFINITIONS                                                              */
  /****************************************************************************/

  public function getFilters() : array {
    return [
      new TwigFilter('dateOrDefault', $this->getDateOrDefault(...)),
    ];
  }

  /****************************************************************************/
  /* FILTERS                                                                  */
  /****************************************************************************/

  public function getDateOrDefault($datetime, $format, $default = '') {
    if ($datetime instanceof \DateTime) {
      return $datetime->format($format);
    }

    return $default;
  }

}

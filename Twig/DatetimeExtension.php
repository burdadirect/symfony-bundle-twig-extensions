<?php

namespace HBM\TwigExtensionsBundle\Twig;

class DatetimeExtension extends \Twig_Extension
{

  public function getFilters() {
    return array(
      new \Twig_SimpleFilter('datetime_diff', array($this, 'getDatetimeDiff')),
      new \Twig_SimpleFilter('dateOrDefault', array($this, 'getDateOrDefault')),
    );
  }

  public function getName() {
    return 'hbm_twig_extensions_datetime';
  }

  /****************************************************************************/
  /* FILTERS                                                                  */
  /****************************************************************************/

  public function getDatetimeDiff($datetime, $format = '%dd %hh', $compareDatetime = NULL) {
    if (!$datetime instanceof \DateTime) {
      try {
        $datetime = new \DateTime($datetime);
      } catch(\Exception $e) {
        $datetime = new \DateTime('now');
      }

    }

    if ($compareDatetime === NULL) {
      $compareDatetime = new \DateTime('now');
    }

    $dateDiff = $datetime->diff($compareDatetime);

    return $dateDiff->format($format);
  }

  public function getDateOrDefault($datetime, $format, $default = '') {
    if ($datetime instanceof \DateTime) {
      return $datetime->format($format);
    }

    return $default;
  }

}

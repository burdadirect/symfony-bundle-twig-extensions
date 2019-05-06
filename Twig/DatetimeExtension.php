<?php

namespace HBM\TwigExtensionsBundle\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class DatetimeExtension extends AbstractExtension {

  public function getFilters() : array {
    return [
      new TwigFilter('datetime_diff', [$this, 'getDatetimeDiff']),
      new TwigFilter('dateOrDefault', [$this, 'getDateOrDefault']),
      new TwigFilter('strftimeOrDefault', [$this, 'getStrftimeOrDefault']),
    ];
  }

  /****************************************************************************/
  /* FILTERS                                                                  */
  /****************************************************************************/

  /**
   * Get datetime difference.
   *
   * @param $datetime
   * @param string $format
   * @param \DateTime|null $compareDatetime
   *
   * @return string
   *
   * @throws \Exception
   */
  public function getDatetimeDiff($datetime, $format = '%dd %hh', $compareDatetime = NULL) : string {
    if (!$datetime instanceof \DateTime) {
      try {
        $datetime = new \DateTime($datetime);
      } catch(\Exception $e) {
        $datetime = new \DateTime('now');
      }

    }

    if ($compareDatetime === NULL) {
      $compareDatetime = new \DateTime();
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

  public function getStrftimeOrDefault($datetime, $format, $default = '') {
    if ($datetime instanceof \DateTime) {
      return strftime($format, $datetime->getTimestamp());
    }

    return $default;
  }

}

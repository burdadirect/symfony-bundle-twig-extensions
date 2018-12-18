<?php

namespace HBM\TwigExtensionsBundle\Twig;

class DatetimeExtension extends \Twig_Extension {

  public function getFilters() : array {
    return array(
      new \Twig_SimpleFilter('datetime_diff', array($this, 'getDatetimeDiff')),
      new \Twig_SimpleFilter('dateOrDefault', array($this, 'getDateOrDefault')),
      new \Twig_SimpleFilter('strftimeOrDefault', array($this, 'getStrftimeOrDefault')),
    );
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

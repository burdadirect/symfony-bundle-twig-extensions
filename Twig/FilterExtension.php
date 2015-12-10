<?php

namespace HBM\TwigExtensionsBundle\Twig;

class FilterExtension extends \Twig_Extension
{

  public function getFilters() {
    return array(
      new \Twig_SimpleFilter('token', array($this, 'tokenFilter')),
      new \Twig_SimpleFilter('decimals', array($this, 'decimalsFilter')),
      new \Twig_SimpleFilter('bytes', array($this, 'bytesFilter')),
    );
  }

  public function getName() {
    return 'hbm_twig_extensions_filter';
  }

  /****************************************************************************/
  /* FILTER                                                                   */
  /****************************************************************************/

  public function tokenFilter($string, $sep = ' ') {
    $tokens = explode($sep, $string);

    return array_map('trim', $tokens);
  }

  public function bytesFilter($bytes, $sep = ' ', $decimals = 2, $dec_point = ',', $thousands_sep = '.') {
    $kilobyte = 1024;
    $megabyte = $kilobyte * 1024;
    $gigabyte = $megabyte * 1024;
    $terabyte = $gigabyte * 1024;

    if ($bytes < 0) {
      return '>2' . $sep . 'GB';
    }
    elseif ($bytes < $kilobyte) {
      return $bytes . $sep . 'B';
    }
    elseif ($bytes < $megabyte) {
      return number_format($bytes / $kilobyte, $decimals, $dec_point, $thousands_sep) . $sep . 'KB';
    }
    elseif ($bytes < $gigabyte) {
      return number_format($bytes / $megabyte, $decimals, $dec_point, $thousands_sep) . $sep . 'MB';
    }
    elseif ($bytes < $terabyte) {
      return number_format($bytes / $gigabyte, $decimals, $dec_point, $thousands_sep) . $sep . 'GB';
    }
    else {
      return number_format($bytes / $terabyte, $decimals, $dec_point, $thousands_sep) . $sep . 'TB';
    }
  }

  // Only returns the decimal places of a float.
  public function decimalsFilter($float, $digits = 2) {
    $whole = floor($float);
    $fraction = $float - $whole;
    $string = substr($fraction, 2, $digits);
    $nullsToAdd = $digits - strlen($string);
    for ($i = 0; $i < $nullsToAdd; $i++) {
      $string .= '0';
    }
    return $string;
  }

}

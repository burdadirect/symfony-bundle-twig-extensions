<?php

namespace HBM\TwigExtensionsBundle\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class FilterExtension extends AbstractExtension {

  public function getFilters() : array {
    return array(
      new TwigFilter('token', array($this, 'tokenFilter')),
      new TwigFilter('without', array($this, 'withoutFilter')),
      new TwigFilter('unique', array($this, 'uniqueFilter')),
      new TwigFilter('push', array($this, 'pushFilter')),
      new TwigFilter('pop', array($this, 'popFilter')),
      new TwigFilter('unshift', array($this, 'unshiftFilter')),
      new TwigFilter('shift', array($this, 'shiftFilter')),
      new TwigFilter('appendToKey', array($this, 'appendToKey')),
      new TwigFilter('cssClasses', array($this, 'cssClasses')),
      new TwigFilter('decimals', array($this, 'decimalsFilter')),
      new TwigFilter('bytes', array($this, 'bytesFilter')),
      new TwigFilter('link', array($this, 'link'), array('is_safe' => array('html'))),
      new TwigFilter('filterVar', array($this, 'filterVar')),
    );
  }

  /****************************************************************************/
  /* FILTER                                                                   */
  /****************************************************************************/

  public function filterVar($var, $filter, $options = NULL) {
    return filter_var($var, $filter, $options);
  }

  public function tokenFilter($string, $sep = ' ') {
    $tokens = explode($sep, $string);

    return array_map('trim', $tokens);
  }

  public function withoutFilter($var, $without = ' ') {
    if (is_string($var)) {
      $var = str_replace($without, '', $var);
    } elseif (is_array($var)) {
      $var = array_diff($var, [$without]);
    }

    return $var;
  }

  public function uniqueFilter($var) {
    if (is_array($var)) {
      $var = array_unique($var);
    }

    return $var;
  }

  public function pushFilter($var, $push) {
    if (is_array($var)) {
      $var[] = $push;
    }

    return $var;
  }

  public function popFilter($var) {
    if (is_array($var)) {
      return array_pop($var);
    }

    return $var;
  }

  public function unshiftFilter($var, $push) {
    if (is_array($var)) {
      array_unshift($var, $push);
    }

    return $var;
  }

  public function shiftFilter($var) {
    if (is_array($var)) {
      return array_shift($var);
    }

    return $var;
  }

  public function appendToKey($var, $key, $value) {
    if (!is_array($var)) {
      return $var;
    }

    if (!isset($var[$key])) {
      $var[$key] = '';
    }

    if (is_array($var[$key])) {
      $var[$key][] = $value;
    } else {
      $var[$key] .= $value;
    }

    return $var;
  }

  public function cssClasses($var) {
    return trim(preg_replace('!\s+!', ' ', $var));
  }

  public function bytesFilter($bytes, $sep = ' ', $decimals = 2, $dec_point = ',', $thousands_sep = '.') : string {
    $kilobyte = 1024;
    $megabyte = $kilobyte * 1024;
    $gigabyte = $megabyte * 1024;
    $terabyte = $gigabyte * 1024;

    if ($bytes < 0) {
      return '>2' . $sep . 'GB';
    }

    if ($bytes < $kilobyte) {
      return $bytes . $sep . 'B';
    }

    if ($bytes < $megabyte) {
      return number_format($bytes / $kilobyte, $decimals, $dec_point, $thousands_sep) . $sep . 'KB';
    }

    if ($bytes < $gigabyte) {
      return number_format($bytes / $megabyte, $decimals, $dec_point, $thousands_sep) . $sep . 'MB';
    }

    if ($bytes < $terabyte) {
      return number_format($bytes / $gigabyte, $decimals, $dec_point, $thousands_sep) . $sep . 'GB';
    }

    return number_format($bytes / $terabyte, $decimals, $dec_point, $thousands_sep) . $sep . 'TB';
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

  public function link($string, $text = '%s', $title = 'Link: %s') {
    $regex_url = "/(href=\"|>)?(\b(?:(?:https?|ftp|file|[A-Za-z]+):\/\/|www\.|ftp\.)(?:\([-A-Z0-9+&@#\/%=~_|$?!:,.]*\)|[-A-Z0-9+&@#\/%=~_|$?!:,.])*(?:\([-A-Z0-9+&@#\/%=~_|$?!:,.]*\)|[A-Z0-9+&@#\/%=~_|$]))(<\/a>)?/i";

    return preg_replace_callback($regex_url, function($matches) use ($text, $title) {
      if ((count($matches) === 4) && ($matches[1] === '>') && ($matches[3] === '</a>')) {
        return $matches[0];
      }

      if ((count($matches) === 3) && ($matches[1] === 'href="')) {
        return $matches[0];
      }

      return '<a href="'.$matches[0].'" target="_blank" title="'.sprintf($title, $matches[0]).'">'.sprintf($text, $matches[0]).'</a>';
    }, $string);
  }

}

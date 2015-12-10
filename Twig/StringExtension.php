<?php

namespace HBM\TwigExtensionsBundle\Twig;

class StringExtension extends \Twig_Extension
{

  public function getTests() {
    return [
      'prefixed' => new \Twig_SimpleTest('prefixed', array(
        $this,
        'isPrefixed'
      ))
    ];
  }

  public function getFunctions()
  {
      return array(
          new \Twig_SimpleFunction('uuid', array($this, 'getUuid')),
      );
  }

  public function getName() {
    return 'hbm_twig_extensions_string';
  }

  /****************************************************************************/
  /* FUNCTIONS                                                                */
  /****************************************************************************/

  public function getUuid($prefix = NULL, $more_entropy = FALSE) {
		return uniqid($prefix, $more_entropy);
  }

  /****************************************************************************/
  /* TESTS                                                                    */
  /****************************************************************************/

  /**
   * @param $var
   * @param $instance
   * @return bool
   */
  public function isPrefixed($var, $prefixes) {
    if (!is_array($prefixes)) {
      $prefixes = [$prefixes];
    }

    foreach ($prefixes as $prefix) {
      if (substr($var, 0, strlen($prefix)) === $prefix) {
        return TRUE;
      }
    }

    return FALSE;
  }

}

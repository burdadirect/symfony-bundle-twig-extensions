<?php

namespace HBM\TwigExtensionsBundle\Twig;

use HBM\TwigExtensionsBundle\Utils\Bootstrap\BootstrapDropdownItem;
use HBM\TwigExtensionsBundle\Utils\Bootstrap\BootstrapLink;

class BootstrapExtension extends \Twig_Extension {

  public function getTests() : array {
    return [
      'bsLink' => new \Twig_SimpleTest('bsLink', array($this, 'isBsLink')),
      'bsDropdownItem' => new \Twig_SimpleTest('bsDropdownItem', array($this, 'isBsDropdownItem')),
    ];
  }

  public function getFunctions() : array {
    return [
      new \Twig_SimpleFunction('bsLink', [$this, 'bsLink']),
      new \Twig_SimpleFunction('bsDropdownItem', [$this, 'bsDropdownItem']),
    ];
  }

  /****************************************************************************/
  /* FUNCTIONS                                                                */
  /****************************************************************************/

  /**
   * @param null|string $text
   * @return \HBM\TwigExtensionsBundle\Utils\Bootstrap\BootstrapLink
   */
  public function bsLink($text = NULL) : BootstrapLink {
    return new BootstrapLink($text);
  }

  /**
   * @param null|string $text
   * @return \HBM\TwigExtensionsBundle\Utils\Bootstrap\BootstrapDropdownItem
   */
  public function bsDropdownItem($text = NULL) : BootstrapDropdownItem {
    return new BootstrapDropdownItem($text);
  }

  /****************************************************************************/
  /* TESTS                                                                    */
  /****************************************************************************/

  /**
   * @param $var
   * @return bool
   */
  public function isBsLink($var) : bool {
    return $var instanceof BootstrapLink;
  }

  /**
   * @param $var
   * @return bool
   */
  public function isBsDropdownItem($var) : bool {
    return $var instanceof BootstrapDropdownItem;
  }

}

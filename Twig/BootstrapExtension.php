<?php

namespace HBM\TwigExtensionsBundle\Twig;

use HBM\TwigExtensionsBundle\Utils\Bootstrap\BootstrapDropdownItem;
use HBM\TwigExtensionsBundle\Utils\Bootstrap\BootstrapLink;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Twig\TwigTest;

class BootstrapExtension extends AbstractExtension {

  public function getTests() : array {
    return [
      'bsLink' => new TwigTest('bsLink', array($this, 'isBsLink')),
      'bsDropdownItem' => new TwigTest('bsDropdownItem', array($this, 'isBsDropdownItem')),
    ];
  }

  public function getFunctions() : array {
    return [
      new TwigFunction('bsLink', [$this, 'bsLink']),
      new TwigFunction('bsDropdownItem', [$this, 'bsDropdownItem']),
    ];
  }

  /****************************************************************************/
  /* FUNCTIONS                                                                */
  /****************************************************************************/

  /**
   * @param null|string $text
   * @return BootstrapLink
   */
  public function bsLink($text = NULL) : BootstrapLink {
    return new BootstrapLink($text);
  }

  /**
   * @param null|string $text
   * @return BootstrapDropdownItem
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

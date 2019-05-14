<?php

namespace HBM\TwigExtensionsBundle\Twig;

use HBM\TwigExtensionsBundle\Utils\Bootstrap\BootstrapDropdownItem;
use HBM\TwigExtensionsBundle\Utils\Bootstrap\BootstrapLink;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Twig\TwigTest;

class BootstrapExtension extends AbstractExtension {

  /**
   * @var array
   */
  protected $config;

  public function __construct($config) {
    $this->config = $config;
  }

  public function getTests() : array {
    return [
      'bsLink' => new TwigTest('bsLink', [$this, 'isBsLink']),
      'bsDropdownItem' => new TwigTest('bsDropdownItem', [$this, 'isBsDropdownItem']),
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
    return new BootstrapLink($text, $this->config);
  }

  /**
   * @param null|string $text
   * @return BootstrapDropdownItem
   */
  public function bsDropdownItem($text = NULL) : BootstrapDropdownItem {
    return new BootstrapDropdownItem($text, $this->config);
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

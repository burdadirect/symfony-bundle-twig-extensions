<?php

namespace HBM\TwigExtensionsBundle\Twig;

use HBM\TwigExtensionsBundle\Utils\HtmlAttributes;

class AttributesExtension extends \Twig_Extension {

  public function getTests() : array {
    return [
      'attributes' => new \Twig_SimpleTest('attributes', array($this, 'isAttributes')),
    ];
  }

  public function getFunctions() : array {
    return [
      new \Twig_SimpleFunction('attributes', [$this, 'attributes']),
    ];
  }

  public function getName() {
    return 'hbm_twig_extensions_attributes';
  }

  /****************************************************************************/
  /* FUNCTIONS                                                                */
  /****************************************************************************/

  /**
   * Create an html attribute object.
   *
   * @param array $attributes
   *
   * @return \HBM\TwigExtensionsBundle\Utils\HtmlAttributes
   */
  public function attributes(array $attributes = []) : HtmlAttributes {
    return new HtmlAttributes($attributes);
  }

  /****************************************************************************/
  /* TEXTS                                                                    */
  /****************************************************************************/

  /**
   * @param $var
   * @return bool
   */
  public function isAttributes($var) : bool {
    return $var instanceof HtmlAttributes;
  }

}

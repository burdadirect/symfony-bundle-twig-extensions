<?php

namespace HBM\TwigExtensionsBundle\Twig;

use HBM\TwigExtensionsBundle\Utils\HtmlAttributes;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Twig\TwigTest;

class AttributesExtension extends AbstractExtension {

  public function getTests() : array {
    return [
      'attributes' => new TwigTest('attributes', [$this, 'isAttributes']),
    ];
  }

  public function getFunctions() : array {
    return [
      new TwigFunction('attributes', [$this, 'attributes']),
    ];
  }

  /****************************************************************************/
  /* FUNCTIONS                                                                */
  /****************************************************************************/

  /**
   * Create an html attribute object.
   *
   * @param HtmlAttributes|array|null $attributes
   *
   * @return HtmlAttributes
   */
  public function attributes($attributes = NULL) : HtmlAttributes {
    return new HtmlAttributes($attributes);
  }

  /****************************************************************************/
  /* TESTS                                                                    */
  /****************************************************************************/

  /**
   * @param $var
   * @return bool
   */
  public function isAttributes($var) : bool {
    return $var instanceof HtmlAttributes;
  }

}

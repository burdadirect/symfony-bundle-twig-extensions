<?php

namespace HBM\TwigExtensionsBundle\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Twig\TwigTest;

class ObjectExtension extends AbstractExtension {

  public function getTests() : array {
    return [
      'instanceof' => new TwigTest('instanceof', [$this, 'isInstanceOf'])
    ];
  }

  public function getFunctions() : array {
    return [
      'classShort' => new TwigFunction('classShort', [$this, 'getClassShort']),
      'classFull' => new TwigFunction('classFull', [$this, 'getClassFull'])
    ];
  }

  /****************************************************************************/
  /* FUNCTIONS                                                                */
  /****************************************************************************/

  /**
   * @param $object
   *
   * @return string
   *
   * @throws \ReflectionException
   */
  public function getClassShort($object) : string {
    return (new \ReflectionClass($object))->getShortName();
  }

  /**
   * @param $object
   *
   * @return string
   *
   * @throws \ReflectionException
   */
  public function getClassFull($object) : string {
    return (new \ReflectionClass($object))->getName();
  }

  /****************************************************************************/
  /* TESTS                                                                    */
  /****************************************************************************/

  /**
   * @param $var
   * @param $instance
   * @return bool
   */
  public function isInstanceof($var, $instance) : bool {
    return $var instanceof $instance;
  }

}

<?php

namespace HBM\TwigExtensionsBundle\Twig;

class ObjectExtension extends \Twig_Extension {

  public function getTests() : array {
    return [
      'instanceof' => new \Twig_SimpleTest('instanceof', array(
        $this,
        'isInstanceOf'
      ))
    ];
  }

  public function getFunctions() : array {
    return [
      'classShort' => new \Twig_SimpleFunction('classShort', array(
        $this,
        'getClassShort'
      )),
      'classFull' => new \Twig_SimpleFunction('classFull', array(
        $this,
        'getClassFull'
      ))
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

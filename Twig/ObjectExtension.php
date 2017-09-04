<?php

namespace HBM\TwigExtensionsBundle\Twig;

class ObjectExtension extends \Twig_Extension
{

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

  public function getName() {
    return 'hbm_twig_extensions_object';
  }

  /****************************************************************************/
  /* FUNCTIONS                                                                */
  /****************************************************************************/

  public function getClassShort($object) {
    return (new \ReflectionClass($object))->getShortName();
  }

  public function getClassFull($object) {
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

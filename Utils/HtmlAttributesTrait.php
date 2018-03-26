<?php

namespace HBM\TwigExtensionsBundle\Utils;

trait HtmlAttributesTrait {

  public function getAttributesObject() {
    return $this;
  }

  public function class() {
    if (\func_num_args() === 0) {
      return $this->getAttributesObject()->getClasses();
    }

    if ((\func_num_args() === 2) && \is_bool(func_get_arg(1))) {
      if (func_get_arg(1) === TRUE) {
        $this->getAttributesObject()->addClasses(func_get_arg(0));
      }
    } else {
      foreach (\func_get_args() as $classes) {
        $this->getAttributesObject()->addClasses($classes);
      }
    }

    return $this;
  }

  public function href() {
    if (\func_num_args() === 0) {
      return $this->getAttributesObject()->get('href');
    }

    if (\func_num_args() === 1) {
      $this->getAttributesObject()->set('href', func_get_arg(0));
    } elseif (\func_num_args() === 2) {
      $this->getAttributesObject()->set('href', func_get_arg(0));
      $this->getAttributesObject()->set('target', func_get_arg(1));
    }

    return $this;
  }

  public function title() {
    if (\func_num_args() === 0) {
      return $this->getAttributesObject()->get('title');
    }

    $this->getAttributesObject()->set('title', func_get_arg(0));

    return $this;
  }

  public function target() {
    if (\func_num_args() === 0) {
      return $this->getAttributesObject()->get('target');
    }

    $this->getAttributesObject()->set('target', func_get_arg(0));

    return $this;
  }

  public function onclick() {
    if (\func_num_args() === 0) {
      return $this->getAttributesObject()->get('onclick');
    }

    $this->getAttributesObject()->set('onclick', func_get_arg(0));

    return $this;
  }

  public function id() {
    if (\func_num_args() === 0) {
      return $this->getAttributesObject()->get('id');
    }

    $this->getAttributesObject()->set('id', func_get_arg(0));

    return $this;
  }

  public function disabled() {
    if (\func_num_args() === 0) {
      return $this->getAttributesObject()->get('disabled');
    }

    $this->getAttributesObject()->set('disabled', func_get_arg(0));

    return $this;
  }

}

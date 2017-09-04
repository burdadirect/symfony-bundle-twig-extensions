<?php

namespace HBM\TwigExtensionsBundle\Utils;

class HtmlAttributes {

  private static $standalone = [
    'selected', 'checked', 'disabled', 'readonly', 'multiple',
    'noresize', 'compact', 'ismap', 'nowrap', 'declare', 'defer', 'noshade'
  ];

  /**
   * @var string[]
   */
  private $classes = [];

  /**
   * @var array
   */
  private $attributes = [];

  /**
   * HtmlAttributes constructor.
   *
   * @param array $attributes
   */
  public function __construct(array $attributes = []) {
    foreach ($attributes as $key => $value) {
      $this->set($key, $value);
    }
  }

  /**
   * Sets an html attribute.
   *
   * @param $key
   * @param $value
   *
   * @return self
   */
  public function set($key, $value) : self {
    if ($key === 'class') {
      $this->addClasses($value);
    } else {
      $this->attributes[$key] = $value;
    }

    return $this;
  }

  /**
   * Sets an html attribute.
   *
   * @param $key
   *
   * @return self
   */
  public function unset($key) : self {
    unset($this->attributes[$key]);

    return $this;
  }

  /**
   * Sets an html attribute if the value does not exist or is empty.
   *
   * @param $key
   * @param $value
   *
   * @return self
   */
  public function setIfEmpty($key, $value) : self {
    if (!$this->get($key)) {
      return $this->set($key, $value);
    }

    return $this;
  }

  /**
   * Gets an html attribute.
   *
   * @param $key
   *
   * @return mixed|null|\string[]
   */
  public function get($key) {
    if ($key === 'class') {
      return $this->classes;
    }

    return $this->attributes[$key] ?? NULL;
  }

  public function addClass($class) : self {
    $this->classes[] = trim($class);
    $this->classes = array_unique($this->classes);

    return $this;
  }

  public function addClasses($classes) : self {
    if (!is_array($classes)) {
      $classes = explode(' ', $classes);
    }

    $classes = array_map('trim', $classes);
    $classes = array_merge($this->classes, $classes);
    $classes = array_unique($classes);

    $this->classes = $classes;

    return $this;
  }

  public function __toString() {
    try {
      $attributes = [];
      if (count($this->classes) > 0) {
        $attributes[] = 'class="'.implode(' ', $this->classes).'"';
      }

      foreach ($this->attributes as $key => $value) {
        if (in_array($key, self::$standalone, TRUE)) {
          if ($value) {
            $attributes[] = $key.'="'.$key.'"';
          }
        } else {
          $attributes[] = $key.'="'.htmlentities($value, ENT_COMPAT).'"';
        }
      }

      return implode(' ', $attributes);
    } catch (\Exception $e) {
      return 'data-exception="'.htmlentities(json_encode($this->attributes), ENT_COMPAT).'"';
    }
  }

}

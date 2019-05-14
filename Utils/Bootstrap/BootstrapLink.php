<?php

namespace HBM\TwigExtensionsBundle\Utils\Bootstrap;

use HBM\TwigExtensionsBundle\Utils\HtmlAttributes;
use HBM\TwigExtensionsBundle\Utils\HtmlAttributesTrait;

class BootstrapLink {

  use HtmlAttributesTrait;

  /**
   * @var array
   */
  protected $config;

  /**
   * @var string[]
   */
  private $icons = [];

  /**
   * @var string
   */
  private $text;

  /**
   * @var HtmlAttributes
   */
  private $attributes;

  public function __construct($text = NULL, array $config = []) {
    var_dump($config);
    $this->config = $config;
    $this->text = $text;
    $this->attributes = new HtmlAttributes();
  }

  /**
   * Returns a copy of the bootstrap link.
   *
   * @return BootstrapLink
   */
  public function copy() : self {
    $copy = new BootstrapLink();
    $copy->setIcons($this->getIcons());
    $copy->setText($this->getText());
    $copy->setAttributes($this->getAttributes()->copy());

    return $copy;
  }

  /****************************************************************************/

  public function icon() {
    return $this->icons(...func_get_args());
  }

  public function icons() {
    if (func_num_args() === 0) {
      return $this->getIcons();
    }

    $this->addIcons(...func_get_args());

    return $this;
  }

  public function addIcon($icons) : self {
    return $this->addIcons($icons);
  }

  public function addIcons($icons) : self {
    if (!is_array($icons)) {
      $icons = [$icons];
    }

    foreach ($icons as $icon) {
      $iconParts = explode(' ', $icon);
      if (count(array_intersect($iconParts, ['fa', 'fas', 'far', 'fal', 'fab'])) === 0) {
        $iconParts[] = $this->config['fontawesome']['default_class'] ?? 'fas';
      }
      $this->icons[] = implode(' ', $iconParts);
    }

    return $this;
  }

  public function setIcons($icons) : self {
    if ($icons === NULL) {
      $this->icons = [];
    } else {
      if (!is_array($icons)) {
        $icons = [$icons];
      }
      $this->icons = $icons;
    }

    return $this;
  }

  public function getIcon() : array {
    return $this->icons;
  }

  public function getIcons() : array {
    return $this->icons;
  }

  /****************************************************************************/

  public function text() {
    if (func_num_args() === 0) {
      return $this->getText();
    }

    foreach (func_get_args() as $text) {
      $this->addText($text);
    }

    return $this;
  }

  public function addText($text) : self {
    $this->text .= $text;

    return $this;
  }

  public function setText($text) : self {
    $this->text = $text;

    return $this;
  }

  public function getText() : ?string {
    return $this->text;
  }

  /****************************************************************************/

  public function attr($key, $value) {
    $this->getAttributes()->set($key, $value);

    return $this;
  }

  public function attributes() {
    if (func_num_args() === 0) {
      return $this->attributes;
    }

    if (func_num_args() === 1) {
      $this->setAttributes(new HtmlAttributes(func_get_arg(0)));
    }

    return $this;
  }

  public function setAttributes(HtmlAttributes $attributes) : self {
    $this->attributes = $attributes;

    return $this;
  }

  public function getAttributes() : HtmlAttributes {
    return $this->attributes;
  }

  public function getAttributesObject() : HtmlAttributes {
    return $this->attributes;
  }

}

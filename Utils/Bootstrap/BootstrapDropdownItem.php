<?php

namespace HBM\TwigExtensionsBundle\Utils\Bootstrap;

use HBM\TwigExtensionsBundle\Utils\HtmlAttributes;

class BootstrapDropdownItem extends BootstrapLink {

  /**
   * @var bool
   */
  private $divider;

  /**
   * @var string
   */
  private $header;

  public function apply(BootstrapLink $bsLink) {
    $this->setIcons($bsLink->getIcons());
    $this->setText($bsLink->getText());
    $this->setAttributes(new HtmlAttributes($bsLink->getAttributes()));

    return $this;
  }

  /****************************************************************************/

  public function divider() {
    if (\func_num_args() === 0) {
      return $this->divider;
    }

    $this->divider = (bool) func_get_arg(0);

    return $this;
  }

  public function header() {
    if (\func_num_args() === 0) {
      return $this->header;
    }

    $this->header = (string) func_get_arg(0);

    return $this;
  }

}

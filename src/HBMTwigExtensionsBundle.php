<?php

namespace HBM\TwigExtensionsBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class HBMTwigExtensionsBundle extends Bundle {

  public function getPath(): string {
    return \dirname(__DIR__);
  }

}

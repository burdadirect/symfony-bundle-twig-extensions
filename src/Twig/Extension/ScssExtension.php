<?php

namespace HBM\TwigExtensionsBundle\Twig\Extension;

use ScssPhp\ScssPhp\Compiler;
use ScssPhp\ScssPhp\Exception\SassException;
use ScssPhp\ScssPhp\OutputStyle;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class ScssExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
          new TwigFilter('hbmScss', $this->hbmScss(...)),
        ];
    }

    /* FILTER */

    public function hbmScss(string $scss): string
    {
        $compiler = new Compiler();
        $compiler->setOutputStyle(OutputStyle::EXPANDED);

        try {
            return $compiler->compileString($scss)->getCss();
        } catch (SassException $e) {
            return '/* ' . $e->getMessage() . ' */';
        }
    }
}

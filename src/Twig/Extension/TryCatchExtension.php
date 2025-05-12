<?php

namespace HBM\TwigExtensionsBundle\Twig\Extension;

use HBM\TwigExtensionsBundle\Twig\TokenParser\TryCatchTokenParser;
use Twig\Extension\AbstractExtension;

class TryCatchExtension extends AbstractExtension
{
    public function getTokenParsers(): array
    {
        return [
            new TryCatchTokenParser(),
        ];
    }
}

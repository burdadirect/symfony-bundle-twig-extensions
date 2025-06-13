<?php

namespace HBM\TwigExtensionsBundle\Twig\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigTest;

class TestExtension extends AbstractExtension
{
    public function getTests(): array
    {
        return [
          'array'   => new TwigTest('array',   $this->isArray(...)),
          'bool'    => new TwigTest('bool',    $this->isBool(...)),
          'float'   => new TwigTest('float',   $this->isFloat(...)),
          'int'     => new TwigTest('int',     $this->isInteger(...)),
          'integer' => new TwigTest('integer', $this->isInteger(...)),
          'numeric' => new TwigTest('numeric', $this->isNumeric(...)),
        ];
    }

    public function isArray($var): bool
    {
        return is_array($var);
    }

    public function isBool($var): bool
    {
        return is_bool($var);
    }

    public function isFloat($var): bool
    {
        return is_float($var);
    }

    public function isInteger($var): bool
    {
        return is_int($var);
    }

    public function isNumeric($var): bool
    {
        return is_numeric($var);
    }
}

<?php

namespace HBM\TwigExtensionsBundle\Twig\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Twig\TwigTest;

class ObjectExtension extends AbstractExtension
{
    /* DEFINITIONS */

    public function getTests(): array
    {
        return [
          'instanceof' => new TwigTest('instanceof', $this->isInstanceof(...)),
        ];
    }

    public function getFunctions(): array
    {
        return [
          'classShort' => new TwigFunction('classShort', $this->getClassShort(...)),
          'classFull'  => new TwigFunction('classFull', $this->getClassFull(...)),
        ];
    }

    /* FUNCTIONS */

    /**
     * @throws \ReflectionException
     */
    public function getClassShort($object): string
    {
        return (new \ReflectionClass($object))->getShortName();
    }

    /**
     * @throws \ReflectionException
     */
    public function getClassFull($object): string
    {
        return (new \ReflectionClass($object))->getName();
    }

    /* TESTS */

    public function isInstanceof($var, $instance): bool
    {
        return $var instanceof $instance;
    }
}

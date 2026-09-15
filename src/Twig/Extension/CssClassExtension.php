<?php

namespace HBM\TwigExtensionsBundle\Twig\Extension;

use Random\RandomException;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;
use Twig\TwigTest;

class CssClassExtension extends AbstractExtension
{

    public function getFilters(): array
    {
        return [
          new TwigFilter('cssClass', $this->cssClass(...)),
        ];
    }

    public function getFunctions(): array
    {
        return [
          new TwigFunction('cssClass', $this->cssClass(...)),
        ];
    }

    public static function cssClass(string|array|null $classesExisting, string|array|callable|null $classesNew): string
    {
        if ($classesExisting === null) {
            $classesExisting = [];
        } elseif (is_string($classesExisting)) {
            $classesExisting = array_map('trim', explode(' ', $classesExisting));
        }

        if (is_callable($classesNew)) {
            $args = func_get_args();
            $args = array_slice($args, 2);
            $classesNew = $classesNew(...$args);
        }
        if ($classesNew === null) {
            $classesNew = [];
        } elseif (is_string($classesNew)) {
            $classesNew = array_map('trim', explode(' ', $classesNew));
        }

        $classesReplace = [];
        $classesRemove = [];
        foreach ($classesNew as $class) {
            if (str_starts_with($class, '-')) {
                $classesRemove[] = substr($class, 1);
            } elseif (str_starts_with($class, '+')) {
                $classesExisting[] = substr($class, 1);
            } else {
                $classesReplace[] = $class;
            }
        }

        if (count($classesReplace) > 0) {
            return implode(' ', $classesReplace);
        }

        return implode(' ', array_unique(array_diff($classesExisting, $classesRemove)));
    }
}

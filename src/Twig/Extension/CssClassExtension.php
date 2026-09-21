<?php

namespace HBM\TwigExtensionsBundle\Twig\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class CssClassExtension extends AbstractExtension
{
    /* DEFINITIONS */

    public function getFilters(): array
    {
        return [
            new TwigFilter('hbmCssClass', $this->hbmCssClass(...)),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('hbmCssClass', $this->hbmCssClass(...)),
        ];
    }

    /* FILTERS & FUNCTIONS */

    public static function hbmCssClass(string|array|null $classesExisting, string|array|callable|null $classesNew): string
    {
        if ($classesExisting === null) {
            $classesExisting = [];
        } elseif (is_string($classesExisting)) {
            $classesExisting = array_map('trim', explode(' ', $classesExisting));
        }

        if (is_callable($classesNew)) {
            $args       = func_get_args();
            $args       = array_slice($args, 2);
            $classesNew = $classesNew(...$args);
        }

        if (($classesNew === null) || ($classesNew === '')) {
            $classesNew = [];
        } elseif (is_string($classesNew)) {
            $classesNew = trim(preg_replace('/\s+/', ' ', $classesNew));
            $classesNew = explode(' ', $classesNew);
        }

        $classesReplace = [];
        $classesRemove  = [];
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

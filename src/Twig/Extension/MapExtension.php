<?php

namespace HBM\TwigExtensionsBundle\Twig\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class MapExtension extends AbstractExtension
{
    /* DEFINITIONS */

    public function getFilters(): array
    {
        return [
            new TwigFilter('mapAdd', $this->mapAdd(...)),
            new TwigFilter('mapRemove', $this->mapRemove(...)),
        ];
    }

    public function getTests(): array
    {
        return [
            new TwigFunction('mapContainsKey', $this->mapContainsKey(...)),
            new TwigFunction('mapContainsValue', $this->mapContainsValue(...)),
        ];
    }

    /* FILTERS */

    public function mapAdd(array $map, string|int $key, mixed $value): array
    {
        $map[$key] = $value;

        return $map;
    }

    public function mapRemove(array $map, string|int|array $keys): array
    {
        $keys = !is_array($keys) ? [$keys] : $keys;

        foreach ($keys as $key) {
            unset($map[$key]);
        }

        return $map;
    }

    /* FUNCTIONS */

    public function mapContainsKey(array $map, string|int $key): bool
    {
        return array_key_exists($key, $map);
    }

    public function mapContainsValue(array $map, mixed $value, bool $strict = false): bool
    {
        return in_array($map, $value, $strict);
    }
}

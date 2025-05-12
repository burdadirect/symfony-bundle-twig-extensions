<?php

namespace HBM\TwigExtensionsBundle\Twig\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class DatetimeExtension extends AbstractExtension
{
    /* DEFINITIONS */

    public function getFilters(): array
    {
        return [
          new TwigFilter('dateOrDefault', $this->getDateOrDefault(...)),
          new TwigFilter('dateIntervalParts', $this->dateIntervalParts(...)),
        ];
    }

    /* FILTERS */

    public function getDateOrDefault($datetime, $format, $default = '')
    {
        if ($datetime instanceof \DateTime) {
            return $datetime->format($format);
        }

        return $default;
    }

    public static function dateIntervalParts(\DateInterval $interval, array $suffixes = [
      'd' => ['p' => ' Tage',     's' => ' Tag'],
      'h' => ['p' => ' Stunden',  's' => ' Stunde'],
      'm' => ['p' => ' Minuten',  's' => ' Minute'],
      's' => ['p' => ' Sekunden', 's' => ' Sekunde'],
    ]): array
    {
        $intervalParts = [];
        if ($days = $interval->format('%a')) {
              $intervalParts['d'] = $days.($suffixes['d'][($days > 1) ? 'p' : 's'] ?? $suffixes['d'] ?? '');
            }
        if ($hours = $interval->format('%h')) {
            $intervalParts['h'] = $hours.($suffixes['h'][($hours > 1) ? 'p' : 's'] ?? $suffixes['h'] ?? '');
        }
        if ($minutes = $interval->format('%i')) {
            $intervalParts['m'] = $minutes.($suffixes['m'][($minutes > 1) ? 'p' : 's'] ?? $suffixes['m'] ?? '');
        }
        if ($seconds = $interval->format('%s')) {
            $intervalParts['s'] = $seconds.($suffixes['s'][($seconds > 1) ? 'p' : 's'] ?? $suffixes['s'] ?? '');
        }

        return $intervalParts;
    }

}

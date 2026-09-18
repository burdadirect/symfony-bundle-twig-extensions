<?php

namespace HBM\TwigExtensionsBundle\Twig\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class MatchesFormatterExtension extends AbstractExtension
{
    /* DEFINITIONS */

    public function getFilters(): array
    {
        return [
            new TwigFilter('hbmFormatMatches', self::apply(...), ['is_safe' => ['html']]),
        ];
    }

    /* FILTERS */

    public static function apply(?string $text, string|array|null $searchTerms, string $format = '<b>%s</b>'): ?string
    {
        if (($text === null) || ($searchTerms === null) || (is_array($searchTerms) && (count($searchTerms) === 0))) {
            return $text;
        }

        if (!is_array($searchTerms)) {
            $searchTerms = [$searchTerms];
        }

        $intervals = [];
        foreach ($searchTerms as $searchTerm) {
            if ($searchTerm === null) {
                continue;
            }
            $matchStr = (string) $searchTerm;

            if ($matchStr === '') {
                continue;
            }
            $matchLen = mb_strlen($matchStr);
            $offset   = 0;
            while (($pos = mb_stripos($text, $matchStr, $offset)) !== false) {
                $intervals[] = [$pos, $pos + $matchLen];
                $offset      = $pos + 1;
            }
        }

        if (count($intervals) === 0) {
            return $text;
        }

        usort($intervals, static function (array $a, array $b): int {
            return ($a[0] <=> $b[0]) ?: ($b[1] <=> $a[1]);
        });

        $merged = [];
        foreach ($intervals as $interval) {
            if (empty($merged)) {
                $merged[] = $interval;

                continue;
            }
            $lastIndex             = count($merged) - 1;
            [$lastStart, $lastEnd] = $merged[$lastIndex];
            [$currStart, $currEnd] = $interval;

            if ($currStart <= $lastEnd) {
                $merged[$lastIndex][1] = max($lastEnd, $currEnd);
            } else {
                $merged[] = $interval;
            }
        }

        $result = '';
        $cursor = 0;
        foreach ($merged as [$start, $end]) {
            if ($start > $cursor) {
                $result .= mb_substr($text, $cursor, $start - $cursor);
            }
            $result .= sprintf($format, mb_substr($text, $start, $end - $start));
            $cursor = $end;
        }

        $textLen = mb_strlen($text);

        if ($cursor < $textLen) {
            $result .= mb_substr($text, $cursor);
        }

        return $result;
    }
}

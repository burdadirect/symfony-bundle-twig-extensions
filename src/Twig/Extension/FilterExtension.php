<?php

namespace HBM\TwigExtensionsBundle\Twig\Extension;

use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class FilterExtension extends AbstractExtension
{
    /* DEFINITIONS */

    public function getFilters(): array
    {
        return [
          new TwigFilter('token', $this->tokenFilter(...)),
          new TwigFilter('without', $this->withoutFilter(...)),
          new TwigFilter('unique', $this->uniqueFilter(...)),
          new TwigFilter('push', $this->pushFilter(...)),
          new TwigFilter('pop', $this->popFilter(...)),
          new TwigFilter('unshift', $this->unshiftFilter(...)),
          new TwigFilter('shift', $this->shiftFilter(...)),
          new TwigFilter('appendToKey', $this->appendToKey(...)),
          new TwigFilter('cssClasses', $this->cssClasses(...)),
          new TwigFilter('decimals', $this->decimalsFilter(...)),
          new TwigFilter('bytes', $this->bytesFilter(...)),
          new TwigFilter('bytesOrDefault', $this->bytesOrDefault(...)),
          new TwigFilter('link', $this->link(...), ['is_safe' => ['html']]),
          new TwigFilter('filterVar', $this->filterVar(...)),
          new TwigFilter('applyFilters', $this->appyFilters(...), ['needs_environment' => true, 'is_safe' => ['html']]),
          new TwigFilter('spacelessCustom', $this->spacelessCustom(...), ['is_safe' => ['html']]),
        ];
    }

    /* FILTER */

    public function filterVar($var, $filter, $options = null)
    {
        return filter_var($var, $filter, $options);
    }

    public function tokenFilter($string, $sep = ' ')
    {
        $tokens = explode($sep, $string);

        return array_map('trim', $tokens);
    }

    public function withoutFilter($var, $without = ' ')
    {
        if (is_string($var)) {
            $var = str_replace($without, '', $var);
        } elseif (is_array($var)) {
            $var = array_diff($var, [$without]);
        }

        return $var;
    }

    public function uniqueFilter($var)
    {
        if (is_array($var)) {
            $var = array_unique($var);
        }

        return $var;
    }

    public function pushFilter($var, $push)
    {
        if (is_array($var)) {
            $var[] = $push;
        }

        return $var;
    }

    public function popFilter($var)
    {
        if (is_array($var)) {
            return array_pop($var);
        }

        return $var;
    }

    public function unshiftFilter($var, $push)
    {
        if (is_array($var)) {
            array_unshift($var, $push);
        }

        return $var;
    }

    public function shiftFilter($var)
    {
        if (is_array($var)) {
            return array_shift($var);
        }

        return $var;
    }

    public function appendToKey($var, $key, $value)
    {
        if (!is_array($var)) {
            return $var;
        }

        if (!isset($var[$key])) {
            $var[$key] = '';
        }

        if (is_array($var[$key])) {
            $var[$key][] = $value;
        } else {
            $var[$key] .= $value;
        }

        return $var;
    }

    public function cssClasses($var)
    {
        return trim(preg_replace('!\s+!', ' ', $var));
    }

    public function bytesOrDefault(mixed $bytes, mixed $default = null, string $sep = ' ', int $decimals = 2, ?string $decimal_separator = ',', ?string $thousands_separator = '.')
    {
        if (is_numeric($bytes)) {
            return self::bytesFilter($bytes, $sep, $decimals, $decimal_separator, $thousands_separator);
        }

        return $default;
    }

    public static function bytesFilter(mixed $bytes, string $sep = ' ', int $decimals = 2, ?string $decimal_separator = ',', ?string $thousands_separator = '.'): string
    {
        $size   = ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
        $factor = floor((strlen($bytes) - 1) / 3);

        $bytesToUse = $bytes / (1024 ** $factor);

        return number_format($bytesToUse, $decimals, $decimal_separator, $thousands_separator) . $sep . ($size[$factor] ?? '');
    }

    // Only returns the decimal places of a float.
    public function decimalsFilter($float, $digits = 2)
    {
        $whole      = floor($float);
        $fraction   = $float - $whole;
        $string     = substr($fraction, 2, $digits);
        $nullsToAdd = $digits - strlen($string);
        for ($i = 0; $i < $nullsToAdd; ++$i) {
            $string .= '0';
        }

        return $string;
    }

    public function link($string, $text = '%s', $title = 'Link: %s')
    {
        $regex_url = "/(href=\"|>)?(\b(?:(?:https?|ftp|file|[A-Za-z]+):\/\/|www\.|ftp\.)(?:\([-A-Z0-9+&@#\/%=~_|$?!:,.]*\)|[-A-Z0-9+&@#\/%=~_|$?!:,.])*(?:\([-A-Z0-9+&@#\/%=~_|$?!:,.]*\)|[A-Z0-9+&@#\/%=~_|$]))(<\/a>)?/i";

        return preg_replace_callback($regex_url, function ($matches) use ($text, $title) {
            if ((count($matches) === 4) && ($matches[1] === '>') && ($matches[3] === '</a>')) {
                return $matches[0];
            }

            if ((count($matches) === 3) && ($matches[1] === 'href="')) {
                return $matches[0];
            }

            return '<a href="' . $matches[0] . '" target="_blank" title="' . sprintf($title, $matches[0]) . '">' . sprintf($text, $matches[0]) . '</a>';
        }, $string);
    }

    /**
     * @param array|string $filters
     *
     * @return string
     */
    public function appyFilters(Environment $environment, $var, $filters = [])
    {
        if (is_string($filters)) {
            $filters = [$filters];
        }

        if (count($filters) > 0) {
            $templateParamsArrays   = [];
            $templateParamsArrays[] = ['var' => $var];

            $templateString = 'var';
            foreach ($filters as $filterIndex => $filterData) {
                // Determine filter name and params.
                if (is_array($filterData)) {
                    $filterName   = $filterData[0] ?? null;
                    $filterParams = $filterData[1] ?? [];
                } else {
                    $filterName   = $filterData;
                    $filterParams = [];
                }

                // Generate filter params string if necessary.
                $filterParamsString = '';

                if (count($filterParams) > 0) {
                    $namedFilterParams = [];
                    foreach ($filterParams as $filterParamIndex => $filterParamValue) {
                        $namedFilterParams['filter_param_' . $filterIndex . '_' . $filterParamIndex] = $filterParamValue;
                    }
                    $templateParamsArrays[] = $namedFilterParams;

                    $filterParamsString = '(' . implode(', ', array_keys($namedFilterParams)) . ')';
                }

                // Apply filter to variable (or preceding filters).
                $templateString .= '|' . $filterName . $filterParamsString;
            }

            $template = $environment->createTemplate('{{ ' . $templateString . ' }}');

            return $template->render(array_merge(...$templateParamsArrays));
        }

        return $var;
    }

    public function spacelessCustom($content): string
    {
        return trim(preg_replace('/>\s+</', '><', $content ?? ''));
    }
}

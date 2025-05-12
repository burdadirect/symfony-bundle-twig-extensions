<?php

namespace HBM\TwigExtensionsBundle\Twig\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class FileInfoExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
          new TwigFilter('hbmBasename', $this->hbmBasename(...)),
          new TwigFilter('hbmDirname', $this->hbmDirname(...)),
        ];
    }

    public function hbmBasename(string $filename): string
    {
        return basename($filename);
    }

    public function hbmDirname(string $filename): string
    {
        return dirname($filename);
    }
}

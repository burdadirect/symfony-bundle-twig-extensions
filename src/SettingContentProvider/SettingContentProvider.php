<?php

namespace HBM\TwigExtensionsBundle\SettingContentProvider;

class SettingContentProvider implements SettingContentProviderInterface
{
    public function getVarValueParsed(string $key, string $nature = null, $default = null, $orderBy = null): string
    {
        return '';
    }
}

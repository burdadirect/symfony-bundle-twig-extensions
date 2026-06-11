<?php

namespace HBM\TwigExtensionsBundle\SettingContentProvider;

class SettingContentProvider implements SettingContentProviderInterface
{
    public function getVarValueParsed(string $key, ?string $nature = null, mixed $default = null, ?array $orderBy = null): string
    {
        return '';
    }
}

<?php

namespace HBM\TwigExtensionsBundle\SettingContentProvider;

interface SettingContentProviderInterface
{
    public function getVarValueParsed(string $key, ?string $nature = null, mixed $default = null, ?array $orderBy = null): mixed;
}

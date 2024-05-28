<?php

namespace HBM\TwigExtensionsBundle\SettingContentProvider;

interface SettingContentProviderInterface
{
    public function getVarValueParsed(string $key, string $nature = null, $default = null, $orderBy = null): mixed;
}

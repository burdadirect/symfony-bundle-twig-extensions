<?php

namespace HBM\TwigExtensionsBundle\Interfaces;

interface SettingContentProviderInterface
{
    public function getVarValueParsed(string $key, string $nature = null, $default = null, $orderBy = null);
}

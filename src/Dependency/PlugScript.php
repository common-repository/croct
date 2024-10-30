<?php

namespace Croct\WordPress\Dependency;

use Croct\WordPress\ExternalDependency;

final class PlugScript implements ExternalDependency
{
    const HANDLE = 'croct-plug';

    public function getHandle()
    {
        return self::HANDLE;
    }

    public function getVersion()
    {
        return self::VERSION_NONE;
    }

    public function getType()
    {
        return self::TYPE_SCRIPT;
    }

    public function getDependencies()
    {
        return [];
    }

    public function getSourceUri()
    {
        return 'https://cdn.croct.io/js/v1/lib/plug.js';
    }
}

<?php

namespace Croct\WordPress\Dependency;

use Croct\WordPress\ExternalDependency;

final class TagifyScript implements ExternalDependency
{
    const HANDLE = 'tagify';

    /** @var string */
    private $baseUrl;

    /**
     * @param string $baseUrl
     */
    public function __construct($baseUrl)
    {
        $this->baseUrl = \rtrim($baseUrl, '/');
    }

    public function getType()
    {
        return self::TYPE_SCRIPT;
    }

    public function getVersion()
    {
        return self::VERSION_WORDPRESS;
    }

    public function getHandle()
    {
        return self::HANDLE;
    }

    public function getDependencies()
    {
        return [];
    }

    public function getSourceUri()
    {
        return \sprintf('%s/static/js/tagify.min.js', $this->baseUrl);
    }
}

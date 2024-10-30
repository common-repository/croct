<?php

namespace Croct\WordPress;

interface ExternalDependency extends Dependency
{
    const VERSION_NONE = 'none';

    const VERSION_WORDPRESS = 'wp';

    /**
     * @return string
     */
    public function getHandle();

    /**
     * @return array<string>
     */
    public function getDependencies();

    /**
     * @return string
     */
    public function getSourceUri();

    /**
     * @return string
     */
    public function getVersion();
}

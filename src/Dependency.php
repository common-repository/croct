<?php

namespace Croct\WordPress;

interface Dependency
{
    const TYPE_SCRIPT = 'script';

    const TYPE_STYLE = 'style';

    /**
     * Returns the code type;
     *
     * @return string
     *
     * @see Dependency::TYPE_SCRIPT
     * @see Dependency::TYPE_STYLE
     */
    public function getType();
}

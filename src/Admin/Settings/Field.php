<?php

namespace Croct\WordPress\Admin\Settings;

interface Field
{
    /**
     * @param string $value
     *
     * @return string
     */
    public function render($value);
}

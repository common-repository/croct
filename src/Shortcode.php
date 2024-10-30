<?php

namespace Croct\WordPress;

interface Shortcode
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @param array<mixed> $attributes
     * @param string|null  $content
     *
     * @return string
     */
    public function render(array $attributes, $content = null);
}

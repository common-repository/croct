<?php

namespace Croct\WordPress\Shortcode;

use Croct\WordPress\Shortcode;

final class IfShortcode implements Shortcode
{
    /**
     * Whether the shortcode is enabled.
     *
     * @var bool
     */
    private $enabled;

    /**
     * @param bool $enabled
     */
    public function __construct($enabled)
    {
        $this->enabled = $enabled;
    }

    public function getName()
    {
        return 'if';
    }

    public function render(array $attributes, $content = null)
    {
        if (!$this->enabled) {
            return '';
        }

        $attributes = \shortcode_atts(['condition' => ''], $attributes);

        if ($attributes['condition'] === '') {
            return (string) $content;
        }

        return \sprintf(
            '<span data-croct-condition="%s" data-croct-content="%s"></span>',
            \esc_attr($attributes['condition']),
            \esc_attr((string) $content)
        );
    }
}

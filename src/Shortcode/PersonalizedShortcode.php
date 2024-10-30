<?php

namespace Croct\WordPress\Shortcode;

use Croct\WordPress\Shortcode;

final class PersonalizedShortcode implements Shortcode
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
        return 'personalized';
    }

    public function render(array $attributes, $content = null)
    {
        if (!$this->enabled) {
            return (string) $content;
        }

        $attributes = \shortcode_atts(['value' => ''], $attributes);

        if ($attributes['value'] === '') {
            return (string) $content;
        }

        return \sprintf(
            '<span data-croct-value="%s">%s</span>',
            \esc_attr($attributes['value']),
            $content
        );
    }
}

<?php

namespace Croct\WordPress\Admin\Settings;

final class TextField implements Field
{
    /** @var string */
    private $id;

    /** @var string */
    private $name;

    /** @var string */
    private $type;

    /** @var string|null */
    private $help;

    /**
     * @param array{id: string, name: string, type: string, help?: string} $options
     */
    public function __construct(array $options)
    {
        $this->id = $options['id'];
        $this->name = $options['name'];
        $this->type = $options['type'];
        $this->help = isset($options['help']) ? $options['help'] : null;
    }

    public function render($value)
    {
        $output = \strtr(
            '<input class="regular-text" type="{type}" id="{id}" name="{name}" value="{value}" />',
            [
                '{type}' => $this->type,
                '{id}' => $this->id,
                '{name}' => $this->name,
                '{value}' => \esc_attr($value),
            ]
        );

        if ($this->help !== null) {
            $output .= \sprintf(
                '<p class="description">%s</p>',
                \__($this->help, 'croct')
            );
        }

        return $output;
    }
}

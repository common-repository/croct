<?php

namespace Croct\WordPress\Admin\Settings;

final class SelectField implements Field
{
    /** @var string */
    private $id;

    /** @var string */
    private $name;

    /** @var array<array<mixed>> */
    private $options;

    /** @var string|null */
    private $help;

    /**
     * @param array{id: string, name: string, options: array<mixed>, help?: string} $options
     */
    public function __construct(array $options)
    {
        $this->id = $options['id'];
        $this->name = $options['name'];
        $this->options = $options['options'];
        $this->help = isset($options['help']) ? $options['help'] : null;
    }

    public function render($value)
    {
        $output = \strtr(
            '<select id="{id}" name="{name}">',
            [
                '{id}' => $this->id,
                '{name}' => $this->name,
            ]
        );

        foreach ($this->options as $option) {
            $output .= \strtr(
                '<option value="{value}" {selected}>{label}</option>',
                [
                    '{value}' => $option['value'],
                    '{label}' => $option['label'],
                    '{selected}' => $option['value'] === $value ? 'selected' : '',
                ]
            );
        }

        $output .= '</select>';

        if ($this->help !== null) {
            $output .= \sprintf(
                '<p class="description">%s</p>',
                \__($this->help, 'croct')
            );
        }

        return $output;
    }
}

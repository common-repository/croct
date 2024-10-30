<?php

namespace Croct\WordPress\Admin\Settings;

final class CheckboxField implements Field
{
    /** @var string */
    private $id;

    /** @var string */
    private $name;

    /** @var string */
    private $value;

    /** @var string */
    private $label;

    /** @var string|null */
    private $help;

    /**
     * @param array{id: string, name: string, value: string, label: string, help?: string} $options
     */
    public function __construct(array $options)
    {
        $this->id = $options['id'];
        $this->name = $options['name'];
        $this->value = $options['value'];
        $this->label = $options['label'];
        $this->help = isset($options['help']) ? $options['help'] : null;
    }

    public function render($value)
    {
        $output = \strtr(
            '<label for="{id}">' .
            '<input type="checkbox" id="{id}" name="{name}" value="{value}" {checked} /> {label}' .
            '</label>',
            [
                '{id}' => $this->id,
                '{name}' => $this->name,
                '{label}' => \__($this->label, 'croct'),
                '{value}' => \esc_attr($this->value),
                '{checked}' => $this->value === $value ? 'checked' : '',
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

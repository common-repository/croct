<?php

namespace Croct\WordPress\Admin\Settings;

use Croct\WordPress\Options;

final class SettingsPage
{
    /** @var Options */
    private $options;

    /** @var string */
    private $slug;

    /**
     * @param Options $options
     * @param string  $slug
     */
    public function __construct($options, $slug)
    {
        $this->options = $options;
        $this->slug = $slug;
    }

    /**
     * @return void
     */
    public function load()
    {
        \register_setting(
            $this->options->getGroup(),
            $this->options->getName(),
            [
                'sanitize_callback' => function ($input) {
                    return $this->sanitize($input);
                },
            ]
        );

        foreach ($this->getSections() as $section) {
            $sectionId = $section->getId();
            $sectionTitle = $section->getTitle();

            \add_settings_section(
                $sectionId,
                \__($sectionTitle, 'croct'),
                static function () use ($section) {
                    echo $section->render();
                },
                $this->slug
            );

            foreach ($section->getFields() as $name => $definition) {
                \add_settings_field(
                    $name,
                    \__($definition['title'], 'croct'),
                    function () use ($definition, $name) {
                        $options = $definition['options'];
                        $options['id'] = $name;
                        $options['name'] = \sprintf('%s[%s]', $this->options->getName(), $name);

                        $renderer = new $definition['type']($options);

                        echo $renderer->render($this->options->getOption($name));
                    },
                    $this->slug,
                    $sectionId
                );
            }
        }
    }

    /**
     * @return void
     */
    public function render()
    {
        ?>
        <div class="wrap">
            <h2><?php echo \__('Croct Settings', 'croct'); ?></h2>
            <?php \settings_errors(); ?>
            <form method="post" action="options.php">
                <?php
                \settings_fields($this->options->getGroup());
                \do_settings_sections($this->slug);
                \submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    /**
     * @param array<mixed> $input
     *
     * @return array<mixed>
     */
    private function sanitize(array $input)
    {
        $result = [];
        foreach ($this->getSections() as $section) {
            foreach ($section->getFields() as $field => $definition) {
                $value = isset($input[$field]) ? $input[$field] : '';
                $validator = $definition['validator'];

                try {
                    $validator($value);
                } catch (\Exception $exception) {
                    \add_settings_error($field, $field, \__($exception->getMessage(), 'croct'), 'error');

                    continue;
                }

                $result[$field] = $value;
            }
        }

        return $result;
    }

    /**
     * @return array<GeneralSection>
     */
    private function getSections()
    {
        return [
            new GeneralSection(),
        ];
    }
}

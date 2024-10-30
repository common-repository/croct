<?php

namespace Croct\WordPress\Admin\Settings;

use Croct\WordPress\Listener\InterestMetatag;

final class GeneralSection implements Section
{
    const UUID_PATTERN = '/^[a-f\d]{8}(-[a-f\d]{4}){4}[a-f\d]{8}$/i';

    const APP_ID = 'app_id';

    const DEBUG_MODE = 'debug_mode';

    const TRACKING_TRIGGER = 'tracking_trigger';

    public function getId()
    {
        return 'croct_general_settings';
    }

    public function getTitle()
    {
        return 'General';
    }

    /**
     * @return string
     */
    public function render()
    {
        return \sprintf('<p>%s</p>', \__('Set up the integration with Croct.', 'croct'));
    }

    public function getFields()
    {
        return [
            self::APP_ID => [
                'type' => TextField::class,
                'title' => 'Application ID',
                'options' => [
                    'type' => 'text',
                    'help' => 'You can find the Application ID under Organization > Workspaces > Applications.',
                ],
                'validator' => static function ($value) {
                    if ($value !== '' && \preg_match(self::UUID_PATTERN, $value) !== 1) {
                        throw new \InvalidArgumentException('Invalid application ID.');
                    }
                },
            ],
            self::DEBUG_MODE => [
                'type' => CheckboxField::class,
                'title' => 'Debug mode',
                'options' => [
                    'label' => 'Log debugging information to the console',
                    'help' => 'The logs can only be viewed by administrators.',
                    'value' => '1',
                ],
                'validator' => static function ($value) {
                    if (!\in_array($value, ['1', ''], true)) {
                        throw new \InvalidArgumentException('Invalid debug mode option.');
                    }
                },
            ],
            self::TRACKING_TRIGGER => [
                'type' => SelectField::class,
                'title' => 'Tracking trigger',
                'options' => [
                    'help' => 'What triggers the tracking of visitor interests?',
                    'options' => [
                        [
                            'label' => 'Visit page',
                            'value' => InterestMetatag::VISIT_PAGE,
                        ],
                        [
                            'label' => 'Stay on the page',
                            'value' => InterestMetatag::STAY_ON_PAGE,
                        ],
                        [
                            'label' => 'Scroll down',
                            'value' => InterestMetatag::SCROLL_DOWN,
                        ],
                    ],
                ],
                'validator' => static function ($value) {
                    if (!\in_array($value, InterestMetatag::TRIGGERS, true)) {
                        throw new \InvalidArgumentException('Invalid tracking trigger option.');
                    }
                },
            ],
        ];
    }
}

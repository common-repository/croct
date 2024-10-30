<?php

namespace Croct\WordPress;

final class Options
{
    /**
     * The application ID.
     */
    const APP_ID = 'app_id';

    /**
     * Whether the debug mode is enabled.
     */
    const DEBUG_MODE = 'debug_mode';

    /**
     * The tracking trigger.
     */
    const TRACKING_TRIGGER = 'tracking_trigger';

    /** @var string */
    private $name;

    /** @var string */
    private $group;

    /** @var array<mixed> */
    private $options;

    /**
     * @param string       $name
     * @param string       $group
     * @param array<mixed> $options
     */
    public function __construct($name, $group, array $options)
    {
        $this->name = $name;
        $this->group = $group;
        $this->options = $options;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * @return string|null
     */
    public function getAppId()
    {
        $appId = $this->getOption(self::APP_ID);

        return $appId === '' ? null : $appId;
    }

    /**
     * @return string|null
     */
    public function getTrackingTrigger()
    {
        return $this->getOption(self::TRACKING_TRIGGER);
    }

    /**
     * @return bool
     */
    public function isDebugModeEnabled()
    {
        return $this->getOption(self::DEBUG_MODE) === '1';
    }

    /**
     * @param mixed $name
     *
     * @return mixed|null
     */
    public function getOption($name)
    {
        return \array_key_exists($name, $this->options) ? $this->options[$name] : null;
    }
}

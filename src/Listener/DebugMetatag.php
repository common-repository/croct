<?php

namespace Croct\WordPress\Listener;

use Croct\WordPress\HookListener;

final class DebugMetatag implements HookListener
{
    /** @var bool */
    private $enabled;

    /**
     * @param bool $enabled
     */
    public function __construct($enabled)
    {
        $this->enabled = $enabled;
    }

    public function __toString()
    {
        return \sprintf(
            '<meta name="croct:debug" content="%s" />',
            $this->enabled ? 'true' : 'false'
        );
    }
}

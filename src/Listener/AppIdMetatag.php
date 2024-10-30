<?php

namespace Croct\WordPress\Listener;

use Croct\WordPress\HookListener;

final class AppIdMetatag implements HookListener
{
    /** @var string */
    private $appId;

    /**
     * @param string $appId
     */
    public function __construct($appId)
    {
        $this->appId = $appId;
    }

    public function __toString()
    {
        return \sprintf(
            '<meta name="croct:appId" content="%s" />',
            $this->appId
        );
    }
}

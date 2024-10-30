<?php

namespace Croct\WordPress\Listener;

use Croct\WordPress\HookListener;

final class InterestMetatag implements HookListener
{
    const VISIT_PAGE = 'visit';

    const STAY_ON_PAGE = 'stay';

    const SCROLL_DOWN = 'scroll';

    const TRIGGERS = [
        self::VISIT_PAGE,
        self::STAY_ON_PAGE,
        self::SCROLL_DOWN,
    ];

    /** @var array<string> */
    private $interests;

    /** @var string */
    private $trigger;

    /**
     * @param array<string> $interests
     * @param string        $trigger
     */
    public function __construct(array $interests, $trigger = null)
    {
        $this->interests = [];
        $this->trigger = $trigger === null ? self::VISIT_PAGE : $trigger;

        foreach ($interests as $interest) {
            $this->interests[] = \htmlspecialchars(\strtr($interest, [',' => '']));
        }
    }

    public function __toString()
    {
        return \sprintf(
            '<meta name="croct:interests" content="%s;%s" />',
            $this->trigger,
            \implode(',', $this->interests)
        );
    }
}

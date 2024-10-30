<?php

namespace Croct\WordPress\Dependency;

use Croct\WordPress\InlineDependency;

final class TagifyInitScript implements InlineDependency
{
    /** @var string */
    private $fieldId;

    /** @var array<mixed> */
    private $options;

    /**
     * @param string       $fieldId
     * @param array<mixed> $options
     */
    public function __construct($fieldId, array $options)
    {
        $this->fieldId = $fieldId;
        $this->options = $options;
    }

    public function getType()
    {
        return self::TYPE_SCRIPT;
    }

    public function getHandle()
    {
        return TagifyScript::HANDLE;
    }

    public function getPlacementPosition()
    {
        return self::PLACEMENT_AFTER;
    }

    public function getSource()
    {
        return \strtr(
            'window.addEventListener("DOMContentLoaded", function () {
                new Tagify(document.getElementById("{id}"), {options});
            });',
            [
                '{id}' => $this->fieldId,
                '{options}' => \json_encode($this->options),
            ]
        );
    }
}

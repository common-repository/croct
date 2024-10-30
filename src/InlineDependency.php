<?php

namespace Croct\WordPress;

interface InlineDependency extends Dependency
{
    const PLACEMENT_AFTER = 'after';

    const PLACEMENT_BEFORE = 'before';

    /**
     * The name of the dependency.
     *
     * @return string
     */
    public function getHandle();

    /**
     * The position relative to the external dependency.
     *
     * @return string
     *
     * @see InlineDependency::PLACEMENT_AFTER
     * @see InlineDependency::PLACEMENT_BEFORE
     */
    public function getPlacementPosition();

    /**
     * Returns the CSS style.
     *
     * @return string
     */
    public function getSource();
}

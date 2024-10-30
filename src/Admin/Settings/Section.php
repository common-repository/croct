<?php

namespace Croct\WordPress\Admin\Settings;

interface Section
{
    /**
     * @return string
     */
    public function getId();

    /**
     * @return string
     */
    public function getTitle();

    /**
     * @return string
     */
    public function render();

    /**
     * @return array<string, array{type: string, title: string, options: array<mixed>, validator: callable}>
     */
    public function getFields();
}

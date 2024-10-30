<?php

namespace Croct\WordPress\Admin;

final class Menu
{
    /** @var string */
    private $baseUrl;

    /** @var callable */
    private $settingsCallback;

    /**
     * @param string   $baseUrl
     * @param callable $settingsCallback
     */
    public function __construct($baseUrl, $settingsCallback)
    {
        $this->baseUrl = $baseUrl;
        $this->settingsCallback = $settingsCallback;
    }

    /**
     * @return void
     */
    public function build()
    {
        \add_menu_page(
            'Croct',
            'Croct',
            'manage_options',
            'croct',
            $this->settingsCallback,
            $this->baseUrl . 'static/images/menu-icon.svg'
        );
    }
}

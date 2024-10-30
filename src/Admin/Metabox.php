<?php

namespace Croct\WordPress\Admin;

use Croct\WordPress\Action;
use Croct\WordPress\Dependency;

interface Metabox
{
    const SCREEN_POST = 'post';

    const CONTEXT_NORMAL = 'normal';

    const CONTEXT_SIDE = 'side';

    const CONTEXT_ADVANCED = 'advanced';

    const PRIORITY_HIGH = 'high';

    const PRIORITY_LOW = 'low';

    const PRIORITY_DEFAULT = 'default';

    /**
     * Returns the Meta box ID.
     *
     * This is used in the 'id' attribute for the meta box.
     *
     * @return string
     */
    public function getId();

    /**
     * Returns the title of the meta box.
     *
     * @return string
     */
    public function getTitle();

    /**
     * Returns the screens on which to show the box.
     *
     * If you have `used add_menu_page()` or `add_submenu_page()` to create
     * a new screen (and hence `screen_id`), make sure your menu slug conforms
     * to the limits of `sanitize_key()` otherwise the 'screen' menu may not
     * correctly render on your page.
     *
     * @return array<string>
     */
    public function getScreens();

    /**
     * The context within the screen where the boxes should display.
     *
     * Available contexts vary from screen to screen.
     *
     * - Post edit screen contexts include 'normal', 'side', and 'advanced'.
     * - Comments screen contexts include 'normal' and 'side'.
     * - Menus meta boxes (accordion sections) all use the 'side' context.
     * - Global default is 'advanced'.
     *
     * @return string
     */
    public function getContext();

    /**
     * The priority within the context where the boxes should show.
     *
     * The possible values are 'high', 'low' and 'default'.
     *
     * @return string
     */
    public function getPriority();

    /**
     * Returns a callback to render the box with the desired content.
     *
     * The callback should echo its output.
     *
     * @return callable
     */
    public function getRenderer();

    /**
     * The list of actions to register.
     *
     * @return array<Action>
     */
    public function getActions();

    /**
     * The list of dependencies to load.
     *
     * @return array<Dependency>
     */
    public function getDependencies();
}

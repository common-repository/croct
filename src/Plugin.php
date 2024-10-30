<?php

namespace Croct\WordPress;

use Croct\WordPress\Admin\Menu;
use Croct\WordPress\Admin\Metabox;
use Croct\WordPress\Admin\Settings\SettingsPage;
use Croct\WordPress\Dependency\PlugScript;
use Croct\WordPress\Dependency\WpCroctScript;
use Croct\WordPress\Listener\AppIdMetatag;
use Croct\WordPress\Listener\DebugMetatag;
use Croct\WordPress\Listener\InterestMetatag;

final class Plugin
{
    const VERSION = '1.1.1';

    const OPTIONS_GROUP = 'croct';

    const OPTIONS_NAME = 'croct_settings';

    /** @var string */
    private $baseUrl;

    /** @var \wpdb */
    private $database;

    /** @var DependencyQueue */
    private $dependencies;

    /** @var Options|null */
    private $options;

    /**
     * @param string $baseUrl
     */
    public function __construct($baseUrl, \wpdb $database)
    {
        $this->baseUrl = $baseUrl;
        $this->database = $database;
        $this->dependencies = new DependencyQueue();
    }

    /**
     * @return void
     */
    public function initialize()
    {
        if (\is_admin()) {
            $this->registerAdminHooks();
        } else {
            $this->registerSiteHooks();
        }
    }

    /**
     * @return void
     */
    private function registerAdminHooks()
    {
        $settings = new SettingsPage($this->getOptions(), 'croct');
        $menu = new Menu($this->baseUrl, [$settings, 'render']);

        \add_action('admin_init', function () use ($settings) {
            $settings->load();
            $this->registerMetaboxActions();
        });

        \add_action('admin_menu', [$menu, 'build']);

        \add_action('add_meta_boxes', function () {
            $this->registerMetaboxes();
        });

        \add_action('admin_enqueue_scripts', function () {
            $this->dependencies->enqueue($this->getAdminDependencies());
        });
    }

    /**
     * @return void
     */
    private function registerSiteHooks()
    {
        $this->registerShortcodes();

        \add_action('wp_enqueue_scripts', function () {
            $this->dependencies->enqueue($this->getSiteDependencies());
        });

        \add_action('wp_head', function () {
            foreach ($this->getHeadTags() as $tag) {
                echo $tag;
                echo "\n";
            }
        });
    }

    /**
     * @return array<HookListener>
     */
    private function getHeadTags()
    {
        $options = $this->getOptions();
        $appId = $options->getAppId();

        if ($appId === null) {
            return [];
        }

        $listeners = [new AppIdMetatag($appId)];

        if ($options->isDebugModeEnabled()) {
            $listeners[] = new DebugMetatag(true);
        }

        $postId = \is_single() ? \get_the_ID() : false;

        if ($postId !== false) {
            $interests = \get_post_meta($postId, Metabox\InterestMetabox::ID, true);

            if (\is_string($interests) && $interests !== '') {
                $listeners[] = new InterestMetatag(
                    \array_map('trim', \explode(',', $interests)),
                    $options->getTrackingTrigger()
                );
            }
        }

        return $listeners;
    }

    /**
     * @return array<Dependency>
     */
    private function getAdminDependencies()
    {
        $screen = \get_current_screen();

        if ($screen === null) {
            return [];
        }

        $dependencies = [];
        foreach ($this->getMetaboxes() as $metabox) {
            $screens = $metabox->getScreens();

            if (\in_array($screen->base, $screens, true) || \in_array($screen->id, $screens, true)) {
                \array_push($dependencies, ...$metabox->getDependencies());
            }
        }

        return $dependencies;
    }

    /**
     * @return array<Dependency>
     */
    private function getSiteDependencies()
    {
        $options = $this->getOptions();
        $appId = $options->getAppId();

        if ($appId === null) {
            return [];
        }

        return [
            new PlugScript(),
            new WpCroctScript($this->baseUrl),
        ];
    }

    /**
     * @return void
     */
    private function registerMetaboxes()
    {
        foreach ($this->getMetaboxes() as $metabox) {
            \add_meta_box(
                $metabox->getId(),
                $metabox->getTitle(),
                $metabox->getRenderer(),
                $metabox->getScreens(),
                $metabox->getContext(),
                $metabox->getPriority()
            );
        }
    }

    /**
     * @return array<Metabox>
     */
    private function getMetaboxes()
    {
        return [new Metabox\InterestMetabox($this->baseUrl, $this->database)];
    }

    /**
     * @return void
     */
    private function registerMetaboxActions()
    {
        foreach ($this->getMetaboxes() as $metabox) {
            foreach ($metabox->getActions() as $action) {
                \add_action($action->getName(), $action);
            }
        }
    }

    /**
     * @return void
     */
    private function registerShortcodes()
    {
        foreach ($this->getShortcodes() as $shortcode) {
            \add_shortcode($shortcode->getName(), [$shortcode, 'render']);
        }
    }

    /**
     * @return array<Shortcode>
     */
    private function getShortcodes()
    {
        $options = $this->getOptions();
        $enabled = $options->getAppId() !== null;

        return [
            new Shortcode\PersonalizedShortcode($enabled),
            new Shortcode\IfShortcode($enabled),
        ];
    }

    /**
     * @return Options
     */
    private function getOptions()
    {
        if ($this->options === null) {
            $options = \get_option(self::OPTIONS_NAME);

            $this->options = new Options(
                self::OPTIONS_NAME,
                self::OPTIONS_GROUP,
                \is_array($options) ? $options : []
            );
        }

        return $this->options;
    }
}

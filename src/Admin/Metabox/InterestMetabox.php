<?php

namespace Croct\WordPress\Admin\Metabox;

use Croct\WordPress\Action;
use Croct\WordPress\Admin\Metabox;
use Croct\WordPress\Dependency\TagifyInitScript;
use Croct\WordPress\Dependency\TagifyScript;
use Croct\WordPress\Dependency\TagifyStyle;

final class InterestMetabox implements Metabox
{
    const ID = 'croct_user_interests';

    const FIELD_ID = 'croct_user_interests_name';

    /** @var string */
    private $baseUrl;

    /** @var \wpdb */
    private $database;

    /**
     * @param string $baseUrl
     * @param \wpdb  $database
     */
    public function __construct($baseUrl, \wpdb $database)
    {
        $this->baseUrl = $baseUrl;
        $this->database = $database;
    }

    public function getId()
    {
        return self::ID;
    }

    public function getTitle()
    {
        return 'Croct - Audience Interests';
    }

    public function getScreens()
    {
        return [self::SCREEN_POST];
    }

    public function getContext()
    {
        return self::CONTEXT_SIDE;
    }

    public function getPriority()
    {
        return self::PRIORITY_DEFAULT;
    }

    public function getRenderer()
    {
        return [$this, 'render'];
    }

    public function getActions()
    {
        return [new Action('save_post', [$this, 'save'])];
    }

    public function getDependencies()
    {
        return [
            new TagifyScript($this->baseUrl),
            new TagifyStyle($this->baseUrl),
            new TagifyInitScript(self::FIELD_ID, [
                'whitelist' => $this->getInterests(),
                'maxTags' => 10,
                'dropdown' => [
                    'maxItems' => 30,
                    'enabled' => 0,
                ],
            ]),
        ];
    }

    /**
     * @param mixed $postId
     *
     * @return void
     */
    public function save($postId)
    {
        if (!\array_key_exists(self::ID, $_POST)) {
            return;
        }

        $interests = [];
        foreach (\json_decode(\stripslashes($_POST[self::ID]), true) as $tag) {
            $interest = \trim(\sanitize_text_field($tag['value']));

            if ($interest !== '') {
                $interests[] = $interest;
            }
        }

        if (\count($interests) === 0) {
            \delete_post_meta($postId, self::ID);
        } else {
            \update_post_meta($postId, self::ID, \implode(', ', \array_unique($interests)));
        }
    }

    /**
     * @return void
     */
    public function render(\WP_Post $post)
    {
        $value = \get_post_meta($post->ID, self::ID, true);

        echo \strtr(
            '<div class="components-base-control">' .
            '<label for="{id}" class="components-base-control__label">{label}</label>' .
            '<input type="text" id="{id}" name="{name}" placeholder="{placeholder}" value="{value}" />' .
            '</div>',
            [
                '{id}' => self::FIELD_ID,
                '{name}' => self::ID,
                '{label}' => \__('Interests related to the post:', 'croct'),
                '{placeholder}' => \__('add more interests', 'croct'),
                '{value}' => \esc_attr($value),
            ]
        );
    }

    /**
     * @return array<string>
     */
    private function getInterests()
    {
        $columns = $this->database->get_col(
            \sprintf(
                'SELECT DISTINCT meta_value FROM %s WHERE meta_key = "%s" LIMIT 100',
                $this->database->postmeta,
                self::ID
            )
        );

        $interests = [];
        foreach ($columns as $column) {
            $interests[] = \array_map('\trim', \explode(', ', $column));
        }

        return \array_values(\array_unique(\array_merge(...$interests)));
    }
}

<?php

namespace Croct\WordPress;

use Croct\WordPress\Admin\Metabox\InterestMetabox;

if (!\defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

require_once \dirname(__FILE__) . '/autoload.php';

\delete_post_meta_by_key(InterestMetabox::ID);
\delete_option(Plugin::OPTIONS_NAME);

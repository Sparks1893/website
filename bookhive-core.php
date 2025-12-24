<?php
/*
Plugin Name: Bookhive Core
Description: Core data layer for Bookhive (books, shelves, reviews, activity).
Version: 1.0.0
Author: Emma Durant
*/

if (!defined('ABSPATH')) exit;

define('BOOKHIVE_CORE_PATH', plugin_dir_path(__FILE__));

require_once BOOKHIVE_CORE_PATH . 'includes/db-install.php';
register_activation_hook(__FILE__, ['Bookhive_DB', 'install']);

require_once BOOKHIVE_CORE_PATH . 'includes/post-types.php';
require_once BOOKHIVE_CORE_PATH . 'includes/reviews.php';
require_once BOOKHIVE_CORE_PATH . 'includes/shelves.php';
require_once BOOKHIVE_CORE_PATH . 'includes/series.php';
require_once BOOKHIVE_CORE_PATH . 'includes/activity.php';
require_once BOOKHIVE_CORE_PATH . 'includes/ajax.php';

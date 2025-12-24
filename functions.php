<?php
if (!defined('ABSPATH')) exit;

add_action('wp_enqueue_scripts', function () {
  wp_enqueue_style(
    'bookhive-theme',
    get_template_directory_uri() . '/assets/css/bookhive.css',
    [],
    '1.0.0'
  );
});

/**
 * Basic theme supports
 */
add_action('after_setup_theme', function () {
  add_theme_support('title-tag');
  add_theme_support('post-thumbnails');
  add_theme_support('html5', ['search-form', 'gallery', 'caption']);
});

add_action('wp_enqueue_scripts', function () {
  wp_enqueue_script(
    'bookhive-ui',
    get_template_directory_uri() . '/assets/js/bookhive-ui.js',
    [],
    '1.0.0',
    true
  );

  wp_localize_script('bookhive-ui', 'bookhiveUI', [
    'ajaxurl' => admin_url('admin-ajax.php'),
    'nonce'   => wp_create_nonce('bookhive_nonce'),
  ]);
});

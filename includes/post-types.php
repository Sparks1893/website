<?php
if (!defined('ABSPATH')) exit;

add_action('init', function () {
  register_post_type('book', [
    'label' => 'Books',
    'public' => true,
    'rewrite' => ['slug' => 'book'],
    'supports' => ['title', 'editor', 'thumbnail'],
    'show_in_rest' => true,
    'menu_icon' => 'dashicons-book',
  ]);
});


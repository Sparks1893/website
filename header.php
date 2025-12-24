<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<header class="bh-header">
  <div class="bh-container">
    <a class="bh-logo" href="<?php echo esc_url(home_url('/')); ?>">
      📚 Bookhive
    </a>
    <nav class="bh-nav">
      <a href="<?php echo esc_url(site_url('/library')); ?>">My Library</a>
      <a href="<?php echo esc_url(site_url('/feed')); ?>">Feed</a>
      <?php if (is_user_logged_in()): ?>
        <a href="<?php echo esc_url(get_author_posts_url(get_current_user_id())); ?>">
          Profile
        </a>
      <?php endif; ?>
    </nav>
  </div>
</header>

<main class="bh-main">


<?php
get_header();
$author = get_queried_object();
?>

<div class="bh-container">
  <h1><?php echo esc_html($author->display_name); ?></h1>
  <p>Reader profile</p>
</div>

<?php get_footer(); ?>


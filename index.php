<?php get_header(); ?>
<div class="bh-container">
  <h1><?php single_post_title(); ?></h1>
  <?php if (have_posts()): while (have_posts()): the_post(); ?>
    <?php the_content(); ?>
  <?php endwhile; endif; ?>
</div>
<?php get_footer(); ?>


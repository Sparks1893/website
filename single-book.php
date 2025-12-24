<?php
get_header();
?>

<div class="bh-container bh-book-page">

  <?php if (have_posts()): while (have_posts()): the_post(); ?>

    <article class="bh-book">
      <div class="bh-book-grid">

        <div class="bh-book-cover">
          <?php if (has_post_thumbnail()): ?>
            <?php the_post_thumbnail('medium'); ?>
          <?php else: ?>
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/default-book.png" alt="">
          <?php endif; ?>
        </div>

        <div class="bh-book-meta">
          <h1><?php the_title(); ?></h1>
          <div class="bh-book-author">
            <?php echo esc_html(get_post_meta(get_the_ID(), 'author', true)); ?>
          </div>

          <div class="bh-book-description">
            <?php the_content(); ?>
          </div>
        </div>

      </div>
    </article>

  <?php endwhile; endif; ?>

</div>

<?php get_footer(); ?>

<?php
get_header();

if (have_posts()): while (have_posts()): the_post();

  $book_id = get_the_ID();

  // averages + community reviews from core plugin
  $avg = class_exists('Bookhive_Reviews') ? Bookhive_Reviews::averages($book_id) : null;
  $reviews = class_exists('Bookhive_Reviews') ? Bookhive_Reviews::get($book_id) : [];

  $my_review = null;
  $my_shelf = 'none';
  if (is_user_logged_in() && class_exists('Bookhive_Reviews') && class_exists('Bookhive_Shelves')) {
    $my_review = Bookhive_Reviews::get_user_review(get_current_user_id(), $book_id);
    $my_shelf = Bookhive_Shelves::get_primary_shelf(get_current_user_id(), $book_id) ?: 'none';
  }
?>

<div class="bh-container bh-book-page">

  <article class="bh-book">
    <div class="bh-book-grid">
      <div class="bh-book-cover">
        <?php if (has_post_thumbnail()): the_post_thumbnail('medium'); else: ?>
          <img src="<?php echo esc_url(get_template_directory_uri().'/assets/images/default-book.png'); ?>" alt="">
        <?php endif; ?>
      </div>

      <div class="bh-book-meta">
        <h1><?php the_title(); ?></h1>

        <div class="bh-book-author">
          <?php echo esc_html(get_post_meta($book_id, 'author', true)); ?>
        </div>

        <div class="bh-avg">
          <span>⭐ <?php echo esc_html($avg->rating ?? '—'); ?>/5</span>
          <span>🌶️ <?php echo esc_html($avg->spice ?? '—'); ?>/5</span>
          <span>(<?php echo intval($avg->total ?? 0); ?> reviews)</span>
        </div>

        <?php if (is_user_logged_in()): ?>
          <div class="bh-shelf">
            <label>Status shelf</label>
            <select class="bh-shelf-select" data-book="<?php echo esc_attr($book_id); ?>">
              <option value="none" <?php selected($my_shelf, 'none'); ?>>None</option>
              <option value="want-to-read" <?php selected($my_shelf, 'want-to-read'); ?>>Want to Read</option>
              <option value="currently-reading" <?php selected($my_shelf, 'currently-reading'); ?>>Currently Reading</option>
              <option value="read" <?php selected($my_shelf, 'read'); ?>>Read</option>
            </select>
          </div>

          <div class="bh-review-form">
            <h3>Your review</h3>

            <label>Rating</label>
            <select id="bh-rating">
              <?php for ($i=1; $i<=5; $i++): ?>
                <option value="<?php echo $i; ?>" <?php selected(intval($my_review->rating ?? 0), $i); ?>>
                  <?php echo $i; ?> ★
                </option>
              <?php endfor; ?>
            </select>

            <label>Spice</label>
            <select id="bh-spice">
              <?php for ($i=0; $i<=5; $i++): ?>
                <option value="<?php echo $i; ?>" <?php selected(intval($my_review->spice ?? 0), $i); ?>>
                  <?php echo $i; ?> 🌶️
                </option>
              <?php endfor; ?>
            </select>

            <textarea id="bh-review" placeholder="Write your thoughts…"><?php
              echo esc_textarea($my_review->review ?? '');
            ?></textarea>

            <button class="bh-save-review" data-book="<?php echo esc_attr($book_id); ?>">
              Save review
            </button>

            <div class="bh-save-status" style="display:none;"></div>
          </div>
        <?php else: ?>
          <p><a href="<?php echo esc_url(wp_login_url(get_permalink())); ?>">Log in</a> to rate, review, and track this book.</p>
        <?php endif; ?>

        <div class="bh-book-description">
          <?php the_content(); ?>
        </div>
      </div>
    </div>

    <section class="bh-community">
      <h3>Community reviews</h3>

      <?php if (empty($reviews)): ?>
        <p>No reviews yet.</p>
      <?php else: ?>
        <?php foreach ($reviews as $r): ?>
          <div class="bh-review">
            <strong><?php echo esc_html($r->display_name); ?></strong>
            <div>⭐ <?php echo str_repeat('★', intval($r->rating)); ?></div>
            <div>🌶️ <?php echo str_repeat('🌶️', intval($r->spice)); ?></div>
            <p><?php echo esc_html($r->review); ?></p>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </section>

  </article>
</div>

<?php endwhile; endif; get_footer(); ?>

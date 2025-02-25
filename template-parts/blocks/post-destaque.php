<?php

/**
 * Bloco de destaques nas telas de blog
 *
 * @package airclean
 */

namespace Air_Light;

// Query args base
$destaque_args = array(
  'meta_query' => array(
    array(
      'key' => 'destaque',
      'value' => '"na-categoria"',
      'compare' => 'LIKE',
    ),
  ),
  'posts_per_page' => 1
);

$destaque_blog = get_posts($destaque_args);

if ($destaque_blog) {
  global $post;

  foreach ($destaque_blog as $post) {
    setup_postdata($post);
?>

    <article id="post-<?php the_ID(); ?>" <?php post_class('block destaque-blog'); ?>>

      <div class="destaque thumbnail">
        <?php
        if (has_post_thumbnail()) {
          the_post_thumbnail('destaque-home', array('loading' => 'lazy', 'fetchpriority' => 'low'));
        }
        ?>
      </div>

      <div class="detalhes-do-post">
        <?php if (has_category()) : ?>
          <ul class="categories">
            <?php
            $categories = wp_get_post_categories(get_the_id(), ['fields' => 'all']);
            if (! empty($categories)) {
              foreach ($categories as $category) {
                echo '<li><a href="' . esc_url(get_category_link($category)) . '">' . esc_html($category->name) . '</a></li>';
              }
            }
            ?>
          </ul>
        <?php endif; ?>

        <h2 class="post-title">
          <a href="<?php echo esc_url(get_the_permalink()); ?>">
            <?php the_title(); ?>
          </a>
        </h2>

        <div class="content"> <?php the_excerpt(); ?> </div>

        <p>
          <time datetime="<?php the_time('c'); ?>">
            <?php echo get_the_date(get_option('date_format')); ?>
          </time>
        </p>
      </div>

    </article>
<?php
  }
  wp_reset_postdata();
}
?>

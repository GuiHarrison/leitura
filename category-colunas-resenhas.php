<?php
/**
 * Template para Colunas e Resenhas
 *
 * @package leitura
 */

namespace Air_Light;

get_header(); ?>

<main class="site-main">
  <section class="block block-blog">
    <div class="container">
      <?php
      // Post em destaque
      $detaque_blog = get_posts(array(
        'category_name' => get_queried_object()->slug,
        'meta_query' => array(
          array(
            'key' => 'destaque',
            'value' => '"home"',
            'compare' => 'LIKE',
          ),
        ),
        'posts_per_page' => 1
      ));

      if ($detaque_blog) {
        global $post;
        echo '<div id="destaque_blog">';
        foreach ($detaque_blog as $post) {
          setup_postdata($post);
          get_template_part('template-parts/content', 'featured');
        }
        echo '</div>';
        wp_reset_postdata();
      }

      // Loop principal
      if (have_posts()) :
        while (have_posts()) :
          the_post();
          ?>
          <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <div class="thumbnail">
              <?php the_post_thumbnail('destaque-home', array('loading' => 'lazy', 'fetchpriority' => 'low')); ?>
            </div>

            <div class="detalhes-do-post">
              <?php if (has_category()) : ?>
                <ul class="categories">
                  <?php
                  $categories = wp_get_post_categories(get_the_id(), ['fields' => 'all']);
                  foreach ($categories as $category) {
                    echo '<li><a href="' . esc_url(get_category_link($category)) . '">' . esc_html($category->name) . '</a></li>';
                  }
                  ?>
                </ul>
              <?php endif; ?>

              <h2 class="<?php echo esc_attr(get_post_type()); ?>-title">
                <a href="<?php echo esc_url(get_the_permalink()); ?>"><?php the_title(); ?></a>
              </h2>

              <div class="content"><?php the_excerpt(); ?></div>

              <p><time datetime="<?php the_time('c'); ?>"><?php echo get_the_date(); ?></time></p>
            </div>
          </article>
        <?php
        endwhile;

        the_posts_pagination();
      endif;
      ?>
    </div>

    <div class="sidebar">
      <?php get_sidebar(); ?>
    </div>
  </section>
</main>

<?php get_footer();

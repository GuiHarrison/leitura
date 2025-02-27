<?php

/**
 * The main template file
 *
 * @package leitura
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 */

namespace Air_Light;

get_header(); ?>

<div class="site-main container">

  <section class="block-blog">
    <main class="main grid-container grid">
      <?php
      // Obtém o ID da categoria 'blog'
      $blog_category = get_category_by_slug('blog');
      $category_ids = array();

      if ($blog_category) {
        // Obtém todas as subcategorias
        $category_ids = array_merge(
          array($blog_category->term_id),
          get_term_children($blog_category->term_id, 'category')
        );
      }

      $destaque_blog = new \WP_Query(array(
        'category__in' => $category_ids,
        'meta_query' => array(
          array(
            'key' => 'destaque',
            'value' => '"na-categoria"',
            'compare' => 'LIKE',
          ),
        ),
        'posts_per_page' => 1,
        'orderby' => 'date',
        'order' => 'DESC'
      ));

      if ($destaque_blog->have_posts()) {
        while ($destaque_blog->have_posts()) {
          $destaque_blog->the_post();
      ?>

          <article id="post-<?php the_ID(); ?>" <?php post_class('block destaque-blog'); ?>>

            <a href="<?php echo esc_url(get_the_permalink()); ?>" class="destaque thumbnail">
              <?php
              if (has_post_thumbnail()) {
                the_post_thumbnail('destaque-home', array('loading' => 'lazy', 'fetchpriority' => 'low'));
              }
              ?>
            </a>

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

      <?php
      // Obtém o ID da categoria 'blog'
      $blog_category = get_category_by_slug('blog');

      if ($blog_category) {
        // Obtém todas as subcategorias
        $category_ids = array_merge(
          array($blog_category->term_id),
          get_term_children($blog_category->term_id, 'category')
        );

        // Modifica a query principal
        query_posts(array(
          'category__in' => $category_ids,
          'paged' => get_query_var('paged') ? get_query_var('paged') : 1
        ));
      }

      if (have_posts()) :

        while (have_posts()) :
          the_post();
          $thumb = get_the_post_thumbnail(get_the_ID(), 'destaque-home', array('loading' => 'lazy', 'fetchpriority' => 'low'));
      ?>

          <article id="post-<?php the_ID(); ?>" <?php post_class('block'); ?>>

            <a href="<?php echo esc_url(get_the_permalink()); ?>" class="thumbnail">
              <?php
              if ($thumb) {
                echo $thumb;
              }
              ?>
            </a>

            <div class="detalhes-do-post">
              <h3 class="post-title">
                <a href="<?php echo esc_url(get_the_permalink()); ?>">
                  <?php the_title(); ?>
                </a>
              </h3>

              <div class="content"> <?php the_excerpt(); ?> </div>

              <p>
                <time datetime="<?php the_time('c'); ?>">
                  <?php echo get_the_date(get_option('date_format')); ?>
                </time>
              </p>
            </div>

          </article>
      <?php
        endwhile;

        the_posts_pagination();

      endif;
      ?>

    </main>

    <aside id="sidebar" class="sidebar">
      <?php get_sidebar(); ?>
    </aside>
  </section>

  <aside id="mais-lidos">
    <?php
    $query_obj = get_queried_object();
    $categoria_atual = $query_obj ? $query_obj->term_id : '';
    get_template_part('template-parts/blocks/mais-lidos', null, ['category' => $categoria_atual]);
    ?>
  </aside>

  <?php get_template_part('template-parts/blocks/form-seliga'); ?>

</div>

<?php get_footer();

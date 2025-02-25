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
      // Identificar se estamos em uma categoria ou taxonomia
      $current_term_id = null;
      $current_taxonomy = null;

      if (is_category()) {
        $current_term_id = get_queried_object_id();
        $current_taxonomy = 'category';
      } elseif (is_tax('category_generos')) {
        $current_term_id = get_queried_object_id();
        $current_taxonomy = 'category_generos';
      }

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

      // Adiciona filtro de taxonomia se estivermos em uma página de categoria/taxonomia
      if ($current_term_id && $current_taxonomy) {
        $destaque_args['tax_query'] = array(
          array(
            'taxonomy' => $current_taxonomy,
            'field' => 'term_id',
            'terms' => $current_term_id,
          ),
        );
      }

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

      <?php
      if (have_posts()) :

        while (have_posts()) :
          the_post();
          $thumb = get_the_post_thumbnail(get_the_ID(), 'destaque-home', array('loading' => 'lazy', 'fetchpriority' => 'low'));
      ?>

          <article id="post-<?php the_ID(); ?>" <?php post_class('block'); ?>>

            <div class="thumbnail">
              <?php
              if ($thumb) {
                echo $thumb;
              }
              ?>
            </div>

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

  <?php get_template_part('template-parts/blocks/newsletter'); ?>

</div>

<?php get_footer();

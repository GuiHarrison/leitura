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

  <div class="posts-page-content">
    <?php
    $posts_page_id = get_option('page_for_posts');
    if ($posts_page_id) {
      $posts_page = get_post($posts_page_id);
      if ($posts_page) {
        setup_postdata($posts_page);
        the_content();
        wp_reset_postdata();
      }
    }
    ?>
  </div>

  <section id="sidebar" class="sidebar">
    <?php get_sidebar(); ?>
  </section>

  <section class="block-blog">
    <?php
    if (have_posts()) :
    ?>
      <main class="main grid-container grid">

        <?php
        while (have_posts()) :
          the_post();
          $thumb = get_the_post_thumbnail(get_the_ID(), 'destaque-home', array('loading' => 'lazy', 'fetchpriority' => 'low'));
        ?>

          <article id="post-<?php the_ID(); ?>" <?php post_class('block'); ?>>

            <a href="<?php echo esc_url(get_the_permalink()); ?>" class="thumbnail">
              <?php if ($thumb) {
                echo $thumb;
              } ?>
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
        ?>

      </main>
    <?php
      the_posts_pagination();
    endif;
    ?>


  </section>

  <aside id="mais-lidos">
    <?php
    $query_obj = get_queried_object();
    $categoria_atual = $query_obj ? $query_obj->term_id : '';
    get_template_part('template-parts/blocks/mais-lidos', null, ['category' => $categoria_atual]);
    ?>
  </aside>

  <?php get_template_part('template-parts/blocks/cta-news'); ?>

</div>

<?php get_footer();

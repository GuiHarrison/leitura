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

  <section class="block-blog taxonomy">
    <main class="main grid-container grid">

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

      else :
        echo '<h2>Nenhum post nessa categoria ainda 📖</h2>';

      endif;
      ?>

    </main>

    <aside class="sidebar">
      <?php get_sidebar(); ?>
    </aside>
  </section>

  <aside id="mais-lidos">
    <?php
    $categoria_atual = get_queried_object();
    get_template_part('template-parts/blocks/mais-lidos', null, ['category' => $categoria_atual->term_id]);
    ?>
  </aside>

  <?php get_template_part('template-parts/blocks/form-seliga'); ?>

</div>

<?php get_footer();

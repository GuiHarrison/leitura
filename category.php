<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @Date:   2019-10-15 12:30:02
 * @Last Modified by:   Roni Laukkarinen
 * @Last Modified time: 2022-02-08 17:03:18
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
      if ( have_posts() ) :

        while ( have_posts() ) :
          the_post();
          $thumb = get_the_post_thumbnail( get_the_ID(), 'destaque-home', array( 'loading' => 'lazy', 'fetchpriority' => 'low' ) );
          ?>

          <article id="post-<?php the_ID(); ?>" <?php post_class('block'); ?> >

            <div class="thumbnail">
            <?php
            if ( $thumb ) {
              echo $thumb;
            }
            ?>
            </div>

            <div class="detalhes-do-post">
              <h3 class="post-title">
                <a href="<?php echo esc_url( get_the_permalink() ); ?>">
                  <?php the_title(); ?>
                </a>
              </h3>

              <div class="content"> <?php the_excerpt(); ?> </div>

              <p>
                <time datetime="<?php the_time( 'c' ); ?>">
                  <?php echo get_the_date( get_option( 'date_format' ) ); ?>
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

  <aside class="grid cta-rodape">
    <?php get_template_part( 'template-parts/blocks/revista' ); ?>
    <?php get_template_part( 'template-parts/blocks/cta-3-3' ); ?>
  </aside>

</div>

<?php get_footer();

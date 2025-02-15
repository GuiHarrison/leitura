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

<main class="site-main">

  <section class="block block-blog">
    <div class="container">

      <?php
      $detaque_blog = get_posts(array(
        'meta_query' => array(
          array(
            'key' => 'destaque',
            'value' => '"home"',
            'compare' => 'LIKE',
          ),
        ),
        'posts_per_page' => 1
      ));

      if ( $detaque_blog ) {
          global $post;
      ?>

        <div id="destaque_blog">
          <?php
          foreach ( $detaque_blog as $post ) {
            setup_postdata( $post );
            ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

              <div class="destaque thumbnail">
                <?php
                if ( has_post_thumbnail() ) {
                  the_post_thumbnail( 'destaque-home', array( 'loading' => 'lazy', 'fetchpriority' => 'low' ) );
                }
                ?>
              </div>

              <div class="detalhes-do-post">
                <?php if ( has_category() ) : ?>
                <ul class="categories">
                    <?php
                        $categories = wp_get_post_categories( get_the_id(), [ 'fields' => 'all' ] );
                        if ( ! empty( $categories ) ) {
                          foreach ( $categories as $category ) {
                            echo '<li><a href="' . esc_url( get_category_link( $category ) ) . '">' . esc_html( $category->name ) . '</a></li>';
                          }
                        }
                    ?>
                  </ul>
                <?php	endif; ?>

                <h3 class="<?php echo esc_attr( get_post_type() ); ?>-title">
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
        }
        wp_reset_postdata();
      }
      ?>
      </div>

      <?php
      if ( have_posts() ) :

        while ( have_posts() ) :
          the_post();
          $thumb = get_the_post_thumbnail( the_post( 'ID' ), 'destaque-home', array( 'loading' => 'lazy', 'fetchpriority' => 'low' ) );

          echo '<hr />';
          ?>
          <article id="post-<?php the_ID(); ?>" <?php post_class(); ?> >

            <div class="thumbnail">
            <?php
            if ( $thumb ) {
              echo $thumb;
            }
            ?>
            </div>

            <div class="detalhes-do-post">
              <h2 class="<?php echo esc_attr( get_post_type() ); ?>-title">
                <a href="<?php echo esc_url( get_the_permalink() ); ?>">
                  <?php the_title(); ?>
                </a>
              </h2>

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

        the_posts_pagination();

      endif;
      ?>

    </div>
  </section>

</main>

<?php get_footer();

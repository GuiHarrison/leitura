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
    $posts_destaque = get_posts(array(
      'meta_query' => array(
        array(
          'key' => 'destaque',
          'value' => '"home"',
          'compare' => 'LIKE',
        ),
      ),
    ));

    if ( $posts_destaque ) {
      foreach ( $posts_destaque as $post ) {
        setup_postdata( $post );
        ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

          <h2 class="<?php echo esc_attr( get_post_type() ); ?>-title">
            <a href="<?php echo esc_url( get_the_permalink() ); ?>">
              <?php the_title(); ?>
            </a>
          </h2>

          <?php
          $destaque_values = get_post_meta( get_the_ID(), 'destaque', true );
          $destaque_values = maybe_unserialize( $destaque_values );
          if ( is_array( $destaque_values ) ) {
            echo '<ul class="categories">';
            foreach ( $destaque_values as $value ) {
              echo '<li><a href="#_">' . esc_html( $value ) . '</a></li>';
            }
            echo '</ul>';
          }
          ?>

          <p>
            <time datetime="<?php the_time( 'c' ); ?>">
              <?php echo get_the_date( get_option( 'date_format' ) ); ?>
            </time>
          </p>

          <div class="content">
            <?php
              the_content();
              entry_footer();
            ?>
          </div>

        </article>

        <?php
      }
      wp_reset_postdata();
    } else {
      echo '<h2>Sem posts de destaque 😳</h2>';
    }
    ?>

      <?php if ( have_posts() ) : ?>

        <?php if ( is_home() && ! is_front_page() ) : ?>
          <h1 id="content" class="screen-reader-text"><?php single_post_title(); ?></h1>
        <?php endif; ?>

        <?php while ( have_posts() ) :
          the_post(); ?>
          <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

            <h2 class="<?php echo esc_attr( get_post_type() ); ?>-title">
              <a href="<?php echo esc_url( get_the_permalink() ); ?>">
                <?php the_title(); ?>
              </a>
            </h2>

            <p>
              <time datetime="<?php the_time( 'c' ); ?>">
                <?php echo get_the_date( get_option( 'date_format' ) ); ?>
              </time>
            </p>

            <div class="content">
              <?php
                the_content();
                entry_footer();
              ?>
            </div>

          </article>
        <?php endwhile; ?>

        <?php the_posts_pagination(); ?>

      <?php endif; ?>

    </div>
  </section>

</main>

<?php get_footer();

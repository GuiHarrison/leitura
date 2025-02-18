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
      $destaque_blog = get_posts(array(
        // 'category_name' => get_queried_object()->slug,
        'meta_query' => array(
          array(
            'key' => 'destaque',
            'value' => '"na-categoria"',
            'compare' => 'LIKE',
          ),
        ),
        'posts_per_page' => 1
      ));

      if ($destaque_blog) {
        global $post;
        ?>

        <div id="destaque_blog">
          <?php
          foreach ( $destaque_blog as $post ) {
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

              <div class="detalhes-do-post"> <!-- A partir daqui, alterar para colunas e resenhas como está no destaque da home -->
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

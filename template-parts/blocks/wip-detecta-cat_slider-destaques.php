<?php
/**
 * Bloco slider de destaques nas telas de blog
 *
 * @package airclean
 */

namespace Air_Light;
?>

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
          'posts_per_page' => 10
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

      if ( $destaque_blog ) {
          global $post;
          ?>
      <section id="destaques-blog" class="grid owl-carousel owl-theme">

      <?php
      foreach ( $destaque_blog as $post ) {
        setup_postdata( $post );
        // Verifica se o post está na categoria colunas-e-resenhas ou suas subcategorias
        $is_resenha = false;
        $categories = get_the_category();
        foreach ($categories as $category) {
          if ($category->slug === 'colunas-e-resenhas' || cat_is_ancestor_of(get_category_by_slug('colunas-e-resenhas'), $category)) {
            $is_resenha = true;
            break;
          }
        }
        ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class( 'block destaque-blog item' ); ?>>

          <div class="destaque thumbnail<?php echo $is_resenha ? ' resenha' : ''; ?>">
            <?php
            if ( has_post_thumbnail() ) {
              the_post_thumbnail( 'destaque-blog', array( 'loading' => 'lazy', 'fetchpriority' => 'low' ) );
            }
            ?>
          </div>

          <div class="detalhes-do-post<?php echo $is_resenha ? ' resenha' : ''; ?>">
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

            <h2 class="post-title">
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
        }
        wp_reset_postdata();
        ?>
      </section>
      <script>
        document.addEventListener('DOMContentLoaded', function() {
          jQuery('#destaques-blog').owlCarousel({
            items: 1,
            loop: true,
            margin: 0,
            nav: true,
            dots: true,
            autoplay: true,
            autoplayTimeout: 2000,
            autoplayHoverPause: true
          });
        });
      </script>

      <?php
      }
    ?>

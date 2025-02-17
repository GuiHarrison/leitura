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
      $destaque_blog = get_posts(array(
        'meta_query' => array(
          array(
            'key' => 'destaque',
            'value' => '"home"',
            'compare' => 'LIKE',
          ),
        ),
        'posts_per_page' => 1
      ));

      if ( $destaque_blog ) {
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
          $thumb = get_the_post_thumbnail( get_the_ID(), 'destaque-home', array( 'loading' => 'lazy', 'fetchpriority' => 'low' ) );
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

    <div class="sidebar">

      <div class="s-categorias">
        <h4>→ Explorar categorias:</h4>
          <a href="<?php echo esc_url( get_category_link( get_cat_ID( 'noticias' ) ) ); ?>" class="grandes-categorias button notícias">Notícias</a>
          <a href="<?php echo esc_url( get_category_link( get_cat_ID( 'resenhas' ) ) ); ?>" class="grandes-categorias button resenhas">Resenhas</a>
          <a href="<?php echo esc_url( get_category_link( get_cat_ID( 'colunas' ) ) ); ?>" class="grandes-categorias button colunas">Colunas</a>
          <a href="https://leitura.com.br/index.php?route=product/special" target="_ecommerce" class="grandes-categorias button ofertas">Ofertas</a>
      </div>

      <div class="s-filtrar">
        <h4>→ Filtrar temas:</h4>
        <ul class="categories">
          <?php
          $generos = get_terms(array(
            'taxonomy' => 'category_generos',
            'hide_empty' => false,
          ));

          if (!empty($generos) && !is_wp_error($generos)) {
            echo '<li><a href="' . get_post_type_archive_link('post') . '" class="category">Todas</a></li>';
            foreach($generos as $genero) {
              echo '<li><a href="' . get_term_link($genero) . '" class="category">' . $genero->name . '</a></li>';
            }
          }
          ?>
        </ul>
      </div>

      <div class="revista">
        <?php get_template_part( 'template-parts/blocks/revista' ); ?>
      </div>

      <div class="histórico block-accordion">
        <h4>→ Postagens por mês:</h4>
        <?php
        $args = array(
          'type' => 'monthly',
          'limit' => '',
          'format' => 'html',
          'before' => '',
          'after' => '',
          'echo' => 0,
          'order' => 'DESC'
        );
        $archives = wp_get_archives($args);

        $years = array();
        if ($archives) {
          $archive_items = explode('</li>', $archives);
          foreach ($archive_items as $archive) {
            if (empty($archive)) continue;

            if (preg_match('|(\w+)\s+(\d{4})|', strip_tags($archive), $matches)) {
              $month = $matches[1];
              $year = $matches[2];
              $years[$year][] = array(
                'month' => $month,
                'link' => strip_tags($archive, '<a>')
              );
            }
          }
        }

        // Renderiza o acordeão de anos
        if (!empty($years)) {
          $contador = 0;
          echo '<ul class="lista-anos accordion" data-allow-toggle>';
          foreach ($years as $year => $months) {
            $contador++;
            echo '<li class="la-ano accordion-item">';
              echo
              '<h5 '.
                'id="accordion-' . $contador . '"'.
                'aria-expanded="false"'.
                'class="accordion-trigger"'.
                'aria-controls="' . $contador . '">'.
                  $year.
              '</h5>';
              echo
              '<ul '.
              'id="' . $contador . '"'.
              'class="lista-meses accordion-panel"'.
              'role="region"'.
              'aria-labelledby="accordion-' . $contador . '"'.
              'hidden=""'.
              '>';
              foreach ($months as $month_data) {
                echo '<li class="lm-mes">' . $month_data['link'] . '</li>';
              }
              echo '</ul>';
            echo '</li>';
          }
          echo '</ul>';
        }
        ?>
      </div>


    </div>

  </section>

</main>

<?php get_footer();

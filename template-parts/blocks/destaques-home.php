<?php
/**
 * Bloco para destaques da home
 *
 * @package airclean
 */

namespace Air_Light;

$ppp = get_field('ppp');
$posts_destaque = get_posts([
    'meta_query' => [[
        'key' => 'destaque',
        'value' => '"home"',
        'compare' => 'LIKE',
    ]],
    'posts_per_page' => $ppp,
    'category__not_in' => [403],
]);

if ($posts_destaque) {
    global $post;
    ?>

    <div id="publicacoes-em-destaque" class="publicacoes">
        <div class="titulo">
            <h2 id="destaque-home">→ Publicações em destaque</h2>
            <a href="<?php echo esc_url(home_url('/se-liga-na-leitura')); ?>" class="ver-todas">Ver todas</a>
        </div>

<<<<<<< HEAD
        <div class="grid-container">
            <?php
            $contador = 0;
            foreach ($posts_destaque as $post) {
                setup_postdata($post);
                $contador++;
                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('post-destaque item-' . $contador); ?>>
                    <div class="thumbnail">
                        <?php if (has_post_thumbnail()) {
                            the_post_thumbnail('destaque-home', [
                                'class' => 'img-thumbnail',
                                'loading' => 'lazy',
                                'fetchpriority' => 'low'
                            ]);
                        } ?>
                        <?php if (has_category()) : ?>
                            <ul class="categories">
                                <?php
                                $categories = wp_get_post_categories(get_the_id(), ['fields' => 'all']);
                                foreach ($categories as $category) {
                                    echo '<li>
                                    <a href="' . esc_url(get_category_link($category)) . '">' . esc_html($category->name) . '</a>
                                    </li>';
                                }
                                ?>
                            </ul>
                        <?php endif; ?>
                        <h3 class="title">
                            <a href="<?php echo esc_url(get_the_permalink()); ?>">
                                <?php the_title(); ?>
                            </a>
                        </h3>
                        <div class="content">
                            <?php the_excerpt(); ?>
                        </div>
                        <p class="data-publicacao">
                            →  
                            <time datetime="<?php the_time( 'c' ); ?>">
                                <?php echo date_i18n('j \d\e M \d\e Y', get_the_time('U')); ?>
                            </time>
                        </p>
                    </div>
                </article>
                <?php
            }
            wp_reset_postdata();
            ?>
        </div>
    </div>

<?php } ?>
=======
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
>>>>>>> 0832efaf1570abc82f42f59944f62fb41ebd0a01

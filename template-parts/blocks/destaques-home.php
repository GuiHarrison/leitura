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

    <section id="publicacoes-em-destaque" class="publicacoes">
        <div class="titulo">
            <h2 id="destaque-home">→ Publicações em destaque</h2>
            <a href="<?php echo esc_url(home_url('/se-liga-na-leitura')); ?>" class="ver-todas">Ver todas</a>
        </div>

        <div class="grid-container grid">
            <?php
            $contador = 0;
            foreach ($posts_destaque as $post) {
                setup_postdata($post);
                $contador++;
                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('post-destaque item-' . $contador); ?>>
                <?php if (has_post_thumbnail() && $contador <= 2 ) { ?>
                  <div class="thumbnail">
                    <?php
                        the_post_thumbnail('destaque-home', [
                            'class' => 'img-thumbnail',
                            'loading' => 'lazy',
                            'fetchpriority' => 'low'
                        ]);
                        ?>
                  </div>
                <?php } ?>

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

                    <h3 class="<?php echo esc_attr( get_post_type() ); ?>-title title">
                      <a href="<?php echo esc_url( get_the_permalink() ); ?>" class="sublinhado-bonito">
                        <?php the_title(); ?>
                      </a>
                    </h3>

                    <div class="content"> <?php the_excerpt(); ?> </div>

                    <?php echo get_template_part( 'template-parts/snippets/data-publicacao' ); ?>
                  </div>
                </article>
                <?php
            }
            wp_reset_postdata();
            ?>
        </div>
    </section>

<?php } ?>

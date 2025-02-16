<?php
/**
 * Bloco para Colunas e Resenhas
 *
 * @package airclean
 */

namespace Air_Light;

$ppp = get_field('ppp');
$posts = get_posts(array(
    'posts_per_page' => $ppp,
    'category' => array(403), // 403 = Colunas e resenhas
));

if ($posts) {
    global $post;
    ?>

    <div id="colunas-e-resenhas" class="colunas-e-resenhas">
        <div class="section-header">
            <h2 class="section-title">→ Colunas e Resenhas</h2>
            <a href="<?php echo esc_url(home_url('/se-liga-na-leitura')); ?>" class="ver-todas">Ver todas</a>
        </div>

        <div class="resenhas-container">
            <?php foreach ($posts as $post) {
                setup_postdata($post);
                $autoria = get_field('autoria', get_the_id());
                $citacao = get_field('citacao', get_the_id());
                $usuario = get_the_author_meta('ID');
                ?>

                <article id="post-<?php the_ID(); ?>" class="resenha-item">
					<h3 class="resenha-title">
                        <a href="<?php echo esc_url(get_the_permalink()); ?>">
                            <?php the_title(); ?>
                        </a>
                    </h3>



                    <div class="resenha-thumbnail">
                        <?php the_post_thumbnail('resenha-p', array('loading' => 'lazy', 'fetchpriority' => 'low')); ?>
                    </div>



                    <h4 class="resenha-autor">
                        <a href="<?php echo esc_url(get_the_permalink()); ?>">
                            <?php echo esc_html($autoria); ?>
                        </a>
                    </h4>

                    <div class="autor-info">
                        <img src="<?php echo esc_url(get_avatar_url($usuario)); ?>" alt="Autor: <?php echo esc_html(get_the_author()); ?>" class="autor-foto">
                        <h5 class="autor-nome"><?php echo esc_html(get_the_author()); ?></h5>
                    </div>

                    <div class="resenha-citacao">
                        <span class="aspas">“</span>
                        <?php echo esc_html($citacao ? $citacao : wp_trim_words(get_the_excerpt(), 20, '[…]')); ?>
                        <span class="aspas">”</span>
                    </div>

                    <p class="resenha-data">
                        <time datetime="<?php the_time('c'); ?>">
                            <?php echo get_the_date(get_option('date_format')); ?>
                        </time>
                    </p>
                </article>

            <?php } ?>
        </div>
    </div>

    <?php wp_reset_postdata();
} ?>

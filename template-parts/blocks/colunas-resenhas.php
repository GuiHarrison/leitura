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

    <section id="colunas-e-resenhas" class="publicacoes colunas-e-resenhas">
      <div class="titulo">
          <h2 class="section-title">→ Colunas e Resenhas</h2>
          <a href="<?php echo esc_url(home_url('/category/colunas-e-resenhas')); ?>" class="ver-todas">Ver todas</a>
      </div>

      <div class="resenhas-container grid">
      <?php foreach ($posts as $post) {
        setup_postdata($post);
        $autoria = get_field('autoria', get_the_id());
        $citacao = get_field('citacao', get_the_id());
        $usuario = get_the_author_meta('ID');
        ?>

        <article id="post-<?php the_ID(); ?>" class="resenha-item">
          <div class="resenha-titulo">
            <h3 class="post-title">
              <a class="sublinhado-bonito" href="<?php echo esc_url(get_the_permalink()); ?>">
                <?php the_title(); ?>
              </a>
            </h3>
            <h4 class="resenha-autor">
              <a href="<?php echo esc_url(get_the_permalink()); ?>">
                <?php echo esc_html($autoria); ?>
              </a>
            </h4>
          </div>

          <div class="livro-thumbnail">
            <?php the_post_thumbnail('resenha-p', array('loading' => 'lazy', 'fetchpriority' => 'low')); ?>
          </div>

          <div class="autor-info">
            <img  class="aspas" src="<?php echo get_theme_file_uri('/img/aspas.svg'); ?>" >
            <img src="<?php echo esc_url(get_avatar_url($usuario)); ?>" alt="Autor: <?php echo esc_html(get_the_author()); ?>" class="autor-foto">
            <h5 class="autor-nome"><?php echo esc_html(get_the_author()); ?></h5>
          </div>

          <div class="resenha-citacao">
            <span class="aspas">“</span>
              <?php echo esc_html($citacao ? $citacao : wp_trim_words(get_the_excerpt(), 20, '[…]')); ?>
            <span class="aspas">”</span>
          </div>

          <div class="resenha-data">
            <?php echo get_template_part( 'template-parts/snippets/data-publicacao' ); ?>
          </div>
        </article>

      <?php } ?>
      </div>
    </section>

    <?php wp_reset_postdata();
} ?>

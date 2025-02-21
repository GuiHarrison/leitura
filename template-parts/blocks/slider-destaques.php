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
  'posts_per_page' => 9
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

if ($destaque_blog) {
  global $post;
?>
  <section id="destaques-blog" class="grid owl-carousel owl-theme sem-margem">

    <?php
    foreach ($destaque_blog as $post) {
      setup_postdata($post);
      $is_resenha = in_array(403, wp_get_post_categories(get_the_ID())); // 403 = Colunas e resenhas
      $autoria = '';
      $citacao = '';
      $usuario = '';
      $cor = '';
      if ($is_resenha) {
        $autoria = get_field('autoria', get_the_ID());
        $citacao = get_field('citacao', get_the_ID());
        $cor = get_field('fundo_do_livro', get_the_ID());
        $usuário = get_the_author_meta('ID');
        $foto = get_field('foto_usuario', 'user_' . $usuário);
        $foto = wp_get_attachment_image_src($foto, 'foto-perfil');
        $foto = $foto[0];
      }
    ?>

      <article id="post-<?php the_ID(); ?>" <?php post_class('block destaque-blog item'); ?>>
        <div <?php echo $is_resenha ? 'class="destaque thumbnail livro-thumbnail" style="background-color: ' . $cor . ';"' : 'class="destaque thumbnail"'; ?>>
          <?php
          if (has_post_thumbnail()) :
            $tamanho = $is_resenha ? 'resenha-g' : 'destaque-blog';
            the_post_thumbnail($tamanho);
          endif;
          ?>
        </div>

        <div <?php echo $is_resenha ? 'id="colunas-e-resenhas" class="detalhes-do-post resenha"' : 'class="detalhes-do-post"'; ?>>
          <?php if ($is_resenha) : ?>
            <div class="autor-info">
              <img class="aspas" src="<?php echo get_theme_file_uri('/img/aspas.svg'); ?>">
              <img src="<?php echo esc_url($foto); ?>" alt="Autor: <?php echo esc_html(get_the_author()); ?>" class="autor-foto">
              <h5 class="autor-nome"><?php echo esc_html(get_the_author()); ?></h5>
            </div>

            <div class="resenha-citacao">
              <span class="aspas">“</span>
              <?php echo esc_html($citacao ? $citacao : wp_trim_words(get_the_excerpt(), 20, '[…]')); ?>
              <span class="aspas">”</span>
            </div>

            <div class="resenha-link">
              <a href="<?php echo get_the_permalink(get_the_ID()) ?>">→ Ler resenha completa</a>
            </div>
          <?php else : ?>
            <?php if (has_category()) : ?>
              <ul class="categories">
                <?php foreach (wp_get_post_categories(get_the_id(), ['fields' => 'all']) as $category) : ?>
                  <li><a href="<?php echo esc_url(get_category_link($category)); ?>"><?php echo esc_html($category->name); ?></a></li>
                <?php endforeach; ?>
              </ul>
            <?php endif; ?>
            <h2 class="post-title">
              <a href="<?php echo esc_url(get_the_permalink()); ?>"><?php the_title(); ?></a>
            </h2>
            <div class="content"><?php the_excerpt(); ?></div>
            <p><time datetime="<?php the_time('c'); ?>"><?php echo get_the_date(); ?></time></p>
          <?php endif; ?>
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
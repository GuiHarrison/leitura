<?php

/**
 * Página de lista de posts do autor
 *
 *
 * @package leitura
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 */

namespace Air_Light;

get_header();
?>

<div class="site-main container">
  <section id="colunas-e-resenhas" class="publicacoes colunas-e-resenhas block-blog">
    <?php get_template_part('template-parts/blocks/colunas-resenhas'); ?>

    <div id="sidebar" class="sidebar">
      <?php get_sidebar(); ?>
    </div>

  </section>

  <aside class="grid cta-rodape">
    <?php get_template_part('template-parts/blocks/revista'); ?>
    <?php get_template_part('template-parts/blocks/cta-3-3'); ?>
  </aside>

</div>

<?php get_footer();

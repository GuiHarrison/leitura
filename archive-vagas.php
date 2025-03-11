<?php

/**
 * Página de listagem de vagas
 *
 * @package leitura
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 */

namespace Air_Light;

get_header();
?>

<div class="site-main container">
  <section id="queridinhos-da-leitura" class="publicacoes">
    <?php
    if (have_posts()) :
      echo '<ul>';
      while (have_posts()) :
        the_post();
        the_title('<li>', '</li>');
      endwhile;
      echo '</ul>';

      the_posts_pagination();
    endif;
    ?>
  </section>

  <aside class="grid cta-rodape">
    <?php get_template_part('template-parts/blocks/cta-3-3'); ?>
    <?php get_template_part('template-parts/blocks/revista'); ?>
  </aside>

  <?php get_template_part('template-parts/blocks/form-seliga'); ?>

</div>

<?php get_footer(); ?>

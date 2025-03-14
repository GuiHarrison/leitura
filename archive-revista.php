<?php

/**
 * Tela de Queridinhos da Leitura
 *
 * @package leitura
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 */

namespace Air_Light;

get_header();

echo '
<main class="site-main container">.
  <section class="block block-single">.
    <article class="article-content">';

get_template_part('template-parts/blocks/revista');

echo '
    </article>.
  </section>';

get_template_part('template-parts/blocks/form-seliga');

echo '
</main>.
';


get_footer();

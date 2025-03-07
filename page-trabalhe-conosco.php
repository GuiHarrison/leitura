<?php

/**
 * Página de trabalhe conosco
 *
 * @package leitura
 */

namespace Air_Light;

get_header(); ?>

<main class="site-main container">
  <?php
  the_content();
  air_edit_link();
  ?>
</main>

<?php get_footer(); ?>

<?php

/**
 * Template para página de banco de talentos
 *
 * @package leitura
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 */

namespace Air_Light;

the_post();

get_header(); ?>

<main class="site-main container main-vagas">
  <?php
  the_content();
  air_edit_link();
  ?>
</main>

<?php get_footer();

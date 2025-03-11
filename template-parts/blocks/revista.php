<?php

/**
 * Bloco de chamada para revista
 *
 * @package airclean
 */

namespace Air_Light;

$revistas = get_posts(array(
  'post_type' => 'revista',
  'posts_per_page' => 1,
));

if ($revistas) {
  global $post;
  foreach ($revistas as $post) {
    setup_postdata($post);

    $first_word = strtok(get_the_title(), ' ');
    $pdf = get_field('pdf', get_the_ID());

    echo
    '<div class="revista-container">' .
      '<div class="conteudo">' .
      '<h2 class="post-title"><a href="' . esc_url($pdf) . '">Explore as ofertas de ' . esc_html($first_word) . '</a></h2>' .
      '<a class="button com-seta-direita" href="' . esc_url($pdf) . '" target="_blank">Acessar revista</a>' .
      '</div>' .
      '<div class="thumbnail">' .
      get_the_post_thumbnail(get_the_ID(), 'revista') .
      '</div>' .
      '</div>';
  }
  wp_reset_postdata();
}

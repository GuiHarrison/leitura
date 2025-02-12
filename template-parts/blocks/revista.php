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

if ( $revistas ) {
  global $post;
  foreach ( $revistas as $revista ) {
    setup_postdata( $revista );

    $first_word = strtok(get_the_title( $revista ), ' ');
    echo '<div class="revista-container' . get_post_class( $revista ) . '">'.
    '<h3>Explore as ofertas de ' . esc_html( $first_word ) . '</h3>'.
    '</div>';
  }
}

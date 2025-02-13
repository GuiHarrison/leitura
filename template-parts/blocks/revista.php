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
  foreach ( $revistas as $post ) {
		setup_postdata( $post );

		$first_word = strtok( get_the_title(), ' ' );
    $pdf = get_field( 'pdf', get_the_ID() );

		echo '' .
    '<div class="revista-container">' .
      '<h3>Explore as ofertas de ' . esc_html( $first_word ) . '</h3>' .
      '<a class="button" src="' . esc_url( $pdf ) . '" target="_revista">Acessar revista</a>' .
      get_the_post_thumbnail( get_the_ID(), 'revista' ) .
		'</div>';
  }
}

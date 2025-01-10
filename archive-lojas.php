<?php
/**
 * Template Name: Lojas
 *
 * Página de arquivos do tipo loja
 *
 * @Date:   2025-01-03 16:54:35
 * @Last Modified by:   Guilherme Harrison
 * @Last Modified time: 2025-01-03 16:54:35
 *
 * @package leitura
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 */

namespace Air_Light;

get_header();

$api_keys = APIKeys::get_instance();
$geoapify = $api_keys->get_key( 'geoapify' );

$args = array(
  'post_type'      => 'loja',
  'posts_per_page' => -1,
  'post_status'    => 'publish',
  'orderby'        => 'date',
  'order'          => 'DESC',
);

$query = new \WP_Query( $args );

if ( $query->have_posts() ) :
  $locations = array();
  while ( $query->have_posts() ) : $query->the_post();
      // Obtém o campo personalizado 'mapa_loja'
      $mapa_loja = get_post_meta( get_the_ID(), 'mapa_loja', true );
      if ( $mapa_loja ) {
          $locations[] = $mapa_loja;
      }
  endwhile;
  wp_reset_postdata();
endif;

?>

<script>
	var requestOptions = {
		method: 'GET',
	};

	fetch("https://api.geoapify.com/v1/ipinfo?apiKey=<?php echo esc_js( $geoapify ); ?>", requestOptions)
	.then(response => response.json())
	.then(result => console.log(result))
	.catch(error => console.log('error', error));
</script>

<main class="site-main">
	<h1><?php the_title(); ?></h1>



	<div class="loja-container">
		<div class="loja-mapa">
			<div id="map"></div>
		</div>
	</div>

</main>

<?php get_footer();

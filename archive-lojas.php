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
  'post_type'      => 'lojas',
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
    .then(result => {
        console.log(result);
        var latDetec = result.location.latitude || -14.235004; // Latitude padrão do Brasil
        var longDetec = result.location.longitude || -51.92528; // Longitude padrão do Brasil
        var zoom = (latDetec === -14.235004) ? 6 : 13;

        window.latDetec = latDetec;
        window.longDetec = longDetec;
        window.zoom = zoom;

        if (typeof initMap === 'function') {
            initMap();
        }
    })
    .catch(error => {
        console.log('error', error);
        // Coordenadas padrão do Brasil
        window.latDetec = -14.235004;
        window.longDetec = -51.92528;

        if (typeof initMap === 'function') {
            initMap();
        }
    });

    function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: zoom,
            center: {lat: window.latDetec, lng: window.longDetec}
        });

        var geocoder = new google.maps.Geocoder();
        var locations = <?php echo json_encode( $locations ); ?>;

        locations.forEach(function(location) {
            geocoder.geocode({'address': location['address']}, function(results, status) {
                if (status === 'OK') {
                    new google.maps.Marker({
                        map: map,
                        position: results[0].geometry.location
                    });
                }
            });
        });
    }
</script>

<main class="site-main">

	<div class="loja-container">
		<div class="loja-mapa">
			<div id="map" style="min-height: calc(100vh - 60px);">
      </div>
		</div>
	</div>

</main>

<?php get_footer();

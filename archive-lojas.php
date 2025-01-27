<?php
/**
 * Template Name: Lojas
 *
 * Página de arquivos do tipo loja
 *
 * @Date:                 2025-01-03 16:54:35
 * @Last Modified by:     Guilherme Harrison
 * @Last Modified time:   2025-01-03 16:54:35
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
  'orderby'        => 'name',
  'order'          => 'ASC',
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
    var map; // Declare a variável map no escopo global
    var markers = {};
    var requestOptions = {
        method: 'GET',
    };

    fetch("https://api.geoapify.com/v1/ipinfo?apiKey=<?php echo esc_js( $geoapify ); ?>", requestOptions)
    .then(response => response.json())
    .then(result => {
        var latDetec = result.location.latitude || -14.235004; // Latitude padrão do Brasil
        var longDetec = result.location.longitude || -51.92528; // Longitude padrão do Brasil
        var zoom = ( latDetec === -14.235004 ) ? 6 : 13;
        var offsetX = 0.03;

        window.latDetec = latDetec;
        window.longDetec = longDetec - offsetX;
        window.zoom = zoom;
        window.offsetX = offsetX;

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

    function lojaSelecionada(lojaId) {
        var marker = markers[lojaId];
        if (marker) {
          offsetX = 0.003;
          map.setZoom(zoom + 3);
          var center = marker.getPosition();
          var offsetCenter = {
              lat: center.lat(),
              lng: center.lng() - offsetX
          };
          map.setCenter(offsetCenter);

          jQuery('.ll-loja').removeClass('selected');
          jQuery('#' + lojaId).addClass('selected');

          jQuery('.ll-detalhes').addClass('hide-completely');
          jQuery('#' + lojaId + ' .ll-detalhes').removeClass('hide-completely');
        }
    }

    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), { // Inicialize a variável map
            zoom: window.zoom,
            center: {lat: window.latDetec, lng: window.longDetec},
            streetViewControl: false,
            mapTypeControl: false,
            mapfullscreenControl: false,
            fullscreenControl: false,
        });

        var geocoder = new google.maps.Geocoder();
        var locations = <?php echo json_encode( $locations ); ?>;
        var icon = {
            url: <?php echo '"' . esc_url( get_theme_file_uri( 'svg/icone-mapa.svg' ) ) . '"'; ?>,
            scaledSize: new google.maps.Size(36, 49),
        }

        // Buscar dados das lojas
        fetch( 'http://leitura.local/wp-json/wp/v2/lojas')
            .then(response => response.json())
            .then(data => {
                data.forEach(store => {
                    var location = {
                        id: store.id,
                        nome: store.title.rendered,
                        email: store.acf.email_loja,
                        telefone: store.acf.telefone_loja,
                        whatsapp: store.acf.wpp_loja,
                        informações: store.acf.infor_loja,
                        horário: store.acf.funcionamento_loja,
                        endereço: store.acf.mapa_loja.address,
                        lat: parseFloat(store.acf.mapa_loja.lat),
                        lng: parseFloat(store.acf.mapa_loja.lng),
                    };

                    // Adicionar marcadores ao mapa
                    var marker = new google.maps.Marker({
                        position: { lat: location.lat, lng: location.lng },
                        map: map,
                        icon: icon
                    });
                    markers[location.id] = marker;
                    google.maps.event.addListener(marker, 'click', function() {
                        lojaSelecionada(location.id);
                    });

                    // Adicionar loja à lista
                    jQuery('#ll-lista').append(`
                        <li class="ll-loja" id="${location.id}">
                          <h4 class="ll-nome" onclick="lojaSelecionada(${location.id})">${location.nome}</h4>
                          <p class="ll-endereco" onclick="lojaSelecionada(${location.id})">${location.endereço}</p>
                          <div class="ll-detalhes hide-completely">
                            <p class="ll-email">${location.email}</p>
                            <p class="ll-telefone">${location.telefone}</p>
                            <p class="ll-whatsapp">${location.whatsapp}</p>
                            <p class="ll-horario">${location.horário}</p>
                            <div class="ll-detalhes hide-completely">
                            <a target="_blank" href="https://www.google.com/maps?saddr=My+Location&daddr=${location.lat},${location.lng}" class="ll-como-chegar">Como chegar</a>
                            <button class="ll-fechar" onclick="zoomOut()"></button>
                          </div>
                          </div>
                        </li>
                    `);
                });
            })
        .catch(error => console.error('Erro ao buscar dados das lojas:', error));
    }

    function buscador_lojas() {
      document.getElementById('busca_lojas').addEventListener('keyup', function() {
          if (this.value.length > 3) {
              const termoLoja = this.value.toLowerCase();
              const $lista_loja = document.querySelectorAll('#ll-lista li');

              $lista_loja.forEach(function($storeItem) {
                  const storeName = $storeItem.textContent.toLowerCase();
                  $storeItem.style.display = storeName.includes(termoLoja) ? '' : 'none';
              });
          } else {
              const $lista_loja = document.querySelectorAll('#ll-lista li');
              $lista_loja.forEach(function($storeItem) {
                  $storeItem.style.display = '';
              });
              zoomOut();
          }
      });
    }

    function zoomOut() {
      jQuery('.ll-detalhes').addClass('hide-completely');
      jQuery('.ll-loja').removeClass('selected');
      map.setCenter({lat: window.latDetec, lng: window.longDetec});
      map.setZoom(zoom);
    }

    document.addEventListener('DOMContentLoaded', function() {
        buscador_lojas();
    });
</script>

<main class="site-main">

	<div class="loja-container">
		<div class="loja-mapa">
			<div id="map" style="min-height: calc(100vh - 100px);">
        <p id="carregando-mapa">Carregando mapa...</p>
      </div>
      <button id="zoom-out" onclick="zoomOut()">▣</button>
      <!-- Navegador de lojas -->
      <div class="lista-lojas-container">
        <div class="ll-spacer">
          <h3 class="ll-titulo">→ Encotre uma Leitura próxima de você</h3>
          <input type="text" id="busca_lojas" class="ll-campo" placeholder="Cidade, shopping, etc…">
          <ul id="ll-lista" class="ll-lista"></ul>
        </div>
      </div>
    </div>
	</div>

</main>

<?php get_footer();

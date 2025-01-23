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
        var zoom = ( latDetec === -14.235004 ) ? 6 : 13;

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

    function lojaSelecionada(lojaId) {
        var marker = markers[lojaId];
        if (marker) {
            map.setZoom(16);
            var center = marker.getPosition();
            var offsetX = 0.003;
            var offsetCenter = {
                lat: center.lat(),
                lng: center.lng() - offsetX
            };
            map.setCenter(offsetCenter);
            
            jQuery('.ll-loja').removeClass('selected');
            jQuery('#' + lojaId).addClass('selected');
            // openStoreInfo(store);
        }
    }

    var markers = {};
    function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: zoom,
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
                        email: store.acf.mapa_loja.email_loja,
                        telefone: store.acf.mapa_loja.telefone_loja,
                        whatsapp: store.acf.mapa_loja.wpp_loja,
                        informações: store.acf.mapa_loja.infor_loja,
                        horário: store.acf.mapa_loja.funcionamento_loja,
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
                    jQuery('.lista-lojas-container>.ll-lista').append(`
                        <li class="ll-loja" id="${location.id}" onclick="lojaSelecionada(${location.id})">${location.nome}</li>
                    `);

                    // Remover a chamada duplicada
                    // jQuery('.ll-loja').on('click', function() {
                    //     var lojaClicada = jQuery(this).attr('id');
                    //     lojaSelecionada(lojaClicada);
                    // });

                    // jQuery('.ll-loja')).forEach(function(element) {
                    //     var marker = markers[location.id];


                    //     element.addEventListener('click', function() {
                    //         jQuery('.ll-loja').removeClass('selected');
                    //         jQuery(this).addClass('selected');

                    //         selectStore(this[marker]);
                    //         map.setZoom(16);
                    //         map.setCenter(marker.getPosition());
                    //         // openStoreInfo(location.id);
                    //     });
                    // });
                });
            })
        .catch(error => console.error('Erro ao buscar dados das lojas:', error));
    }

    function openStoreInfo(store) {
        var info = `
            <h4 class="ll-nome">${store.title.rendered}</h4>
            <p class="ll-endereco">${store.acf.mapa_loja.address}</p>
            <div class="ll-detalhes">
                <p class="ll-horario">${store.acf.mapa_loja.funcionamento_loja}</p>
                <p class="ll-email">${store.acf.mapa_loja.email_loja}</p>
                <p class="ll-telefone">${store.acf.mapa_loja.telefone_loja}</p>
                <p class="ll-whatsapp">${store.acf.mapa_loja.wpp_loja}</p>
                <a href="${store.acf.mapa_loja.maps_link}" class="ll-como-chegar">Como chegar</a>
            </div>
        `;
        console.log(info);
        // jQuery('.lista-lojas-container>.ll-lista>.ll-loja').removeClass('selected');
        // jQuery('.lista-lojas-container>.ll-lista>.ll-loja').each(function() {
        //     if (jQuery(this).text() === store.title.rendered) {
        //         jQuery(this).addClass('selected');
        //     }
        // });
        // jQuery('.lista-lojas-container>.ll-lista').find('.ll-detalhes').addClass('hidden');
    }

        // locations.forEach(function(location) {
        //     geocoder.geocode({'address': location['address']}, function(results, status) {
        //       if (status === 'OK') {
        //         new google.maps.Marker({
        //                 map: map,
        //                 position: results[0].geometry.location,
        //                 icon: icon,
        //             });
        //         }
        //     });
        // });
</script>

<main class="site-main">

	<div class="loja-container">
		<div class="loja-mapa">
			<div id="map" style="min-height: calc(100vh - 100px);">
        <p id="carregando-mapa">Carregando mapa...</p>
      </div>
      <!-- Navegador de lojas -->
      <div class="lista-lojas-container">
          <h3 class="ll-titulo">Encotre uma Leitura próxima de você</h3>
          <input type="text" class="ll-campo"><button class="ll-buscar hidden">Procurar</button>
          <ul class="ll-lista">
              <!-- <li class="ll-loja">
                  <a href="#_" class="ll-link"></a>
                  <h4 class="ll-nome">Shopping Contagem</h4>
                  <p class="ll-endereco">Avenida Severino Ballesteros Rodrigues, 850 Cabral, Contagem - MG</p>
                  <div class="ll-detalhes hidden">
                      <p class="ll-horario">09h00 às 18h00</p>
                      <p class="ll-email">teste@teste</p>
                      <p class="ll-telefone">(31) 9999 9999</p>
                      <p class="ll-whatsapp">(31) 9 9999 9999</p>
                      <a href="$para-o-maps" class="ll-como-chegar">Como chegar</a>
                  </div>
              </li>
              <li class="ll-loja">
                  <a href="#_" class="ll-link"></a>
                  <h4 class="ll-nome">Shopping partage campina grande</h4>
                  <p class="ll-endereco">Avenida Prefeito Severino Bezerra Cabral Catolé, Campina Grande - PB</p>
                  <div class="ll-detalhes hidden">
                      <p class="ll-horario">09h00 às 18h00</p>
                      <p class="ll-email">teste@teste</p>
                      <p class="ll-telefone">(31) 9999 9999</p>
                      <p class="ll-whatsapp">(31) 9 9999 9999</p>
                      <a href="$para-o-maps" class="ll-como-chegar">Como chegar</a>
                  </div>
              </li>
              <li class="ll-loja">
                  <a href="#_" class="ll-link"></a>
                  <h4 class="ll-nome">Shopping Paralela</h4>
                  <p class="ll-endereco">Av. Luís Viana, 8544 - Alphaville, Salvador - BA</p>
                  <div class="ll-detalhes hidden">
                      <p class="ll-horario">09h00 às 18h00</p>
                      <p class="ll-email">teste@teste</p>
                      <p class="ll-telefone">(31) 9999 9999</p>
                      <p class="ll-whatsapp">(31) 9 9999 9999</p>
                      <a href="$para-o-maps" class="ll-como-chegar">Como chegar</a>
                  </div>
              </li>
              <li class="ll-loja">
                  <a href="#_" class="ll-link"></a>
                  <h4 class="ll-nome">IGUATEMI SÃO JOSÉ DO RIO PRETO</h4>
                  <p class="ll-endereco">Avenida Presidente Juscelino Kubitschek de Oliveira 5000</p>
                  <div class="ll-detalhes hidden">
                      <p class="ll-horario">09h00 às 18h00</p>
                      <p class="ll-email">teste@teste</p>
                      <p class="ll-telefone">(31) 9999 9999</p>
                      <p class="ll-whatsapp">(31) 9 9999 9999</p>
                      <a href="$para-o-maps" class="ll-como-chegar">Como chegar</a>
                  </div>
              </li> -->
          </ul>
      </div>
    </div>
	</div>

</main>

<?php get_footer();

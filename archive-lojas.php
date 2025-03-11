<?php

/**
 * Template Name: Lojas
 *
 * Página de arquivos do tipo loja
 *
 * @Date:								 2025-01-03 16:54:35
 * @Last Modified by:		 Guilherme Harrison
 * @Last Modified time:	 2025-02-25 14:23:30
 *
 * @package leitura
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 */

namespace Air_Light;

get_header();

$api_keys = APIKeys::get_instance();
$geoapify = $api_keys->get_key('geoapify');
?>

<script>
  // Testando se é celular.
  var isMobile; // Declare isMobile no escopo global

  function seCelular(e) {
    // Pega --width-max-mobile do CSS
    const widthMaxMobile = getComputedStyle(
      document.documentElement,
    ).getPropertyValue('--width-max-mobile');

    // Vamos ver se estamos em dimensões de celular
    isMobile = window.matchMedia(
      `(max-width: ${widthMaxMobile})`,
    ).matches;

    // Se as coisas não estão bem, saia
    if (isMobile) {
      return;
    }
  }
  // quando colocar esse código com módulos, importar seCelular assim:
  // import seCelular from './navigation/se-celular';
  seCelular();

  var map; // Declare a variável map no escopo global
  var markers = {};
  var requestOptions = {
    method: 'GET',
  };

  fetch("https://api.geoapify.com/v1/ipinfo?apiKey=<?php echo esc_js($geoapify); ?>", requestOptions)
    .then(response => response.json())
    .then(result => {
      var latDetec = result.location.latitude || -14.235004; // Latitude padrão do Brasil
      var longDetec = result.location.longitude || -51.92528; // Longitude padrão do Brasil
      var zoom = (latDetec === -14.235004) ? 6 : 14;

      if (isMobile) {
        offsetX = 0;
        offsetY = -0.006;
      } else {
        offsetX = 0.03;
        offsetY = 0;
      }

      window.latDetec = latDetec + offsetY;
      window.longDetec = longDetec - offsetX;
      window.zoom = zoom;
      window.offsetX = offsetX;
      window.offsetY = offsetY;

      if (typeof initMap === 'function') {
        initMap();
      }
    })
    .catch(error => {
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
      if (isMobile) {
        offsetY = 0;
      } else {
        offsetX = 0.003;
      }
      var center = marker.position;
      var offsetCenter = {
        lat: center.lat - offsetY,
        lng: center.lng - offsetX
      };
      map.setZoom(zoom + 3);
      map.setCenter(offsetCenter);

      jQuery('.ll-loja').removeClass('selected');
      jQuery('#' + lojaId).addClass('selected').removeClass('hide-completely');

      jQuery('.ll-detalhes').addClass('hide-completely');
      jQuery('#' + lojaId + ' .ll-detalhes').removeClass('hide-completely');

      setTimeout(() => {
        if (isMobile) {
          document.getElementById('colophon').scrollIntoView({
            behavior: 'smooth',
            block: 'end'
          });
        } else {
          document.getElementsByClassName('selected')[0].scrollIntoView({
            behavior: 'smooth',
            block: 'nearest'
          });
        }
      }, 200);
    }
  }

  function initMap() {
    map = new google.maps.Map(document.getElementById('map'), {
      zoom: window.zoom,
      center: {
        lat: window.latDetec,
        lng: window.longDetec
      },
      streetViewControl: false,
      mapTypeControl: false,
      mapfullscreenControl: false,
      fullscreenControl: false,
      mapId: '8e08a18cdd960c02'
    });

    var geocoder = new google.maps.Geocoder();
    var iconUrl = <?php echo '"' . esc_url(get_theme_file_uri('svg/icone-mapa.svg')) . '"'; ?>;

    // Buscar dados das lojas
    function fetchTodasLojas(page = 1, TodasLojas = []) {
      return fetch(`https://seliganaleitura.com.br/wp-json/wp/v2/lojas?per_page=100&page=${page}`)
        .then(response => response.json())
        .then(data => {
          if (data.length > 0) {
            TodasLojas = TodasLojas.concat(data);
            return fetchTodasLojas(page + 1, TodasLojas);
          } else {
            return TodasLojas;
          }
        });
    }

    // No futuro, preencher primeiro as lojas no estado identificado pelo campo `response.state.name` do geoapify, depois o restante.

    fetchTodasLojas().then(data => {
      data.sort((a, b) => b.acf.mapa_loja.lat - a.acf.mapa_loja.lat);

      data.forEach(store => {
        if (store.acf.mapa_loja) {
          var location = {
            id: store.id,
            nome: store.title.rendered || '',
            email: store.acf.email_loja || '',
            telefone: store.acf.telefone_loja || '',
            whatsapp: store.acf.wpp_loja || '',
            horário: store.acf.funcionamento_loja || '',
            endereço: store.acf.mapa_loja.address,
            informações: store.acf.infor_loja || '',
            lat: parseFloat(store.acf.mapa_loja.lat),
            lng: parseFloat(store.acf.mapa_loja.lng),
          };

          // Criar elemento de conteúdo do marcador
          var markerContent = document.createElement('div');
          var markerImage = document.createElement('img');
          markerImage.src = iconUrl;
          markerImage.style.width = '36px';
          markerImage.style.height = '49px';
          markerContent.appendChild(markerImage);

          // Adicionar marcadores ao mapa
          var marker = new google.maps.marker.AdvancedMarkerElement({
            position: {
              lat: location.lat,
              lng: location.lng
            },
            map: map,
            content: markerContent
          });
          markers[location.id] = marker;
          marker.addListener('click', function() {
            lojaSelecionada(location.id);
          });

          // Adicionar loja à lista
          jQuery('#ll-lista').append(`
							<li class="ll-loja ${isMobile ? 'hide-completely' : ''}" onclick="lojaSelecionada(${location.id})" id="${location.id}">
								<h4 class="ll-nome">${location.nome}</h4>
								<p class="ll-endereco">${location.endereço}</p>
								<div class="ll-detalhes hide-completely">
									${location.email ? `<p class="ll-email"><span>Email:</span> ${location.email}</p>` : ''}
									${location.telefone ? `<p class="ll-telefone"><span>Telefone:</span> ${location.telefone}</p>` : ''}
									${location.whatsapp ? `<p class="ll-whatsapp"><span>WhatsApp:</span> ${location.whatsapp}</p>` : ''}
									${location.horário ? `<p class="ll-horário"><span>Funcionamento:</span> ${location.horário}</p>` : ''}
									${location.informações ? `<p class="ll-informações"><span>Informações:</span> ${location.informações}</p>` : ''}
									<a target="_blank" href="https://www.google.com/maps?saddr=My+Location&daddr=${location.lat},${location.lng}" class="ll-como-chegar">Como chegar</a>
									<button class="ll-fechar" onclick="zoomOut()"></button>
								</div>
							</li>
            `);
        } else {
          console.log('Loja sem coordenadas:', store);
        }
      });
    }).catch(error => console.error('Erro ao buscar dados das lojas:', error));
  }

  function buscador_lojas() {
    document.getElementById('busca_lojas').addEventListener('keyup', function() {
      const termoLoja = this.value.toLowerCase();
      const ll = document.querySelectorAll('#ll-lista li');

      ll.forEach(function(loja) {
        const storeName = loja.textContent.toLowerCase();
        const match = storeName.includes(termoLoja);
        loja.classList.toggle('hide-completely', !match);
      });

      if (this.value.length <= 3) {
        ll.forEach(function(loja) {
          loja.classList.toggle('hide-completely', isMobile);
        });
        zoomOut();
      }
    });
  }

  function zoomOut() {
    var campo = document.getElementById('busca_lojas');
    jQuery('.ll-detalhes').addClass('hide-completely');
    jQuery('.ll-loja').removeClass('selected').toggleClass('hide-completely', isMobile);
    map.setCenter({
      lat: window.latDetec,
      lng: window.longDetec
    });
    map.setZoom(zoom);

    campo.focus();

    if (!e) var e = window.event;
    e.cancelBubble = true;
    if (e.stopPropagation) e.stopPropagation();
  }

  document.addEventListener('DOMContentLoaded', function() {
    buscador_lojas();
  });
</script>

<main class="site-main">

  <div id="loja-container">
    <div class="loja-mapa">
      <!-- Navegador de lojas -->
      <div class="lista-lojas-container">
        <div class="ll-spacer">
          <h3 class="ll-titulo">→ Encontre uma Leitura próxima de você</h3>
          <input type="text" id="busca_lojas" class="ll-campo" placeholder="Cidade, shopping, etc…">
          <ul id="ll-lista" class="ll-lista"></ul>
        </div>
      </div>
      <div id="map">
        <p id="carregando-mapa">Carregando mapa...</p>
      </div>
      <button id="zoom-out" onclick="zoomOut()">▣</button>
    </div>
  </div>

</main>

<?php get_footer();

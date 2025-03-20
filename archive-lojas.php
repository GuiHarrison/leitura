<?php

/**
 * Template Name: Lojas
 *
 * Página de arquivos do tipo loja
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
  // Declare variáveis globais no início
  var map;
  var markers = {};
  var isMobile;

  // Configurar localização padrão global
  window.latDetec = -14.235004;
  window.longDetec = -51.92528;
  window.offsetX = 0.03;
  window.offsetY = 0;
  window.zoom = 6;

  // Testando se é celular.
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

  var requestOptions = {
    method: 'GET',
  };

  fetch("https://api.geoapify.com/v1/ipinfo?apiKey=<?php echo esc_js($geoapify); ?>", requestOptions)
    .then(response => response.json())
    .then(result => {
      // Atualizar coordenadas com localização do usuário
      window.latDetec = result.location.latitude + (isMobile ? -0.006 : 0);
      window.longDetec = result.location.longitude - (isMobile ? 0 : 0);
      window.zoom = 14;

      // Atualizar mapa se já estiver inicializado
      if (map) {
        map.setCenter({
          lat: window.latDetec,
          lng: window.longDetec
        });
        map.setZoom(window.zoom);
      }
    })
    .catch(error => console.error('Erro ao buscar localização:', error));

  function lojaSelecionada(lojaId) {
    var marker = markers[lojaId];
    if (marker) {
      if (isMobile) {
        offsetY = 0;
        offsetX = 0;
      } else {
        offsetX = 0.003;
      }
      var center = marker.position;
      var offsetCenter = {
        lat: center.lat - offsetY,
        lng: center.lng - offsetX
      };
      map.setZoom(16);
      map.setCenter(offsetCenter);

      jQuery('.ll-loja').removeClass('selected');
      jQuery('#' + lojaId).addClass('selected').removeClass('hide-completely');

      jQuery('.ll-detalhes').addClass('hide-completely');
      jQuery('#' + lojaId + ' .ll-detalhes').removeClass('hide-completely');

      setTimeout(() => {
        if (isMobile) {
          document.getElementById('map').scrollIntoView({
            behavior: 'smooth',
            block: 'start'
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

    // Buscar dados das lojas do cache do servidor
    const lojas = <?php echo json_encode(get_cached_lojas()); ?>;

    lojas.sort((a, b) => b.acf.mapa_loja.lat - a.acf.mapa_loja.lat);

    lojas.forEach(store => {
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
    rolaBusca();

    if (!e) var e = window.event;
    e.cancelBubble = true;
    if (e.stopPropagation) e.stopPropagation();
  }

  function rolaBusca() {
    document.getElementById('busca_lojas').addEventListener('focus', function() {
      this.scrollIntoView({
        behavior: 'smooth',
        block: 'start',
        inline: 'nearest'
      });
    });
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

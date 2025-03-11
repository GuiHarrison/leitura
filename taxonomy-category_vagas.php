<?php

/**
 * Página de lista de vagas
 *
 * @package leitura
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 */

namespace Air_Light;

get_header();

$current_term = get_queried_object();
$requisitos = get_field('requisitos', $current_term);
$diferenciais = get_field('diferenciais', $current_term);
$loja = get_field('loja', $current_term);

$api_keys = APIKeys::get_instance();
$geoapify = $api_keys->get_key('geoapify');

// Obter dados da loja
$location = [
  'nome' => $loja->post_title,
  'email' => get_field('email_loja', $loja->ID),
  'telefone' => get_field('telefone_loja', $loja->ID),
  'whatsapp' => get_field('wpp_loja', $loja->ID),
  'horario' => get_field('funcionamento_loja', $loja->ID),
  'informacoes' => get_field('infor_loja', $loja->ID),
  'mapa' => get_field('mapa_loja', $loja->ID)
];
?>

<script>
  // Adiciona callback ao objeto window
  window.initMap = function() {

    if (!google || !google.maps) {
      console.error('Google Maps não foi carregado corretamente');
      return;
    }

    const mapElement = document.getElementById('mapTC');
    if (!mapElement) {
      console.error('Elemento do mapa não encontrado');
      return;
    }

    const lat = parseFloat('<?php echo $location['mapa']['lat']; ?>');
    const lng = parseFloat('<?php echo $location['mapa']['lng']; ?>');

    if (isNaN(lat) || isNaN(lng)) {
      return;
    }

    try {
      const map = new google.maps.Map(mapElement, {
        zoom: 16,
        center: {
          lat,
          lng
        },
        streetViewControl: false,
        mapTypeControl: false,
        mapfullscreenControl: false,
        fullscreenControl: false,
        mapId: '8e08a18cdd960c02'
      });

      const iconUrl = <?php echo '"' . esc_url(get_theme_file_uri('svg/icone-mapa.svg')) . '"'; ?>;

      const markerContent = document.createElement('div');
      const markerImage = document.createElement('img');
      markerImage.src = iconUrl;
      markerImage.style.width = '36px';
      markerImage.style.height = '49px';
      markerContent.appendChild(markerImage);

      new google.maps.marker.AdvancedMarkerElement({
        position: {
          lat,
          lng
        },
        map: map,
        content: markerContent
      });

    } catch (error) {
      console.error('Erro ao inicializar mapa:', error);
    }
  }
</script>

<main class="site-main container">
  <section class="detalhes-da-vaga">
    <div class="vaga-info">
      <h2><?php echo esc_html($current_term->name); ?></h2>

      <div class="vaga-detalhes">
        <?php
        $description = $current_term->description;

        if ($requisitos || $diferenciais): ?>
          <?php if ($requisitos): ?>
            <div class="requisitos">
              <h4>Requisitos</h4>
              <p><?php echo wp_kses_post(wpautop($requisitos)); ?></p>
            </div>
          <?php endif; ?>

          <?php if ($diferenciais): ?>
            <div class="diferenciais">
              <h4>Diferenciais</h4>
              <p><?php echo wp_kses_post(wpautop($diferenciais)); ?></p>
            </div>
          <?php endif; ?>
        <?php elseif ($description): ?>
          <div class="descricao-vaga">
            <?php echo wp_kses_post(wpautop($description)); ?>
          </div>
        <?php endif; ?>
      </div>
    </div>

    <div class="loja-info">
      <div id="mapTC" style="height: 400px"></div>

      <div class="ll-detalhes">
        <?php if ($location['email']): ?>
          <p class="ll-email"><span>Email:</span> <?php echo esc_html($location['email']); ?></p>
        <?php endif; ?>
        <?php if ($location['telefone']): ?>
          <p class="ll-telefone"><span>Telefone:</span> <?php echo esc_html($location['telefone']); ?></p>
        <?php endif; ?>
        <?php if ($location['whatsapp']): ?>
          <p class="ll-whatsapp"><span>WhatsApp:</span> <?php echo esc_html($location['whatsapp']); ?></p>
        <?php endif; ?>
        <?php if ($location['horario']): ?>
          <p class="ll-horário"><span>Funcionamento:</span> <?php echo esc_html($location['horario']); ?></p>
        <?php endif; ?>
        <?php if ($location['informacoes']): ?>
          <p class="ll-informações"><span>Informações:</span> <?php echo esc_html($location['informacoes']); ?></p>
        <?php endif; ?>
      </div>
    </div>
  </section>
  <div class="formidable">
    <?php echo \FrmFormsController::get_form_shortcode(['id' => 3, 'title' => false, 'description' => false]); ?>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const lojaSelects = ['field_loja1', 'field_loja2', 'field_loja3'].map(id => document.getElementById(id));
      const cargoSelect = document.getElementById('field_cargo-de-interesse');

      // Obter parâmetros da URL
      const urlParams = new URLSearchParams(window.location.search);
      const lojaId = urlParams.get('loja');
      const cargoNome = urlParams.get('cargo')?.replace(/\+/g, ' ') || '';

      // Função para avançar o formulário
      function avancarFormulario() {
        const submitButton = document.querySelector('.frm_submit input[type="submit"]');
        if (submitButton) {
          submitButton.click();
        }
      }

      function atualizarOpcoes() {
        // Pegar valores selecionados
        const valoresSelecionados = lojaSelects
          .map(select => select.value)
          .filter(value => value !== '');

        // Para cada select
        lojaSelects.forEach(currentSelect => {
          // Pegar todas as options exceto a primeira (em branco)
          Array.from(currentSelect.options).slice(1).forEach(option => {
            // Desabilitar se o valor está selecionado em outro select
            const estaSelcionadoEmOutro = valoresSelecionados.includes(option.value) &&
              option.value !== currentSelect.value;

            option.disabled = estaSelcionadoEmOutro;
          });
        });
      }

      // Preencher campo da loja
      if (lojaId && lojaSelects[0]) {
        lojaSelects[0].value = lojaId;
      }

      // Preencher campo do cargo
      if (cargoNome && cargoSelect) {
        // Procurar a opção que corresponde ao cargo (case insensitive)
        Array.from(cargoSelect.options).forEach(option => {
          if (option.text.toLowerCase() === decodeURIComponent(cargoNome).toLowerCase()) {
            cargoSelect.value = option.value;

            // Se ambos os campos estão preenchidos, avançar o formulário
            if (lojaSelects[0].value) {
              // Pequeno delay para garantir que os campos foram preenchidos
              setTimeout(avancarFormulario, 500);
            }
          }
        });
      }

      // Adicionar evento de mudança para todos os selects
      lojaSelects.forEach(select => {
        select.addEventListener('change', atualizarOpcoes);
      });

      // Executar uma vez para configuração inicial
      atualizarOpcoes();
    });
  </script>
</main>

<?php get_footer(); ?>

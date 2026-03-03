<?php

/**
 * Bloco CTA 2/3
 *
 * @package airclean
 */

namespace Air_Light;

// Buscar campos da página de opções 'ctas'
$cta_data = get_field('cta-pagina', 'option');

if ($cta_data && $cta_data['cta_pagina_imagem_desktop'] && $cta_data['cta_pagina_link']) {
  $imagem_desktop = wp_get_attachment_image_src($cta_data['cta_pagina_imagem_desktop'], 'full');
  $imagem_celular = $cta_data['cta_pagina_imagem_celular'] ?
    wp_get_attachment_image_src($cta_data['cta_pagina_imagem_celular'], 'full') :
    false;

  if ($imagem_desktop) {
    $imagem_html =
      '<picture>' .
      ($imagem_celular ? '<source media="(max-width: 767px)" srcset="' . esc_url($imagem_celular[0]) . '">' : '') .
      '<img src="' . esc_url($imagem_desktop[0]) . '" alt="" class="cta-image">' .
      '</picture>';

    echo
    '<a href="' . esc_url($cta_data['cta_pagina_link']) . '" class="cta-link" rel="nofollow">' .
      $imagem_html .
      '</a>';
  }
}

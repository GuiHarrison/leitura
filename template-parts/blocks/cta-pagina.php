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
  $is_mobile = wp_is_mobile();
  $imagem_id = $is_mobile && $cta_data['cta_pagina_imagem_celular'] ?
    $cta_data['cta_pagina_imagem_celular'] :
    $cta_data['cta_pagina_imagem_desktop'];

  $imagem = wp_get_attachment_image_src($imagem_id, 'full');

  if ($imagem) {
    echo
    '<a href="' . esc_url($cta_data['cta_pagina_link']) . '" class="cta-link" rel="nofollow">' .
      '<img src="' . esc_url($imagem[0]) . '" alt="" class="cta-image">' .
      '</a>';
  }
}

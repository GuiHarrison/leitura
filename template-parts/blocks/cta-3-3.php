<?php

/**
 * Bloco CTA 3/3
 *
 * @package airclean
 */

namespace Air_Light;

$cta_data = get_field('cta-externo', 'option');

if ($cta_data && $cta_data['cta_externo_imagem_desktop'] && $cta_data['cta_externo_link']) {
  $is_mobile = wp_is_mobile();
  $cor = $cta_data['cta_externo_cor'];
  $imagem = $is_mobile && $cta_data['cta_externo_imagem_celular'] ?
    $cta_data['cta_externo_imagem_celular'] :
    $cta_data['cta_externo_imagem_desktop'];

  if ($imagem) {
    echo
    '<a href="' . esc_url($cta_data['cta_externo_link']) . '" class="cta-link" rel="nofollow" target="_blank" style="background-color: ' . $cor . '">' .
      '<img src="' . esc_url($imagem['url']) . '" alt="' . esc_html($imagem['alt']) . '" class="cta-image">' .
      '</a>';
  }
}

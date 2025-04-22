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

  if ($is_mobile && $cta_data['cta_externo_imagem_celular']) {
    $imagem_id = $cta_data['cta_externo_imagem_celular']['ID'];
    $imagem_url = wp_get_attachment_image_url($imagem_id, 'ctaCelular');
    $imagem_alt = $cta_data['cta_externo_imagem_celular']['alt'];
  } else {
    $imagem_id = $cta_data['cta_externo_imagem_desktop']['ID'];
    $imagem_url = wp_get_attachment_image_url($imagem_id, 'ctaDesktop');
    $imagem_alt = $cta_data['cta_externo_imagem_desktop']['alt'];
  }

  if ($imagem_url) {
    echo
    '<a href="' . esc_url($cta_data['cta_externo_link']) . '" class="cta-link" rel="nofollow" target="_blank" style="background-color: ' . $cor . '">' .
      '<img src="' . esc_url($imagem_url) . '" alt="' . esc_html($imagem_alt) . '" class="cta-image">' .
      '</a>';
  }
}

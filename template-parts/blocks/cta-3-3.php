<?php

/**
 * Bloco CTA 3/3
 *
 * @package airclean
 */

namespace Air_Light;

$cta_data = get_field('cta-externo', 'option');

if ($cta_data && $cta_data['cta_externo_imagem_desktop'] && $cta_data['cta_externo_link']) {
  $cor = $cta_data['cta_externo_cor'];
  $imagem_desktop_id = $cta_data['cta_externo_imagem_desktop']['ID'];
  $imagem_celular_id = $cta_data['cta_externo_imagem_celular'] ? $cta_data['cta_externo_imagem_celular']['ID'] : null;
  $imagem_desktop_url = wp_get_attachment_image_url($imagem_desktop_id, 'ctaDesktop');
  $imagem_celular_url = $imagem_celular_id ? wp_get_attachment_image_url($imagem_celular_id, 'ctaCelular') : false;
  $imagem_alt = $cta_data['cta_externo_imagem_desktop']['alt'];

  if ($imagem_desktop_url) {
    $imagem_html =
      '<picture>' .
      ($imagem_celular_url ? '<source media="(max-width: 767px)" srcset="' . esc_url($imagem_celular_url) . '">' : '') .
      '<img src="' . esc_url($imagem_desktop_url) . '" alt="' . esc_html($imagem_alt) . '" class="cta-image">' .
      '</picture>';

    echo
    '<a href="' . esc_url($cta_data['cta_externo_link']) . '" class="cta-link" rel="nofollow" target="_blank" style="background-color: ' . $cor . '">' .
      $imagem_html .
      '</a>';
  }
}

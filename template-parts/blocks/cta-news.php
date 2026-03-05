<?php

/**
 * Bloco CTA para newsletter
 *
 * @package airclean
 */

namespace Air_Light;

$cta_data = get_field('cta-news', 'option');

if ($cta_data && $cta_data['imagem_news_desktop'] && $cta_data['news_link']) {
  $cor = $cta_data['news_cor'];
  $imagem_desktop = $cta_data['imagem_news_desktop'];
  $imagem_celular = $cta_data['imagem_news_celular'];
  $imagem_desktop_url = !empty($imagem_desktop['url']) ? $imagem_desktop['url'] : wp_get_attachment_image_url($imagem_desktop['ID'], 'full');
  $imagem_celular_url = $imagem_celular ? (!empty($imagem_celular['url']) ? $imagem_celular['url'] : wp_get_attachment_image_url($imagem_celular['ID'], 'full')) : false;
  $imagem_alt = !empty($imagem_desktop['alt']) ? $imagem_desktop['alt'] : '';

  if ($imagem_desktop_url) {
    $imagem_html =
      '<picture>' .
      ($imagem_celular_url ? '<source media="(max-width: 767px)" srcset="' . esc_url($imagem_celular_url) . '">' : '') .
      '<img src="' . esc_url($imagem_desktop_url) . '" alt="' . esc_html($imagem_alt) . '" class="cta-image">' .
      '</picture>';

    echo
    '<a href="' . esc_url($cta_data['news_link']) . '" class="cta-link no-external-link-indicator" rel="nofollow" target="_blank" style="background-color: ' . $cor . '">' .
      $imagem_html .
      '</a>';
  }
}

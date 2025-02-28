<?php

/**
 * Bloco CTA para newsletter
 *
 * @package airclean
 */

namespace Air_Light;

$cta_data = get_field('cta-news', 'option');

if ($cta_data && $cta_data['imagem_news_desktop'] && $cta_data['news_link']) {
  $is_mobile = wp_is_mobile();
  $cor = $cta_data['news_cor'];
  $imagem = $is_mobile && $cta_data['imagem_news_celular'] ?
    $cta_data['imagem_news_celular'] :
    $cta_data['imagem_news_desktop'];

  if ($imagem) {
    echo
    '<a href="' . esc_url($cta_data['news_link']) . '" class="cta-link" rel="nofollow" target="_blank" style="background-color: ' . $cor . '">' .
      '<img src="' . esc_url($imagem['url']) . '" alt="' . esc_html($imagem['alt']) . '" class="cta-image">' .
      '</a>';
  }
}

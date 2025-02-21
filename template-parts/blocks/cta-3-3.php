<?php

/**
 * Bloco CTA 2/3
 *
 * @package airclean
 */

namespace Air_Light;

$imagem_desktop = get_field('imagem_desktop', 'option');
$imagem_celular = get_field('imagem_celular', 'option');
$link = get_field('link', 'option');

if ($imagem_desktop && $link) {
  $is_mobile = wp_is_mobile();
  $imagem = $is_mobile && $imagem_celular ? $imagem_celular : $imagem_desktop;
  if ($imagem) {
    echo
    '<a href="' . esc_url($link) . '" class="cta-link" rel="nofollow" target="_blank">' .
      '<img src="' . esc_url($imagem['url']) . '" alt="' . esc_html($imagem['alt']) . '" class="cta-image">' .
      '</a>';
  }
}

<?php
/**
 * Bloco CTA 2/3
 *
 * @package airclean
 */

namespace Air_Light;

$imagem_desktop = get_field('imagem_desktop');
$imagem_celular = get_field('imagem_celular');
$link = get_field('link');

if ($imagem_desktop && $link) {
    $is_mobile = wp_is_mobile();
    $imagem = $is_mobile && $imagem_celular ? $imagem_celular : $imagem_desktop;
    if ($imagem) {
      echo
      '<a href="' . esc_url($link) . '" class="cta-link" rel="nofollow">'.
        '<img src="' . esc_url($imagem['url']) . '" alt="' . esc_html($imagem['alt']) . '" class="cta-image">'.
      '</a>';
    }
}
?>

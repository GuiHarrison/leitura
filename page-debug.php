<?php

/**
 * Tela de Debug
 *
 * @package leitura
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 */

namespace Air_Light;

get_header();

echo '<h1>Opções de queridinhos</h1>';
$args = array(
  'post_type' => 'queridinhos',
  'posts_per_page' => -1,
);

$query = new \WP_Query($args);

if ($query->have_posts()) {
  while ($query->have_posts()) {
    $query->the_post();
    $queridinhos_fields = get_fields();
    if ($queridinhos_fields) {
      echo '<h2>' . get_the_title() . '</h2>';
      echo '<pre>';
      print_r($queridinhos_fields);
      echo '</pre>';
    }
  }
  wp_reset_postdata();
} else {
  echo 'No custom fields found for queridinhos.';
}


echo '<h1>Página de Opções</h1>';

$option_fields = get_fields('option');
if ($option_fields) {
  echo '<pre>';
  print_r($option_fields);
  echo '</pre>';
} else {
  echo 'No ACF option fields found.';
}

get_footer();

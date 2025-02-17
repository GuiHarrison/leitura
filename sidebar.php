<?php
/**
 * The sidebar containing the main widget area
 * Implement your custom sidebar to this file.
 *
 * @Date:   2019-10-15 12:30:02
 * @Last Modified by:   Timi Wahalahti
 * @Last Modified time: 2019-10-15 14:35:42
 *
 * @package leitura
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 */

namespace Air_Light;
?>

<div class="sidebar">

<div class="s-categorias">
  <h4>→ Explorar categorias:</h4>
    <a href="<?php echo esc_url( get_category_link( get_cat_ID( 'noticias' ) ) ); ?>" class="grandes-categorias button notícias">Notícias</a>
    <a href="<?php echo esc_url( get_category_link( get_cat_ID( 'resenhas' ) ) ); ?>" class="grandes-categorias button resenhas">Resenhas</a>
    <a href="<?php echo esc_url( get_category_link( get_cat_ID( 'colunas' ) ) ); ?>" class="grandes-categorias button colunas">Colunas</a>
    <a href="https://leitura.com.br/index.php?route=product/special" target="_ecommerce" class="grandes-categorias button ofertas">Ofertas</a>
</div>

<div class="s-filtrar">
  <h4>→ Filtrar temas:</h4>
  <ul class="categories">
    <?php
    $generos = get_terms(array(
      'taxonomy' => 'category_generos',
      'hide_empty' => false,
    ));

    if (!empty($generos) && !is_wp_error($generos)) {
      echo '<li><a href="' . get_post_type_archive_link('post') . '" class="category">Todas</a></li>';
      foreach($generos as $genero) {
        echo '<li><a href="' . get_term_link($genero) . '" class="category">' . $genero->name . '</a></li>';
      }
    }
    ?>
  </ul>
</div>

<div class="revista">
  <?php get_template_part( 'template-parts/blocks/revista' ); ?>
</div>

<div class="histórico block-accordion">
  <h4>→ Postagens por mês:</h4>
  <?php
  $args = array(
    'type' => 'monthly',
    'limit' => '',
    'format' => 'html',
    'before' => '',
    'after' => '',
    'echo' => 0,
    'order' => 'DESC'
  );
  $archives = wp_get_archives($args);

  $years = array();
  if ($archives) {
    $archive_items = explode('</li>', $archives);
    foreach ($archive_items as $archive) {
      if (empty($archive)) continue;

      if (preg_match('|(\w+)\s+(\d{4})|', strip_tags($archive), $matches)) {
        $month = $matches[1];
        $year = $matches[2];
        $years[$year][] = array(
          'month' => $month,
          'link' => strip_tags($archive, '<a>')
        );
      }
    }
  }

  // Renderiza o acordeão de anos
  if (!empty($years)) {
    $contador = 0;
    echo '<ul class="lista-anos accordion" data-allow-toggle>';
    foreach ($years as $year => $months) {
      $contador++;
      echo '<li class="la-ano accordion-item">';
        echo
        '<h5 '.
          'id="accordion-' . $contador . '"'.
          'aria-expanded="false"'.
          'class="accordion-trigger"'.
          'aria-controls="' . $contador . '">'.
            $year.
        '</h5>';
        echo
        '<ul '.
        'id="' . $contador . '"'.
        'class="lista-meses accordion-panel"'.
        'role="region"'.
        'aria-labelledby="accordion-' . $contador . '"'.
        'hidden=""'.
        '>';
        foreach ($months as $month_data) {
          echo '<li class="lm-mes">' . $month_data['link'] . '</li>';
        }
        echo '</ul>';
      echo '</li>';
    }
    echo '</ul>';
  }
  ?>
</div>
</div>

<?php

/*
if ( ! is_active_sidebar( 'sidebar-1' ) ) {
  return;
} ?>

<aside id="secondary" class="widget-area">
  <?php dynamic_sidebar( 'sidebar-1' ); ?>
</aside><!-- #secondary -->
 */

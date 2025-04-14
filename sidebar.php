<?php

/**
 * The sidebar containing the main widget area
 * Implement your custom sidebar to this file.
 *
 * @package leitura
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 */

namespace Air_Light;
?>

<?php if (get_queried_object() && (
  get_queried_object()->slug === 'portal-de-conteudos' ||
  is_tax('category_generos', 'portal-de-conteudos') ||
  is_tax('category_generos', get_queried_object()->slug)
)) : ?>
  <div class="s-filtrar">
    <h4>→ Filtrar gêneros:</h4>
    <ul class="categories">
      <?php
      $generos = get_terms(array(
        'taxonomy' => 'category_generos',
        'hide_empty' => false,
      ));

      if (!empty($generos) && !is_wp_error($generos)) {
        $current_term = get_queried_object();
        echo '<li><a href="' . get_post_type_archive_link('post') . '" class="category">Todas</a></li>';
        foreach ($generos as $genero) {
          $current_class = ($current_term && $current_term->term_id === $genero->term_id) ? ' current' : '';
          echo '<li><a href="' . get_term_link($genero) . '" class="category' . $current_class . '">' . $genero->name . '</a></li>';
        }
      }
      ?>
    </ul>
  </div>
<?php elseif (get_queried_object() && (get_queried_object()->slug === 'blog' || cat_is_ancestor_of(get_cat_ID('blog'), get_queried_object_id()))) : ?>
  <div class="s-filtrar">
    <h4>→ Filtrar categorias:</h4>
    <ul class="categories">
      <?php
      $blog_id = get_cat_ID('blog');
      $categories = get_categories(array(
        'child_of' => $blog_id,
        'hide_empty' => false,
      ));

      if (!empty($categories) && !is_wp_error($categories)) {
        echo '<li><a href="' . get_category_link($blog_id) . '" class="category">Todas</a></li>';
        foreach ($categories as $category) {
          echo '<li><a href="' . get_category_link($category->term_id) . '" class="category">' . $category->name . '</a></li>';
        }
      }
      ?>
    </ul>
  </div>
<?php endif; ?>

<?php if (get_queried_object() && (get_queried_object()->slug === 'blog' || cat_is_ancestor_of(get_cat_ID('blog'), get_queried_object_id())) || (is_date())) : ?>
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
        '<h5 ' .
          'id="accordion-' . $contador . '"' .
          'aria-expanded="false"' .
          'class="accordion-trigger"' .
          'aria-controls="' . $contador . '">' .
          $year .
          '</h5>';
        echo
        '<ul ' .
          'id="' . $contador . '"' .
          'class="lista-meses accordion-panel"' .
          'role="region"' .
          'aria-labelledby="accordion-' . $contador . '"' .
          'hidden=""' .
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
<?php endif; ?>

<div class="revista">
  <?php get_template_part('template-parts/blocks/revista'); ?>
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

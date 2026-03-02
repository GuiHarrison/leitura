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

<div class="s-filtrar">
  <ul class="categories">
    <?php
    $blog_id = get_cat_ID('blog');
    $categories = get_categories(array(
      'child_of' => $blog_id,
      'hide_empty' => false,
      'exclude' => get_cat_ID('uncategorized'),
      'orderby' => 'name',
    ));

    $current_curadoria = get_current_curadoria_slug();
    $current_category = get_current_category_id();

    // Link "Todas" com a curadoria atual se houver
    $todas_url = home_url('/blog/');
    if ($current_curadoria) {
      $todas_url = add_query_arg('curadoria', $current_curadoria, $todas_url);
    }
    echo '<li><a href="' . $todas_url . '" class="category fundo-azul">Todas</a></li>';

    foreach ($categories as $category) {
      $category_url = build_filter_url($category->term_id, $current_curadoria);
      $current_class = ($current_category && $current_category == $category->term_id) ? ' current' : '';
      echo '<li><a href="' . $category_url . '" class="category fundo-azul' . $current_class . '">' . $category->name . '</a></li>';
    }
    ?>
  </ul>
</div>


<div class="s-filtrar">
  <ul class="categories">
    <?php
    $curadorias = get_terms(array(
      'taxonomy' => 'category_curadoria',
      'hide_empty' => true,
    ));

    if (!empty($curadorias) && !is_wp_error($curadorias)) {
      $current_category = get_current_category_id();
      $current_curadoria = get_current_curadoria_slug();

      // Link "Todas" com a categoria atual se houver
      $todas_url = home_url('/blog/');
      if ($current_category) {
        $todas_url = add_query_arg('cat', $current_category, $todas_url);
      }
      echo '<li><a href="' . $todas_url . '" class="category">Todas</a></li>';

      foreach ($curadorias as $curadoria) {
        $curadoria_url = build_filter_url($current_category, $curadoria->slug);
        $current_class = ($current_curadoria && $current_curadoria === $curadoria->slug) ? ' current' : '';
        echo '<li><a href="' . $curadoria_url . '" class="category' . $current_class . '">' . $curadoria->name . '</a></li>';
      }
    }
    ?>
  </ul>
</div>


<?php if (is_date()) : ?>
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

<!-- <div class="revista">
  <?php get_template_part('template-parts/blocks/revista'); ?>
</div> -->

<?php

/*
if ( ! is_active_sidebar( 'sidebar-1' ) ) {
  return;
} ?>

<aside id="secondary" class="widget-area">
  <?php dynamic_sidebar( 'sidebar-1' ); ?>
</aside><!-- #secondary -->
 */

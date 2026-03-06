<?php

/**
 * The sidebar containing the main widget area
 * Implement your custom sidebar to this file.
 *
 * @package leitura
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 */

namespace Air_Light;

$sidebar_toggle_id = wp_unique_id('sidebar-mobile-trigger-');
$sidebar_panel_id = wp_unique_id('sidebar-mobile-panel-');
?>

<div class="sidebar-mobile-accordion accordion" data-allow-toggle>
  <div class="sidebar-mobile-toggle">
    <button
      type="button"
      id="<?php echo esc_attr($sidebar_toggle_id); ?>"
      class="sidebar-mobile-toggle-button accordion-trigger"
      aria-controls="<?php echo esc_attr($sidebar_panel_id); ?>"
      aria-expanded="false">
      Filtrar postagens
    </button>
  </div>

  <div
    id="<?php echo esc_attr($sidebar_panel_id); ?>"
    class="sidebar-mobile-panel accordion-panel"
    role="region"
    aria-labelledby="<?php echo esc_attr($sidebar_toggle_id); ?>">

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
        $request_path = trim((string) wp_parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH), '/');
        $is_todas_current = ($request_path === 'blog' || preg_match('#^curadoria(/.*)?$#', $request_path));

        // Link "Todas" com a curadoria atual se houver
        $todas_url = home_url('/blog/');
        if ($current_curadoria) {
          $todas_url = add_query_arg('curadoria', $current_curadoria, $todas_url);
        }
        echo '<li><a href="' . $todas_url . '" class="category fundo-azul' . ($is_todas_current ? ' current' : '') . '">Todas</a></li>';

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
          'hide_empty' => false,
        ));

        if (!empty($curadorias) && !is_wp_error($curadorias)) {
          $current_category = get_current_category_id();
          $current_curadoria = get_current_curadoria_slug();
          $request_path = trim((string) wp_parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH), '/');
          $has_curadoria_query = array_key_exists('curadoria', $_GET);
          $is_curadoria_path = (bool) preg_match('#^curadoria(/.*)?$#', $request_path);
          $is_todas_current = (!$is_curadoria_path && !$has_curadoria_query);

          // Link "Todas" com a categoria atual se houver
          $todas_url = home_url('/blog/');
          if ($current_category) {
            $todas_url = add_query_arg('cat', $current_category, $todas_url);
          }
          echo '<li><a href="' . $todas_url . '" class="category' . ($is_todas_current ? ' current' : '') . '">Todas</a></li>';

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

  </div>
</div>

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

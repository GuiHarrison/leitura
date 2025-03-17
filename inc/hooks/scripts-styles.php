<?php

/**
 * Enqueue and localize theme scripts and styles.
 *
 * @package leitura
 */

namespace Air_Light;

/**
 * Move jQuery to footer
 */
function move_jquery_into_footer($wp_scripts)
{
  if (! is_admin()) {
    $wp_scripts->add_data('jquery', 'group', 1);
    $wp_scripts->add_data('jquery-core', 'group', 1);
    $wp_scripts->add_data('jquery-migrate', 'group', 1);
  }
} // end air_light_move_jquery_into_footer

/**
 * Enqueue scripts and styles.
 */
function enqueue_theme_scripts(): void
{

  // Enqueue global.css
  wp_enqueue_style(
    'styles',
    get_theme_file_uri(get_asset_file('global.css')),
    [],
    filemtime(get_theme_file_path(get_asset_file('global.css')))
  );

  // Enqueue jquery and front-end.js
  wp_enqueue_script('jquery-core');

  // Enqueue DataTables CSS and JS only on vagas archive
  if (is_post_type_archive('vagas') || is_singular('vagas')) {
    // CSS files first
    wp_enqueue_style(
      'datatables-css',
      get_theme_file_uri('css/jquery.dataTables.css'),
      [],
      filemtime(get_theme_file_path('css/jquery.dataTables.css'))
    );

    wp_enqueue_style(
      'rh-css',
      get_theme_file_uri('css/rh.css'),
      [],
      filemtime(get_theme_file_path('css/rh.css'))
    );

    // 1. Moment.js primeiro
    wp_enqueue_script(
      'moment',
      'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js',
      ['jquery'],
      '2.8.4'
    );

    // 2. DataTables principal
    wp_enqueue_script(
      'datatables-js',
      get_theme_file_uri('js/src/modules/jquery.dataTables.js'),
      ['jquery', 'moment'],
      filemtime(get_theme_file_path('js/src/modules/jquery.dataTables.js'))
    );

    // 3. DateTime-moment plugin por último
    wp_enqueue_script(
      'datatables-datetime-moment',
      'https://cdn.datatables.net/plug-ins/1.10.12/sorting/datetime-moment.js',
      ['jquery', 'moment', 'datatables-js'],
      '1.10.12'
    );

    // Inicialização da tabela RH
    wp_enqueue_script(
      'rh-table-js',
      get_theme_file_uri('js/src/modules/rh-table.js'),
      ['jquery', 'moment', 'datatables-js', 'datatables-datetime-moment'],
      filemtime(get_theme_file_path('js/src/modules/rh-table.js'))
    );
  }

  wp_enqueue_script(
    'scripts',
    get_theme_file_uri(get_asset_file('front-end.js')),
    [],
    filemtime(get_theme_file_path(get_asset_file('front-end.js'))),
    true
  );

  // Adicionando API do Google Maps à página de Lojas
  if (is_page('lojas') || is_tax('category_vagas')) {
    $api_keys = APIKeys::get_instance();
    $maps_key = $api_keys->get_key('mapsDev');

    if ($api_keys) {
      wp_enqueue_script(
        'google-maps',
        'https://maps.googleapis.com/maps/api/js?key=' . $maps_key . '&libraries=places,marker&loading=async&callback=initMap',
        [],
        null,
        true
      );

      // Async e defer ao google-maps
      add_filter('script_loader_tag', function ($tag, $handle) {
        if ('google-maps' !== $handle) {
          return $tag;
        }
        return str_replace(' src', ' async defer src', $tag);
      }, 10, 2);
    }
  }

  // Required comment-reply script
  if (is_singular() && comments_open() && get_option('thread_comments')) {
    wp_enqueue_script('comment-reply');
  }

  // Tradução do menu
  wp_localize_script('scripts', 'air_light_screenReaderText', [
    'expand_for'      => 'Open child menu for',
    'collapse_for'    => 'Close child menu for',
    'expand_toggle'   => 'Abrir',
    'collapse_toggle' => 'Fechar',
    'external_link'   => 'External site',
    'target_blank'    => 'opens in a new window',
    'previous_slide'  => 'Previous slide',
    'next_slide'      => 'Next slide',
    'last_slide'      => 'Last slide',
    'skip_slider'     => 'Skip over the carousel element',
  ]);

  // Add domains/hosts to disable external link indicators
  wp_localize_script('scripts', 'air_light_externalLinkDomains', THEME_SETTINGS['external_link_domains_exclude']);
} // end air_light_scripts

/**
 * Returns the built asset filename and path depending on
 * current environment.
 *
 * @param string $filename File name with the extension
 * @return string file and path of the asset file
 */
function get_asset_file($filename)
{
  $env = 'development' === wp_get_environment_type() && ! isset($_GET['load_production_builds']) ? 'dev' : 'prod'; // phpcs:ignore WordPress.Security.NonceVerification.Recommended

  $filetype = pathinfo($filename)['extension'];

  return "{$filetype}/{$env}/{$filename}";
} // end get_asset_file

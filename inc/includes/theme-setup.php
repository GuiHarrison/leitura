<?php

/**
 * Theme setup and supports.
 *
 * @package leitura
 **/

namespace Air_Light;

function theme_setup()
{

  /**
   * Register menu locations
   */

  register_nav_menus(THEME_SETTINGS['menu_locations']);

  /**
   * Load textdomain.
   */
  load_theme_textdomain(THEME_SETTINGS['textdomain'], get_template_directory() . '/languages');

  /**
   * Define content width in articles
   */
  if (! isset($content_width)) {
    $content_width = THEME_SETTINGS['content_width'];
  }
}

/**
 * Build taxonomies
 */
function build_taxonomies()
{
  if (! is_array(THEME_SETTINGS['taxonomies']) || ! THEME_SETTINGS['taxonomies']) {
    return;
  }

  foreach (THEME_SETTINGS['taxonomies'] as $name => $post_types) {
    $slug = strtolower($name);

    $classname = __NAMESPACE__ . '\\' . $name;
    $file_path = get_theme_file_path('/inc/taxonomies/' . str_replace('_', '-', $slug) . '.php');

    if (! file_exists($file_path)) {
      return new \WP_Error('invalid-taxonomy', __('The taxonomy class file does not exist.', 'leitura'), $classname);
    }
    // Get the class file, only try to require if not already imported
    if (! class_exists($classname)) {
      require $file_path;
    }

    if (! class_exists($classname)) {
      return new \WP_Error('invalid-taxonomy', __('The taxonomy you attempting to create does not have a class to instance. Possible problems: your configuration does not match the class file name; the class file name does not exist.', 'leitura'), $classname);
    }

    $taxonomy_class = new $classname($slug);
    $taxonomy_class->register($post_types);
  }
}

/**
 * Build custom post types
 */
function build_post_types()
{
  if (! is_array(THEME_SETTINGS['post_types']) || ! THEME_SETTINGS['post_types']) {
    return;
  }

  foreach (THEME_SETTINGS['post_types'] as $name) {
    $slug = strtolower($name);

    $classname = __NAMESPACE__ . '\\' . $name;
    $file_path = get_theme_file_path('/inc/post-types/' . str_replace('_', '-', $slug) . '.php');

    if (! file_exists($file_path)) {
      return new \WP_Error('invalid-cpt', __('The custom post type class file does not exist.', 'leitura'), $classname);
    }
    // Get the class file, only try to require if not already imported
    if (! class_exists($classname)) {
      require $file_path;
    }

    if (! class_exists($classname)) {
      return new \WP_Error('invalid-cpt', __('The custom post type you attempting to create does not have a class to instance. Possible problems: your configuration does not match the class file name; the class file name does not exist.', 'leitura'), $classname);
    }

    $post_type_class = new $classname($slug);
    $post_type_class->register();
  }
}

/**
 * Rebuild taxonomies
 */
function rebuild_taxonomies()
{
  if (! is_array(THEME_SETTINGS['taxonomies']) || ! THEME_SETTINGS['taxonomies']) {
    return;
  }

  foreach (THEME_SETTINGS['taxonomies'] as $name => $post_types) {
    $slug = strtolower($name);

    unregister_taxonomy($slug);
  }

  build_taxonomies();
}

/**
 * Rebuild custom post types
 */
function rebuild_post_types()
{
  if (! is_array(THEME_SETTINGS['post_types']) || ! THEME_SETTINGS['post_types']) {
    return;
  }

  foreach (THEME_SETTINGS['post_types'] as $name) {
    $slug = strtolower($name);

    unregister_post_type($slug);
  }

  build_post_types();
}


/**
 * Build theme support
 */
function build_theme_support()
{
  add_theme_support('automatic-feed-links');
  add_theme_support('title-tag');
  add_theme_support('post-thumbnails');
  add_theme_support('align-wide');
  add_theme_support('wp-block-styles');
  add_theme_support(
    'html5',
    [
      'search-form',
      'comment-form',
      'comment-list',
      'gallery',
      'caption',
      'script',
      'style',
    ]
  );
}

/**
 * API do Google Maps para o ACF
 */
function acf_maps_key()
{
  $api_keys = APIKeys::get_instance();
  $maps_key = $api_keys->get_key('maps');

  if ($maps_key) {
    acf_update_setting('google_api_key', $maps_key);
  }
}

/**
 * Adicionando tamanhos de arquivos
 */
function tamanhos_de_imagens()
{
  add_image_size('post', 800, 640, true);
  add_image_size('destaque-home', 346, 346, true);
  add_image_size('destaque-blog', 532, 532, true);
  add_image_size('revista', 250, 356, true);
  add_image_size('resenha-g', 193, 300, true);
  add_image_size('resenha-p', 130, 203, true);
  add_image_size('foto-perfil', 172, 172);
}

/**
 * Pegar estados do endereço do maps
 */
function endereco_para_estado_curto($string)
{
  if (preg_match('/(\w{2}),(?=[^,]*$)/', $string, $matches)) {
    return $matches[1];
  }
  return '';
}

/**
 * Alterando o tamanho do excerpt
 */
function tamanho_do_excerpt($tamanho)
{
  return 20;
}

/**
 * Modifica a quantidade de posts por página nas páginas de categoria
 */
function ppp_categorias($query)
{
  if (!is_admin() && !$query->is_category(403) && $query->is_category() && $query->is_main_query()) {
    $query->set('posts_per_page', 8);
  }
}


/*
 * Filtrar resultados da busca para excluir posts do tipo 'lojas'
 */
function excluir_lojas_da_busca($query)
{
  if (!is_admin() && $query->is_main_query() && $query->is_search()) {
    $post_types = get_post_types(array('public' => true), 'names');
    unset($post_types['lojas']); // Remove 'lojas' do array de post types
    $query->set('post_type', array_values($post_types));
  }
  return $query;
}

/**
 * Popula os campos de loja do formulário Formidable
 */
function popula_campos_com_lojas($field)
{
  $loja_field_ids = [136, 153, 154];

  if (in_array($field['id'], $loja_field_ids)) {
    $lojas = get_transient('lista_de_lojas');

    if (false === $lojas) {
      $args = [
        'post_type' => 'lojas',
        'posts_per_page' => -1,
        'orderby' => 'title',
        'order' => 'ASC',
      ];

      $lojas_query = new \WP_Query($args);
      $field['options'] = [
        ['label' => '', 'value' => ''] // Opção vazia
      ];

      if ($lojas_query->have_posts()) {
        while ($lojas_query->have_posts()) {
          $lojas_query->the_post();
          $field['options'][] = [
            'label' => get_the_title(),
            'value' => get_the_ID()
          ];
        }
      }
      wp_reset_postdata();

      set_transient('lista_de_lojas', $field['options'], 12 * HOUR_IN_SECONDS);
    } else {
      $field['options'] = $lojas;
    }
  }

  return $field;
}

// Limpa o cache quando uma loja é atualizada
function clear_lojas_cache($post_id, $post)
{
  if ($post->post_type === 'lojas') {
    delete_transient('lista_de_lojas'); // Atualizando o nome do transiente
  }
}

// Depurando a validação do CPF
function validate_cpf_field($errors, $field, $value)
{
  if ($field->id == 92) { // ID do campo CPF

    global $wpdb;
    $cpf_exists = $wpdb->get_var($wpdb->prepare(
      "SELECT COUNT(*) FROM wp_postmeta WHERE meta_key = 'cpf_rh' and meta_value = %s",
      $value
    ));

    if ($cpf_exists) {
      $errors['field' . $field->id] = 'Você já possui um cadastro no banco de dados da Leitura. Conforme a nossa demanda entraremos em contato para convidá-lo para um processo seletivo.';
    }
  }
  return $errors;
}

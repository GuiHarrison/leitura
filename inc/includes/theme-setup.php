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

  // Carregar a classe base primeiro - não funcionou.
  // require_once get_theme_file_path('/inc/post-types/base-post-type.php');

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
  $maps_key = (strpos($_SERVER['REMOTE_ADDR'], '192.168') === 0 ||
    $_SERVER['REMOTE_ADDR'] === '127.0.0.1')
    ? $api_keys->get_key('mapsDev')
    : $api_keys->get_key('maps');

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
    $query->set('post_type', array_diff(get_post_types(['public' => true]), ['lojas', 'vagas']));
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

/**
 * Valida o CPF no formulário
 */
function validate_cpf_field($errors, $field, $value)
{
  if ($field->id == 92) { // ID do campo CPF

    global $wpdb;
    $cpf_exists = $wpdb->get_var($wpdb->prepare(
      "SELECT cpf FROM wp_cpf WHERE CPF = %s limit 1",
      $value
    ));

    if ($cpf_exists) {
      $errors['field' . $field->id] = 'CPF já cadastrado';
    }
  }
  return $errors;
}


/**
 * Colocando CPFs na tabela de checagem
 */

function leva_CPF($post_id)
{
  if (get_post_type($post_id) == 'vagas') {
    global $wpdb;

    // Trunca a tabela wp_cpf
    $wpdb->query("TRUNCATE TABLE {$wpdb->prefix}wp_cpf");

    // Insere os dados na tabela wp_cpf
    $wpdb->query("
          INSERT INTO {$wpdb->prefix}cpf (post_id, CPF)
          SELECT pm.post_id, pm.meta_value
          FROM {$wpdb->prefix}postmeta pm
          WHERE pm.meta_key = 'cpf_rh'
          ON DUPLICATE KEY UPDATE CPF = VALUES(CPF)
      ");
  }
}

/**
 * Filtrar itens do menu
 */
function filtrar_itens_menu($antes, $args)
{
  $depois = $antes;
  if (!is_user_logged_in()) {
    // Busca LIs com qualquer id, mas que contenham 'apenas-logado' entre as classes.
    // [^"]* é qualquer coisa que não seja aspas.
    // /s é o modificador para que o . possa pegar também quebras de linha.
    $pattern = '/<li id="[^"]*" class="[^"]*apenas-logado[^"]*".*?<\/li>/s';

    // Fazer a substituição
    $depois = preg_replace($pattern, '', $antes);
  }
  return $depois;
}

/**
 * Cache de lojas
 */
// Funções para gerenciar o cache das lojas
function get_cached_lojas()
{
  $lojas_cache = get_transient('todas_lojas_cache');

  if ($lojas_cache === false) {
    $args = array(
      'post_type' => 'lojas',
      'posts_per_page' => -1,
      'orderby' => 'title',
      'order' => 'ASC'
    );

    $lojas = get_posts($args);
    $lojas_data = array();

    foreach ($lojas as $loja) {
      $acf = get_fields($loja->ID);
      if (!empty($acf['mapa_loja'])) {
        $lojas_data[] = array(
          'id' => $loja->ID,
          'title' => array('rendered' => get_the_title($loja)),
          'acf' => $acf
        );
      }
    }

    set_transient('todas_lojas_cache', $lojas_data, 24 * HOUR_IN_SECONDS);
    return $lojas_data;
  }

  return $lojas_cache;
}

/**
 * Cache de lojas
 */
function clear_lojas_cache($post_id)
{
  if (get_post_type($post_id) === 'lojas') {
    delete_transient('todas_lojas_cache');
    delete_transient('lista_de_lojas');
  }
}

/**
 * Adiciona um modal para informar que o CPF já está cadastrado
 */
function adicionar_modal_cpf()
{
  // Verifica se estamos em uma página que contém o formulário com campo CPF
  if (class_exists('FrmForm') && \FrmField::getOne(92)) {
    $modal = Modal::get_instance();

    // Adiciona o HTML do modal
    add_action('wp_footer', function () use ($modal) {
      echo $modal->render(
        'CPF já cadastrado',
        'Você já possui um cadastro no banco de dados da Leitura. Conforme a nossa demanda entraremos em contato para convidá-lo para um processo seletivo.'
      );
    }, 5);

    // Adiciona o JavaScript de detecção de erro
    add_action('wp_footer', function () {
?>
      <script>
        jQuery(document).ready(function($) {
          $(document).on('frmFormErrors', function(event, form, response) {
            if (response.errors && response.errors['92']) {
              if (typeof Modal !== 'undefined') {
                Modal.abrir();
              }
            }
          });
        });
      </script>
<?php
    }, 20);
  }
}

// Adicionar o hook
add_action('wp_enqueue_scripts', __NAMESPACE__ . '\adicionar_modal_cpf');

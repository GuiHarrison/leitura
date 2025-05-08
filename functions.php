<?php

/**
 * Gather all bits and pieces together.
 * If you end up having multiple post types, taxonomies,
 * hooks and functions - please split those to their
 * own files under /inc and just require here.
 *
 * @package leitura
 */

namespace Air_Light;

// use function PHPSTORM_META\map;

/**
 * The current version of the theme.
 */
define('AIR_LIGHT_VERSION', '1.0.5');

// We need to have some defaults as comments or empties so let's allow this:
// phpcs:disable Squiz.Commenting.InlineComment.SpacingBefore, WordPress.Arrays.ArrayDeclarationSpacing.SpaceInEmptyArray

/**
 * Theme settings
 */
add_action('after_setup_theme', function () {
  $theme_settings = [
    /**
     * Theme textdomain
     */
    'textdomain' => 'leitura',

    /**
     * Content width
     */
    'content_width' => 800,

    /**
     * Logo and featured image
     */
    'default_featured_image'  => null,
    'logo'                    => '/svg/logo-azul.svg',
    'logo-simbolo-preta'      => '/svg/logo-simbolo-preta.svg',
    'logo-simbolo-branca'     => '/svg/logo-simbolo-branca.svg',

    /**
     * Social media links
     */
    'Instagram'               => '/svg/s-Instagram.svg',
    'WhatsApp'                => '/svg/s-WhatsApp.svg',
    'TikTok'                  => '/svg/s-TikTok.svg',
    'LinkedIn'                => '/svg/s-LinkedIn.svg',
    'Facebook'                => '/svg/s-Facebook.svg',
    'Youtube'                 => '/svg/s-Youtube.svg',

    /**
     * Custom setting group settings when using Air setting groups plugin.
     * On multilingual sites using Polylang, translations are handled automatically.
     */
    'custom_settings' => [
      // 'your-custom-setting' => [
      //   'id' => Your custom setting post id,
      //   'title' => 'Your custom setting',
      //   'block-editor' => true,
      //  ],
    ],

    'social_media_accounts'  => [
      // 'twitter' => [
      //   'title' => 'Twitter',
      //   'url'   => 'https://twitter.com/digitoimistodude',
      // ],
    ],

    /**
     * All links are checked with JS, if those direct to external site and if,
     * indicator of that is included. Exclude domains from that check in this array.
     */
    'external_link_domains_exclude' => [
      'seliganaleitura.com.br',
      'leitura.com.br',
    ],

    /**
     * Menu locations
     */
    'menu_locations' => [
      'primary' => __('Primary Menu', 'leitura'),
      'informacoes' => __('Informações', 'leitura'),
      'servicos_ao_cliente' => __('Serviços ao cliente', 'leitura'),
    ],

    /**
     * Taxonomies
     *
     * See the instructions:
     * https://github.com/digitoimistodude/air-light#custom-taxonomies
     */
    'taxonomies' => [
      // 'Your_Taxonomy' => [ 'post', 'page' ],
      'Category_Cidade_Estado' => ['lojas', 'eventos'],
      'Category_Generos' => ['post', 'queridinhos'],
      'Category_Vagas' => ['lojas', 'sistema-rh'],
    ],

    /**
     * Post types
     *
     * See the instructions:
     * https://github.com/digitoimistodude/air-light#custom-post-types
     */
    'post_types' => [
      'lojas',
      // 'eventos',
      'revista',
      'queridinhos',
      'vagas',
    ],

    /**
     * Gutenberg -related settings
     */
    // Register custom ACF Blocks
    'acf_blocks' => [
      [
        'name'           => 'hero',
        'title'          => 'Hero',
        // Icon defaults to svg file inside svg/block-icons named after the block name,
        // eg. svg/block-icons/block-file-slug.svg
        //
        // Icon setting defines the dashicon equivalent: https://developer.wordpress.org/resource/dashicons/#block-default
        // 'icon'  => 'block-default',
      ],
      [
        'name'           => 'slider',
        'title'          => 'Slider',
        'icon'           => 'interactive',
      ],
      [
        'name'           => 'cta-3-3',
        'title'          => 'CTA site externo',
        'supports'       => [
          'customClassName' => true,
          'align'          => true,
          'spacing'        => true,
          'anchor'         => true,
          'jsx'            => true,
          'blockGap'       => true,
          'dimensions'     => true,
          'grid'           => [
            'columnCount' => true,
            'columnSpan'  => true
          ]
        ],
        'icon'           => 'tickets',
      ],
      [
        'name'           => 'cta-news',
        'title'          => 'CTA Newsletter',
        'supports'       => [
          'customClassName' => true,
          'align'          => true,
          'spacing'        => true,
          'anchor'         => true,
          'jsx'            => true,
          'blockGap'       => true,
          'dimensions'     => true,
          'grid'           => [
            'columnCount' => true,
            'columnSpan'  => true
          ]
        ],
        'icon'           => 'email',
      ],
      [
        'name'           => 'cta-pagina',
        'title'          => 'CTA Página interna',
        'supports'       => [
          'customClassName' => true,
          'align'          => true,
          'spacing'        => true,
          'anchor'         => true,
          'jsx'            => true,
          'blockGap'       => true,
          'dimensions'     => true,
          'grid'           => [
            'columnCount' => true,
            'columnSpan'  => true
          ]
        ],
        'icon'           => 'tickets',
      ],
      [
        'name'           => 'revista',
        'title'          => 'Chamada para revista',
        'supports'       => [
          'customClassName' => true,
          'align'           => 'left',
        ],
        'icon'           => 'text-page',
      ],
      [
        'name'           => 'destaques-home',
        'title'          => 'Destaques Home',
        'icon'           => 'excerpt-view',
      ],
      [
        'name'           => 'mais-lidos',
        'title'          => 'Mais lidos',
        'icon'           => 'excerpt-view',
      ],
      [
        'name'           => 'mais-recentes',
        'title'          => 'Mais Recentes',
        'icon'           => 'excerpt-view',
      ],
      [
        'name'           => 'colunas-resenhas',
        'title'          => 'Colunas & Resenhas',
        'icon'           => 'excerpt-view',
      ],
      [
        'name'           => 'queridinhos-da-leitura',
        'title'          => 'Queridinhos da Leitura',
        'icon'           => 'excerpt-view',
      ],
      [
        'name'           => 'slider-queridinhos',
        'title'          => 'Slider de Queridinhos da Leitura',
        'icon'           => 'interactive',
      ],
      [
        'name'           => 'form-seliga',
        'title'          => 'Formulário Se liga na Leitura',
        'icon'           => 'tickets',
      ],
      [
        'name'           => 'post-livro',
        'title'          => 'Descrição de livro',
        'supports'       => [
          'customClassName' => true,
          'align'          => true,
          'spacing'        => true,
          'anchor'         => true,
          'jsx'            => true,
          'blockGap'       => true,
          'dimensions'     => true,
          'grid'           => [
            'columnCount' => true,
            'columnSpan'  => true
          ]
        ],
        'icon'           => 'book-alt',
      ],
    ],

    // Custom ACF block default settings
    'acf_block_defaults' => [
      'category'          => 'leitura',
      'mode'              => 'auto',
      'align'             => 'full',
      'post_types'        => [
        'page',
        'post',
      ],
      'supports'  => [
        'align'           => false,
        'anchor'          => true,
        'customClassName' => false,
      ],
      'render_callback'   => __NAMESPACE__ . '\render_acf_block',
    ],

    // Restrict to only selected blocks
    //
    // Options: 'none', 'all', 'all-core-blocks', 'all-acf-blocks',
    // or any specific block or a combination of these
    // Accepts both string (all*/none-options only) and array (options + specific blocks)
    'allowed_blocks' => [
      'post' => [
        'acf/post-livro',
        'all-core-blocks',
      ],
      'queridinhos' => [
        'acf/queridinhos-da-leitura',
        'all-core-blocks',
      ],
      'page' => [
        'all',
      ],
    ],

    // If you want to use classic editor somewhere, define it here
    'use_classic_editor' => [],

    // Add your own settings and use them wherever you need, for example THEME_SETTINGS['my_custom_setting']

  ];

  $theme_settings = apply_filters('air_light_theme_settings', $theme_settings);

  define('THEME_SETTINGS', $theme_settings);
}); // end action after_setup_theme

/**
 * Required files
 */
require get_theme_file_path('/inc/includes.php');
require get_theme_file_path('/inc/hooks.php');
require get_theme_file_path('/inc/template-tags.php');

// Run theme setup
add_action('after_setup_theme', __NAMESPACE__ . '\theme_setup');
add_action('after_setup_theme', __NAMESPACE__ . '\build_theme_support');

/*
 * First: we register the taxonomies and post types after setup theme
 * If air-helper loads (for translations), we unregister the original taxonomies and post types
 * and reregister them with the translated ones.
 *
 * This allows the slugs translations to work before the translations are available,
 * and for the label translations to work if they are available.
 */
add_action('after_setup_theme', __NAMESPACE__ . '\build_taxonomies');
add_action('after_setup_theme', __NAMESPACE__ . '\build_post_types');

add_action('after_air_helper_init', __NAMESPACE__ . '\rebuild_taxonomies');
add_action('after_air_helper_init', __NAMESPACE__ . '\rebuild_post_types');

/**
 * Tamanhos de imagens
 */
add_action('after_setup_theme', __NAMESPACE__ . '\tamanhos_de_imagens');

/**
 * Chamando o tamanho do excerpt
 */
add_filter('excerpt_length', __NAMESPACE__ . '\tamanho_do_excerpt');

// Função para processar o upload do Formidable e anexar ao post
add_action('frm_after_create_entry', __NAMESPACE__ . '\processar_upload_curriculo', 30, 2);
function processar_upload_curriculo($entry_id, $form_id)
{
  // Obtém o post_id criado pelo Formidable
  $post_id = \FrmDb::get_var('frm_items', array('id' => $entry_id), 'post_id');

  if (!$post_id) return;

  // 230 é o campo de upload no Formidable
  $campo_upload = 230;

  // Pega o arquivo enviado usando a classe correta do Formidable
  $arquivo = \FrmDb::get_var('frm_item_metas', array('field_id' => $campo_upload, 'item_id' => $entry_id), 'meta_value');

  error_log('Arquivo: ' . print_r($arquivo, true)); // Log para depuração

  if (empty($arquivo)) return;

  // Se for um ID numérico, usa direto
  if (is_numeric($arquivo)) {
    update_field('anexar_curriculo_rh', $arquivo, $post_id);
    return;
  }
}

/**
 * Restringe acesso ao formulário específico do Formidable
 */
class RestricaoFormulario
{
  private static $usuario_restrito_id = 232;
  private static $form_id = 12;

  public static function init()
  {
    // Remove formulário da listagem
    add_action('frm_before_list_forms', array(__CLASS__, 'remover_form_listagem'));

    // Bloqueia acesso direto ao formulário
    add_action('frm_before_show_form', array(__CLASS__, 'bloquear_acesso_form'));

    // Remove entradas do formulário
    add_filter('frm_where_filter', array(__CLASS__, 'filtrar_entradas'));

    // Bloqueia visualização de entradas
    add_action('frm_before_show_entry', array(__CLASS__, 'bloquear_acesso_entrada'));

    // Remove do menu admin
    add_action('admin_menu', array(__CLASS__, 'remover_menu_admin'), 999);

    // Intercepta AJAX
    add_action('wp_ajax_frm_entries_ajax_get_data', array(__CLASS__, 'bloquear_ajax'), 1);
    add_action('wp_ajax_nopriv_frm_entries_ajax_get_data', array(__CLASS__, 'bloquear_ajax'), 1);

    // Modifica queries
    add_filter('frm_form_object', array(__CLASS__, 'modificar_form_object'));
  }

  public static function tem_acesso()
  {
    return get_current_user_id() == self::$usuario_restrito_id;
  }

  public static function remover_form_listagem($forms)
  {
    if (!self::tem_acesso()) {
      foreach ($forms as $key => $form) {
        if (is_object($form) && $form->id == self::$form_id) {
          unset($forms[$key]);
        }
      }
    }
    return $forms;
  }

  public static function bloquear_acesso_form($form)
  {
    if (!self::tem_acesso() && is_object($form) && $form->id == self::$form_id) {
      wp_die('Acesso negado.');
    }
  }

  public static function filtrar_entradas($where)
  {
    if (!self::tem_acesso()) {
      global $wpdb;
      $where .= $wpdb->prepare(" AND form_id != %d", self::$form_id);
    }
    return $where;
  }

  public static function bloquear_acesso_entrada($entry)
  {
    if (!self::tem_acesso() && $entry->form_id == self::$form_id) {
      wp_die('Acesso negado.');
    }
  }

  public static function remover_menu_admin()
  {
    if (!self::tem_acesso()) {
      global $submenu;
      if (isset($submenu['formidable'])) {
        foreach ($submenu['formidable'] as $key => $item) {
          if (isset($item[2]) && strpos($item[2], 'formidable&id=' . self::$form_id) !== false) {
            unset($submenu['formidable'][$key]);
          }
        }
      }
    }
  }

  public static function bloquear_ajax()
  {
    if (
      !self::tem_acesso() &&
      isset($_POST['form_id']) &&
      $_POST['form_id'] == self::$form_id
    ) {
      wp_die(-1);
    }
  }

  public static function modificar_form_object($form)
  {
    if (!self::tem_acesso() && is_object($form) && $form->id == self::$form_id) {
      return null;
    }
    return $form;
  }
}

// Inicializa a classe de restrição
add_action('init', array(__NAMESPACE__ . '\RestricaoFormulario', 'init'));

// Remove funções antigas
remove_action('plugins_loaded', __NAMESPACE__ . '\restringir_acesso_form', 1);
remove_filter('frm_get_forms', __NAMESPACE__ . '\remover_form_temp', 99);
remove_filter('frm_forms_dropdown', __NAMESPACE__ . '\remover_form_temp', 99);
remove_filter('frm_form_list', __NAMESPACE__ . '\remover_form_temp', 99);
remove_filter('query', __NAMESPACE__ . '\restringir_acesso_form_db');
remove_filter('posts_where', __NAMESPACE__ . '\restringir_acesso_entradas_db');
remove_filter('user_has_cap', __NAMESPACE__ . '\restringir_permissoes_form');
remove_action('init', __NAMESPACE__ . '\interceptar_queries_formidable');
remove_action('admin_init', __NAMESPACE__ . '\bloquear_acesso_direto');

/**
 * Filtros específicos para restrição de formulários
 */
class RestricaoFormularioFiltros
{
  private static $usuario_restrito_id = 232;
  private static $form_id = 12;

  public static function init()
  {
    // Filtros específicos para listagem
    add_filter('frm_get_forms_args', array(__CLASS__, 'filtrar_forms_args'), 99);
    add_filter('frm_forms_list_table', array(__CLASS__, 'filtrar_forms_table'), 99);
    add_filter('frm_forms_dropdown_args', array(__CLASS__, 'filtrar_forms_dropdown'), 99);
    add_filter('frm_prepare_display_form', array(__CLASS__, 'filtrar_display_form'), 99);

    // Filtros para entradas
    add_filter('frm_entries_args', array(__CLASS__, 'filtrar_entries_args'), 99);
    add_filter('frm_entry_list_query', array(__CLASS__, 'filtrar_entry_query'), 99);

    // Ações para bloqueio direto
    add_action('frm_load_form_hooks', array(__CLASS__, 'verificar_acesso_form'));
    add_action('load-toplevel_page_formidable', array(__CLASS__, 'verificar_acesso_admin'));
  }

  public static function tem_acesso()
  {
    return get_current_user_id() == self::$usuario_restrito_id;
  }

  public static function filtrar_forms_args($args)
  {
    if (!self::tem_acesso()) {
      if (!isset($args['where'])) {
        $args['where'] = array();
      }
      $args['where']['id !'] = self::$form_id;
    }
    return $args;
  }

  public static function filtrar_forms_table($forms)
  {
    if (!self::tem_acesso() && is_array($forms)) {
      return array_filter($forms, function ($form) {
        return !is_object($form) || $form->id != self::$form_id;
      });
    }
    return $forms;
  }

  public static function filtrar_forms_dropdown($args)
  {
    if (!self::tem_acesso()) {
      $args['where'] = " AND id != " . self::$form_id;
    }
    return $args;
  }

  public static function filtrar_display_form($form)
  {
    if (!self::tem_acesso() && is_object($form) && $form->id == self::$form_id) {
      wp_die('Acesso negado.', '', array('response' => 403));
    }
    return $form;
  }

  public static function filtrar_entries_args($args)
  {
    if (!self::tem_acesso()) {
      $args['form_id'] = array('not' => self::$form_id);
    }
    return $args;
  }

  public static function filtrar_entry_query($query)
  {
    if (!self::tem_acesso()) {
      global $wpdb;
      $query['where'] .= $wpdb->prepare(" AND form_id != %d", self::$form_id);
    }
    return $query;
  }

  public static function verificar_acesso_form()
  {
    if (!self::tem_acesso()) {
      $current_form = \FrmAppHelper::get_param('form', '', 'get', 'absint');
      if ($current_form == self::$form_id) {
        wp_die('Acesso negado.', '', array('response' => 403));
      }
    }
  }

  public static function verificar_acesso_admin()
  {
    if (!self::tem_acesso()) {
      $current_form = \FrmAppHelper::get_param('id', '', 'get', 'absint');
      if ($current_form == self::$form_id) {
        wp_die('Acesso negado.', '', array('response' => 403));
      }
    }
  }
}

// Inicializa os novos filtros
add_action('init', array(__NAMESPACE__ . '\RestricaoFormularioFiltros', 'init'), 0);

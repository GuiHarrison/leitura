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

// Função para atualizar anexos antigos
function atualizar_anexos_antigos()
{
  // Aumenta o limite de tempo de execução para 5 minutos
  set_time_limit(300);

  // Define o tempo máximo de execução em segundos
  $tempo_maximo = 240; // 4 minutos
  $tempo_inicio = time();

  // Verifica se o usuário tem permissão
  if (!current_user_can('edit_posts')) {
    error_log('Atualização de anexos: Usuário sem permissão');
    wp_send_json_error('Você não tem permissão para realizar esta ação.');
    return;
  }

  // Verifica o nonce
  if (!isset($_REQUEST['_wpnonce']) || !wp_verify_nonce($_REQUEST['_wpnonce'], 'atualizar_anexos_action')) {
    error_log('Atualização de anexos: Falha na verificação do nonce');
    wp_send_json_error('Verificação de segurança falhou.');
    return;
  }

  // Campo de upload do Formidable (230)
  $campo_upload = 230;

  // Primeiro, vamos buscar todos os entries que têm anexos
  global $wpdb;
  $entries_com_anexos = $wpdb->get_results($wpdb->prepare(
    "SELECT DISTINCT item_id, meta_value 
     FROM {$wpdb->prefix}frm_item_metas 
     WHERE field_id = %d 
     AND meta_value != ''
     AND meta_value IS NOT NULL",
    $campo_upload
  ));

  $total_entries = count($entries_com_anexos);
  error_log("Atualização de anexos: Encontrados {$total_entries} entries com anexos");

  if (empty($entries_com_anexos)) {
    wp_send_json_success(array(
      'message' => 'Nenhum entry com anexo encontrado.',
      'total_processados' => 0,
      'total_atualizados' => 0,
      'total_erros' => 0,
      'total_entries' => 0
    ));
    return;
  }

  // Pega o offset da página atual
  $pagina = isset($_REQUEST['pagina']) ? intval($_REQUEST['pagina']) : 1;
  $por_pagina = 10; // Processa 10 entries por vez
  $offset = ($pagina - 1) * $por_pagina;
  $total_paginas = ceil($total_entries / $por_pagina);

  // Pega os entries desta página
  $entries_desta_pagina = array_slice($entries_com_anexos, $offset, $por_pagina);

  error_log("Atualização de anexos: Processando página {$pagina} de {$total_paginas}");

  $atualizados = 0;
  $erros = 0;
  $processados = 0;

  foreach ($entries_desta_pagina as $entry) {
    // Limpa a memória após cada iteração
    wp_cache_flush();

    // Verifica se excedeu o tempo limite
    if ((time() - $tempo_inicio) >= $tempo_maximo) {
      error_log('Atualização de anexos: Tempo limite excedido');
      wp_send_json_error(array(
        'message' => 'Tempo limite excedido. Processo interrompido.',
        'total_processados' => $processados + (($pagina - 1) * $por_pagina),
        'total_atualizados' => $atualizados,
        'total_erros' => $erros,
        'total_entries' => $total_entries,
        'pagina_atual' => $pagina,
        'total_paginas' => $total_paginas,
        'tem_mais' => ($pagina < $total_paginas)
      ));
      return;
    }

    $processados++;
    error_log("Atualização de anexos: Processando entry {$processados}/{$por_pagina} (ID: {$entry->item_id})");

    // Encontra o post_id relacionado ao entry
    $post_id = \FrmDb::get_var('frm_items', array('id' => $entry->item_id), 'post_id');

    if (!$post_id) {
      error_log("Atualização de anexos: Entry {$entry->item_id} sem post_id relacionado");
      $erros++;
      continue;
    }

    $arquivo = $entry->meta_value;
    error_log("Atualização de anexos: Arquivo encontrado para entry {$entry->item_id}: " . print_r($arquivo, true));

    // Se for um ID numérico, atualiza direto
    if (is_numeric($arquivo)) {
      update_field('anexar_curriculo_rh', $arquivo, $post_id);
      error_log("Atualização de anexos: ID {$arquivo} atualizado para post {$post_id}");
      $atualizados++;
      continue;
    }

    // Se for URL, faz o download e anexa
    if (filter_var($arquivo, FILTER_VALIDATE_URL)) {
      error_log("Atualização de anexos: Iniciando download de {$arquivo} para post {$post_id}");

      $tmp = download_url($arquivo);

      if (is_wp_error($tmp)) {
        error_log("Atualização de anexos: Erro no download para post {$post_id}: " . $tmp->get_error_message());
        $erros++;
        continue;
      }

      $file_array = array(
        'name' => basename($arquivo),
        'tmp_name' => $tmp
      );

      $attachment_id = media_handle_sideload($file_array, $post_id);

      if (is_wp_error($attachment_id)) {
        error_log("Atualização de anexos: Erro ao anexar arquivo para post {$post_id}: " . $attachment_id->get_error_message());
        $erros++;
        @unlink($tmp);
        continue;
      }

      update_field('anexar_curriculo_rh', $attachment_id, $post_id);
      error_log("Atualização de anexos: Arquivo anexado com sucesso para post {$post_id}");
      $atualizados++;

      @unlink($tmp);
    }

    // Limpa a memória após cada arquivo processado
    gc_collect_cycles();
  }

  $total_processados = $processados + (($pagina - 1) * $por_pagina);
  error_log("Atualização de anexos: Página {$pagina} finalizada. Total processados: {$total_processados}, Atualizados: {$atualizados}, Erros: {$erros}");

  wp_send_json_success(array(
    'message' => $pagina >= $total_paginas ? 'Atualização de anexos concluída.' : 'Lote processado com sucesso.',
    'total_processados' => $total_processados,
    'total_atualizados' => $atualizados,
    'total_erros' => $erros,
    'total_entries' => $total_entries,
    'pagina_atual' => $pagina,
    'total_paginas' => $total_paginas,
    'tem_mais' => ($pagina < $total_paginas)
  ));
}

// Hook para executar a função via admin-ajax.php
add_action('wp_ajax_atualizar_anexos_antigos', __NAMESPACE__ . '\atualizar_anexos_antigos');

// Adiciona página de administração para atualização de anexos
function adicionar_pagina_admin_anexos()
{
  add_menu_page(
    'Atualizar Anexos', // Título da página
    'Atualizar Anexos', // Texto do menu
    'edit_posts',       // Capacidade necessária
    'atualizar-anexos', // Slug da página
    __NAMESPACE__ . '\renderizar_pagina_anexos', // Callback
    'dashicons-update', // Ícone
    30                  // Posição no menu
  );
}
add_action('admin_menu', __NAMESPACE__ . '\adicionar_pagina_admin_anexos');

// Renderiza a página de atualização de anexos
function renderizar_pagina_anexos()
{
  require_once get_theme_file_path('/template-parts/admin/atualizar-anexos.php');
}

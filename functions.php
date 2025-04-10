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

  if (empty($arquivo)) return;

  // Se for uma URL, faz o download e anexa
  if (filter_var($arquivo, FILTER_VALIDATE_URL)) {
    // Baixa o arquivo
    $tmp = download_url($arquivo);

    if (!is_wp_error($tmp)) {
      // Prepara o arquivo
      $file_array = array(
        'name' => basename($arquivo),
        'tmp_name' => $tmp
      );

      // Anexa o arquivo à biblioteca de mídia
      $attachment_id = media_handle_sideload($file_array, $post_id);

      if (!is_wp_error($attachment_id)) {
        // Atualiza o campo ACF com o ID do anexo
        update_field('anexar_curriculo_rh', $attachment_id, $post_id);
      }

      @unlink($tmp);
    }
  }
}

// Função para verificar se a senha expirou
function check_password_expiration($user_id)
{
  $last_password_change = get_user_meta($user_id, 'last_password_change', true);
  $expiration_period = 90 * DAY_IN_SECONDS; // 3 meses em segundos

  if (empty($last_password_change)) {
    update_user_meta($user_id, 'last_password_change', time());
    return false;
  }

  return (time() - $last_password_change) > $expiration_period;
}

// Atualizar timestamp apenas quando a senha for efetivamente alterada
function update_password_change_time($user_id)
{
  if (is_int($user_id)) {
    update_user_meta($user_id, 'last_password_change', time());
  }
}

// Remover todos os hooks anteriores e adicionar apenas os necessários
add_action('password_reset', function ($user) {
  update_password_change_time($user->ID);
});

add_action('after_password_reset', function ($user) {
  update_password_change_time($user->ID);
});

// Verificar expiração de senha no login
function check_password_expiration_on_login($user, $username, $password)
{
  if (!$user || is_wp_error($user)) {
    return $user;
  }

  if (check_password_expiration($user->ID)) {
    // Gerar token para a sessão
    $token = wp_generate_password(43, false);

    // Configurar dados da sessão
    $session_data = array(
      'force_password_reset' => true,
      'expiration' => time() + 2 * DAY_IN_SECONDS,
      'token' => $token
    );

    // Atualizar sessão com token
    \WP_Session_Tokens::get_instance($user->ID)->update($token, $session_data);

    // Redirecionar para página de redefinição
    $key = get_password_reset_key($user);
    if (!is_wp_error($key)) {
      wp_redirect(network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user->user_login) . "&password_expired=1"));
      exit;
    }
  }

  return $user;
}
add_filter('authenticate', __NAMESPACE__ . '\check_password_expiration_on_login', 99, 3);

// Adicionar mensagem personalizada na tela de login
function password_expiration_login_message($message)
{
  if (isset($_GET['password_expired'])) {
    return '<div class="message" style="border-left-color: #dc3232;">Sua senha expirou. Por favor, defina uma nova senha para continuar.</div>';
  }
  return $message;
}
add_filter('login_message', __NAMESPACE__ . '\password_expiration_login_message');

// Implementar requisitos de senha forte
function enforce_strong_password($errors, $update, $user)
{
  if (isset($_POST['pass1']) && !empty($_POST['pass1'])) {
    $password = $_POST['pass1'];

    // Verificar comprimento mínimo
    if (strlen($password) < 12) {
      $errors->add('password_too_short', 'A senha deve ter pelo menos 12 caracteres.');
    }

    // Verificar complexidade
    if (!preg_match('/[A-Z]/', $password)) {
      $errors->add('password_no_upper', 'A senha deve conter pelo menos uma letra maiúscula.');
    }
    if (!preg_match('/[a-z]/', $password)) {
      $errors->add('password_no_lower', 'A senha deve conter pelo menos uma letra minúscula.');
    }
    if (!preg_match('/[0-9]/', $password)) {
      $errors->add('password_no_number', 'A senha deve conter pelo menos um número.');
    }
    if (!preg_match('/[^A-Za-z0-9]/', $password)) {
      $errors->add('password_no_special', 'A senha deve conter pelo menos um caractere especial.');
    }
  }
  return $errors;
}
add_action('user_profile_update_errors', __NAMESPACE__ . '\enforce_strong_password', 10, 3);

// Adiciona o histórico de senhas caso ele ainda não exista
function initialize_password_history($user_id)
{
  $history = get_user_meta($user_id, 'password_history', true);
  if (empty($history)) {
    $user = get_user_by('id', $user_id);
    if ($user) {
      $history = array($user->user_pass);
      update_user_meta($user_id, 'password_history', $history);
      error_log('Histórico de senha inicializado para usuário: ' . $user_id);
    }
  }
}

// Modificar a função check_password_history para ser mais rigorosa
function check_password_history($errors, $update, $user)
{
  error_log('=== check_password_history INICIADO ===');

  if (!isset($_POST['pass1']) || empty($_POST['pass1'])) {
    error_log('pass1 não definido ou vazio. Retornando erros.');
    error_log('=== check_password_history FINALIZADO ===');
    return $errors;
  }

  $new_password = $_POST['pass1'];

  // Debug
  error_log('User ID: ' . $user->ID);

  // Verificar senha atual primeiro
  if (wp_check_password($new_password, $user->user_pass)) {
    error_log('Senha igual à atual detectada');
    $errors->add('password_same_as_current', 'A nova senha não pode ser igual à senha atual.');
    error_log('=== check_password_history FINALIZADO ===');
    return $errors;
  }

  // Buscar e verificar histórico
  $history = get_user_meta($user->ID, 'password_history', true);
  error_log('Histórico atual: ' . print_r($history, true));

  if (!is_array($history)) {
    $history = array();
  }

  // Garantir que a senha atual está no histórico
  if (!in_array($user->user_pass, $history)) {
    array_unshift($history, $user->user_pass);
  }

  // Verificar cada hash do histórico
  foreach ($history as $old_hash) {
    if (!empty($old_hash)) {
      error_log('Verificando hash: ' . $old_hash);
      if (wp_check_password($new_password, $old_hash)) {
        error_log('Senha encontrada no histórico!');
        $errors->add('password_reused', 'Esta senha já foi utilizada anteriormente. Por favor, escolha uma senha diferente.');
        error_log('=== check_password_history FINALIZADO ===');
        return $errors;
      }
    }
  }

  // Se chegou aqui, a senha é válida
  if (empty($errors->errors)) {
    $new_hash = wp_hash_password($new_password);
    array_unshift($history, $new_hash);
    $history = array_slice($history, 0, 5);
    $history = array_filter($history); // Remover valores vazios
    update_user_meta($user->ID, 'password_history', $history);
    error_log('Novo histórico salvo: ' . print_r($history, true));
  }

  error_log('=== check_password_history FINALIZADO ===');
  return $errors;
}

// Adicione estes hooks para garantir que o histórico seja atualizado
add_action('user_register', __NAMESPACE__ . '\initialize_password_history');
add_action('reset_password', function ($user) {
  initialize_password_history($user->ID);
});
add_action('profile_update', function ($user_id) {
  if (isset($_POST['pass1']) && !empty($_POST['pass1'])) {
    initialize_password_history($user_id);
  }
}, 10);

// Inicializar histórico de senhas para todos os usuários
function initialize_all_users_password_history()
{
  // Verificar se já foi executado
  if (get_option('password_history_initialized')) {
    return;
  }

  global $wpdb;

  // Buscar todos os usuários
  $users = $wpdb->get_results("SELECT ID, user_pass FROM {$wpdb->users}");

  foreach ($users as $user) {
    // Verificar se já tem histórico
    $history = get_user_meta($user->ID, 'password_history', true);

    if (empty($history)) {
      // Criar histórico com a senha atual
      $history = array($user->user_pass);
      update_user_meta($user->ID, 'password_history', $history);
      error_log("Histórico de senha inicializado para usuário ID: {$user->ID}");
    }
  }

  // Marcar como executado
  update_option('password_history_initialized', true);
  error_log('Inicialização do histórico de senhas completa para todos os usuários');
}

// Executar na inicialização do WordPress
add_action('init', __NAMESPACE__ . '\initialize_all_users_password_history');

// Desabilitar lista de usuários para não-administradores
function disable_users_list()
{
  if (!current_user_can('administrator') && is_admin()) {
    wp_die(__('Acesso negado.'));
  }
}
add_action('pre_user_query', __NAMESPACE__ . '\disable_users_list');

// Limitar tentativas de login
function limit_login_attempts($user, $username, $password)
{
  if (!$username) {
    return $user;
  }

  $login_attempts = get_transient('login_attempts_' . $username);
  if ($login_attempts === false) {
    $login_attempts = 0;
  }

  if ($login_attempts >= 5) { // Limite de 5 tentativas
    return new \WP_Error('too_many_attempts', 'Muitas tentativas de login. Bloqueamos novas tentativas de login por 15 minutos.');
  }

  if ($user instanceof \WP_Error) {
    $login_attempts++;
    set_transient('login_attempts_' . $username, $login_attempts, 900); // 15 minutos
  } else {
    delete_transient('login_attempts_' . $username);
  }

  return $user;
}
add_filter('authenticate', __NAMESPACE__ . '\limit_login_attempts', 30, 3);

// Verificar e notificar senhas próximas de expirar
add_action('wp_login', function ($user_login) {
  $user = get_user_by('login', $user_login);
  $last_password_change = get_user_meta($user->ID, 'last_password_change', true);
  $expiration_period = 90 * DAY_IN_SECONDS;
  $warning_period = 7 * DAY_IN_SECONDS;

  if ($last_password_change && (($expiration_period - (time() - $last_password_change)) <= $warning_period)) {
    $days_left = floor(($expiration_period - (time() - $last_password_change)) / DAY_IN_SECONDS);
    $to = $user->user_email;
    $subject = 'Sua senha irá expirar em breve';
    $message = sprintf(
      'Olá %s,\n\nSua senha irá expirar em %d dias. Por favor, acesse sua conta e altere sua senha.\n\nAtenciosamente,\nEquipe do site',
      $user->display_name,
      $days_left
    );
    wp_mail($to, $subject, $message);
  }
});

// Notificar tentativas de login malsucedidas
add_action('wp_login_failed', function ($username) {
  $user = get_user_by('login', $username);
  if ($user) {
    $to = $user->user_email;
    $subject = 'Tentativa de login malsucedida';
    $message = sprintf(
      'Olá %s,\n\nHouve uma tentativa malsucedida de login em sua conta em %s.\n\nSe não foi você, recomendamos que altere sua senha imediatamente.\n\nAtenciosamente,\nEquipe Leitura.',
      $user->display_name,
      gmdate('Y-m-d H:i:s', strtotime('-3 hours'))
    );
    wp_mail($to, $subject, $message);
  }
});

// Adicionar verificação de histórico no reset de senha
add_action('validate_password_reset', function ($errors, $user) {
  if (!$errors->has_errors() && isset($_POST['pass1']) && !empty($_POST['pass1'])) {
    error_log('=== Verificando senha no reset ===');
    error_log('User ID: ' . $user->ID);

    $new_password = $_POST['pass1'];
    $history = get_user_meta($user->ID, 'password_history', true);

    error_log('Histórico atual: ' . print_r($history, true));

    // Verificar senha atual
    if (wp_check_password($new_password, $user->user_pass)) {
      error_log('Tentativa de usar a mesma senha no reset');
      $errors->add('password_same_as_current', 'A nova senha não pode ser igual à senha atual.');
      return $errors;
    }

    if (is_array($history)) {
      foreach ($history as $old_hash) {
        if (!empty($old_hash) && wp_check_password($new_password, $old_hash)) {
          error_log('Senha encontrada no histórico durante reset');
          $errors->add('password_reused', 'Esta senha já foi utilizada anteriormente. Por favor, escolha uma senha diferente.');
          return $errors;
        }
      }
    }

    error_log('Senha válida no reset');
  }
  return $errors;
}, 10, 2);

// Atualizar histórico após reset bem-sucedido
add_action('after_password_reset', function ($user) {
  error_log('Atualizando histórico após reset de senha');
  if (isset($_POST['pass1']) && !empty($_POST['pass1'])) {
    $history = get_user_meta($user->ID, 'password_history', true);
    if (!is_array($history)) {
      $history = array();
    }

    array_unshift($history, $user->user_pass); // Adiciona a senha atual ao histórico
    $history = array_slice($history, 0, 5);
    update_user_meta($user->ID, 'password_history', $history);
    error_log('Histórico atualizado após reset: ' . print_r($history, true));
  }
});

// Remover opção de confirmar senha fraca
add_action('login_enqueue_scripts', function () {
  wp_add_inline_script('password-strength-meter', 'jQuery(document).ready(function($) {
      $("div.pw-weak").remove();
      $("#pw-checkbox").parent().remove();
  });', 'after');
});


// Notificar quando a conta for bloqueada
/* add_action('wp_login_failed', function ($username) {
  $login_attempts = get_transient('login_attempts_' . $username);
  if ($login_attempts && $login_attempts >= 4) { // Avisa na penúltima tentativa
    $user = get_user_by('login', $username);
    if ($user) {
      $to = $user->user_email;
      $subject = 'Alerta de segurança - Conta próxima de ser bloqueada';
      $message = sprintf(
        'Olá %s,\n\nSua conta está próxima de ser bloqueada devido a múltiplas tentativas de login malsucedidas.\n\nSe não foi você tentando acessar, recomendamos que altere sua senha imediatamente.\n\nAtenciosamente,\nEquipe do site',
        $user->display_name
      );
      wp_mail($to, $subject, $message);
    }
  }
}); */

/* // Debug scripts carregados
add_action('wp_footer', function () {
  global $wp_scripts;
  error_log('Scripts carregados: ' . print_r($wp_scripts->queue, true));
}, 999);
 */

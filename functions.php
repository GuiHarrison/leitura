<?php
/**
 * Gather all bits and pieces together.
 * If you end up having multiple post types, taxonomies,
 * hooks and functions - please split those to their
 * own files under /inc and just require here.
 *
 * @Date: 2019-10-15 12:30:02
 * @Last Modified by:   Roni Laukkarinen
 * @Last Modified time: 2024-01-10 18:54:48
 *
 * @package leitura
 */

namespace Air_Light;

// use function PHPSTORM_META\map;

/**
 * The current version of the theme.
 */
define( 'AIR_LIGHT_VERSION', '9.4.7' );

// We need to have some defaults as comments or empties so let's allow this:
// phpcs:disable Squiz.Commenting.InlineComment.SpacingBefore, WordPress.Arrays.ArrayDeclarationSpacing.SpaceInEmptyArray

error_log( 'Iniciando o functions.php' );

/**
 * Theme settings
 */
add_action( 'after_setup_theme', function() {
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
      'localhost:3000',
      'leitura.local',
      'airdev.test',
      'airwptheme.com',
      'localhost',
    ],

    /**
     * Menu locations
     */
    'menu_locations' => [
      'primary' => __( 'Primary Menu', 'leitura' ),
      'informacoes' => __( 'Informações', 'leitura' ),
      'servicos_ao_cliente' => __( 'Serviços ao cliente', 'leitura' ),
    ],

    /**
     * Taxonomies
     *
     * See the instructions:
     * https://github.com/digitoimistodude/leitura#custom-taxonomies
     */
    'taxonomies' => [
      'Category_Cidade_Estado' => [ 'lojas', 'eventos' ],
      'Category_Generos' => [ 'post', 'eventos', 'queridinhos' ],
    ],

    /**
     * Post types
     *
     * See the instructions:
     * https://github.com/digitoimistodude/leitura#custom-post-types
     */
    'post_types' => [
      'lojas',
      'eventos',
      'revista',
      'queridinhos',
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
        'name'           => 'cta-1-3',
        'title'          => 'CTA 1/3',
        'supports'       => [
          'customClassName' => true,
          'align'           => 'left',
        ],
        'icon'           => 'tickets',
      ],
      [
        'name'           => 'cta-2-3',
        'title'          => 'CTA 2/3',
        'supports'       => [
          'customClassName' => true,
          'align'           => 'left',
        ],
        'icon'           => 'tickets',
      ],
      [
        'name'           => 'cta-3-3',
        'title'          => 'CTA 3/3',
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
        'name'           => 'newsletter',
        'title'          => 'Newsletter',
        'icon'           => 'tickets',
      ],
    ],

    // Custom ACF block default settings
    'acf_block_defaults' => [
      'category'          => 'leitura',
      'mode'              => 'auto',
      'align'             => 'full',
      'post_types'        => [
        'page',
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
      'post' => 'all-core-blocks',
      'page' => [
        'all-acf-blocks',
        'core/paragraph',
      ],
      'all-acf-blocks',
      // 'page' => [
      //   'all-acf-blocks',
      //   'core/paragraph',
      // ],
      // 'post-type' => [
      //   'acf/content-image',
      //   'core/paragraph',
      // ],
      // 'example' => [
      //   'all-core-blocks',
      //   'acf/content-image',
      // ],
    ],

    // If you want to use classic editor somewhere, define it here
    'use_classic_editor' => [],

    // Add your own settings and use them wherever you need, for example THEME_SETTINGS['my_custom_setting']

  ];

  $theme_settings = apply_filters( 'air_light_theme_settings', $theme_settings );

  define( 'THEME_SETTINGS', $theme_settings );
} ); // end action after_setup_theme

/**
 * Required files
 */
require get_theme_file_path( '/inc/includes.php' );
require get_theme_file_path( '/inc/hooks.php' );
require get_theme_file_path( '/inc/template-tags.php' );

// Run theme setup
add_action( 'after_setup_theme', __NAMESPACE__ . '\theme_setup' );
add_action( 'after_setup_theme', __NAMESPACE__ . '\build_theme_support' );

/*
 * First: we register the taxonomies and post types after setup theme
 * If air-helper loads (for translations), we unregister the original taxonomies and post types
 * and reregister them with the translated ones.
 *
 * This allows the slugs translations to work before the translations are available,
 * and for the label translations to work if they are available.
 */
add_action( 'after_setup_theme', __NAMESPACE__ . '\build_taxonomies' );
add_action( 'after_setup_theme', __NAMESPACE__ . '\build_post_types' );

add_action( 'after_air_helper_init', __NAMESPACE__ . '\rebuild_taxonomies' );
add_action( 'after_air_helper_init', __NAMESPACE__ . '\rebuild_post_types' );

/**
 * Tamanhos de imagens
 */
add_action( 'after_setup_theme', __NAMESPACE__ . '\tamanhos_de_imagens' );

/**
 * Suporte temporário para SVG
 */
// Allow SVG
add_filter( 'wp_check_filetype_and_ext', function( $data, $file, $filename, $mimes ) {
  global $wp_version;

  if ( '4.7.1' !== $wp_version ) {
		 return $data;
  }

  $filetype = wp_check_filetype( $filename, $mimes );

  return [
      'ext'             => $filetype['ext'],
      'type'            => $filetype['type'],
      'proper_filename' => $data['proper_filename'],
  ];
}, 10, 4 );

function cc_mime_types( $mimes ) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter( 'upload_mimes',  __NAMESPACE__ . '\cc_mime_types' );

function fix_svg() {
  echo '<style type="text/css">
        .attachment-266x266, .thumbnail img {
             width: 100% !important;
             height: auto !important;
        }
        </style>';
}
add_action( 'admin_head',  __NAMESPACE__ . '\fix_svg' );

<?php

/**
 * Hooks
 *
 * All hooks that are run in the theme are listed here
 *
 * @package leitura
 */

namespace Air_Light;

/**
 * Enable search view
 */
// add_filter( 'air_helper_disable_views_search', '__return_false' );

/**
 * Breadcrumb
 */
// require get_theme_file_path( 'inc/hooks/breadcrumb.php' );

/**
 * General hooks
 */
require get_theme_file_path('inc/hooks/general.php');
add_action('widgets_init', __NAMESPACE__ . '\widgets_init');

/**
 * Scripts and styles associated hooks
 */
require get_theme_file_path('inc/hooks/scripts-styles.php');
add_action('wp_enqueue_scripts', __NAMESPACE__ . '\enqueue_theme_scripts');

// NB! If you use ajax functionality in Gravity Forms, remove this line
// to prevent Uncaught ReferenceError: jQuery is not defined
add_action('wp_default_scripts', __NAMESPACE__ . '\move_jquery_into_footer');

/**
 * Gutenberg associated hooks
 */
require get_theme_file_path('inc/hooks/gutenberg.php');
add_filter('allowed_block_types_all', __NAMESPACE__ . '\allowed_block_types', 10, 2);
add_filter('use_block_editor_for_post_type', __NAMESPACE__ . '\use_block_editor_for_post_type', 10, 2);
add_action('enqueue_block_editor_assets', __NAMESPACE__ . '\register_block_editor_assets');
add_filter('block_editor_settings_all', __NAMESPACE__ . '\remove_gutenberg_inline_styles', 10, 2);
add_action('enqueue_block_editor_assets', __NAMESPACE__ . '\block_editor_title_input_styles');

/**
 * ACF blocks
 */
require get_theme_file_path('inc/hooks/acf-blocks.php');
add_filter('block_categories_all', __NAMESPACE__ . '\acf_blocks_add_category_in_gutenberg', 10, 2);
add_action('acf/init', __NAMESPACE__ . '\acf_blocks_init');

/**
 * Chamando API do Google
 */
add_action('acf/init', __NAMESPACE__ . '\acf_maps_key');

/**
 * Form related hooks
 */
require get_theme_file_path('inc/hooks/forms.php');
add_action('gform_enqueue_scripts', __NAMESPACE__ . '\dequeue_gf_stylesheets', 999);

/**
 * Remove barra administrativa
 */
add_filter('show_admin_bar', '__return_false');

/**
 * Popula campos com o nome das lojas
 */
add_filter('frm_setup_new_fields_vars', __NAMESPACE__ . '\popula_campos_com_lojas', 20, 2);
add_action('save_post', __NAMESPACE__ . '\clear_lojas_cache', 10, 2);

/**
 * Controle de listagem de posts
 */
add_action('pre_get_posts', __NAMESPACE__ . '\ppp_categorias');
add_filter('pre_get_posts', __NAMESPACE__ . '\excluir_lojas_da_busca');

/**
 * Validação de CPF no formulário
 */
add_action('frm_validate_field_entry', __NAMESPACE__ . '\validate_cpf_field', 10, 4);

/**
 * Insere o CPF do candidato
 */
add_action('save_post', __NAMESPACE__ . '\leva_CPF', 10, 2);

/**
 * Apenas usuários logados
 */
add_filter('wp_nav_menu_items', 'filtrar_itens_menu', 10, 2);

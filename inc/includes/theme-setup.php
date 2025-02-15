<?php
/**
 * Theme setup and supports.
 *
 * @package leitura
 **/

namespace Air_Light;

function theme_setup() {

	/**
	 * Register menu locations
	 */

	register_nav_menus( THEME_SETTINGS['menu_locations'] );

	/**
	 * Load textdomain.
	 */
	load_theme_textdomain( THEME_SETTINGS['textdomain'], get_template_directory() . '/languages' );

	/**
	 * Define content width in articles
	 */
	if ( ! isset( $content_width ) ) {
		$content_width = THEME_SETTINGS['content_width'];
	}
}

/**
 * Build taxonomies
 */
function build_taxonomies() {
	if ( ! is_array( THEME_SETTINGS['taxonomies'] ) || ! THEME_SETTINGS['taxonomies'] ) {
		return;
	}

	foreach ( THEME_SETTINGS['taxonomies'] as $name => $post_types ) {
		$slug = strtolower( $name );

		$classname = __NAMESPACE__ . '\\' . $name;
		$file_path = get_theme_file_path( '/inc/taxonomies/' . str_replace( '_', '-', $slug ) . '.php' );

		if ( ! file_exists( $file_path ) ) {
			return new \WP_Error( 'invalid-taxonomy', __( 'The taxonomy class file does not exist.', 'leitura' ), $classname );
		}
		// Get the class file, only try to require if not already imported
		if ( ! class_exists( $classname ) ) {
			require $file_path;
		}

		if ( ! class_exists( $classname ) ) {
			return new \WP_Error( 'invalid-taxonomy', __( 'The taxonomy you attempting to create does not have a class to instance. Possible problems: your configuration does not match the class file name; the class file name does not exist.', 'leitura' ), $classname );
		}

		$taxonomy_class = new $classname( $slug );
		$taxonomy_class->register( $post_types );
	}
}

/**
 * Build custom post types
 */
function build_post_types() {
	if ( ! is_array( THEME_SETTINGS['post_types'] ) || ! THEME_SETTINGS['post_types'] ) {
		return;
	}

	foreach ( THEME_SETTINGS['post_types'] as $name ) {
		$slug = strtolower( $name );

		$classname = __NAMESPACE__ . '\\' . $name;
		$file_path = get_theme_file_path( '/inc/post-types/' . str_replace( '_', '-', $slug ) . '.php' );

		if ( ! file_exists( $file_path ) ) {
			return new \WP_Error( 'invalid-cpt', __( 'The custom post type class file does not exist.', 'leitura' ), $classname );
		}
		// Get the class file, only try to require if not already imported
		if ( ! class_exists( $classname ) ) {
			require $file_path;
		}

		if ( ! class_exists( $classname ) ) {
			return new \WP_Error( 'invalid-cpt', __( 'The custom post type you attempting to create does not have a class to instance. Possible problems: your configuration does not match the class file name; the class file name does not exist.', 'leitura' ), $classname );
		}

		$post_type_class = new $classname( $slug );
		$post_type_class->register();
	}
}

/**
 * Rebuild taxonomies
 */
function rebuild_taxonomies() {
	if ( ! is_array( THEME_SETTINGS['taxonomies'] ) || ! THEME_SETTINGS['taxonomies'] ) {
		return;
	}

	foreach ( THEME_SETTINGS['taxonomies'] as $name => $post_types ) {
		$slug = strtolower( $name );

		unregister_taxonomy( $slug );
	}

	build_taxonomies();
}

/**
 * Rebuild custom post types
 */
function rebuild_post_types() {
	if ( ! is_array( THEME_SETTINGS['post_types'] ) || ! THEME_SETTINGS['post_types'] ) {
		return;
	}

	foreach ( THEME_SETTINGS['post_types'] as $name ) {
		$slug = strtolower( $name );

		unregister_post_type( $slug );
	}

	build_post_types();
}


/**
 * Build theme support
 */
function build_theme_support() {
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'wp-block-styles' );
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
function acf_maps_key() {
  $api_keys = APIKeys::get_instance();
  $maps_key = $api_keys->get_key( 'maps' );

  if ( $maps_key ) {
		acf_update_setting( 'google_api_key', $maps_key );
  }
}

/**
 * Adicionando tamanhos de arquivos
 */
function tamanhos_de_imagens() {
  add_image_size( 'destaque-home', 346, 346, true );
  add_image_size( 'revista', 250, 356, true );
  add_image_size( 'resenha-g', 193, 300 );
  add_image_size( 'resenha-p', 130, 203 );
}

/**
 * Pegar estados do endereço do maps
 */
function endereco_para_estado_curto($string) {
  if (preg_match('/(\w{2}),(?=[^,]*$)/', $string, $matches)) {
      return $matches[1];
  }
  return '';
}

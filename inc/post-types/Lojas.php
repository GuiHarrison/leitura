<?php
/**
 * The post type class.
 *
 * @package leitura
 **/

namespace Air_Light;

/**
 * Registers the Lojas post type.
 */
class Lojas extends Post_Type {

  public function register() {

		// Modify all the i18ized strings here.
		$generated_labels = [
		// The Post_Type ask__ function wraps the air-helper ask__, and automatically registers the keys to Polylang!
		// self::ask__( 'Key', 'Default value' )
		// -> Key: Default value => 'Default value'
		'menu_name'          => self::ask__( 'Lojas', 'Lojas' ),
		'name'               => self::ask__( 'Lojas', 'Lojas' ),
		'singular_name'      => self::ask__( 'Lojas', 'Loja' ),
		'name_admin_bar'     => self::ask__( 'Lojas', 'Lojas' ),
		'add_new'            => self::ask__( 'Lojas', 'Adicionar nova' ),
		'add_new_item'       => self::ask__( 'Lojas', 'Adicionar nova loja' ),
		'new_item'           => self::ask__( 'Lojas', 'Nova Loja' ),
		'edit_item'          => self::ask__( 'Lojas', 'Editar Loja' ),
		'view_item'          => self::ask__( 'Lojas', 'Ver Loja' ),
		'all_items'          => self::ask__( 'Lojas', 'Todas as lojas' ),
		'search_items'       => self::ask__( 'Lojas', 'Buscar lojas' ),
		'parent_item_colon'  => self::ask__( 'Lojas', 'Lojas mães:' ),
		'not_found'          => self::ask__( 'Lojas', 'Nenhuma loja encontrado.' ),
		'not_found_in_trash' => self::ask__( 'Lojas', 'Nenhuma loja encontrado no lixo.' ),
		];

		// Definition of the post type arguments. For full list see:
		// http://codex.wordpress.org/Function_Reference/register_post_type
		$args = [
		'labels'                => $generated_labels,
		'menu_icon'             => 'dashicons-sticky',
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 21,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'show_in_rest'          => true,
		'pll_translatable'      => true,
		'rewrite'               => [
      'with_front'            => false,
      'slug'                  => 'loja',
		],
		'supports'              => [ 'title', 'revisions' ],
		'taxonomies'            => [ 'category_cidade_estado' ],
		];

		$this->register_wp_post_type( $this->slug, $args );

		$this->register_acf_rest();
  }
}

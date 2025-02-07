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
		'menu_name'          => 'Lojas',
		'name'               => 'Lojas',
		'singular_name'      => 'Loja',
		'name_admin_bar'     => 'Lojas',
		'add_new'            => 'Adicionar nova',
		'add_new_item'       => 'Adicionar nova loja',
		'new_item'           => 'Nova Loja',
		'edit_item'          => 'Editar Loja',
		'view_item'          => 'Ver Loja',
		'all_items'          => 'Todas as lojas',
		'search_items'       => 'Buscar lojas',
		'parent_item_colon'  => 'Lojas mães:',
		'not_found'          => 'Nenhuma loja encontrado.',
		'not_found_in_trash' => 'Nenhuma loja encontrado no lixo.',
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

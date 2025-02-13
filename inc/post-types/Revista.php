<?php
/**
 * The post type class.
 *
 * @package leitura
 **/

namespace Air_Light;

/**
 * Registers the Revistas post type.
 */
class Revista extends Post_Type {

  public function register() {

		// Modify all the i18ized strings here.
		$generated_labels = [
		// The Post_Type ask__ function wraps the air-helper ask__, and automatically registers the keys to Polylang!
		// self::ask__( 'Key', 'Default value' )
		// -> Key: Default value => 'Default value'
		'menu_name'          => 'Revistas',
		'name'               => 'Revistas',
		'singular_name'      => 'Revista',
		'name_admin_bar'     => 'Revistas',
		'add_new'            => 'Adicionar nova',
		'add_new_item'       => 'Adicionar nova Revista',
		'new_item'           => 'Nova Revista',
		'edit_item'          => 'Editar Revista',
		'view_item'          => 'Ver Revista',
		'all_items'          => 'Todas as Revistas',
		'search_items'       => 'Buscar Revistas',
		'parent_item_colon'  => 'Revistas mães:',
		'not_found'          => 'Nenhuma Revista encontrado.',
		'not_found_in_trash' => 'Nenhuma Revista encontrado no lixo.',
		];

		// Definition of the post type arguments. For full list see:
		// http://codex.wordpress.org/Function_Reference/register_post_type
		$args = [
		'labels'              => $generated_labels,
		'menu_icon'           => 'dashicons-text-page',
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'show_in_rest'        => true,
		'pll_translatable'    => true,
		'rewrite'             => [
        'with_front'        => false,
        'slug'              => 'revista',
		],
		'supports'            => [ 'title', 'editor', 'thumbnail', 'revisions' ],
		];

		$this->register_wp_post_type( $this->slug, $args );
  }
}

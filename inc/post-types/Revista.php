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
		'menu_name'          => self::ask__( 'Revistas', 'Revistas' ),
		'name'               => self::ask__( 'Revistas', 'Revistas' ),
		'singular_name'      => self::ask__( 'Revistas', 'Revista' ),
		'name_admin_bar'     => self::ask__( 'Revistas', 'Revistas' ),
		'add_new'            => self::ask__( 'Revistas', 'Adicionar nova' ),
		'add_new_item'       => self::ask__( 'Revistas', 'Adicionar nova Revista' ),
		'new_item'           => self::ask__( 'Revistas', 'Nova Revista' ),
		'edit_item'          => self::ask__( 'Revistas', 'Editar Revista' ),
		'view_item'          => self::ask__( 'Revistas', 'Ver Revista' ),
		'all_items'          => self::ask__( 'Revistas', 'Todas as Revistas' ),
		'search_items'       => self::ask__( 'Revistas', 'Buscar Revistas' ),
		'parent_item_colon'  => self::ask__( 'Revistas', 'Revistas mães:' ),
		'not_found'          => self::ask__( 'Revistas', 'Nenhuma Revista encontrado.' ),
		'not_found_in_trash' => self::ask__( 'Revistas', 'Nenhuma Revista encontrado no lixo.' ),
		];

		// Definition of the post type arguments. For full list see:
		// http://codex.wordpress.org/Function_Reference/register_post_type
		$args = [
		'labels'              => $generated_labels,
		// 'menu_icon'           => 'dashicons-sticky',
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

<?php
/**
 * The post type class.
 *
 * @package leitura
 **/

namespace Air_Light;

/**
 * Registers the Eventos post type.
 */
class Eventos extends Post_Type {

  public function register() {

		// Modify all the i18ized strings here.
		$generated_labels = [
		// The Post_Type ask__ function wraps the air-helper ask__, and automatically registers the keys to Polylang!
		// self::ask__( 'Key', 'Default value' )
		// -> Key: Default value => 'Default value'
		'menu_name'          => self::ask__( 'Eventos', 'Eventos' ),
		'name'               => self::ask__( 'Eventos', 'Eventos' ),
		'singular_name'      => self::ask__( 'Eventos', 'Evento' ),
		'name_admin_bar'     => self::ask__( 'Eventos', 'Eventos' ),
		'add_new'            => self::ask__( 'Eventos', 'Add New' ),
		'add_new_item'       => self::ask__( 'Eventos', 'Add New Evento' ),
		'new_item'           => self::ask__( 'Eventos', 'New Evento' ),
		'edit_item'          => self::ask__( 'Eventos', 'Edit Evento' ),
		'view_item'          => self::ask__( 'Eventos', 'View Evento' ),
		'all_items'          => self::ask__( 'Eventos', 'All Eventos' ),
		'search_items'       => self::ask__( 'Eventos', 'Search Eventos' ),
		'parent_item_colon'  => self::ask__( 'Eventos', 'Parent Eventos:' ),
		'not_found'          => self::ask__( 'Eventos', 'No Eventos found.' ),
		'not_found_in_trash' => self::ask__( 'Eventos', 'No Eventos found in Trash.' ),
		];

		// Definition of the post type arguments. For full list see:
		// http://codex.wordpress.org/Function_Reference/register_post_type
		$args = [
		'labels'              => $generated_labels,
		'menu_icon'           => null,
		'public'              => true,
		'show_ui'             => true,
		'has_archive'         => false,
		'exclude_from_search' => false,
		'show_in_rest'        => false,
		'pll_translatable'    => true,
		'rewrite'             => [
        'with_front'  => false,
        'slug'        => 'eventos',
		],
		'supports'            => [ 'title', 'editor', 'thumbnail', 'revisions' ],
		'taxonomies'          => [ 'category_cidade_estado' ],
		];

		$this->register_wp_post_type( $this->slug, $args );
  }
}

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
		'menu_name'          => 'Eventos',
		'name'               => 'Eventos',
		'singular_name'      => 'Evento',
		'name_admin_bar'     => 'Eventos',
		'add_new'            => 'Add New',
		'add_new_item'       => 'Add New Evento',
		'new_item'           => 'New Evento',
		'edit_item'          => 'Edit Evento',
		'view_item'          => 'View Evento',
		'all_items'          => 'All Eventos',
		'search_items'       => 'Search Eventos',
		'parent_item_colon'  => 'Parent Eventos:',
		'not_found'          => 'No Eventos found.',
		'not_found_in_trash' => 'No Eventos found in Trash.',
		];

		// Definition of the post type arguments. For full list see:
		// http://codex.wordpress.org/Function_Reference/register_post_type
		$args = [
		'labels'              => $generated_labels,
		'menu_icon'           => 'dashicons-calendar',
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

<?php
/**
 * The post type class.
 *
 * @package leitura
 **/

namespace Air_Light;

/**
 * Registers the Tipinho post type.
 */
class Tipinho extends Post_Type {

  public function register() {

    // Modify all the i18ized strings here.
    $generated_labels = [
      // The Post_Type ask__ function wraps the air-helper ask__, and automatically registers the keys to Polylang!
      // self::ask__( 'Key', 'Default value' )
      // -> Key: Default value => 'Default value'
      'menu_name'          => self::ask__( 'Tipinho', 'Tipinho' ),
      'name'               => self::ask__( 'Tipinho', 'Tipinhos' ),
      'singular_name'      => self::ask__( 'Tipinho', 'Tipinho' ),
      'name_admin_bar'     => self::ask__( 'Tipinho', 'Tipinho' ),
      'add_new'            => self::ask__( 'Tipinho', 'Adicionar novo' ),
      'add_new_item'       => self::ask__( 'Tipinho', 'Adicionar novo tipinho' ),
      'new_item'           => self::ask__( 'Tipinho', 'Novo Tipinho' ),
      'edit_item'          => self::ask__( 'Tipinho', 'Editar Tipinho' ),
      'view_item'          => self::ask__( 'Tipinho', 'Ver Tipinho' ),
      'all_items'          => self::ask__( 'Tipinho', 'Todo os tipinhos' ),
      'search_items'       => self::ask__( 'Tipinho', 'Buscar tipinhos' ),
      'parent_item_colon'  => self::ask__( 'Tipinho', 'Tipinhos pais:' ),
      'not_found'          => self::ask__( 'Tipinho', 'Nenhum tipinho encontrado.' ),
      'not_found_in_trash' => self::ask__( 'Tipinho', 'Nenhum tipinho encontrado no lixo.' ),
    ];

    // Definition of the post type arguments. For full list see:
    // http://codex.wordpress.org/Function_Reference/register_post_type
    $args = [
      'labels'              => $generated_labels,
      'menu_icon'           => 'none',
      'public'              => true,
      'show_ui'             => true,
      'show_in_menu'        => true,
      // 'menu_position'       => 21,
      'has_archive'         => false,
      'exclude_from_search' => false,
      'show_in_rest'        => false,
      'pll_translatable'    => true,
      'rewrite'             => [
        'with_front'        => false,
        'slug'              => 'tipinho',
      ],
      'supports'            => [ 'title', 'editor', 'thumbnail', 'revisions' ],
      'taxonomies'          => [],
    ];

    $this->register_wp_post_type( $this->slug, $args );
  }
}

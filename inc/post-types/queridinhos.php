<?php
/**
 * Post type Queridinho.
 *
 * @package leitura
 **/

namespace Air_Light;

/**
 * Registers the Queridinho post type.
 */
class Queridinhos extends Post_Type {

  public function register() {
    // Modify all the i18ized strings here.
    $generated_labels = [
      // The Post_Type ask__ function wraps the air-helper ask__, and automatically registers the keys to Polylang!
      // self::ask__( 'Key', 'Default value' )
      // -> Key: Default value => 'Default value'
      'menu_name'          => 'Queridinhos',
      'name'               => 'Queridinhos',
      'singular_name'      => 'Queridinhos',
      'name_admin_bar'     => 'Queridinhos',
      'add_new'            => 'Adicionar novo',
      'add_new_item'       => 'Adicionar novo queridinho',
      'new_item'           => 'Novo queridinho',
      'edit_item'          => 'Editar queridinho',
      'view_item'          => 'Ver queridinho',
      'all_items'          => 'Todos os queridinhos',
      'search_items'       => 'Procurar queridinhos',
      'parent_item_colon'  => 'Mãe de queridinhos:',
      'not_found'          => 'Nenhum queridinho encontrado.',
      'not_found_in_trash' => 'Nenhum queridinho encontrado no lixo.',
    ];

    // Definition of the post type arguments. For full list see:
    // http://codex.wordpress.org/Function_Reference/register_post_type
    $args = [
      'labels'              => $generated_labels,
      'menu_icon'           => 'dashicons-book-alt',
      'public'              => true,
      'show_ui'             => true,
      'has_archive'         => true,
      'exclude_from_search' => false,
      'show_in_rest'        => true,
      'pll_translatable'    => true,
      'rewrite'             => [
        'with_front'  => false,
        'slug'        => 'queridinhos',
      ],
      'supports'            => [ 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'revisions' ],
      'taxonomies'          => [],
    ];

    $this->register_wp_post_type( $this->slug, $args );
  }
}

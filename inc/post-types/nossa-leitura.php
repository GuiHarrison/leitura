<?php
/**
 * Post type Nossa Leitura.
 *
 * @package leitura
 **/

namespace Air_Light;

/**
 * Registers the Nossa Leitura post type.
 */
class Nossa_Leitura extends Post_Type {

  public function register() {
    // Modify all the i18ized strings here.
    $generated_labels = [
      // The Post_Type ask__ function wraps the air-helper ask__, and automatically registers the keys to Polylang!
      // self::ask__( 'Key', 'Default value' )
      // -> Key: Default value => 'Default value'
      'menu_name'          => 'Nossa Leitura',
      'name'               => 'Nossas Leituras',
      'singular_name'      => 'Nossa Leitura',
      'name_admin_bar'     => 'Nossa Leitura',
      'add_new'            => 'Adicionar novo',
      'add_new_item'       => 'Adicionar novo Nossa Leitura',
      'new_item'           => 'Novo Nossa Leitura',
      'edit_item'          => 'Editar Nossa Leitura',
      'view_item'          => 'Ver Nossa Leitura',
      'all_items'          => 'Todos os Nossas Leituras',
      'search_items'       => 'Search Nossas Leituras',
      'parent_item_colon'  => 'Parent Nossas Leituras:',
      'not_found'          => 'Nenhum Nossas Leituras encontrado.',
      'not_found_in_trash' => 'Nenhum Nossas Leituras encontrado no lixo.',
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
        'slug'        => 'nossa-leitura',
      ],
      'supports'            => [ 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'revisions' ],
      'taxonomies'          => [],
    ];

    $this->register_wp_post_type( $this->slug, $args );
  }
}

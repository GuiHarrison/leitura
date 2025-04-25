<?php

/**
 * The post type class.
 *
 * @package leitura
 **/

namespace Air_Light;

/**
 * Registers the Vagas post type.
 */
class vagas extends Post_Type
{

  public function register()
  {

    $generated_labels = [
      'menu_name'          => 'Sistema RH',
      'name'               => 'Vagas',
      'singular_name'      => 'Sistema RH',
      'name_admin_bar'     => 'Vagas',
      'add_new'            => 'Adicionar nova',
      'add_new_item'       => 'Adicionar nova vaga',
      'new_item'           => 'Nova vaga',
      'edit_item'          => 'Editar vaga',
      'view_item'          => 'Ver vaga',
      'all_items'          => 'Todas as vagas',
      'search_items'       => 'Buscar vagas',
      'parent_item_colon'  => 'Vagas mães:',
      'not_found'          => 'Nenhuma vaga encontrado.',
      'not_found_in_trash' => 'Nenhuma vaga encontrado no lixo.',
    ];

    $args = [
      'labels'                => $generated_labels,
      'menu_icon'             => 'dashicons-megaphone',
      'public'                => true,
      'show_ui'               => true,
      'show_in_menu'          => true,
      'menu_position'         => 6,
      'has_archive'           => true,
      'exclude_from_search'   => false,
      'show_in_rest'          => true,
      'pll_translatable'      => true,
      'rewrite'               => [
        'with_front'            => false,
        'slug'                  => 'rh',
      ],
      'supports'              => ['title', 'revisions'],
      'taxonomies'            => ['category_cidade_estado', 'category_vagas'],
    ];

    $this->register_wp_post_type($this->slug, $args);

    $this->register_acf_rest();
  }
}

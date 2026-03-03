<?php

/**
 * A categoria de curadoria de livros
 *
 * @package leitura
 */

namespace Air_Light;

/**
 * Registra a taxonomia Curadoria
 *
 * @param Array $post_types Optional. Post types in
 * which the taxonomy should be registered.
 */

class Category_Curadoria extends Taxonomy
{


  public function register(array $post_types = [])
  {
    // Taxonomy labels.
    $labels = [
      'name'                  => 'Curadoria',
      'singular_name'         => 'Curadoria',
      'search_items'          => 'Buscar curadoria',
      'popular_items'         => 'Curadorias populares',
      'all_items'             => 'Todas as suas curadorias',
      'parent_item'           => 'Mãe de  curadoria',
      'parent_item_colon'     => 'Mãe de  curadoria',
      'edit_item'             => 'Editar curadoria',
      'update_item'           => 'Atualizar curadoria',
      'add_new_item'          => 'Adicionar nova curadoria',
      'new_item_name'         => 'Nova curadoria',
      'add_or_remove_items'   => 'Adicionar ou remover curadorias',
      'choose_from_most_used' => 'Escolher entre curadorias mais utilizadas',
      'menu_name'             => 'Curadoria',
    ];

    $args = [
      'labels'            => $labels,
      'public'            => true,
      'show_ui'           => true,
      'show_in_nav_menus' => true,
      'show_admin_column' => true,
      'show_tagcloud'     => true,
      'show_in_rest'      => true,
      'hierarchical'      => true,
      'query_var'         => true,
      'pll_translatable'  => true,
      'rewrite'           => [
        'slug' => 'curadoria',
      ],
    ];

    $this->register_wp_taxonomy($this->slug, $post_types, $args);
  }
}

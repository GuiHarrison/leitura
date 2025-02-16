<?php
/**
 * A categoria de gêneros de livros
 *
 * @package leitura
 */

namespace Air_Light;

/**
 * Registra a taxonomia Gêneros
 *
 * @param Array $post_types Optional. Post types in
 * which the taxonomy should be registered.
 */

class Category_Generos extends Taxonomy {


  public function register( array $post_types = [] ) {
    // Taxonomy labels.
    $labels = [
      'name'                  => 'Gêneros',
      'singular_name'         => 'Gênero',
      'search_items'          => 'Buscar gêneros',
      'popular_items'         => 'Gêneros populares',
      'all_items'             => 'Todos os seus gêneros',
      'parent_item'           => 'Mãe de  gênero',
      'parent_item_colon'     => 'Mãe de  gênero',
      'edit_item'             => 'Editar gênero',
      'update_item'           => 'Atualizar gênero',
      'add_new_item'          => 'Adicionar novo gênero',
      'new_item_name'         => 'Novo gênero',
      'add_or_remove_items'   => 'Adicionar ou remvoer gêneros',
      'choose_from_most_used' => 'Escolher entre gêneros mais utilizados',
      'menu_name'             => 'Gênero',
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
        'slug' => 'generos',
      ],
    ];

    $this->register_wp_taxonomy( $this->slug, $post_types, $args );
  }
}

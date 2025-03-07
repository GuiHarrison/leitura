<?php

/**
 * A categoria de vagas de livros
 *
 * @package leitura
 */

namespace Air_Light;

/**
 * Registra a taxonomia vagas
 *
 * @param Array $post_types Optional. Post types in
 * which the taxonomy should be registered.
 */

class Category_Vagas extends Taxonomy
{


  public function register(array $post_types = [])
  {
    // Taxonomy labels.
    $labels = [
      'name'                  => 'Vagas',
      'singular_name'         => 'Vaga',
      'search_items'          => 'Buscar vagas',
      'popular_items'         => 'Vagas populares',
      'all_items'             => 'Todos os seus vagas',
      'parent_item'           => 'Mãe de  vaga',
      'parent_item_colon'     => 'Mãe de  vaga',
      'edit_item'             => 'Editar vaga',
      'update_item'           => 'Atualizar vaga',
      'add_new_item'          => 'Adicionar novo vaga',
      'new_item_name'         => 'Novo vaga',
      'add_or_remove_items'   => 'Adicionar ou remvoer vagas',
      'choose_from_most_used' => 'Escolher entre vagas mais utilizados',
      'menu_name'             => 'Vaga',
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
        'slug' => 'vaga',
      ],
    ];

    $this->register_wp_taxonomy($this->slug, $post_types, $args);
  }
}

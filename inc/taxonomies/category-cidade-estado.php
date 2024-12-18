<?php
/**
 * The taxonomy class.
 *
 * @package leitura
 */

namespace Air_Light;

/**
 * Registers the Cidade e estado taxonomy.
 *
 * @param Array $post_types Optional. Post types in
 * which the taxonomy should be registered.
 */
class Category_Cidade_Estado extends Taxonomy {

  public function register( array $post_types = ['lojas'] ) {
    // Taxonomy labels.
    $labels = [
      'name'                  => self::ask__( 'Cidade e estado', 'Cidades e estados' ),
      'singular_name'         => self::ask__( 'Cidade e estado', 'Cidade ou estado' ),
      'search_items'          => self::ask__( 'Cidade e estado', 'Buscar cidade ou estado' ),
      'popular_items'         => self::ask__( 'Cidade e estado', 'Cidades e estados populares' ),
      'all_items'             => self::ask__( 'Cidade e estado', 'Todas as cidades e estados' ),
      'parent_item'           => self::ask__( 'Cidade e estado', 'Estado' ),
      'parent_item_colon'     => self::ask__( 'Cidade e estado', 'Estado' ),
      'edit_item'             => self::ask__( 'Cidade e estado', 'Editar Cidade e estado' ),
      'update_item'           => self::ask__( 'Cidade e estado', 'Atualizar cidade ou estado' ),
      'add_new_item'          => self::ask__( 'Cidade e estado', 'Adicionar cidade ou estado' ),
      'new_item_name'         => self::ask__( 'Cidade e estado', 'Nova cidade ou estado' ),
      'add_or_remove_items'   => self::ask__( 'Cidade e estado', 'Adicionar ou remover cidade ou estado' ),
      'choose_from_most_used' => self::ask__( 'Cidade e estado', 'Cidades e estados mais usados' ),
      'menu_name'             => self::ask__( 'Cidade e estado', 'Cidade e estado' ),
    ];https://meet.google.com/erx-shqg-kas?pli=1&authuser=1

    $args = [
      'labels'            => $labels,
      'public'            => true,
      'show_in_nav_menus' => true,
      'show_admin_column' => true,
      'hierarchical'      => true,
      'show_tagcloud'     => false,
      'query_var'         => false,
      'pll_translatable'  => true,
    ];

    $this->register_wp_taxonomy( $this->slug, $post_types, $args );
  }

}
// Código original:
// register_taxonomy("category_cidade_estado", array("lojas"), array("hierarchical" => true, "label" => "Cidade e Estado"));

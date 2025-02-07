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

  public function register( array $post_types = [ 'lojas' ] ) {
		// Taxonomy labels.
		$labels = [
		'name'                  => 'Cidades e estados',
		'singular_name'         => 'Cidade ou estado',
		'search_items'          => 'Buscar cidade ou estado',
		'popular_items'         => 'Cidades e estados populares',
		'all_items'             => 'Todas as cidades e estados',
		'parent_item'           => 'Estado',
		'parent_item_colon'     => 'Estado',
		'edit_item'             => 'Editar Cidade e estado',
		'update_item'           => 'Atualizar cidade ou estado',
		'add_new_item'          => 'Adicionar cidade ou estado',
		'new_item_name'         => 'Nova cidade ou estado',
		'add_or_remove_items'   => 'Adicionar ou remover cidade ou estado',
		'choose_from_most_used' => 'Cidades e estados mais usados',
		'menu_name'             => 'Cidade e estado',
		];

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

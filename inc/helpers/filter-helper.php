<?php

/**
 * Helper functions for dual taxonomy filtering
 *
 * @package leitura
 */

namespace Air_Light;

/**
 * Get the current active category filter
 *
 * @return int|null Category ID or null
 */
function get_current_category_id()
{
  if (is_category()) {
    return get_queried_object()->term_id;
  }

  $cat_param = isset($_GET['cat']) ? intval($_GET['cat']) : 0;
  return $cat_param > 0 ? $cat_param : null;
}

/**
 * Get the current active curadoria filter
 *
 * @return string|null Curadoria slug or null
 */
function get_current_curadoria_slug()
{
  if (is_tax('category_curadoria')) {
    return get_queried_object()->slug;
  }

  return isset($_GET['curadoria']) ? sanitize_text_field($_GET['curadoria']) : null;
}

/**
 * Build a filter URL with both category and curadoria parameters
 *
 * @param int|null $category_id Category ID
 * @param string|null $curadoria_slug Curadoria slug
 * @return string The filtered URL
 */
function build_filter_url($category_id = null, $curadoria_slug = null)
{
  $base_url = home_url('/blog/');
  $params = [];

  if ($category_id) {
    $cat = get_category($category_id);
    if ($cat) {
      $base_url = get_category_link($category_id);
      // Remove trailing slash for adding query params
      $base_url = rtrim($base_url, '/');
    }
  }

  if ($curadoria_slug) {
    // Get curadoria term to verify it exists
    $curadoria = get_term_by('slug', $curadoria_slug, 'category_curadoria');
    if ($curadoria) {
      if ($category_id) {
        // If both are set, use base category URL with curadoria as query param
        $params['curadoria'] = $curadoria_slug;
      } else {
        // If only curadoria is set, use its term link
        $base_url = rtrim(get_term_link($curadoria), '/');
      }
    }
  }

  if (!empty($params)) {
    return add_query_arg($params, $base_url);
  }

  return $base_url . '/';
}

/**
 * Get posts filtered by both category and curadoria
 *
 * @param array $args Additional WP_Query arguments
 * @return WP_Query Query object with posts
 */
function get_filtered_posts($args = [])
{
  $category_id = get_current_category_id();
  $curadoria_slug = get_current_curadoria_slug();

  $tax_query = [];

  if ($category_id) {
    $tax_query[] = [
      'taxonomy' => 'category',
      'field' => 'term_id',
      'terms' => $category_id,
    ];
  }

  if ($curadoria_slug) {
    $tax_query[] = [
      'taxonomy' => 'category_curadoria',
      'field' => 'slug',
      'terms' => $curadoria_slug,
    ];
  }

  // If both filters are active, use AND relation
  if (count($tax_query) > 1) {
    $args['tax_query'] = [
      'relation' => 'AND',
      ...$tax_query,
    ];
  } elseif (count($tax_query) === 1) {
    $args['tax_query'] = $tax_query;
  }

  // Default query args
  $defaults = [
    'post_type' => 'post',
    'posts_per_page' => get_option('posts_per_page'),
    'paged' => get_query_var('paged') ? intval(get_query_var('paged')) : 1,
  ];

  $final_args = array_merge($defaults, $args);

  return new \WP_Query($final_args);
}

/**
 * Initialize dual filter query modification
 * Adds a hook to modify the main query when both filters are present
 */
function init_dual_filter_query()
{
  if (!is_admin()) {
    add_action('pre_get_posts', function ($query) {
      if (!$query->is_main_query()) {
        return;
      }

      // Only apply on taxonomy pages or when filters are present in query string
      if (!is_tax('category') && !is_category() && !is_tax('category_curadoria') && !isset($_GET['curadoria'])) {
        return;
      }

      $category_id = get_current_category_id();
      $curadoria_slug = get_current_curadoria_slug();

      $tax_query = [];

      // If there's a curadoria filter on a category page, add it to tax_query
      if ($category_id && $curadoria_slug) {
        $tax_query = [
          'relation' => 'AND',
          [
            'taxonomy' => 'category',
            'field' => 'term_id',
            'terms' => $category_id,
          ],
          [
            'taxonomy' => 'category_curadoria',
            'field' => 'slug',
            'terms' => $curadoria_slug,
          ],
        ];
        $query->set('tax_query', $tax_query);
      } elseif ($curadoria_slug && !is_category()) {
        // If only curadoria is set and we're not on a category page, set it
        $query->set('tax_query', [
          [
            'taxonomy' => 'category_curadoria',
            'field' => 'slug',
            'terms' => $curadoria_slug,
          ],
        ]);
      }
    });
  }
}

// Initialize the dual filter
init_dual_filter_query();

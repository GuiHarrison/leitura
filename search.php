<?php

/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package leitura
 */

namespace Air_Light;

$results = [];

// phpcs:ignore WordPress.Security.NonceVerification.Recommended
if (! empty($_GET['s']) && have_posts()) {
  while (have_posts()) {
    the_post();
    $post_type = get_post_type();

    if ($post_type === 'post') {
      // Pegar a categoria do post
      $categories = get_the_category();
      if (!empty($categories)) {
        foreach ($categories as $category) {
          $results['post']['categories'][$category->term_id]['name'] = $category->name;
          $results['post']['categories'][$category->term_id]['posts'][] = [
            'title'     => (string) get_the_title(),
            'permalink' => (string) get_permalink(),
            'excerpt'   => (string) get_the_excerpt(),
          ];
        }
      } else {
        // Para caso seja sem categoria
        $results['post']['categories']['uncategorized']['name'] = 'Sem categoria';
        $results['post']['categories']['uncategorized']['posts'][] = [
          'title'     => (string) get_the_title(),
          'permalink' => (string) get_permalink(),
          'excerpt'   => (string) get_the_excerpt(),
        ];
      }
    } else {
      $results[$post_type]['posts'][] = [
        'title'     => (string) get_the_title(),
        'permalink' => (string) get_permalink(),
        'excerpt'   => (string) get_the_excerpt(),
      ];
    }
  }
}
wp_reset_postdata();

// Get post type objects for results
foreach ($results as $slug => $post_type) {
  $results[$slug]['object'] = (object) get_post_type_object($slug);
  $results[$slug]['count'] = ($slug === 'post')
    ? array_sum(array_map(function ($cat) {
      return count($cat['posts']);
    }, $post_type['categories']))
    : count($post_type['posts']);
}

get_header(); ?>

<main class="site-main">

  <section class="block block-search">
    <div class="container">
      <h1><?php echo esc_html('Busca'); ?></h1>
    </div>
  </section>

  <?php if (! empty($results)) : ?>
    <section class="block block-search-results">
      <div class="container">

        <?php foreach ($results as $slug => $post_type) : ?>
          <div class="col col-results col-results-<?php echo esc_attr($slug) ?>">

            <?php if ($slug === 'post') : ?>
              <?php foreach ($post_type['categories'] as $category_id => $category) : ?>
                <h2>
                  <?php echo esc_html($category['name']); ?> &nbsp;
                  (<?php echo esc_html(count($category['posts'])); ?>)
                </h2>
                <?php foreach ($category['posts'] as $post) : ?>
                  <div class="row row-result row-result-<?php echo esc_attr($slug) ?>">
                    <div class="content">
                      <h4>
                        <a href="<?php echo esc_url($post['permalink']) ?>">
                          <?php echo esc_html($post['title']) ?>
                        </a>
                      </h4>
                      <p><?php echo wp_kses_post($post['excerpt']) ?></p>
                    </div>
                  </div>
                <?php endforeach; ?>
              <?php endforeach; ?>
            <?php else : ?>
              <h2>
                <?php echo esc_html($post_type['object']->labels->name); ?>&nbsp;
                (<?php echo esc_html($post_type['count']); ?>)
              </h2>
              <?php foreach ($post_type['posts'] as $post) : ?>
                <div class="row row-result row-result-<?php echo esc_attr($slug) ?>">
                  <div class="content">
                    <h3>
                      <a href="<?php echo esc_url($post['permalink']) ?>">
                        <?php echo esc_html($post['title']) ?>
                      </a>
                    </h3>
                    <p><?php echo wp_kses_post($post['excerpt']) ?></p>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>

      </div>
    </section>
  <?php endif; ?>

  <?php
  // "No results" message block
  // phpcs:ignore WordPress.Security.NonceVerification.Recommended
  if (! empty($_GET['s']) && ! have_posts()) : ?>
    <section class="block block-search-results">
      <div class="container">
        <h2><?php echo esc_html('No results found for your search'); ?>.</h2>
      </div>
    </section>
  <?php endif; ?>

</main>

<?php get_footer();

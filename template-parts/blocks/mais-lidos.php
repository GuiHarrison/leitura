<?php

/**
 * Bloco para posts mais lidos ajustado ao layout do Figma
 *
 * @package airclean
 */

namespace Air_Light;

$ppp = (get_field('ppp')) ? get_field('ppp') : 2;
$category = isset($args['category']) ? $args['category'] : null;

$query_args = [
  'meta_query' => [[
    'key' => 'destaque',
    'value' => '"mais-lidos"',
    'compare' => 'LIKE',
  ]],
  'posts_per_page' => $ppp,
];

// Adiciona filtro por categoria se uma categoria foi passada
if ($category) {
  $query_args['cat'] = $category;
}

$posts = get_posts($query_args);

if ($posts) {
  global $post;
  $contador = 0;
?>

  <section id="mais-lidos" class="publicacoes publicacoes-container">

    <div class="titulo">
      <h2 class="titulo-publicacoes">Mais lidos</h2>
    </div>

    <div class="publicacoes-grid grid">
      <?php
      foreach ($posts as $post) {
        setup_postdata($post);
        $contador++;
      ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class('publicacao-item'); ?>>
          <?php if ($contador === 1 && has_post_thumbnail()) : ?>
            <div class="publicacao-thumbnail">
              <?php the_post_thumbnail('destaque-home', ['loading' => 'lazy', 'fetchpriority' => 'low']); ?>
            </div>
          <?php endif; ?>
          <div class="detalhes-do-post">
            <?php if (has_category()) : ?>
              <ul class="categories">
                <?php
                $categories = wp_get_post_categories(get_the_id(), ['fields' => 'all']);
                if (! empty($categories)) {
                  foreach ($categories as $category) {
                    echo '<li><a href="' . esc_url(get_category_link($category)) . '">' . esc_html($category->name) . '</a></li>';
                  }
                }
                ?>
              </ul>
            <?php endif; ?>

            <h3 class="<?php echo esc_attr(get_post_type()); ?>-title title">
              <a href="<?php echo esc_url(get_the_permalink()); ?>" class="sublinhado-bonito">
                <?php the_title(); ?>
              </a>
            </h3>

            <div class="publicacao-excerpt">
              <?php the_excerpt(); ?>
            </div>

            <?php echo get_template_part('template-parts/snippets/data-publicacao'); ?>

          </div>
        </article>
      <?php
      }
      wp_reset_postdata();
      ?>
    </div>

  </section>

<?php
}
?>
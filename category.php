<?php

/**
 * The main template file
 *
 *
 * @package leitura
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 */

namespace Air_Light;

function is_resenhas_category()
{
  $current_cat = get_queried_object();
  $resenhas_id = 403; // ID da categoria "se-liga-na-leitura"

  // Verifica se é a própria categoria ou uma filha
  return ($current_cat->category_parent === $resenhas_id || $current_cat->term_id === $resenhas_id);
}

get_header();
?>

<div class="site-main container">

  <?php

  if (is_resenhas_category()) {
    echo '<section id="colunas-e-resenhas" class="publicacoes colunas-e-resenhas block-blog">';
    get_template_part('template-parts/blocks/colunas-resenhas');
  } else {
    echo '<section class="block-blog">';
    // get_template_part('template-parts/blocks/post-destaque');
  ?>

    <main class="main grid-container grid">
      <?php
      if (have_posts()) :

        while (have_posts()) :
          the_post();
          $thumb = get_the_post_thumbnail(get_the_ID(), 'destaque-home', array('loading' => 'lazy', 'fetchpriority' => 'low'));
      ?>

          <article id="post-<?php the_ID(); ?>" <?php post_class('block'); ?>>

            <a href="<?php echo esc_url(get_the_permalink()); ?>" class="thumbnail">
              <?php
              if ($thumb) {
                echo $thumb;
              }
              ?>
            </a>

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

              <h3 class="post-title">
                <a href="<?php echo esc_url(get_the_permalink()); ?>">
                  <?php the_title(); ?>
                </a>
              </h3>

              <div class="content"> <?php the_excerpt(); ?> </div>

              <p>
                <time datetime="<?php the_time('c'); ?>">
                  <?php echo get_the_date(get_option('date_format')); ?>
                </time>
              </p>
            </div>

          </article>
        <?php
        endwhile;
        ?>

      <?php
        the_posts_pagination();
      endif;
      ?>
    </main>

  <?php } ?>

  <div id="sidebar" class="sidebar">
    <?php get_sidebar(); ?>
  </div>

  </section>

  <aside class="grid cta-rodape">
    <?php get_template_part('template-parts/blocks/revista'); ?>
    <?php get_template_part('template-parts/blocks/cta-3-3'); ?>
  </aside>

  <aside class="cta-rodape">
    <?php
    if (is_resenhas_category()) {
      get_template_part('template-parts/blocks/form-seliga');
    } else {
      get_template_part('template-parts/blocks/cta-news');
    }
    ?>
  </aside>

</div>

<?php get_footer();

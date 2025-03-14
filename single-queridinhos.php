<?php

/**
 * The template for displaying all single posts
 *
 * @Date:   2019-10-15 12:30:02
 * @Last Modified by:   Roni Laukkarinen
 * @Last Modified time: 2022-09-07 11:57:39
 *
 * @package leitura
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 */

namespace Air_Light;

the_post();
get_header();
$thumb = get_the_post_thumbnail(get_the_ID(), 'resenha-g', array('loading' => 'lazy', 'fetchpriority' => 'low'));
$cor = get_field('fundo_do_livro', get_the_ID()) ? get_field('fundo_do_livro', get_the_ID()) : '#e6e6e6';
?>

<main class="site-main">

  <section class="block block-single">
    <article class="article-content">

      <?php
      if ('post' === get_post_type()) :
        if (has_category()) : ?>
          <ul class="categories">
            <?php $categories = wp_get_post_categories(get_the_id(), ['fields' => 'all']);
            if (! empty($categories)) {
              foreach ($categories as $category) {
                echo '<li><a href="' . esc_url(get_category_link($category)) . '">' . esc_html($category->name) . '</a></li>';
              }
            } ?>
          </ul>
      <?php endif;

      endif;
      ?>

      <h1><?php the_title(); ?></h1>
      <div class="thumbnail livro-thumbnail" style="background-color: <?php echo $cor; ?>">
        <?php echo $thumb; ?>
      </div>

      <div class="data-e-autor">
        <?php get_template_part('template-parts/snippets/data-publicacao'); ?>
        <p><?php echo esc_html(get_the_author()); ?></p>
      </div>

      <?php the_content();

      // Required by WordPress Theme Check, feel free to remove as it's rarely used in starter themes
      wp_link_pages(array('before' => '<div class="page-links">' . esc_html__('Pages:', 'leitura'), 'after' => '</div>'));

      entry_footer();

      if (get_edit_post_link()) {
        edit_post_link(sprintf(wp_kses(__('Edit <span class="screen-reader-text">%s</span>', 'leitura'), ['span' => ['class' => []]]), get_the_title()), '<p class="edit-link">', '</p>');
      }

      get_template_part('template-parts/blocks/slider-queridinhos');

      // If comments are open or we have at least one comment, load up the comment template.
      if (comments_open() || get_comments_number()) {
        comments_template();
      } ?>

    </article>
  </section>

</main>

<?php get_footer();

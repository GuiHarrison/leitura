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
$is_resenha = get_post_type() === 'queridinhos' || in_array(403, wp_get_post_categories(get_the_ID()));
// $classe_livro = $is_resenha ? ' livro-thumbnail' : '';
$cor = get_field('fundo_do_livro', get_the_ID()) ? get_field('fundo_do_livro', get_the_ID()) : '#f7f7f7';
// $thumbsize = $is_resenha ? 'resenha-p' : 'post';
$thumb = get_the_post_thumbnail(get_the_ID(), 'post', array('loading' => 'lazy', 'fetchpriority' => 'low'));
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

      // $tags_list = get_the_tag_list('', esc_attr_x(', ', 'list item separator', 'leitura'));
      // if ($tags_list) {
      //   the_tags('<ul class="tags"><li>', '</li><li>', '</li></ul>');
      // }
      endif;
      ?>

      <h1><?php the_title(); ?></h1>
      <div class="data-e-autor">
        <?php get_template_part('template-parts/snippets/data-publicacao'); ?>
        <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>"><?php echo esc_html(get_the_author()); ?></a>
      </div>

      <?php if (get_field('thumb_no_post', get_the_ID())) : ?>
        <div class="thumbnail" style="background-color: <?php echo $cor; ?>">
          <?php echo $thumb; ?>
        </div>
      <?php endif; ?>

      <?php the_content();

      // Required by WordPress Theme Check, feel free to remove as it's rarely used in starter themes
      wp_link_pages(array('before' => '<div class="page-links">' . esc_html__('Pages:', 'leitura'), 'after' => '</div>'));

      entry_footer();

      if (get_edit_post_link()) {
        edit_post_link(sprintf(wp_kses(__('Edit <span class="screen-reader-text">%s</span>', 'leitura'), ['span' => ['class' => []]]), get_the_title()), '<p class="edit-link">', '</p>');
      }

      // Navegação personalizada
      $prev_post = get_previous_post();
      $next_post = get_next_post();

      if ($prev_post || $next_post) : ?>
        <nav class="navigation post-navigation">
          <h2>Leia também</h2>
          <div class="grid prev-next">
            <?php if ($prev_post) : ?>
              <article class="nav-previous">
                <?php
                $prev_categories = wp_get_post_categories($prev_post->ID, ['fields' => 'all']);
                if (!empty($prev_categories)) : ?>
                  <ul class="categories">
                    <?php foreach ($prev_categories as $category) : ?>
                      <li><a href="<?php echo esc_url(get_category_link($category)); ?>"><?php echo esc_html($category->name); ?></a></li>
                    <?php endforeach; ?>
                  </ul>
                <?php endif; ?>
                <h3 class="post-title"><a href="<?php echo get_permalink($prev_post->ID); ?>" rel="prev"><?php echo get_the_title($prev_post->ID); ?></a></h3>
                <p class="post-excerpt"><?php echo get_the_excerpt($prev_post->ID); ?></p>
                <time datetime="<?php echo get_the_time('c', $prev_post->ID); ?>">
                  <?php echo '→ ' . date_i18n('j \d\e M \d\e Y', get_post_time('U', false, $prev_post->ID)); ?>
                </time>
              </article>
            <?php endif;

            if ($next_post) : ?>
              <article class="nav-next">
                <?php
                $next_categories = wp_get_post_categories($next_post->ID, ['fields' => 'all']);
                if (!empty($next_categories)) : ?>
                  <ul class="categories">
                    <?php foreach ($next_categories as $category) : ?>
                      <li><a href="<?php echo esc_url(get_category_link($category)); ?>"><?php echo esc_html($category->name); ?></a></li>
                    <?php endforeach; ?>
                  </ul>
                <?php endif; ?>
                <h3 class="post-title"><a href="<?php echo get_permalink($next_post->ID); ?>" rel="next"><?php echo get_the_title($next_post->ID); ?></a></h3>
                <p class="post-excerpt"><?php echo get_the_excerpt($next_post->ID); ?></p>
                <time datetime="<?php echo get_the_time('c', $next_post->ID); ?>">
                  <?php echo '→ ' . date_i18n('j \d\e M \d\e Y', get_post_time('U', false, $next_post->ID)); ?>
                </time>
              </article>
            <?php endif; ?>
          </div>
        </nav>
      <?php endif;

      // If comments are open or we have at least one comment, load up the comment template.
      if (comments_open() || get_comments_number()) {
        comments_template();
      } ?>

    </article>
  </section>

</main>

<?php get_footer();

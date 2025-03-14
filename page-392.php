<?php

/**
 * Tela de Queridinhos da Leitura
 *
 * @package leitura
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 */

namespace Air_Light;

get_header();
$thumb = get_the_post_thumbnail(get_the_ID(), 'post', array('loading' => 'lazy', 'fetchpriority' => 'low'));
?>

<main class="site-main">
  <section class="block block-single">
    <article class="article-content queridinhos revista">

      <?php
      $posts = get_posts(array(
        'post_type' => 'revista',
        'posts_per_page' => 1,
      ));

      if ($posts) {
        global $post;
      ?>

        <?php
        foreach ($posts as $post) {
          setup_postdata($post);
          $ordem = get_field('queridinho_n', get_the_ID());
          $comprar = get_field('link_na_loja');
        ?>

          <h1><?php the_title(); ?></h1>
          <a href="<?php echo esc_url(get_the_permalink()); ?>" class="thumbnail">
            <?php echo $thumb; ?>
          </a>
          <a href="<?php echo esc_url(get_the_permalink()); ?>" class="button ler">Acessar revista</a>

      <?php
        }
        wp_reset_postdata();
      }
      ?>

      <?php get_template_part('template-parts/blocks/form-seliga'); ?>

    </article>
  </section>
</main>

<?php get_footer(); ?>
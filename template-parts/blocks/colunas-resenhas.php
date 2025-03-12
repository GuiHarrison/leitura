<?php

namespace Air_Light;

if (have_posts()) :
?>
  <div class="resenhas-container">
    <div class="grid">
      <?php get_template_part('template-parts/blocks/slider-destaques'); ?>

      <?php
      while (have_posts()) :
        the_post();
        $autoria = get_field('autoria', get_the_id());
        $citacao = get_field('citacao', get_the_id());
        $usuário = get_the_author_meta('ID');
        $foto = get_field('foto_usuario', 'user_' . $usuário);
        $foto = wp_get_attachment_image_src($foto, 'foto-perfil');
        $foto = $foto ? $foto[0] : '';
      ?>
        <article id="post-<?php the_ID(); ?>" class="resenha-item">
          <a href="<?php echo esc_url(get_the_permalink()); ?>" class="thumbnail">
            <?php the_post_thumbnail('post', array('loading' => 'lazy', 'fetchpriority' => 'low')); ?>
          </a>

          <div class="resenha-titulo">
            <h3 class="post-title">
              <a class="sublinhado-bonito" href="<?php echo esc_url(get_the_permalink()); ?>">
                <?php the_title(); ?>
              </a>
            </h3>
            <h4 class="resenha-autor">
              <a href="<?php echo esc_url(get_the_permalink()); ?>">
                <?php echo esc_html($autoria); ?>
              </a>
            </h4>
          </div>

          <div class="autor-info">
            <img class="aspas" src="<?php echo get_theme_file_uri('/img/aspas.svg'); ?>">
            <img src="<?php echo esc_url($foto); ?>" alt="Autor: <?php echo esc_html(get_the_author()); ?>" class="autor-foto">
            <h5 class="autor-nome"><?php echo esc_html(get_the_author()); ?></h5>
          </div>

          <a href="<?php echo esc_url(get_the_permalink()); ?>" class="resenha-citacao sublinhado-bonito">
            <span class="aspas">“</span>
            <?php echo esc_html($citacao ? $citacao : wp_trim_words(get_the_excerpt(), 20, '[…]')); ?>
            <span class="aspas">”</span>
          </a>

          <div class="resenha-data">
            <?php echo get_template_part('template-parts/snippets/data-publicacao'); ?>
          </div>
        </article>
      <?php endwhile; ?>
    </div>

    <?php
    the_posts_pagination(array(
      'prev_text' => __('Anterior'),
      'next_text' => __('Próximo'),
      'mid_size'  => 1,
      'end_size'  => 1
    ));
    ?>
  </div>
<?php endif; ?>
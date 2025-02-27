<?php

/**
 * Bloco para descrição de um livro no post
 *
 * @package airclean
 */

namespace Air_Light;

if (have_rows('livros')) {
?>
  <section class="livros">
    <?php
    while (have_rows('livros')) {
      the_row();
      $capa = get_sub_field('l-capa');
      $titulo = get_sub_field('l-titulo');
      $autor = get_sub_field('l-autor');
      $descricao = get_sub_field('l-descricao');
      $link = get_sub_field('l-link');
    ?>
      <article class="livro">
        <div class="livro-thumbnail">
          <?php if ($link) { ?>
            <a href="<?php echo esc_html($link); ?>">
            <?php } ?>
            <picture>
              <img src="<?php echo esc_url($capa['url']); ?>" alt="<?php echo esc_attr($capa['alt']); ?>">
            </picture>
            <?php if ($link) { ?>
            </a>
          <?php } ?>
        </div>
        <div class="detalhes-do-livro">
          <h3 class="l-titulo"><?php echo esc_html($titulo); ?> <span class="autor"><?php echo esc_html($autor); ?></span></h3>
          <p class="descricao"><?php echo esc_html($descricao); ?></p>
        </div>
      </article>
    <?php
    }
    ?>
  </section>
<?php
}
?>
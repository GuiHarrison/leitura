<?php

/**
 * Site branding & logo
 *
 * @package leitura
 */

namespace Air_Light;

$description = get_bloginfo('description', 'display');
?>

<div class="barra-topo barra-logo-busca-redes">

  <div class="site-branding">
    <p class="site-title">
      <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
        <span class="screen-reader-text"><?php bloginfo('name'); ?></span>
        <?php include get_theme_file_path(THEME_SETTINGS['logo']); ?>
      </a>
    </p>
    <?php if ($description || is_customize_preview()) : ?>
      <p class="site-description screen-reader-text">
        <?php echo esc_html($description); ?>
      </p>
    <?php endif; ?>
  </div>

  <div class="busca">
    <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
      <input type="search"
        name="s"
        value="<?php echo get_search_query(); ?>"
        placeholder="Procurar…"
        aria-label="Pesquisar" />
      <button type="submit"></button>
    </form>
  </div>

  <?php get_template_part('template-parts/snippets/redes-sociais'); ?>

</div>
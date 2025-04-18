<?php

/**
 * Navigation layout.
 *
 * @package leitura
 */

namespace Air_Light;

?>


<nav id="nav" class="barra-topo barra-navegação nav-primary nav-menu" aria-label="<?php echo esc_html('Main navigation'); ?>">
  <div class="container">
    <button aria-haspopup="true" aria-expanded="false" aria-controls="nav" id="nav-toggle" class="nav-toggle" type="button" aria-label="<?php echo esc_html('Abrir menu'); ?>">
      <span class="hamburger" aria-hidden="true"></span>
    </button>

    <div id="menu-items-wrapper" class="menu-items-wrapper">
      <div class="logo-preta hide-on-desktop-nav-view">
        <?php include get_theme_file_path(THEME_SETTINGS['logo-simbolo-preta']); ?>
      </div>

      <?php wp_nav_menu(array(
        'theme_location' => 'primary',
        'container'      => false,
        'depth'          => 4,
        'menu_class'     => 'menu-items',
        'menu_id'        => 'main-menu',
        'echo'           => true,
        'fallback_cb'    => __NAMESPACE__ . '\Nav_Walker::fallback',
        'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
        'has_dropdown'   => true,
        'walker'         => new Nav_Walker(),
      )); ?>

      <div class="hide-on-desktop-nav-view">
        <?php get_template_part('template-parts/snippets/redes-sociais'); ?>
      </div>
    </div>

  </div>
</nav>

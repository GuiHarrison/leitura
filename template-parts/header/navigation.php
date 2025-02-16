<?php
/**
 * Navigation layout.
 *
 * @package leitura
 */

namespace Air_Light;

?>

<script>
  function ajustarPosicaoMenu() {
    const logo = document.querySelector(".site-branding");
    const menu = document.querySelector(".barra-navegação");

    if (logo && menu) {
      if (window.innerWidth < 1024) {
        let logoRect = logo.getBoundingClientRect();
        let menuHeight = menu.clientHeight;

        let novoTop = logoRect.top + (logoRect.height / 2) - (menuHeight / 2);

        menu.style.top = `${novoTop}px`;
      } else {
        menu.style.top = ""; 
      }
    }
  }

  window.addEventListener("load", ajustarPosicaoMenu);
  window.addEventListener("resize", ajustarPosicaoMenu);

</script>


<nav id="nav" class="barra-topo barra-navegação nav-primary nav-menu" aria-label="<?php echo esc_html( 'Main navigation' ); ?>">
  <div class="container">
    <button aria-haspopup="true" aria-expanded="false" aria-controls="nav" id="nav-toggle" class="nav-toggle" type="button" aria-label="<?php echo esc_html( 'Abrir menu' ); ?>">
      <span class="hamburger" aria-hidden="true"></span>
    </button>

    <div id="menu-items-wrapper" class="menu-items-wrapper">
      <div class="logo-preta hide-on-desktop-nav-view">
        <?php include get_theme_file_path( THEME_SETTINGS['logo-simbolo-preta'] ); ?>
      </div>

      <?php wp_nav_menu( array(
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
      ) ); ?>

      <ul class="redes-sociais hide-on-desktop-nav-view">
        <li><a href=""><span class="screen-reader-text">Instagram</span></a> <?php include get_theme_file_path( THEME_SETTINGS['Instagram'] ) ?> </li>
        <li><a href=""><span class="screen-reader-text">WhatsApp</span></a> <?php include get_theme_file_path( THEME_SETTINGS['WhatsApp'] ) ?> </li>
        <li><a href=""><span class="screen-reader-text">TikTok</span></a> <?php include get_theme_file_path( THEME_SETTINGS['TikTok'] ) ?> </li>
        <li><a href=""><span class="screen-reader-text">LinkedIn</span></a> <?php include get_theme_file_path( THEME_SETTINGS['LinkedIn'] ) ?> </li>
        <li><a href=""><span class="screen-reader-text">Facebook</span></a> <?php include get_theme_file_path( THEME_SETTINGS['Facebook'] ) ?> </li>
        <li><a href=""><span class="screen-reader-text">Youtube</span></a> <?php include get_theme_file_path( THEME_SETTINGS['Youtube'] ) ?> </li>
      </ul>
    </div>
    
  </div>
</nav>

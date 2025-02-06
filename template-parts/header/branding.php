<?php
/**
 * Site branding & logo
 *
 * @package leitura
 */

namespace Air_Light;

$description = get_bloginfo( 'description', 'display' );
?>

<div class="barra-topo barra-logo-busca-redes">

  <div class="site-branding">
    <p class="site-title">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
        <span class="screen-reader-text"><?php bloginfo( 'name' ); ?></span>
        <?php include get_theme_file_path( THEME_SETTINGS['logo'] ); ?>
      </a>
    </p>
    <?php if ( $description || is_customize_preview() ) : ?>
      <p class="site-description screen-reader-text">
        <?php echo esc_html( $description ); ?>
      </p>
    <?php endif; ?>
  </div>

  <div class="busca">
    <form action="">
      <input type="search" placeholder="Busque aqui por título, autor, editora ou código de barras…" aria-label="Pesquisar"/>
      <button type="submit"></button>
    </form>
  </div>
  
  <ul class="redes-sociais hide-on-mobile-nav-view">
    <li><a href=""><span class="screen-reader-text">Instagram</span></a> <?php include get_theme_file_path( THEME_SETTINGS['Instagram'] ) ?> </li>
    <li><a href=""><span class="screen-reader-text">WhatsApp</span></a> <?php include get_theme_file_path( THEME_SETTINGS['WhatsApp'] ) ?> </li>
    <li><a href=""><span class="screen-reader-text">TikTok</span></a> <?php include get_theme_file_path( THEME_SETTINGS['TikTok'] ) ?> </li>
    <li><a href=""><span class="screen-reader-text">LinkedIn</span></a> <?php include get_theme_file_path( THEME_SETTINGS['LinkedIn'] ) ?> </li>
    <li><a href=""><span class="screen-reader-text">Facebook</span></a> <?php include get_theme_file_path( THEME_SETTINGS['Facebook'] ) ?> </li>
    <li><a href=""><span class="screen-reader-text">Youtube</span></a> <?php include get_theme_file_path( THEME_SETTINGS['Youtube'] ) ?> </li>
  </ul>

</div>

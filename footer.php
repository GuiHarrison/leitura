<?php
/**
 * Template for displaying the footer
 *
 * Site footer.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 * @package leitura
 */

namespace Air_Light;

?>

</div><!-- #content -->

<footer id="colophon" class="site-footer">
  <div class="footer-container">
    <div class="footer-column">
      <div class="site-branding">
        <?php include get_theme_file_path( THEME_SETTINGS['logo'] ); ?>
      </div>
    </div>
    <div class="footer-column">
      <h2>Informações</h2>
      <?php wp_nav_menu( array(
        'theme_location' => 'informacoes',
        'container'      => false,
        'menu_class'     => 'footer-menu',
      ) ); ?>
    </div>
    <div class="footer-column">
      <h2>Serviços ao cliente</h2>
      <?php wp_nav_menu( array(
        'theme_location' => 'servicos_ao_cliente',
        'container'      => false,
        'menu_class'     => 'footer-menu',
      ) ); ?>
    </div>
    <div class="footer-column">
      <h2>Contato</h2>
      <p>
        <?php
        $telefones = get_field( 'telefones', 'option' );
        if ( $telefones ) {
          foreach ( $telefones as $telefone ) {
            $telefone = preg_replace( '/\D/', '', $telefone['telefone'] ); // Remove caracteres não-numéricos
            echo '<a href="tel:+55' . esc_html( $telefone ) . '">+55 ' . esc_html( $telefone ) . '</a><br>';
          }
        }
        ?>
        <?php
        $email = get_field( 'email', 'option' );
        if ( $email ) {
          echo '<a href="mailto:' . esc_attr( $email ) . '">' . esc_html( $email ) . '</a>';
        }
        ?>
      </p>
      <ul class="redes-sociais">
        <li><a href=""><span class="screen-reader-text">Instagram</span></a> <?php include get_theme_file_path( THEME_SETTINGS['Instagram'] ) ?> </li>
        <li><a href=""><span class="screen-reader-text">WhatsApp</span></a> <?php include get_theme_file_path( THEME_SETTINGS['WhatsApp'] ) ?> </li>
        <li><a href=""><span class="screen-reader-text">TikTok</span></a> <?php include get_theme_file_path( THEME_SETTINGS['TikTok'] ) ?> </li>
        <li><a href=""><span class="screen-reader-text">LinkedIn</span></a> <?php include get_theme_file_path( THEME_SETTINGS['LinkedIn'] ) ?> </li>
        <li><a href=""><span class="screen-reader-text">Facebook</span></a> <?php include get_theme_file_path( THEME_SETTINGS['Facebook'] ) ?> </li>
        <li><a href=""><span class="screen-reader-text">Youtube</span></a> <?php include get_theme_file_path( THEME_SETTINGS['Youtube'] ) ?> </li>
      </ul>
    </div>
  </div>
</footer><!-- #colophon -->

</div><!-- #page -->

<?php wp_footer(); ?>

<a
  href="#page"
  id="top"
  class="top no-external-link-indicator"
  data-version="<?php echo esc_attr( AIR_LIGHT_VERSION ); ?>"
>
  <span class="screen-reader-text"><?php echo esc_html( 'Back to top' ); ?></span>
  <span aria-hidden="true">&uarr;</span>
</a>

</body>
</html>

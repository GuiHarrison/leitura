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
    <!-- Logo -->
    <div class="footer-site-branding">
      <?php include get_theme_file_path( THEME_SETTINGS['logo'] ); ?>
    </div>
    <!-- Conteudo -->
    <div class="main-area">
      <div class="footer-column">
        <h2>Informações</h2>
        <?php
          $menu_items = wp_get_nav_menu_items('informacoes');
          if ($menu_items) {
            echo '<ul class="footer-menu">';
            foreach ($menu_items as $item) {
              $texto_formatado = ucwords(strtolower($item->title));
              echo '<li><a href="' . esc_url($item->url) . '">' . esc_html($texto_formatado) . '</a></li>';
            }
            echo '</ul>';
          }
        ?>
      </div>
      <div class="footer-column">
        <h2>Serviços ao cliente</h2>
        <?php
          $menu_name = 'servicos_ao_cliente';
          $menu_locations = get_nav_menu_locations();

          if (isset($menu_locations[$menu_name])) {
              $menu = wp_get_nav_menu_object($menu_locations[$menu_name]);
              $menu_items = wp_get_nav_menu_items($menu->term_id);

              if ($menu_items) {
                  echo '<ul class="footer-menu">';
                  foreach ($menu_items as $item) {
                      $texto_formatado = ucwords(strtolower($item->title));
                      echo '<li><a href="' . esc_url($item->url) . '">' . esc_html($texto_formatado) . '</a></li>';
                  }
                  echo '</ul>';
              } else {
                  echo '<p>Nenhum item no menu.</p>';
              }
          } else {
              echo '<p>O menu não foi encontrado!</p>';
          }
          ?>

      </div>
      <div class="footer-column">
        <h2>Contato</h2>
        <div class="footer-contact">
          <div class="phone-email">
            <p>(19) 3208-1068</p>
            <p>(19) 3208-1068</p>
            <p>sac@leitura.com.br</p>
          </div>
          <ul class="redes-sociais">
            <li>
              <a href="https://www.instagram.com/livrarialeitura/">
                <span class="screen-reader-text">Instagram</span>
              </a> 
              <?php include get_theme_file_path( THEME_SETTINGS['Instagram'] ) ?> 
            </li>
            <li>
              <a href="https://api.whatsapp.com/send?phone=5519989494465">
                <span class="screen-reader-text">WhatsApp</span>
              </a> 
              <?php include get_theme_file_path( THEME_SETTINGS['WhatsApp'] ) ?> 
            </li>
            <li>
              <a href="https://www.tiktok.com/@livrarialeitura">
                <span class="screen-reader-text">TikTok</span>
              </a>
              <?php include get_theme_file_path( THEME_SETTINGS['TikTok'] ) ?>
            </li>
            <li>
              <a href="https://www.linkedin.com/company/livraria-leitura/?originalSubdomain=br">
                <span class="screen-reader-text">LinkedIn</span>
              </a> 
              <?php include get_theme_file_path( THEME_SETTINGS['LinkedIn'] ) ?>
            </li>
            <li>
              <a href="https://pt-br.facebook.com/livraria.leitura">
                <span class="screen-reader-text">Facebook</span>
              </a>
              <?php include get_theme_file_path( THEME_SETTINGS['Facebook'] ) ?>
            </li>
            <li>
              <a href="https://www.youtube.com/channel/UCwidZVaByjUfjsJ5KsSqurw">
                <span class="screen-reader-text">Youtube</span>
              </a>
              <?php include get_theme_file_path( THEME_SETTINGS['Youtube'] ) ?>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</footer>
</div>

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

<!-- Código removido para quando o ACF do Telefone e email estiver funcionando -->
<!-- <?php
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
        ?> -->
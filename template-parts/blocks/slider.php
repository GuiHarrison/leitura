<?php
/**
 * Blco slider
 *
 * @package airclean
 */

namespace Air_Light;

if ( have_rows( 'slides' ) ) : ?>
  <div id="slider1" class="owl-carousel owl-theme">
    <?php while ( have_rows( 'slides' ) ) : the_row();
      $imagem_desktop = get_sub_field( 'imagem_desktop' );
      $imagem_celular = get_sub_field( 'imagem_celular' );
      $link = get_sub_field( 'link' );
    ?>
      <div class="item">
        <a class="no-external-link-indicator" href="<?php echo esc_url( $link ); ?>">
          <picture>
            <source media="(max-width: 768px)" srcset="<?php echo esc_url( $imagem_celular['url'] ); ?>">
            <img src="<?php echo esc_url( $imagem_desktop['url'] ); ?>" alt="<?php echo esc_attr( $imagem_desktop['alt'] ); ?>">
          </picture>
        </a>
      </div>
    <?php endwhile; ?>
  </div>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      jQuery('#slider1').owlCarousel({
        items: 1,
        loop: true,
        margin: 10,
        nav: true,
        dots: true,
        autoplay: true,
        autoplayTimeout: 2000,
        autoplayHoverPause: true
      });
    });
  </script>
<?php endif; ?>

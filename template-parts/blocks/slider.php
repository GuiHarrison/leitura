<?php

/**
 * Blco slider
 *
 * @package airclean
 */

namespace Air_Light;
?>

<section id="chamada-home">
  <?php
  if (have_rows('slides')) : ?>
    <div id="slider1" class="owl-carousel owl-theme">
      <?php while (have_rows('slides')) : the_row();
        $imagem_desktop = get_sub_field('imagem_desktop');
        $imagem_desktop['url'] = wp_get_attachment_image_url($imagem_desktop['ID'], 'ctaDesktop');
        $imagem_celular = get_sub_field('imagem_celular');
        $imagem_celular['url'] = wp_get_attachment_image_url($imagem_celular['ID'], 'ctaCelular');
        $link = get_sub_field('link');
        $legenda = get_sub_field('legenda');
      ?>
        <div class="item">
          <?php if ($link) : ?>
            <a class="no-external-link-indicator" target="_blank" href="<?php echo esc_url($link); ?>">
            <?php endif; ?>

            <figure>
              <picture>
                <?php if ($imagem_celular) : ?>
                  <source media="(max-width: 768px)" srcset="<?php echo esc_url($imagem_celular['url']); ?>">
                <?php endif; ?>
                <img src="<?php echo esc_url($imagem_desktop['url']); ?>" alt="<?php echo esc_attr($imagem_desktop['alt']); ?>">
              </picture>
              <?php if ($legenda) : ?>
                <figcaption class="legenda">
                  <?php echo wp_kses_post($legenda); ?>
                </figcaption>
              <?php endif; ?>
            </figure>

            <?php if ($link) : ?>
            </a>
          <?php endif; ?>
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
          autoplayTimeout: 3000,
          autoplayHoverPause: true
        });
      });
    </script>
  <?php endif; ?>
</section>
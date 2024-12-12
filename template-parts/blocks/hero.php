<?php
/**
 * Hero block
 *
 * @package airclean
 */

namespace Air_Light;

$title = get_field( 'title' );
$content = get_field( 'content' );

if ( empty( $title ) ) {
  return;
} ?>

<section class="block block-hero has-light-bg">
  <div class="container">

    <div class="content">
      <?php if ( ! empty( $title ) ) : ?>
        <h1 class="block-title"><?php echo esc_html( $title ); ?></h1>
      <?php endif; ?>

      <?php if ( ! empty( $content ) ) : ?>
        <?php echo wp_kses_post( wpautop( $content ) ); ?>
      <?php endif; ?>
    </div>

  </div>
</section>
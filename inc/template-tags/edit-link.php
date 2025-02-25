<?php
/**
 * Edit link
 *
 * This function shows edit links.
 *
 * @package leitura
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 */

namespace Air_Light;

function air_edit_link() {

  if ( ! get_edit_post_link() ) {
		return;
  } ?>

    <p class="edit-link">
      <a href="<?php echo esc_url( get_edit_post_link() ); ?>">
        <?php echo esc_html( 'Edit' ); ?>
        <span class="screen-reader-text"><?php echo esc_html( get_the_title() ); ?></span>
      </a>
    </p>
  <?php
}

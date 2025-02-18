<?php
/**
 * Data de publicação do post
 *
 * @package leitura
 */

namespace Air_Light;
?>

<p class="data-publicacao">
  <time datetime="<?php the_time( 'c' ); ?>">
    <?php echo '→ ' . date_i18n('j \d\e M \d\e Y', get_the_time('U')); ?>
  </time>
</p>

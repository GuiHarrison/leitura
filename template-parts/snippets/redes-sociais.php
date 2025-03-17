<ul class="redes-sociais">
  <?php if (have_rows('redes', 'option')): ?>
    <?php while (have_rows('redes', 'option')): the_row(); ?>
      <li>
        <a href="<?php echo esc_url(get_sub_field('r-link')); ?>" target="_social" class="no-external-link-indicator">
          <span class="screen-reader-text"><?php echo esc_html(get_sub_field('r-nome')); ?></span>
          <?php
          // Testar trocar o de baixo por esse aqui no ambiente de produção -->
          // include esc_url(get_sub_field('r-logo')['url']);
          ?>
          <img src="<?php echo esc_url(get_sub_field('r-logo')['url']); ?>" alt="<?php echo esc_html(get_sub_field('r-nome')); ?>">
        </a>
      </li>
    <?php endwhile; ?>
  <?php endif; ?>
</ul>

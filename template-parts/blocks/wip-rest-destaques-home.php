<?php

/**
 * Bloco para destaques da home
 *
 * @package airclean
 */

namespace Air_Light;

?>

<div id="publicacoes-em-destaque">
    <h2 id="destaque-home">Publicações em destaque</h2>
    <a href="<?php echo esc_url(get_category_link(403)); ?>" class="ver-todas">Ver todas</a>
    <div id="destaques-container">
        <p>Carregando publicações destacadas…</p>
    </div>
</div>
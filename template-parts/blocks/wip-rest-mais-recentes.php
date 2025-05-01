<?php

/**
 * Bloco para posts mais recentes
 *
 * @package airclean
 */

namespace Air_Light;

?>

<div id="publicacoes-recentes">
    <h2 id="recentes-home">Publicações recentes</h2>
    <a href="<?php echo esc_url(get_category_link(403)); ?>" class="ver-todas">Ver todas</a>
    <div id="recentes-container">
        <p>Carregando posts recentes…</p>
    </div>
</div>
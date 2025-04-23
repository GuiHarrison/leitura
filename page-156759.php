<?php

/**
 * Template para página de banco de talentos
 *
 * @package leitura
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 */

namespace Air_Light;

the_post();

get_header();
?>

<main class="site-main container main-vagas">
  <?php
  the_content();
  air_edit_link();
  if (function_exists(__NAMESPACE__ . '\adicionar_modal_cpf')) {
    adicionar_modal_cpf();
  }
  ?>
</main>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const lojaSelects = ['field_loja1', 'field_loja2', 'field_loja3'].map(id => document.getElementById(id));

    function atualizarOpcoes() {
      // Pegar valores selecionados
      const valoresSelecionados = lojaSelects
        .map(select => select.value)
        .filter(value => value !== '');

      // Para cada select
      lojaSelects.forEach(currentSelect => {
        // Pegar todas as options exceto a primeira (em branco)
        Array.from(currentSelect.options).slice(1).forEach(option => {
          // Desabilitar se o valor está selecionado em outro select
          const estaSelcionadoEmOutro = valoresSelecionados.includes(option.value) &&
            currentSelect.value !== option.value;

          option.disabled = estaSelcionadoEmOutro;
        });
      });
    }
    // Adicionar evento de mudança para todos os selects
    lojaSelects.forEach(select => {
      select.addEventListener('change', atualizarOpcoes);
    });
    atualizarOpcoes();
  });
</script>

<?php get_footer();

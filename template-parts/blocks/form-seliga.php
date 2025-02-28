<?php

/**
 * Bloco para assinatura no programa Se liga na Leitura
 *
 * @package airclean
 */

namespace Air_Light;
?>
<section id="seliga">
  <?php echo \FrmFormsController::get_form_shortcode(array('id' => 11)); ?>
</section>

<script>
  function updateCheckboxes() {
    // Desmarca todos os checkboxes
    document.querySelectorAll('.frm_opt_container input[type="checkbox"]')
      .forEach(cb => cb.checked = false);

    // Pega todas as opções selecionadas do select múltiplo
    const select = document.querySelector('.rd-generos');
    if (!select) return;

    Array.from(select.selectedOptions).forEach(option => {
      const checkbox = document.querySelector(`.frm_opt_container input[type="checkbox"][value="${option.value}"]`);
      if (checkbox) checkbox.checked = true;
    });
  }

  const select = document.querySelector('.rd-generos');
  if (select) {
    select.addEventListener('change', updateCheckboxes);
  }

  document.addEventListener('DOMContentLoaded', updateCheckboxes);
</script>
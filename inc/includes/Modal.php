<?php

namespace Air_Light;

class Modal
{
  private static $instance = null;
  private static $is_enqueued = false;

  public static function get_instance()
  {
    if (null === self::$instance) {
      self::$instance = new self();
    }
    return self::$instance;
  }

  public function render($title, $message, $button_text = 'Entendi')
  {
    // Carrega scripts apenas quando o modal for renderizado
    $this->enqueue_assets();

    ob_start();
?>
    <div class="modal-erro">
      <div class="modal-conteudo">
        <span class="fechar">&times;</span>
        <h3><?php echo esc_html($title); ?></h3>
        <p><?php echo esc_html($message); ?></p>
        <button onclick="Modal.fechar()"><?php echo esc_html($button_text); ?></button>
      </div>
    </div>
<?php
    return ob_get_clean();
  }

  private function enqueue_assets()
  {
    // Evita carregar mais de uma vez
    if (self::$is_enqueued) {
      return;
    }

    // Registra o script primeiro
    wp_register_script(
      'modal-js',
      get_theme_file_uri('js/src/modules/modal.js'),
      [],
      filemtime(get_theme_file_path('js/src/modules/modal.js')),
      true
    );

    // Garante que será carregado
    wp_enqueue_script('modal-js');

    self::$is_enqueued = true;
  }
}

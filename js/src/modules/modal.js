const Modal = {
  abrir: function (selector = '.modal-erro') {
    document.querySelector(selector).classList.add('ativo');
  },

  fechar: function (selector = '.modal-erro') {
    document.querySelector(selector).classList.remove('ativo');
  },

  init: function (selector = '.modal-erro') {
    const modal = document.querySelector(selector);
    if (!modal) return;

    // Fechar ao clicar no X
    modal.querySelector('.fechar').addEventListener('click', () => this.fechar(selector));

    // Fechar ao clicar fora do modal
    modal.addEventListener('click', (e) => {
      if (e.target === modal) this.fechar(selector);
    });

    // Fechar com ESC
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && modal.classList.contains('ativo')) {
        this.fechar(selector);
      }
    });
  }
};

// Expor para uso global
window.Modal = Modal;

// Inicializar quando o DOM estiver pronto
document.addEventListener('DOMContentLoaded', () => Modal.init());

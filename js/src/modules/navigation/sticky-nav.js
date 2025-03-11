export const initStickyNav = () => {
  const nav = document.querySelector('.barra-navegação');
  if (!nav) return;

  const navTop = nav.offsetTop;

  function handleSticky() {
    if (window.scrollY >= navTop) {
      nav.classList.add('is-sticky');
    } else {
      nav.classList.remove('is-sticky');
    }
  }

  if (window.innerWidth >= 768) {
    window.addEventListener('scroll', handleSticky);
  }
};

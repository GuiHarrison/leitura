// Checa se estamos em dimensões de celular

function seCelular() {

  // Pega --width-max-mobile do CSS
  const widthMaxMobile = getComputedStyle(
    document.documentElement,
  ).getPropertyValue('--width-max-mobile');

  // Vamos ver se estamos em dimensões de celular
  const isMobile = window.matchMedia(
    `(max-width: ${widthMaxMobile})`,
  ).matches;

  // Se as coisas não estão bem, saia
  if (isMobile) {
    return;
  }
}

export default seCelular;
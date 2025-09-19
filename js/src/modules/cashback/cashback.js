// Cena 3D de fundo (moedas)
const cena = new THREE.Scene();

// breakpoint para dispositivos móveis
const BP_MOBILE_PX = 700;
const mqMobile = window.matchMedia(`(max-width: ${BP_MOBILE_PX}px)`);

let largura = 0;
let altura = 0;
let moedas = [];
let velocidades = [];
let circleTextureGlobal;
let moedaTexture;

// Ajusta a câmera com base no tamanho da tela (criada depois de definir largura/altura)
const camera = new THREE.PerspectiveCamera(60, 1, 0.1, 3000);

const renderer = new THREE.WebGLRenderer({ antialias: true });
renderer.setClearColor('#f2edd9');
renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 2));
document.getElementById('cena3d').appendChild(renderer.domElement);

function getSiteContentDimensions() {
  const siteContent = document.querySelector('.site-content');
  if (!siteContent) {
    // Fallback para window se .site-content não existir
    return {
      width: window.innerWidth,
      height: window.innerHeight,
    };
  }

  const rect = siteContent.getBoundingClientRect();
  return {
    width: rect.width,
    height: rect.height,
  };
}

function computeWidth() {
  const dimensions = getSiteContentDimensions();
  // quando o media query corresponder (telas pequenas), usamos toda a largura
  if (mqMobile.matches) return dimensions.width;
  // caso contrário, aplicamos o offset original (1/10 da largura)
  return dimensions.width - dimensions.width / 10;
}

function clearMoedas() {
  if (!moedas || moedas.length === 0) return;
  for (const m of moedas) {
    try {
      if (m.geometry) m.geometry.dispose();
      if (Array.isArray(m.material)) {
        m.material.forEach((mat) => { if (mat && mat.dispose) mat.dispose(); });
      } else if (m.material && m.material.dispose) {
        m.material.dispose();
      }
      cena.remove(m);
    } catch (e) {
      // ignore
    }
  }
  moedas = [];
  velocidades = [];
}

function updateSceneSize() {
  largura = Math.max(1, Math.floor(computeWidth()));
  altura = Math.max(1, Math.floor(getSiteContentDimensions().height));
  renderer.setSize(largura, altura);
  renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 2));
  camera.aspect = largura / altura;
  camera.updateProjectionMatrix();

  // Posiciona a câmera para manter a cena visível. Usa uma distância proporcional à viewport
  camera.position.set(0, 0, Math.max(largura, altura) * 1.1);

  // Se já tivermos texturas carregadas, recria moedas para ajustar ao novo tamanho
  if (circleTextureGlobal !== undefined || moedaTexture !== undefined) {
    clearMoedas();
    // chama recriação usando texturas armazenadas (podem ser null)
    criarMoedas(circleTextureGlobal || null, moedaTexture || null);
  }
}

// atualiza ao redimensionar e quando o breakpoint mudar
window.addEventListener('resize', updateSceneSize);
mqMobile.addEventListener ? mqMobile.addEventListener('change', updateSceneSize) : mqMobile.addListener(updateSceneSize);

// chama inicialmente para configurar tamanho/câmera
updateSceneSize();

// Parâmetro: quantidade de moedas
const quantidadeMoedas = 5;

// Carrega textura externo e só cria as moedas após o carregamento
const textureLoader = new THREE.TextureLoader();

// Adiciona plano de fundo 3D com textura repetida
textureLoader.load('/wp-content/themes/leitura/img/fundo.jpg', (fundoTexture) => {
  fundoTexture.wrapS = THREE.RepeatWrapping;
  fundoTexture.wrapT = THREE.RepeatWrapping;
  fundoTexture.repeat.set(Math.ceil(largura * 2 / 64), Math.ceil(altura * 2 / 64));
  const planoGeo = new THREE.PlaneGeometry(largura * 3, altura * 3);
  const planoMat = new THREE.MeshBasicMaterial({
    map: fundoTexture, side: THREE.DoubleSide, transparent: true, opacity: 0.7,
  });
  const plano = new THREE.Mesh(planoGeo, planoMat);
  plano.position.set(0, 0, -10);
  cena.add(plano);
});

function criarMoedas(circleTexture, moedaTextureParam) {
  // garante que usamos as texturas globais para possíveis recriações futuras
  circleTextureGlobal = circleTexture;
  moedaTexture = moedaTextureParam;

  clearMoedas();

  // calcula raios proporcionais à viewport, com limites
  const minSide = Math.min(largura, altura);
  const raio = Math.round(Math.max(8, Math.min(60, minSide * 0.035)));
  const espessuraMoeda = Math.max(4, Math.round(raio * 0.28));
  const segmentos = 32;

  for (let i = 0; i < quantidadeMoedas; i++) {
    const geometria = new THREE.CylinderGeometry(raio, raio, espessuraMoeda, segmentos, 1, false);

    // Aleatoriedade para cor lateral e textura
    const lateralColor = Math.random() < 0.4 ? '#32529e' : '#172947';
    const useMoedaTexture = Math.random() < 0.3;

    const materialTopoBase = new THREE.MeshBasicMaterial({ map: useMoedaTexture && moedaTextureParam ? moedaTextureParam : circleTexture });
    const materialLateral = new THREE.MeshBasicMaterial({ color: lateralColor });
    const materiais = [materialLateral, materialTopoBase, materialTopoBase];
    const moeda = new THREE.Mesh(geometria, materiais);

    // Aplica materiais nas faces
    for (let g = 0; g < geometria.groups.length; g++) {
      geometria.groups[g].materialIndex = g;
    }

    // Distribuição na tela inteira (coord. centradas)
    moeda.position.x = (Math.random() * largura) - (largura / 2);
    moeda.position.y = (Math.random() * altura) - (altura / 2);
    moeda.position.z = Math.random() * 1000;

    // Rotações iniciais aleatórias
    moeda.rotation.y = Math.random() * Math.PI * 2;
    moeda.rotation.z = Math.random() * Math.PI * 2;

    velocidades.push({
      y: 0.005 + Math.random() * 0.03,
      z: 0.002 + Math.random() * 0.01,
    });

    cena.add(moeda);
    moedas.push(moeda);
  }
}

// Animação
function animar() {
  for (let i = 0; i < moedas.length; i++) {
    moedas[i].rotation.y += velocidades[i]?.y || 0.01;
    moedas[i].rotation.z += velocidades[i]?.z || 0.005;
  }
  renderer.render(cena, camera);
  requestAnimationFrame(animar);
}

// Carrega textura externo e cria moedas após carregamento
textureLoader.load('/wp-content/themes/leitura/img/moeda.jpg', (loadedMoedaTexture) => {
  moedaTexture = loadedMoedaTexture;
  textureLoader.load(
    '/wp-content/themes/leitura/img/circle-outline.jpg',
    (circleTexture) => {
      circleTextureGlobal = circleTexture;
      // garante que o tamanho/câmera estão calculados antes de criar
      updateSceneSize();
      criarMoedas(circleTextureGlobal, moedaTexture);
      animar();
    },
    undefined,
    () => {
      // Se falhar, cria moedas sem textura
      circleTextureGlobal = null;
      updateSceneSize();
      criarMoedas(null, moedaTexture);
      animar();
    },
  );
}, undefined, () => {
  // Se falhar ao carregar moeda/moeda.jpg, usa só circle-outline.jpg
  textureLoader.load(
    '/wp-content/themes/leitura/img/circle-outline.jpg',
    (circleTexture) => {
      circleTextureGlobal = circleTexture;
      updateSceneSize();
      criarMoedas(circleTextureGlobal, null);
      animar();
    },
    undefined,
    () => {
      circleTextureGlobal = null;
      moedaTexture = null;
      updateSceneSize();
      criarMoedas(null, null);
      animar();
    },
  );
});

jQuery(document).ready(() => {
  // Validação do formulário
  jQuery('#form_login').validate({
    rules: {
      usuario: {
        required: true,
        minlength: 11,
      },
      senha: {
        required: true,
        minlength: 6,
      },
    },
    messages: {
      usuario: {
        required: 'Por favor, insira seu CPF/CNPJ.',
        minlength: 'O CPF/CNPJ deve ter no mínimo 11 caracteres.',
      },
      senha: {
        required: 'Por favor, insira sua senha.',
        minlength: 'A senha deve ter no mínimo 6 caracteres.',
      },
    },
    errorPlacement(error, element) {
      element.siblings('.error-container').removeClass('hidden').find('.error-message').html(error);
    },
    success(label, element) {
      jQuery(element).siblings('.error-container').addClass('hidden').find('.error-message')
        .html('');
    },
    submitHandler(form) {
      form.submit();
    },
  });

  // Alternar visibilidade da senha
  jQuery('.toggle-password').on('click', function () {
    const campoSenha = jQuery(jQuery(this).data('pwd-field'));
    const tipo = campoSenha.attr('type') === 'password' ? 'text' : 'password';
    campoSenha.attr('type', tipo);
    jQuery(this).toggleClass('visible');
  });
});

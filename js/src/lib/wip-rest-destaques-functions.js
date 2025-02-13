const fetchDestaques = async () => {
  try {
    const response = await fetch('/wp-json/leitura/v1/destaques-home');
    const posts = await response.json();
    return posts;
  } catch (error) {
    console.error('Erro ao buscar destaques:', error);
    return [];
  }
};

const createArticleHTML = (post, index) => {
  let html = '<article class="post" id="post-' + post.id + '">';

  // Thumbnail para os primeiros 2 posts
  if (index < 2 && post.featured_media) {
    html += `<div class="destaque thumbnail">
            <img src="${post._embedded?.['wp:featuredmedia']?.[0]?.source_url || ''}"
                 loading="lazy" fetchpriority="low" alt="">
        </div>`;
  }

  // Categorias
  if (post._embedded?.['wp:term']?.[0]?.length) {
    html += '<ul class="categories">';
    post._embedded['wp:term'][0].forEach(category => {
      html += `<li><a href="${category.link}">${category.name}</a></li>`;
    });
    html += '</ul>';
  }

  // Título e conteúdo
  html += `
        <h2 class="post-title">
            <a href="${post.link}">${post.title.rendered}</a>
        </h2>
        <div class="content">
            ${post.excerpt.rendered}
        </div>
        <p>
            <time datetime="${post.date}">
                ${new Date(post.date).toLocaleDateString('pt-BR')}
            </time>
        </p>
    </article>`;

  return html;
};

window.destaquesLib = {
  fetchDestaques,
  createArticleHTML
};

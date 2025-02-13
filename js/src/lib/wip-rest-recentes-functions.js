const fetchRecentes = async () => {
  try {
    const response = await fetch('/wp-json/wp/v2/posts?per_page=2&_embed');
    return await response.json();
  } catch (error) {
    console.error('Erro ao buscar posts recentes:', error);
    return [];
  }
};

const createRecentArticleHTML = (post, index) => {
  let html = '<article class="post" id="post-' + post.id + '">';

  // Thumbnail apenas para o primeiro post
  if (index < 1 && post.featured_media) {
    html += `<div class="thumbnail">
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
        <h2 class="${post.type}-title">
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

window.recentesLib = {
  fetchRecentes,
  createRecentArticleHTML
};

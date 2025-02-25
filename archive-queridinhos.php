<?php

/**
 * Tela de Queridinhos da Leitura
 *
 * @package leitura
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 */

namespace Air_Light;

get_header();

// Definindo os CTAs da tela
for ($i = 1; $i <= 2; $i++) {
  $cta_field = get_field("cta-queridinhos-{$i}", 'option');
  if ($cta_field) {
    $cta_data[$i] = [
      'desktop' => $cta_field["imagem_queridinhos{$i}_desktop"],
      'celular' => $cta_field["imagem_queridinhos{$i}_celular"],
      'link' => $cta_field["queridinhos{$i}_link"],
      'cor' => $cta_field["q{$i}_cor"]
    ];
  }
}
?>

<div class="site-main container">

  <?php
  if ($cta_data[1]['desktop'] && $cta_data[1]['link']) {
    $is_mobile = wp_is_mobile();
    $imagem = $is_mobile && $cta_data[1]['celular'] ? $cta_data[1]['celular'] :  $cta_data[1]['desktop'];
    if ($imagem) {
      echo
      '<aside class="cta sem-margem">' .
        '<a href="' . esc_url($cta_data[1]['link']) . '" class="cta-link" rel="nofollow" target="_blank">' .
        '<img src="' . esc_url($imagem['url']) . '" alt="' . esc_html($imagem['alt']) . '" class="cta-image">' .
        '</a>' .
        '</aside>';
    }
  }

  $posts = get_posts(array(
    'post_type' => 'queridinhos',
    'posts_per_page' => 10,
    'meta_key' => 'queridinho_n',
    'orderby' => 'meta_value_num',
    'order' => 'ASC',
  ));

  if ($posts) {
    global $post;
    $contador = 0;
  ?>

    <section id="queridinhos-da-leitura" class="publicacoes">

      <div class="grid">
        <?php
        foreach ($posts as $post) {
          setup_postdata($post);
          $ordem = get_field('queridinho_n', get_the_ID());
          $comprar = get_field('link_na_loja');
          $usuário = get_the_author_meta('ID');
          $loja = get_field('loja_relacionada', 'user_' . $usuário);
          $id_loja = $loja->ID;
          $endereço = get_field('mapa_loja', $id_loja);
          $estado = endereco_para_estado_curto($endereço['address']);
        ?>

          <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <div class="q-colunas">
              <div class="thumbnail livro-thumbnail">
                <span class="queridinho-n"><?php echo $ordem; ?></span>
                <?php the_post_thumbnail('resenha-p'); ?>
              </div>

              <div class="q-c-detalhes">
                <h3 class="post-title">
                  <a class="sublinhado-bonito" href="<?php echo esc_url(get_the_permalink()); ?>">
                    <?php the_title(); ?>
                  </a>
                </h3>
                <div class="q-c-d-colaborador">
                  <p class="q-pessoa"><?php echo esc_html(get_the_author()); ?></p>
                  <?php if ($loja) {
                    echo '<p class="q-loja">' . esc_html($loja->post_title) . ' / ' . esc_html($estado) . '</p>';
                  } ?>
                </div>
              </div>

            </div>

            <div class="ler-comprar">
              <a href="<?php echo esc_url(get_the_permalink()); ?>" class="button ler">Ler resenha</a>
              <a href="<?php echo esc_html($comprar); ?>" class="button comprar"></a>
            </div>

          </article>

      <?php
        }
        wp_reset_postdata();
      }
      ?>

      <?php
      if ($cta_data[2]['desktop'] && $cta_data[2]['link']) {
        $is_mobile = wp_is_mobile();
        $imagem = $is_mobile && $cta_data[2]['celular'] ? $cta_data[2]['celular'] :  $cta_data[2]['desktop'];
        if ($imagem) {
          echo
          '<aside class="cta grid-column-span-2 sem-margem" style="background-color: ' . $cta_data[2]['cor'] . '">' .
            '<a href="' . esc_url($cta_data[2]['link']) . '" class="cta-link" rel="nofollow" target="_blank">' .
            '<img src="' . esc_url($imagem['url']) . '" alt="' . esc_html($imagem['alt']) . '" class="cta-image">' .
            '</a>' .
            '</aside>';
        }
      }
      ?>
      </div>
    </section>

    <script>
      document.addEventListener('DOMContentLoaded', function() {
        jQuery('#slider-queridinhos').owlCarousel({
          responsive: {
            0: {
              items: 1
            },
            600: {
              items: 3
            }
          },
          loop: false,
          margin: 20,
          nav: true,
          dots: true,
          autoplay: false
        });
      });
    </script>

    <aside class="grid cta-rodape">
      <?php get_template_part('template-parts/blocks/cta-3-3'); ?>
      <?php get_template_part('template-parts/blocks/revista'); ?>
    </aside>

    <?php get_template_part('template-parts/blocks/newsletter'); ?>

</div>

<?php get_footer(); ?>

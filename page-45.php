<?php

/**
 * Página de trabalhe conosco
 *
 * @package leitura
 */

namespace Air_Light;

get_header();

$link_talentos = (strpos($_SERVER['REMOTE_ADDR'], '192.168') === 0 ||
  $_SERVER['REMOTE_ADDR'] === '127.0.0.1')
  ? 156235
  : 156759;
?>

<main class="site-main container main-vagas">
  <?php
  if (have_posts()) : while (have_posts()) : the_post();
      the_content();
    endwhile;
  endif;
  ?>
  <h2>→ Vagas abertas</h2>
  <section class="grid sem-margem">
    <form method="get" class="form-filtro">
      <select name="ofcategory_cidade_estado" class="selecione-cidade" onchange="this.form.submit()">
        <option value="">Selecione uma cidade</option>
        <?php
        $estados = get_terms([
          'taxonomy' => 'category_cidade_estado',
          'hide_empty' => false,
          'parent' => 0
        ]);

        foreach ($estados as $estado) {
          $cidades = get_terms([
            'taxonomy' => 'category_cidade_estado',
            'hide_empty' => false,
            'parent' => $estado->term_id
          ]);

          echo '<optgroup label="' . esc_attr($estado->name) . '">';

          foreach ($cidades as $cidade) {
            $selected = isset($_GET['ofcategory_cidade_estado']) && $_GET['ofcategory_cidade_estado'] == $cidade->term_id ? 'selected' : '';
            echo sprintf(
              '<option value="%s" %s>%s</option>',
              $cidade->term_id,
              $selected,
              $cidade->name
            );
          }

          echo '</optgroup>';
        }
        ?>
      </select>
    </form>
  </section>

  <?php if (isset($_GET['ofcategory_cidade_estado']) && !empty($_GET['ofcategory_cidade_estado'])): ?>
    <section class="grid grid-vagas">
      <?php
      $vagas = get_terms([
        'taxonomy' => 'category_vagas',
        'hide_empty' => false
      ]);

      $has_vagas = false;

      foreach ($vagas as $vaga) {
        $loja = get_field('loja', 'category_vagas_' . $vaga->term_id);
        if (!$loja) continue;

        $term_list = wp_get_post_terms($loja->ID, 'category_cidade_estado', ['fields' => 'all']);
        $location_ids = wp_list_pluck($term_list, 'term_id');

        if (in_array($_GET['ofcategory_cidade_estado'], $location_ids)):
          $has_vagas = true;
          $cidade_estado = array_values(array_filter($term_list, function ($term) {
            return $term->term_id == $_GET['ofcategory_cidade_estado'];
          }))[0];
      ?>
          <article>
            <h3 class="title_vaga"><?php echo $vaga->name; ?></h3>
            <p class="descricao-vaga">
              <span class="label_vaga">Informações:</span>
              <?php
              $description = $vaga->description;
              echo wp_trim_words($description, 25, '...');
              ?>
            </p>
            <p class="descricao-vaga sem-margem local">
              <!-- <span class="label_vaga">Local:</span> -->
              <?php
              $estado = get_term($cidade_estado->parent, 'category_cidade_estado');
              echo $cidade_estado->name . ' → ' . $estado->name;
              ?>
            </p>
            <p class="descricao-vaga sem-margem loja">
              <!-- <span class="label_vaga">Loja:</span> -->
              <?php echo $loja->post_title; ?>
            </p>
            <p>
              <?php
              $categoria_url = get_term_link($vaga);
              $params = http_build_query([
                'loja' => $loja->ID,
                'cargo' => urlencode($vaga->name)
              ]);
              ?>
              <a href="<?php echo esc_url($categoria_url . '?' . $params); ?>" class="candidatar button com-seta-direita" data-target="frm_form_3_container">
                Quero me candidatar
              </a>
            </p>
          </article>
      <?php
        endif;
      }

      // Adiciona o item final da lista
      $cidade_selecionada = get_term($_GET['ofcategory_cidade_estado'], 'category_cidade_estado');
      ?>
      <article>
        <?php if ($has_vagas): ?>
          <h3 class="title_vaga">Não achou sua vaga? Se inscreva em nosso banco de talentos</h3>
        <?php else: ?>
          <h3 class="title_vaga">Não há vagas disponíveis em <?php echo $cidade_selecionada->name; ?> no momento</h3>
        <?php endif; ?>
        <p class="descricao-vaga">
          Cadastre seu currículo em até três lojas na mesma cidade ou candidate-se às vagas disponíveis.
          Ele será analisado e ficará no banco de talentos por seis meses, sendo considerado automaticamente
          para oportunidades compatíveis.
        </p>
        <p>
          <a href="<?php echo esc_url(get_permalink($link_talentos)); ?>" class="candidatar button com-seta-direita">
            Quero me candidatar
          </a>
        </p>
      </article>
      <?php
      echo '</ul>';
      ?>
    </section>
  <?php endif; ?>
</main>

<script>
  window.addEventListener('load', function() {
    const target = document.querySelector('[data-target]')?.dataset.target;
    if (target) {
      const element = document.getElementById(target);
      if (element) {
        element.scrollIntoView();
      }
    }
  });
</script>

<?php get_footer(); ?>
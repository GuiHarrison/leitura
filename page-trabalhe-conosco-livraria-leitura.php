<?php

/**
 * Página de trabalhe conosco
 *
 * @package leitura
 */

namespace Air_Light;

get_header(); ?>

<style>
  optgroup {
    font-weight: bold;
  }

  optgroup option {
    font-weight: normal;
    padding-left: 15px;
  }

  select.form-control {
    padding: 10px;
  }
</style>

<main class="site-main container">
  <div class="col-md-8 col-lg-8">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <?php the_content(); ?>
    <?php endwhile;
    endif; ?>
  </div>
  <div class="row">
    <h2>→ Vagas abertas</h2>
    <div class="col-12 mb-4">
      <form method="get" class="form-filtro">
        <select name="ofcategory_cidade_estado" class="form-control" onchange="this.form.submit()">
          <option value="">Selecione uma cidade/estado</option>
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
    </div>

    <?php if (isset($_GET['ofcategory_cidade_estado']) && !empty($_GET['ofcategory_cidade_estado'])): ?>
      <div class="col-md-4 col-lg-4">
        <div class="list-vagas">
          <?php
          $vagas = get_terms([
            'taxonomy' => 'category_vagas',
            'hide_empty' => false
          ]);

          $has_vagas = false;

          echo '<ul id="vagas-ul">';
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
              <li>
                <h3 class="title_vaga"><?php echo $vaga->name; ?></h3>
                <p class="descricao_vaga">
                  <span class="label_vaga">Informações:</span>
                  <?php
                  $description = $vaga->description;
                  echo wp_trim_words($description, 25, '...');
                  ?>
                </p>
                <p class="descricao_vaga">
                  <span class="label_vaga">Local:</span>
                  <?php
                  $estado = get_term($cidade_estado->parent, 'category_cidade_estado');
                  echo $cidade_estado->name . ' → ' . $estado->name;
                  ?>
                </p>
                <p class="descricao_vaga">
                  <span class="label_vaga">Loja:</span>
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
                  <a href="<?php echo esc_url($categoria_url . '?' . $params); ?>" class="candidatar small-buttom-trasparent">
                    Quero me candidatar
                  </a>
                </p>
              </li>
          <?php
            endif;
          }

          // Adiciona o item final da lista
          $cidade_selecionada = get_term($_GET['ofcategory_cidade_estado'], 'category_cidade_estado');
          ?>
          <li>
            <?php if ($has_vagas): ?>
              <h3 class="title_vaga">Não achou sua vaga? Se inscreva em nosso banco de talentos</h3>
            <?php else: ?>
              <h3 class="title_vaga">Não há vagas disponíveis em <?php echo $cidade_selecionada->name; ?> no momento</h3>
            <?php endif; ?>
            <p class="descricao_vaga">
              Cadastre seu currículo em até três lojas na mesma cidade ou candidate-se às vagas disponíveis.
              Ele será analisado e ficará no banco de talentos por seis meses, sendo considerado automaticamente
              para oportunidades compatíveis.
            </p>
            <p>
              <a href="{alterar para a página de banco de talentos}" class="candidatar small-buttom-trasparent">
                Quero me candidatar
              </a>
            </p>
          </li>
          <?php
          echo '</ul>';
          ?>

        </div>
      </div>
    <?php endif; ?>
  </div>
</main>

<?php get_footer(); ?>

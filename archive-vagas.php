<?php

/**
 * Página de listagem de vagas
 *
 * @package leitura
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 */

namespace Air_Light;

//Exigindo login no sistema
if ((is_archive())
  && !is_page('login') && !is_user_logged_in()
) {
  auth_redirect();
} else {
  get_header();
}
?>

<!-- Verificando qual usuario esta logado. -->
<?php $id_user = $current_user->ID; ?>

<div class="content container rh">
  <div class="grid">
    <div class="banner-legenda">
    </div>
    <div class="logado">
      <?php
      if (is_user_logged_in()) {
        $current_user = wp_get_current_user();
        if (($current_user instanceof \WP_User)) {
          echo 'Olá, ' . $current_user->display_name;
        }
      }
      ?>
      <a class="sair" href="<?php echo wp_logout_url(); ?>">Sair</a>
    </div>
  </div>
  <section>
    <?php
    $args = array(
      'post_type' => 'lojas',
      'posts_per_page' => -1,
      'orderby' => 'post_title',
      'order' => 'ASC',
    );
    $list_lojas = get_posts($args);
    $selected_loja = null;
    if (isset($_GET['oflojas'])) {
      $selected_loja = $_GET['oflojas'];
    }
    ?>
    <?php if (current_user_can('administrator')): ?>
      <div class="select-lojas grid">
        <div class=""></div>
        <form action="" method="get" class="searchandfilter">
          <div> Selecione uma loja: </div>
          <select name="oflojas" id="oflojas" class="postform">
            <option value="0"
              <?php if ($selected_loja == null) {
                echo 'selected="selected"';
              } ?>></option>
            <?php foreach ($list_lojas as $select_loja): ?>
              <option class="level-0"
                value="<?= $select_loja->ID ?>"
                <?php if ($selected_loja == $select_loja->ID) {
                  echo 'selected="selected"';
                } ?>>
                <?= $select_loja->post_title ?>
              </option>
            <?php endforeach; ?>
          </select>
          <input type="hidden" name="ofcategory_operator" value="and">
          <input type="hidden" name="ofsubmitted" value="1">
          <input type="submit" value="Submit" style="display: none;">
        </form>
        <div class=""></div>
      </div>
    <?php endif; ?>
    <?php
    // only show table if user is logista or admin with store selected
    if ($selected_loja || (!current_user_can('administrator') && current_user_can('read'))):
      if (current_user_can('administrator')) {
        $user_loja = [$selected_loja];
      } else if (current_user_can('read')) {
        $usuário = $current_user->ID;
        $loja = get_field('loja_relacionada', 'user_' . $usuário);
        $user_loja = $loja->ID;
        // $user_loja = get_user_meta($current_user->ID, "loja");
      }
    ?>
      <table id="rh_table" class="display" cellspacing="0" width="100%">
        <thead>
          <tr class="tr-header">
            <th>DATA</th>
            <th>STATUS</th>
            <th>CARGO/VAGA</th>
            <th>PRETENÇÃO</th>
            <th>LOJA</th>
            <th>NOME</th>
            <th>AÇÕES</th>
          </tr>
        </thead>
        <tfoot>
          <tr class="tr-header">
            <th>DATA</th>
            <th>STATUS</th>
            <th>CARGO/VAGA</th>
            <th>PRETENÇÃO</th>
            <th>LOJA</th>
            <th>NOME</th>
            <th>AÇÕES</th>
          </tr>
        </tfoot>
        <tbody>
          <?php
          if (!empty($user_loja)) {
            $loja = $user_loja;
            $terms = wp_get_post_terms($post->ID, 'category_vagas');

            $args = array(
              'post_type' => 'vagas',
              'showposts' => -1,
              'orderby' => 'date',
              'order' => 'DESC',
              'meta_key' => "loja_rh_1",
              'meta_value' => $loja
            );

            $my_curriculos = get_posts($args);
            $args['meta_key'] = "loja_rh_2";
            $my_curriculos = array_merge($my_curriculos, get_posts($args));
            $args['meta_key'] = "loja_rh_3";
            $my_curriculos = array_merge($my_curriculos, get_posts($args));
          } else {
            echo "Usuário não possui loja cadastrada, favor contactar administrador";
          }

          if ($my_curriculos) : foreach ($my_curriculos as $post) : setup_postdata($post);
              $id_post = get_the_ID();
              $pretencao = get_field('salarial_rh');
              $sobre_nome = get_field('sobre_nome_rh');
              $loja1_rh = "";
              $loja2_rh = "";
              $loja3_rh = "";

              //Campos loja
              $loja1_id = get_field('loja_rh_1');
              if ($loja1_id != 0) {
                $loja1 = get_post($loja1_id);
                $loja1_rh = $loja1->post_title;
              }

              $loja2_id = get_field('loja_rh_2');
              if ($loja2_id != 0) {
                $loja2 = get_post($loja2_id);
                $loja2_rh = $loja2->post_title;
              }

              $loja3_id = get_field('loja_rh_3');
              if ($loja3_id != 0) {
                $loja3 = get_post($loja3_id);
                $loja3_rh = $loja3->post_title;
              }

              $loja_rh = "";
              if ($loja1_id != 0) {
                $loja_rh = $loja_rh . $loja1_rh;
              }
              if ($loja2_id != 0) {
                $loja_rh = $loja_rh . ", " . $loja2_rh;
              }
              if ($loja3_id != 0) {
                $loja_rh = $loja_rh . ", " . $loja3_rh;
              }

              $cargo = get_field('cargo_rh');
              $vaga = get_field('vaga_rh');

              if (!empty($cargo)) {
                $cargo_vaga = $cargo;
              } else {
                $cargo_vaga = $vaga;
              }

              $status = get_field('status_rh');
              $status_lido_nao = get_field('status_lido_nao');
              $status_destacar = get_field('status_destacar');
          ?>

              <tr class="<?php
                          if ($status == 'Contratado') echo "contratado ";
                          if ($status_lido_nao == 'lido') echo "lido";
                          if ($status_lido_nao == 'nao-lido') echo "novo-user";
                          if ($status_destacar == 'sim') echo " bg_destacado"; ?>">
                <td><?php the_time('d/m/Y') ?></td>

                <?php if ($status == 'Contratado'): ?>
                  <td><span title="Contratado"></span></td>
                <?php elseif ($status == 'selecionado-para-entrevista'): ?>
                  <td><span class="selecionado-para-entrevista" title="Selecionado para entrevista"></span></td>
                <?php elseif ($status == 'cadastro-de-reserva'): ?>
                  <td><span class="cadastro-de-reserva" title="Cadastro de reserva"></span></td>
                <?php elseif ($status == 'nao-contratado'): ?>
                  <td><span class="nao-contratado" title="Não contratado"></span></td>
                <?php else: ?>
                  <td><span class="nao-lido" title="Sem Status"></span></td>
                <?php endif; ?>

                <td><?php echo $cargo_vaga; ?></td>
                <td><?php echo $pretencao; ?></td>
                <td><?php echo $loja_rh; ?></td>
                <td><?php the_title(); ?> <?php echo $sobre_nome; ?></td>
                <td><a href="<?php the_permalink(); ?>" target="_blank" title="Editar currículo" name="submit_meta_lido" class="editar_curriculo">Ver/Editar</a></td>
              </tr>

          <?php
            endforeach;
          endif;
          ?>
        </tbody>
      </table>
    <?php endif; ?>
  </section>
</div>

<script>
  // Select Lojas
  document.getElementById('oflojas').addEventListener('change', function() {
    if (this.selectedIndex === 0) {
      window.location.replace("<?php bloginfo('url'); ?>/rh");
    } else {
      document.querySelector('.searchandfilter').submit();
    }
  });
</script>

<?php get_footer(); ?>
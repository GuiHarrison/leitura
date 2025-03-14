<?php

/**
 * Template de página do candidato
 *
 * @package leitura
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 */

namespace Air_Light;

//Exigindo login no sistema
if ((is_archive() || is_single())
  && !is_page('login') && !is_user_logged_in()
) {
  auth_redirect();
}
global $post;
?>

<?php get_header(); ?>

<div class="content container rh">
  <div class="logado remove-print ">
    <?php
    if (is_user_logged_in()):
      $current_user = wp_get_current_user();

      if (($current_user instanceof \WP_User)) {
        echo 'Olá, ' . $current_user->display_name;
        echo get_avatar($current_user->user_email, 32);
      }
    endif;
    ?>
    <a class="sair" href="<?php echo wp_logout_url(); ?>">Sair</a>
  </div>
  <div class="row">
    <?php $terms = wp_get_post_terms($post->ID, 'category_vagas'); ?>
    <?php if (have_posts()) : while (have_posts()) : the_post();
        $id_post = get_the_ID();
        $pretencao = get_field('salarial_rh');
        $sobre_nome = get_field('sobre_nome_rh');
        $data_nasc = get_field('data_n_rh');
        $ano = explode("-", $data_nasc)[0];
        $mes = explode("-", $data_nasc)[1];
        $idade = (int)date("Y") - (int)$ano;
        if ((int)$mes > (int)date("m")) {
          $idade = $idade - 1;
        }

        $estado_civil = get_field('estado_civil_rh');


        $filhos = get_field('filhos_rh');

        //Campos loja
        $loja1_id = get_field('loja_rh_1');
        if ($loja1_id) {
          $loja1 = get_post($loja1_id);
          $loja1_rh = $loja1->post_title;
          $terms_loja = wp_get_post_terms($loja1_id, "category_cidade_estado");
          $cidade_loja = $terms_loja[0]->name;
          $estado_obj = get_term($terms_loja[0]->parent, "category_cidade_estado");
          $estado_loja = $estado_obj->name;
        }

        $loja2_id = get_field('loja_rh_2');
        if ($loja2_id) {
          $loja2 = get_post($loja2_id);
          $loja2_rh = $loja2->post_title;
        }

        $loja3_id = get_field('loja_rh_3');
        if ($loja3_id) {
          $loja3 = get_post($loja3_id);
          $loja3_rh = $loja3->post_title;
        }


        $cargo = get_field('cargo_rh');
        $vaga = get_field('vaga_rh');

        if (!empty($cargo)) {
          $cargo_vaga = $cargo;
        } else {
          $cargo_vaga = $vaga;
        }




        $cpf = get_field('cpf_rh');
        $endereco = get_field('endereco_rh');
        $nacionalidade = get_field('nacionalidade_rh');
        $pne = get_field('PNE_rh');
        $pne2 = get_field('PNE_2_rh');
        $cidade = get_field('cidade_rh');
        $estado = get_field('estado_rh');
        $email = get_field('email_rh');
        $conhece_funcionario = get_field('parente_rh');
        $conhece_funcionario2 = get_field('parente_2_rh');
        $bairro = get_field('bairro_rh');
        $celular = get_field('telefone_cel_rh');
        $equipe = get_field('equipe_rh');
        $nivel_escolar = get_field('estudo_nivel_rh');
        $especializacao = get_field('especializacao_rh');
        $outros_cursos = get_field('outros_cursos_rh');
        $hardware = get_field('hardware_rh');
        $experiencia = get_field('experiencia_rh');

        $data_inicio = get_field('data_inicio_rh');
        if (!empty($data_inicio)) {
          $data_inicio = date('d/m/Y', strtotime($data_inicio));
        }

        $data_conclusao = get_field('data_conclusao_rh');
        if (!empty($data_conclusao)) {
          $data_conclusao = date('d/m/Y', strtotime($data_conclusao));
        }

        $empresa_anterior = get_field('empresa_atual_rh');
        $cargo_atuacao = get_field('cargo_atuacao_rh');
        $admissao = get_field('admissao_rh');
        if (!empty($admissao)) {
          $admissao = date('d/m/Y', strtotime($admissao));
        }

        $desligamento = get_field('desligamento_rh');
        if (!empty($desligamento)) {
          $desligamento = date('d/m/Y', strtotime($desligamento));
        }
        $ultimo_salario = get_field('salario_rh');

        $adicionar_experiencias = get_field('adicionar_experiencias_rh');

        $nome_da_empresa_2 = get_field('nome_da_empresa_2_rh');
        $data_de_admissao_2 = get_field('data_de_admissao_2_rh');
        $data_de_desligamento_2 = get_field('data_de_desligamento_2_rh');
        $cargo_2 = get_field('cargo_area_de_atuacao_2_rh');

        $nome_da_empresa_3 = get_field('nome_da_empresa_3_rh');
        $data_de_admissao_3 = get_field('data_de_admissao_3_rh');
        $data_de_desligamento_3 = get_field('data_de_desligamento_3_rh');
        $cargo_3 = get_field('cargo_area_de_atuacao_3_rh');

        // $contato_empresa = get_field('contato_outraempresa_rh');
        $conhecimento_infor = get_field('infor_rh');
        $office_rh = get_field('office_rh');
        $seus_conhecimentos = get_field('seus_conhecimentos_rh');
        $ingles = get_field('ingles_rh');
        $espanhol = get_field('espanhol_rh');
        $status = get_field('status_rh');
        $status_lido_nao = get_field('status_lido_nao');
        $status_destacar = get_field('status_destacar');
    ?>

        <?php
        if (isset($_POST['submit_meta'])) {
          if (! empty($_POST['select_aprovacao_' . $id_post . ''])) {
            $status = $_POST['select_aprovacao_' . $id_post . ''];
            $status_destacar = $_POST['select_destacar_' . $id_post . ''];
            //update_post_meta($post->ID, 'status_lido_nao', $_POST['select_status_'. $id_post .'']);
            update_post_meta($post->ID, 'status_rh', $status);
            update_post_meta($post->ID, 'status_destacar', $status_destacar);
          }
        }
        ?>

        <div class="detalhes_conta">

          <?php if (current_user_can('read')): ?>
            <section class="candidato-controles grid-6">
              <input type="button" onclick="window.close();" class="button" value="Voltar">

              <div class="candidato-status">
                <div class="status">
                  <label for="aprovacao">Status</label>
                  <select id="aprovacao" name="select_aprovacao_<?php echo $id_post; ?>">
                    <option
                      <?php if (
                        $status != 'nao-contratado' ||
                        $status != 'selecionado-para-entrevista' ||
                        $status != 'cadastro-de-reserva' ||
                        $status != 'Contratado'
                      )
                        echo "selected='selected'"; ?>
                      value="sem-status">
                      Sem Status
                    </option>
                    <option <?php if ($status == 'selecionado-para-entrevista') echo "selected='selected'"; ?> value="selecionado-para-entrevista">Selecionado para entrevista</option>
                    <option <?php if ($status == 'cadastro-de-reserva') echo "selected='selected'"; ?> value="cadastro-de-reserva">Cadastro de reserva</option>
                    <option <?php if ($status == 'Contratado') echo "selected='selected'"; ?> value="Contratado">Contratado</option>
                    <option <?php if ($status == 'nao-contratado') echo "selected='selected'"; ?> value="nao-contratado">Não contratado</option>
                  </select>
                </div>

                <input class="atualizar" type="submit" name="submit_meta" value="Salvar" />
                <input class="delete_cliente" value="Deletar" type="button" onclick="return confirm('Tem certeza que deseja deletar currículo de <?php the_title(); ?> <?php echo $sobre_nome; ?>?')" href="<?php echo get_delete_post_link($post->ID) ?>">
                <input class="imprimir" type="button" name="imprimir" value="Imprimir" onclick="window.print();">
              </div>


              <div class="candidato-destacar">
                <label for="destacar">Destacar</label>
                <select id="destacar" name="select_destacar_<?php echo $id_post; ?>">
                  <option <?php if ($status_destacar == 'nao') echo "selected='selected'"; ?> value="nao">Não</option>
                  <option <?php if ($status_destacar == 'sim') echo "selected='selected'"; ?> value="sim">Sim</option>
                </select>
              </div>

            </section>
          <?php endif; ?>
          <div class="bloco_dados">
            <h2 class="title-section"><?php the_title(); ?> <?php echo $sobre_nome; ?></h2>
            <strong><?php echo $idade; ?> anos, <?php echo $estado_civil; ?>, Filhos: <?php echo $filhos; ?>, Residência em <?php echo $cidade; ?>/<?php echo $estado; ?> <span class="cadastro"><strong>Cadastro:</strong> <?php the_time('d/m/Y'); ?></span></strong>
          </div>
          <div class="bloco_dados_2">
            <p><strong>Cargo Pretendido:</strong> <?php echo $cargo_vaga; ?> | <strong>Pretenção Salarial:</strong> <?php echo $pretencao; ?> | <strong>Loja(s) de interesse:</strong>
              <?php
              if ($loja1_id) {
                echo $loja1_rh;
              }
              if ($loja2_id) {
                echo ", " . $loja2_rh;
              }
              if ($loja3_id) {
                echo ", " . $loja3_rh;
              }
              ?>
            </p>
          </div>
          <div class="bloco_dados">
            <h3>DADOS PESSOAIS</h3>
            <div class="row">
              <div class="col-md-6 col-lg-6">
                <strong>Telefone Celular:</strong> <?php echo $celular; ?><br />
                <strong>E-mail:</strong> <?php echo $email; ?><br />
                <br />
                <strong>Endereço:</strong> <?php echo $endereco; ?><br />
                <strong>Bairro:</strong> <?php echo $bairro; ?><br />
                <strong>Cidade:</strong> <?php echo $cidade; ?><br />
                <strong>Estado:</strong> <?php echo $estado; ?><br />
                <strong>Nacionalidade:</strong> <?php echo $nacionalidade; ?><br />
                <br />
              </div>
              <div class="col-md-6 col-lg-6">
                <strong>CPF:</strong> <?php echo $cpf; ?><br />
                <strong>Portador de Necessidades Especiais?(PNE):</strong> <?php echo $pne; ?><br />
                <strong>Limitações (Em caso de ser PNE):</strong> <?php echo $pne2; ?><br />
                <br />
                <strong>Conhece algum funcionário da Livraria Leitura?</strong> <?php echo $conhece_funcionario; ?><br />
                <strong>Qual o grau de parentesco e em qual loja trabalha:</strong> <?php echo $conhece_funcionario2; ?> <br />
                <br />
                <strong>Por que você quer fazer parte da equipe da Leitura:</strong> <?php echo $equipe; ?>
              </div>
            </div>
          </div>
          <div class="bloco_dados">
            <h3>FORMAÇÃO ESCOLAR</h3>
            <div class="row">
              <div class="col-md-6 col-lg-6">
                <strong>Nível de Instrução:</strong> <?php echo $nivel_escolar; ?><br />
                <strong>Curso:</strong> <?php echo $especializacao; ?><br />

              </div>
              <div class="col-md-6 col-lg-6">
                <strong>Data de início:</strong> <?php echo $data_inicio; ?><br />
                <strong>Data de Conclusão:</strong> <?php echo $data_conclusao; ?><br />
                <strong>Outros Cursos:</strong> <?php echo $outros_cursos; ?>
              </div>
            </div>
          </div>
          <div class="bloco_dados">
            <h3>Experiência Profissional</h3>
            <div class="row">
              <div class="col-md-6 col-lg-6">
                <strong>Possui alguma experiência profissional?</strong> <?php echo $experiencia; ?><br />
                <strong>Nome da Atual ou Última Empresa:</strong> <?php echo $empresa_anterior; ?><br />
                <strong>Cargo/Area de atuação:</strong> <?php echo $cargo_atuacao; ?><br />
                <strong>Data de admissão:</strong> <?php echo $admissao; ?>
              </div>
              <div class="col-md-6 col-lg-6">
                <strong>Data de desligamento:</strong> <?php echo $desligamento; ?><br />
                <strong>Ultimo salário:</strong> <?php echo $ultimo_salario; ?><br />
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 col-lg-6">
                <strong>Nome da empresa:</strong> <?php echo $nome_da_empresa_2; ?><br />
                <strong>Data de admissão:</strong> <?php echo $data_de_admissao_2; ?>
                <strong>Data de desligamento:</strong> <?php echo $data_de_desligamento_2; ?>
                <strong>Cargo/Area de atuação:</strong> <?php echo $cargo_2; ?><br />
              </div>
              <div class="col-md-6 col-lg-6">
                <strong>Nome da empresa:</strong> <?php echo $nome_da_empresa_3; ?><br />
                <strong>Data de admissão:</strong> <?php echo $data_de_admissao_3; ?>
                <strong>Data de desligamento:</strong> <?php echo $data_de_desligamento_3; ?>
                <strong>Cargo/Area de atuação:</strong> <?php echo $cargo_3; ?><br />
              </div>
            </div>
          </div>
          <div class="bloco_dados">
            <h3>Conhecimentos</h3>
            <div class="row">
              <div class="col-md-4 col-lg-4">
                <strong>Conhecimento em Informática:</strong> <?php echo $conhecimento_infor; ?><br />
                <strong>Pacote Office:</strong> <?php echo $office_rh; ?>
              </div>
              <div class="col-md-2 col-lg-2">
                <strong>Hardware:</strong> <?php echo $hardware; ?>
              </div>
              <div class="col-md-6 col-lg-6">
                <strong>Descreva seu conhecimento em outros aplicativos:</strong> <?php echo $seus_conhecimentos; ?>
              </div>
            </div>
          </div>
          <div class="bloco_dados">
            <h3>Idiomas</h3>
            <div class="row">
              <div class="col-md-4 col-lg-4">
                <strong>Inglês:</strong> <?php echo $ingles; ?>
              </div>
              <div class="col-md-4 col-lg-4">
                <strong>Espanhol:</strong> <?php echo $espanhol; ?>
              </div>
            </div>
          </div>

        </div>

    <?php endwhile;
    endif; ?>

  </div>
</div>

<?php get_footer(); ?>

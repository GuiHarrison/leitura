<?php
/**
 * Bloco de chamada para revista
 *
 * @package airclean
 */

// namespace Air_Light;

$args = array(
    'post_type' => 'revista',
    'posts_per_page' => 1,
);

$query = new \WP_Query( $args );

if ( $query->have_posts() ) {
  echo '<div class="revista-container">';
    while ( $query->have_posts() ) {
      $query->the_post();

      // Debug do post atual
      $current_post = get_post();
      var_dump([
          'ID' => $current_post->ID,
          'post_type' => $current_post->post_type,
          'post_status' => $current_post->post_status,
      ]);

      // Debug do ACF
      var_dump([
          'ACF Ativo' => function_exists( 'get_field' ),
          'Campo PDF' => get_field( 'pdf', $current_post->ID ), // Forçando o ID do post
          'Todos Campos' => get_fields( $current_post->ID ),    // Forçando o ID do post
          'Meta Data' => get_post_meta( $current_post->ID ),    // Verificar todos os meta dados
      ]);

      $post_title = get_the_title();
      $first_word = strtok( $post_title, ' ' );

      // Verifica se o campo ACF existe e obtém a URL do PDF
      $pdf_url = get_field( 'pdf' ); // Alterado para o nome correto do campo

      // Debug para verificar o valor do campo
      // Debug mais detalhado
      var_dump( 'Post ID atual: ' . get_the_ID() );
      var_dump( 'Nome do campo procurado: pdf' );
      var_dump( 'Todos os campos ACF: ', get_fields() );
      var_dump( 'Campo específico: ', get_field( 'pdf' ) );
      var_dump( 'Post type atual: ', get_post_type() );

      // Verificar se o ACF está ativo
      if ( ! function_exists( 'get_field' ) ) {
          echo 'ACF não está ativo';
      }

      echo '<div class="revista-item">';
        echo '<h3>Explore as ofertas de ' . esc_html( $first_word ) . '</h3>';

        // Exibe o link apenas se houver uma URL válida
        if ( ! empty( $pdf_url ) ) {
            // Se o campo retornar um array (comum em campos de arquivo do ACF)
            if ( is_array( $pdf_url ) ) {
                $pdf_url = $pdf_url['url'];
            }
            echo '<a href="' . esc_url( $pdf_url ) . '" class="revista-button">Acessar revista</a>';
        } else {
            echo '<p class="revista-error">PDF não disponível no momento.</p>';
        }

        if ( has_post_thumbnail() ) {
          echo get_the_post_thumbnail( get_the_ID(), 'revista' );
        }
      echo '</div>';
    }
  echo '</div>';
  wp_reset_postdata();
}

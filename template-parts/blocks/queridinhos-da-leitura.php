<?php
/**
 * Bloco para Queridinhos da Leitura
 *
 * @package airclean
 */

 namespace Air_Light;

$ppp = get_field( 'ppp' );
$posts = get_posts(array(
  'post_type' => 'queridinhos',
  'posts_per_page' => $ppp,
));

if ( $posts ) {
	global $post;
	$contador = 0;
	?>

	<div id="queridinhos-da-leitura">
		<h2 id="queridinhos-home">→ Queridinhos da Leitura</h2>
		<a href="<?php echo esc_url( home_url( '/se-liga-na-leitura' ) ); ?>" class="ver-todas">Ver todas</a>

    <div class="slider-queridinhos owl-theme">
		<?php
		foreach ( $posts as $post ) {
			setup_postdata( $post );
      $autoria = get_field( 'autoria' );
      $citacao = get_field( 'citacao' );
      $comprar = get_field( 'lnik_na_loja' );
      $usuário = get_the_author_meta( 'ID' );
      $loja = get_field( 'loja_relacionada', 'user_' . $usuário );
      $id_loja = $loja->ID;
      $endereço = get_field( 'mapa_loja', $id_loja );
      $estado = endereco_para_estado_curto( $endereço['address'] );
      ?>


      <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

        <div class="q-colunas">
          <div class="queridinho thumbnail">
            <?php
              // the_post_thumbnail( 'resenha-p', array( 'loading' => 'lazy', 'fetchpriority' => 'low' ) );
            ?>
          </div>

          <div class="q-c-detalhes">
            <h3 class="<?php echo esc_attr( get_post_type() ); ?>-title">
              <a href="<?php echo esc_url( get_the_permalink() ); ?>">
                <?php the_title(); ?>
              </a>
            </h3>
            <div class="q-c-d-colaborador">
              <p class="q-c-d-pessoa"><?php echo esc_html( get_the_author() ); ?></p>
              <?php if ($loja) { echo '<p class="c-loja">' . esc_html( $loja->post_title ) . ' / ' . esc_html( $estado ) . '</p>'; } ?>
            </div>
          </div>
        </div>

        <div class="ler-comprar">
          <a href="<?php echo esc_url( get_the_permalink() ); ?>" class="button ler">Ler resenha</a>
          <a href="<?php echo esc_html( $comprar ); ?>" class="button comprar">🛒</a>
        </div>

      </article>

    <?php
		}
    wp_reset_postdata();
  }
  ?>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    jQuery('.slider-queridinhos').owlCarousel({
      responsive:{
  	    0:{
  	        items:1
  	    },
  	    600:{
  	        items:3
  	    }
  	  },
      loop: false,
      margin: 20,
      nav: true,
      dots: true,
      autoplay: false,
    });
  });
</script>

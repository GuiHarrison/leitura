<?php
/**
 * Bloco para Colunas e resenhas
 *
 * @package airclean
 */

 namespace Air_Light;

$ppp = get_field( 'ppp' );
$posts = get_posts(array(
	'posts_per_page' => $ppp,
	'category' => array( 403 ), // 403 = Colunas e resenhas
));

if ( $posts ) {
	 global $post;
	 $contador = 0;
	 ?>

	<div id="colunas-e-resenhas">
		<h2 id="destaque-home">→ Colunas e resenhas</h2>
		<a href="<?php echo esc_url( home_url( '/se-liga-na-leitura' ) ); ?>" class="ver-todas">Ver todas</a>

		<?php
		foreach ( $posts as $post ) {
			setup_postdata( $post );
        $autoria = get_field( 'autoria', get_the_id() );
        $citacao = get_field( 'citacao', get_the_id() );
        $usuário = get_the_author_meta( 'ID' );
			  ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				<div class = 'C&R thumbnail'>
					<?php
						the_post_thumbnail( 'resenha-p', array( 'loading' => 'lazy', 'fetchpriority' => 'low' ) );
					?>
				</div>

				<h3 class="<?php echo esc_attr( get_post_type() ); ?>-title">
					<a href="<?php echo esc_url( get_the_permalink() ); ?>">
						<?php the_title(); ?>
					</a>
				</h3>

				<h4>
					<a href="<?php echo esc_url( get_the_permalink() ); ?>">
						<?php echo esc_html( $autoria ) ?>
					</a>
				</h4>

        <div class="autor-do-post">
            <img src="<?php echo esc_url( get_avatar_url( $usuário ) ); ?>" alt="Autor: <?php echo esc_html( get_the_author() ); ?>" class="ap-foto">
          <h5 class="ap-nome"><?php echo esc_html( get_the_author() ); ?></h5>
        </div>

				<div class="content">
					<?php
					if ( $citacao ) {
						echo '<span>“</span>' . esc_html( $citacao ) . '<span>”</span>';
					} else {
						echo '<span>“</span>' . esc_html( wp_trim_words( get_the_excerpt(), 20, '[…]' ) ) . '<span>”</span>';
					}
					?>
				</div>

				<p>
					<time datetime="<?php the_time( 'c' ); ?>">
						<?php echo get_the_date( get_option( 'date_format' ) ); ?>
					</time>
				</p>

			</article>

		<?php
		}
		wp_reset_postdata();
}
?>

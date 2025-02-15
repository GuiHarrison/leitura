<?php
/**
 * Bloco para Queridinhos da Leitura
 *
 * @package airclean
 */

 namespace Air_Light;

 $posts = get_posts(array(
  'post_type' => 'queridinhos_da_leitura',
	'posts_per_page' => 3,
 ));

if ( $posts ) {
	global $post;
	$contador = 0;
	?>

	<div id="queridinhos-da-leitura">
		<h2 id="destaque-home">→ Queridinhos da Leitura</h2>
		<a href="<?php echo esc_url( home_url( '/se-liga-na-leitura' ) ); ?>" class="ver-todas">Ver todas</a>

		<?php
		foreach ( $posts as $post ) {
			setup_postdata( $post );
		$autoria = get_field( 'autoria' );
		$citacao = get_field( 'citacao' );
			  ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				<div class="C&R thumbnail">
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

				<div class="content">
					<?php
					if ( $citacao ) {
						echo esc_html( $citacao );
					} else {
            echo '<span>“</span>' . esc_html( wp_trim_words( get_the_excerpt() ), 10, '[…]' ) . '<span>”</span>';
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

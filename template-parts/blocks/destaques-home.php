<?php
/**
 * Bloco para destaques da home
 *
 * @package airclean
 */

 namespace Air_Light;

 $ppp = get_field( 'ppp' );
 $posts_destaque = get_posts(array(
	'meta_query' => array(
		array(
			'key' => 'destaque',
			'value' => '"home"',
			'compare' => 'LIKE',
		),
	),
	'posts_per_page' => $ppp,
	'category__not_in' => array( 403 ), // 403 = Colunas e resenhas
 ));

 if ( $posts_destaque ) {
    global $post;
    $contador = 0;
?>

  <div id="publicacoes-em-destaque">
    <h2 id="destaque-home">→ Publicações em destaque</h2>
    <a href="<?php echo esc_url( home_url( '/se-liga-na-leitura' ) ); ?>" class="ver-todas">Ver todas</a>
    <?php
        foreach ( $posts_destaque as $post ) {
            setup_postdata( $post );
        $contador++;
    ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div class="destaque thumbnail">
				<?php
				if ( $contador <= 2 && has_post_thumbnail() ) {
					 the_post_thumbnail( 'destaque-home', array( 'loading' => 'lazy', 'fetchpriority' => 'low' ) );
					}
				?>
			</div>

				<?php if ( has_category() ) : ?>
				<ul class="categories">
						<?php
                $categories = wp_get_post_categories( get_the_id(), [ 'fields' => 'all' ] );
						    if ( ! empty( $categories ) ) {
                  foreach ( $categories as $category ) {
										echo '<li><a href="' . esc_url( get_category_link( $category ) ) . '">' . esc_html( $category->name ) . '</a></li>';
                  }
						    }
            ?>
					</ul>
				<?php	endif; ?>

			<h3 class="<?php echo esc_attr( get_post_type() ); ?>-title">
				<a href="<?php echo esc_url( get_the_permalink() ); ?>">
					<?php the_title(); ?>
				</a>
			</h3>

			<?php
			/**
				$destaque_values = get_post_meta( get_the_ID(), 'destaque', true );
				$destaque_values = maybe_unserialize( $destaque_values );
				if ( is_array( $destaque_values ) ) {
					echo '<ul class="categories">';
					foreach ( $destaque_values as $value ) {
						echo '<li><a href="#_">' . esc_html( $value ) . '</a></li>';
					}
					echo '</ul>';
				}
      */
			?>

			<div class="content">
				<?php
					the_excerpt();
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

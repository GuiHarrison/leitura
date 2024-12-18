<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @Date:   2019-10-15 12:30:02
 * @Last Modified by:   Guilherme Harrison
 * @Last Modified time: 2022-02-08 17:03:18
 *
 * @package leitura
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 */

namespace Air_Light;

the_post();

get_header(); ?>

<script>
	var requestOptions = {
		method: 'GET',
	};

	fetch("https://api.geoapify.com/v1/ipinfo?apiKey=<?= THEME_SETTINGS['geoapify'] ?>", requestOptions)
	.then(response => response.json())
	.then(result => console.log(result))
	.catch(error => console.log('error', error));
</script>

<main class="site-main">
	<h1><?php the_title(); ?></h1>

	<?php if( have_rows('lojas') ): ?>
		<div class="acf-map" data-zoom="16">
			<?php while ( have_rows('lojas') ) : the_row(); 

				// Voltar aqui
				$location = get_field('loja');
				$title = get_field('title');
				$description = get_field('description');
				?>
				<div class="marker" data-lat="<?php echo esc_attr($location['lat']); ?>" data-lng="<?php echo esc_attr($location['lng']); ?>">
					<h3><?php echo esc_html( $title ); ?></h3>
					<p><em><?php echo esc_html( $location['address'] ); ?></em></p>
					<p><?php echo esc_html( $description ); ?></p>
				</div>
		<?php endwhile; ?>
		</div>
	<?php endif; ?>

	<?php
		the_content();
		air_edit_link();
	?>
</main>

<?php get_footer();

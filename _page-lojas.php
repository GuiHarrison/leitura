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

get_header();

$api_keys = APIKeys::get_instance();
$geoapify = $api_keys->get_key( 'geoapify' );
?>

<script>
	var requestOptions = {
		method: 'GET',
	};

	fetch("https://api.geoapify.com/v1/ipinfo?apiKey=<?php echo esc_js( $geoapify ); ?>", requestOptions)
	.then(response => response.json())
	.then(result => console.log(result))
	.catch(error => console.log('error', error));
</script>

<main class="site-main">
	<h1><?php the_title(); ?></h1>

	<?php
		$specifications_group_id    = 'group_5c44d6f413f95';
		$specifications_fields      = array();
		$fields = acf_get_fields( $specifications_group_id );
		foreach ( $fields as $field ) {
				$field_value = get_field( $field['name'] );
				if ( ! empty( $field_value ) ) {
						$specifications_fields[ $field['name'] ] = $field_value;
				}
		}
    var_dump( $specifications_fields );
	?>

	<div class="loja-container">
		<div class="loja-mapa">
			<div id="map"></div>
		</div>
	</div>

	<?php
		the_content();
		air_edit_link();
	?>
</main>

<?php get_footer();

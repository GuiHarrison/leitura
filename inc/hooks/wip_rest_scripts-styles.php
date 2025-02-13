<?php
/**
 * Enqueue and localize theme scripts and styles.
 *
 * @package leitura
 */

namespace Air_Light;

/**
 * Move jQuery to footer
 */
function move_jquery_into_footer( $wp_scripts ) {
	if ( ! is_admin() ) {
		$wp_scripts->add_data( 'jquery', 'group', 1 );
		$wp_scripts->add_data( 'jquery-core', 'group', 1 );
		$wp_scripts->add_data( 'jquery-migrate', 'group', 1 );
	}
} // end air_light_move_jquery_into_footer

/**
 * Enqueue scripts and styles.
 */
function enqueue_theme_scripts(): void {

	// Enqueue global.css
	wp_enqueue_style( 'styles',
		get_theme_file_uri( get_asset_file( 'global.css' ) ),
		[],
		filemtime( get_theme_file_path( get_asset_file( 'global.css' ) ) )
	);

	// Enqueue jquery and front-end.js
	wp_enqueue_script( 'jquery-core' );
	wp_enqueue_script( 'scripts',
		get_theme_file_uri( get_asset_file( 'front-end.js' ) ),
		[],
		filemtime( get_theme_file_path( get_asset_file( 'front-end.js' ) ) ),
		true
	);

	// Enfileira script de destaques se o bloco estiver presente
	if ( has_block( 'acf/destaques-home' ) ) {

		// Enfileira biblioteca de funções de destaques se o bloco estiver presente
		wp_enqueue_script(
			'destaques-functions',
			get_theme_file_uri( 'js/src/lib/destaques-functions.js' ),
			[],
			filemtime( get_theme_file_path( 'js/src/lib/destaques-functions.js' ) ),
			true
		);

		// Adiciona o script inline que depende das funções
		wp_add_inline_script('destaques-functions', '
			document.addEventListener("DOMContentLoaded", async function() {
				const container = document.getElementById("destaques-container");
				if (!container) return;

				const posts = await window.destaquesLib.fetchDestaques();
				const content = posts.map((post, index) =>
					window.destaquesLib.createArticleHTML(post, index)
				).join("");

				container.innerHTML = content || "<p>Erro ao carregar os destaques</p>";
			});
		');

    add_action('rest_api_init', function () {
      register_rest_route('leitura/v1', '/destaques-home', [
          'methods' => 'GET',
          'callback' => function () {
              $args = [
                  'post_type' => 'post',
                  'posts_per_page' => 4,
                  'meta_query' => [
                      [
                          'key' => 'destaque',
                          'value' => 'home',
                          'compare' => 'LIKE',
                      ],
                  ],
              ];

              $query = new \WP_Query( $args );
              $posts = $query->posts;

              foreach ( $posts as &$post ) {
                  $post->featured_media_url = get_the_post_thumbnail_url( $post->ID );
                  $post->categories = get_the_category( $post->ID );
              }

              return rest_ensure_response( $posts );
          },
          'permission_callback' => '__return_true',
      ]);
    });

	}

	// Enfileira script de mais recentes se o bloco estiver presente
	if ( has_block( 'acf/mais-recentes' ) ) {
		wp_enqueue_script(
			'recentes-functions',
			get_theme_file_uri( 'js/src/lib/recentes-functions.js' ),
			[],
			filemtime( get_theme_file_path( 'js/src/lib/recentes-functions.js' ) ),
			true
		);

		wp_add_inline_script('recentes-functions', '
			document.addEventListener("DOMContentLoaded", async function() {
				const container = document.getElementById("recentes-container");
				if (!container) return;

				const posts = await window.recentesLib.fetchRecentes();
				const content = posts.map((post, index) =>
					window.recentesLib.createRecentArticleHTML(post, index)
				).join("");

				container.innerHTML = content || "<p>Erro ao carregar os posts recentes</p>";
			});
		');
	}

	// Adicionando API do Google Maps à página de Lojas
	if ( is_page( 'lojas' ) ) {
		$api_keys = APIKeys::get_instance();
		$maps_key = $api_keys->get_key( 'maps' );

		if ( $api_keys ) {
			wp_enqueue_script(
				'google-maps',
				'https://maps.googleapis.com/maps/api/js?key=' . $maps_key . '&libraries=places,marker&loading=async',
				[],
				null,
				true
			);

			// Async e defer ao google-maps
			add_filter( 'script_loader_tag', function ( $tag, $handle ) {
				if ( 'google-maps' !== $handle ) {
					return $tag;
				}
				return str_replace( ' src', ' async defer src', $tag );
			}, 10, 2 );
		}
	}

	// Required comment-reply script
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// Tradução do menu
	wp_localize_script( 'scripts', 'air_light_screenReaderText', [
		'expand_for'      => 'Open child menu for',
		'collapse_for'    => 'Close child menu for',
		'expand_toggle'   => 'Abrir',
		'collapse_toggle' => 'Fechar',
		'external_link'   => 'External site',
		'target_blank'    => 'opens in a new window',
		'previous_slide'  => 'Previous slide',
		'next_slide'      => 'Next slide',
		'last_slide'      => 'Last slide',
		'skip_slider'     => 'Skip over the carousel element',
	] );

	// Add domains/hosts to disable external link indicators
	wp_localize_script( 'scripts', 'air_light_externalLinkDomains', THEME_SETTINGS['external_link_domains_exclude'] );
} // end air_light_scripts

/**
 * Returns the built asset filename and path depending on
 * current environment.
 *
 * @param string $filename File name with the extension
 * @return string file and path of the asset file
 */
function get_asset_file( $filename ) {
	$env = 'development' === wp_get_environment_type() && ! isset( $_GET['load_production_builds'] ) ? 'dev' : 'prod'; // phpcs:ignore WordPress.Security.NonceVerification.Recommended

	$filetype = pathinfo( $filename )['extension'];

	return "{$filetype}/{$env}/{$filename}";
} // end get_asset_file

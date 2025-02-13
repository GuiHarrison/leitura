<?php

namespace Air_Light;

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

<?php

namespace Air_Light;

class Base_Post_Type
{
  protected $post_type;
  protected $args;

  public function __construct($post_type)
  {
    $this->post_type = $post_type;
  }

  protected function get_default_supports()
  {
    return [
      'title',
      'editor',
      'thumbnail',
      'revisions',
      'show_in_rest', // Importante para o Gutenberg
    ];
  }

  protected function get_default_args()
  {
    return [
      'public' => true,
      'show_in_rest' => true, // Necessário para o Gutenberg
      'supports' => $this->get_default_supports(),
    ];
  }

  public function register()
  {
    $args = wp_parse_args($this->args, $this->get_default_args());
    register_post_type($this->post_type, $args);
  }
}

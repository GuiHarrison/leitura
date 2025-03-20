<?php

/**
 * Template for header
 *
 * <head> section and everything up until <div id="content">
 *
 * @package leitura
 */

namespace Air_Light;

?>

<!doctype html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="profile" href="http://gmpg.org/xfn/11">

  <!-- Google tag (gtag.js) -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-B9QPLQ11G1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'G-B9QPLQ11G1');
  </script>

  <!-- Google Tag Manager -->
  <script>
    (function(w, d, s, l, i) {
      w[l] = w[l] || [];
      w[l].push({
        'gtm.start': new Date().getTime(),
        event: 'gtm.js'
      });
      var f = d.getElementsByTagName(s)[0],
        j = d.createElement(s),
        dl = l != 'dataLayer' ? '&l=' + l : '';
      j.async = true;
      j.src =
        'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
      f.parentNode.insertBefore(j, f);
    })(window, document, 'script', 'dataLayer', 'GTM-TR7K4XM8');
  </script>
  <!-- End Google Tag Manager -->

  <?php wp_head(); ?>
</head>

<body <?php body_class('no-js'); ?>>

  <!-- Google Tag Manager (noscript) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TR7K4XM8"
      height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->

  <body <?php body_class('no-js'); ?>>
    <a class="skip-link screen-reader-text" href="#content"><?php echo esc_html('Pular para o conteúdo'); ?></a>

    <?php wp_body_open(); ?>
    <div id="page" class="site">

      <header class="site-header">
        <?php get_template_part('template-parts/header/boas-vindas'); ?>
        <?php get_template_part('template-parts/header/branding'); ?>
        <?php get_template_part('template-parts/header/navigation'); ?>
      </header>

      <div class="site-content">
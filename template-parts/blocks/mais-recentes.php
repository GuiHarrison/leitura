<?php
/**
 * Bloco para posts recentes ajustado ao layout do Figma
 *
 * @package airclean
 */

namespace Air_Light;

$ppp = get_field( 'ppp' );
$posts = get_posts([
  'posts_per_page'    => $ppp,
  'category__not_in'  => [403], // Excluindo a categoria "Colunas e resenhas"
]);

if ($posts) {
    global $post;
    $contador = 0;
?>

<div id="publicacoes-recentes" class="publicacoes-container">
    <div class="header-publicacoes">
        <h2 class="titulo-publicacoes">→ Publicações Recentes</h2>
        <a href="<?php echo esc_url(home_url('/se-liga-na-leitura')); ?>" class="ver-todas">Ver todas</a>
    </div>

    <div class="publicacoes-grid">
        <?php
        foreach ($posts as $post) {
            setup_postdata($post);
            $contador++;
        ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class('publicacao-item'); ?>>
			<?php if ($contador === 1 && has_post_thumbnail()) : ?>
				<div class="publicacao-thumbnail">
					<?php the_post_thumbnail('destaque-home', ['loading' => 'lazy', 'fetchpriority' => 'low']); ?>
				</div>
			<?php endif; ?>
			<div class="conteudo-direito">
				<?php if (has_category()) : ?>
					<ul class="publicacao-categorias">
						<?php
						$categories = wp_get_post_categories(get_the_ID(), ['fields' => 'all']);
						if (!empty($categories)) {
							foreach ($categories as $category) {
								echo '<li><a href="' . esc_url(get_category_link($category)) . '" class="categoria">' . esc_html($category->name) . '</a></li>';
							}
						}
						?>
					</ul>
				<?php endif; ?>
				<h3 class="publicacao-titulo">
					<a href="<?php echo esc_url(get_the_permalink()); ?>">
						<?php the_title(); ?>
					</a>
				</h3>
				<div class="publicacao-excerpt">
					<?php the_excerpt(); ?>
				</div>
				<p class="data-publicacao">
                	→  
                    <time datetime="<?php the_time( 'c' ); ?>">
                    	<?php echo date_i18n('j \d\e M \d\e Y', get_the_time('U')); ?>
                    </time>
                </p>
			</div>
        </article>
        <?php
        }
        wp_reset_postdata();
        ?>
    </div>
</div>

<?php
}
?>

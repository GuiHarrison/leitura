<?php

/**
 * Script de Migração: Renomear taxonomia de generos para curadoria
 * 
 * ============================================
 * OPÇÃO 1: VIA WP-CLI (RECOMENDADO)
 * ============================================
 * 
 * No terminal do servidor, execute:
 * 
 *   wp eval-file migrate-generos-curadoria.php
 * 
 * Ou coloque em wp-content/mu-plugins/ para executar automaticamente:
 * 
 *   cp migrate-generos-curadoria.php wp-content/mu-plugins/
 *   wp eval-file wp-content/mu-plugins/migrate-generos-curadoria.php
 * 
 * ============================================
 * OPÇÃO 2: VIA WP-ADMIN (sem perda de SEO)
 * ============================================
 * 
 * 1. Coloque em: wp-content/mu-plugins/migrate-generos-curadoria.php
 * 2. Acesse QUALQUER página do site (não precisa ser URL especial)
 * 3. Migração ocorre automaticamente (seguro, idempotente)
 * 4. Delete o arquivo depois
 * 
 * ============================================
 * OPÇÃO 3: VIA SSH/BASH (sem WP-CLI)
 * ============================================
 * 
 *   cd /caminho/wordpress && \
 *   php -d display_errors=1 -r 'require("wp-load.php"); run_generos_to_curadoria_migration();'
 * 
 */

if (! function_exists('run_generos_to_curadoria_migration')) {
	function run_generos_to_curadoria_migration()
	{
		global $wpdb;

		// Chave para rastrear migração
		$option_key = 'generos_to_curadoria_migration_completed';

		// Se já foi migrado, não fazer novamente
		if (get_option($option_key)) {
			if (defined('WP_CLI') && WP_CLI) {
				WP_CLI::line('✓ Migração já foi concluída anteriormente.');
			}
			return true;
		}

		$start_time = microtime(true);
		$is_cli = defined('WP_CLI') && WP_CLI;

		if ($is_cli) {
			WP_CLI::line('▶ Iniciando migração...');
		}

		// 1. Atualizar taxonomia
		$updated = $wpdb->query(
			$wpdb->prepare(
				"UPDATE {$wpdb->term_taxonomy} SET taxonomy = %s WHERE taxonomy = %s",
				'category_curadoria',
				'category_generos'
			)
		);

		if ($updated === false) {
			$error = "Erro ao atualizar taxonomia: " . $wpdb->last_error;
			if ($is_cli) {
				WP_CLI::error($error);
			}
			return false;
		}

		if ($is_cli) {
			WP_CLI::line(sprintf('✓ Taxonomia atualizada: %d registros', $updated));
		}

		// 2. Limpar cache
		wp_cache_flush();
		delete_transient('wc_term_recount');

		// 3. Recuperar termos
		wp_cache_delete('all_terms', 'terms');
		$terms = get_terms(array(
			'taxonomy'   => 'category_curadoria',
			'hide_empty' => false,
		));

		if (is_wp_error($terms)) {
			if ($is_cli) {
				WP_CLI::error($terms->get_error_message());
			}
			return false;
		}

		if ($is_cli) {
			WP_CLI::line(sprintf('✓ Total de termos: %d', count($terms)));
			if (! empty($terms)) {
				WP_CLI::line('Termos migrados:');
			}
		}

		// 4. Listar termos
		foreach ($terms as $term) {
			$posts_count = $wpdb->get_var(
				$wpdb->prepare(
					"SELECT COUNT(*) FROM {$wpdb->term_relationships} tr 
                     INNER JOIN {$wpdb->term_taxonomy} tt ON tr.term_taxonomy_id = tt.term_taxonomy_id 
                     WHERE tt.term_id = %d AND tt.taxonomy = %s",
					$term->term_id,
					'category_curadoria'
				)
			);

			if ($is_cli) {
				WP_CLI::line(sprintf('  • %s (%d posts)', $term->name, $posts_count));
			}
		}

		// 5. Marcar como concluído
		update_option($option_key, current_time('mysql'));

		$elapsed = microtime(true) - $start_time;
		if ($is_cli) {
			WP_CLI::success(sprintf('Migração concluída em %.2f segundos!', $elapsed));
		}

		return true;
	}
}

// ========== EXECUTAR CONFORME O CONTEXTO ==========

if (defined('WP_CLI') && WP_CLI) {
	// Via WP-CLI
	run_generos_to_curadoria_migration();
} elseif (strpos(__FILE__, 'mu-plugins') !== false) {
	// Se em mu-plugins, executar ao carregar WordPress
	add_action('plugins_loaded', function () {
		run_generos_to_curadoria_migration();
	}, 1);
}

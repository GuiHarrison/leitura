<?php

namespace Air_Light;

// Verifica se o usuário tem permissão
if (!current_user_can('edit_posts')) {
	return;
}

$nonce = wp_create_nonce('atualizar_anexos_action');
?>

<div class="wrap">
	<h2>Atualização de Anexos</h2>
	<p>Este processo vai atualizar os anexos de currículos antigos. O processo será feito em lotes de 10 vagas por vez.</p>

	<button id="atualizar-anexos" class="button button-primary">
		Iniciar Atualização
	</button>

	<div id="resultado-atualizacao" style="margin-top: 15px;">
		<div class="progress-info" style="display: none;">
			<div class="progress-bar" style="background: #f0f0f0; margin: 10px 0;">
				<div class="progress" style="background: #0073aa; height: 20px; width: 0%; transition: width 0.3s;"></div>
			</div>
			<p class="status"></p>
			<div class="stats">
				<p>Processados: <span class="processados">0</span></p>
				<p>Atualizados com sucesso: <span class="atualizados">0</span></p>
				<p>Erros: <span class="erros">0</span></p>
				<p>Total de vagas: <span class="total">0</span></p>
				<p>Página atual: <span class="pagina">0</span> de <span class="total-paginas">0</span></p>
			</div>
		</div>
	</div>
</div>

<script>
	jQuery(document).ready(function($) {
		let isProcessing = false;

		function processarLote(pagina = 1, statsAcumulados = null) {
			if (!statsAcumulados) {
				statsAcumulados = {
					processados: 0,
					atualizados: 0,
					erros: 0
				};
			}

			const $button = $('#atualizar-anexos');
			const $resultado = $('#resultado-atualizacao');
			const $progress = $resultado.find('.progress-info');
			const $status = $progress.find('.status');
			const $progressBar = $progress.find('.progress');

			if (pagina === 1) {
				$button.prop('disabled', true);
				$progress.show();
				isProcessing = true;
			}

			$status.html('<p>Processando lote ' + pagina + '...</p>');

			$.ajax({
				url: ajaxurl,
				type: 'POST',
				data: {
					action: 'atualizar_anexos_antigos',
					_wpnonce: '<?php echo $nonce; ?>',
					pagina: pagina
				},
				success: function(response) {
					if (response.success) {
						// Atualiza estatísticas acumuladas
						statsAcumulados.processados = response.data.total_processados;
						statsAcumulados.atualizados += response.data.total_atualizados;
						statsAcumulados.erros += response.data.total_erros;

						// Atualiza interface
						$progress.find('.processados').text(statsAcumulados.processados);
						$progress.find('.atualizados').text(statsAcumulados.atualizados);
						$progress.find('.erros').text(statsAcumulados.erros);
						$progress.find('.total').text(response.data.total_vagas);
						$progress.find('.pagina').text(response.data.pagina_atual);
						$progress.find('.total-paginas').text(response.data.total_paginas);

						// Atualiza barra de progresso
						const percentual = (response.data.pagina_atual / response.data.total_paginas) * 100;
						$progressBar.css('width', percentual + '%');

						// Continua para o próximo lote se necessário
						if (response.data.tem_mais) {
							$status.html('<p>Lote ' + pagina + ' concluído. Iniciando próximo lote...</p>');
							setTimeout(() => processarLote(pagina + 1, statsAcumulados), 1000);
						} else {
							$status.html(
								'<div class="notice notice-success">' +
								'<p>Processo concluído! Total de currículos atualizados: ' +
								statsAcumulados.atualizados + '</p>' +
								'</div>'
							);
							$button.prop('disabled', false);
							isProcessing = false;
						}
					} else {
						$status.html(
							'<div class="notice notice-error">' +
							'<p>Erro: ' + (response.data.message || response.data) + '</p>' +
							'</div>'
						);
						$button.prop('disabled', false);
						isProcessing = false;
					}
				},
				error: function(xhr, status, error) {
					$status.html(
						'<div class="notice notice-error">' +
						'<p>Erro na requisição: ' + error + '</p>' +
						'</div>'
					);
					$button.prop('disabled', false);
					isProcessing = false;
				}
			});
		}

		$('#atualizar-anexos').on('click', function() {
			if (!isProcessing) {
				processarLote();
			}
		});
	});
</script>
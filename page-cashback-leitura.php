<?php

/**
 * Página de trabalhe conosco
 *
 * @package leitura
 */

namespace Air_Light;

get_header();
?>
<div id="cena3d"></div>
<main class="container-login">
	<div class="no-telefone"></div>
	<div class="hero">
		<img src="<?php echo esc_url(get_theme_file_uri('img/logoHorizontalPlus.svg')); ?>" alt="Logo Cashback Leitura" class="logo">
	</div>
	<div class="coluna-vazia"></div>
	<div class="coluna-texto">
		<h1 class="poppins-bold">Cashback Leitura: transforme compras em vantagens</h1>
		<h3 class="poppins-medium">Mais benefícios, mais facilidade e muito mais leitura</h3>
		<p class="poppins-medium">O Cashback Leitura chegou para tornar sua experiência ainda melhor! Agora, em vez de pontos, você recebe créditos a cada compra e pode utilizá-los nas próximas. É fácil, rápido e pensado para valorizar quem é apaixonado por livros: faça seu cadastro, acompanhe seu saldo e aproveite as vantagens sempre que quiser renovar sua estante.</p>
		<p class="texto-pequeno poppins-medium"><strong>Importante:</strong> seus créditos são válidos exclusivamente nas lojas físicas da Livraria Leitura espalhadas por todo o Brasil.</p>
		<a class="texto-padrao poppins-medium" target="_blank" href="https://seliganaleitura.com.br/cashbackleitura/regulamento.html">Conheça o regulamento do programa</a>
	</div>
	<section class="coluna-formulario">
		<form class="full-post" method="POST" action="https://cashbackleitura.com.br/index.php?opcao=login"
			name="form_login" id="form_login">
			<div class="form-cadastro">
				<a class="cadastrar texto-grande"
					href="https://cashbackleitura.com.br/index.php?opcao=inclui_cadastro">Cadastre-se</a>
			</div>
			<div class="form-group">
				<p>Já possui cadastro?</p>
				<input type="text" placeholder="CPF / CNPJ" class="texto-grande valid-chars mask mask-cpf-cnpj"
					maxlength="18" name="usuario" id="usuario" autocomplete="off"
					style="max-width: 100%; box-sizing: border-box;">
				<span class="icon icon-user"></span>
			</div>
			<div class="form-group">
				<input type="password" autocomplete="off" placeholder="Senha" class="texto-grande" maxlength="20"
					name="senha" id="senha" style="max-width: 100%; box-sizing: border-box;">
				<span class="icon icon-password toggle-password" data-pwd-field="#senha"></span>
			</div>
			<div class="error-container hidden">
				<a class="texto-padrao error-message"></a>
			</div>
			<button class="texto-grande white login-button" type="submit" name="envia_login"
				id="envia_login">Entrar</button>
			<input type="hidden" name="envia_login" value="1">
			<a class="texto-padrao small"
				href="https://cashbackleitura.com.br/index.php?opcao=esqueci_senha">Esqueci minha senha</a>
		</form>
	</section>
</main>

<?php get_footer(); ?>
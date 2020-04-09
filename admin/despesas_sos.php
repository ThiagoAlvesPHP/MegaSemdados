<?php
require 'header.php';
$nav = new Navegacao();

if (!empty($_GET['num_processo'])) {
	$ajax = new Ajax();
	$r = new Rdp();

	$dados = $ajax->getProc(addslashes($_GET['num_processo']));

	$post = filter_input_array(INPUT_POST, FILTER_DEFAULT);
	$post['num_processo'] = $_GET['num_processo'];
	$post['num_sinistro'] = $dados['num_sinistro'];
	$post['seguradora'] = $dados['seguradora'];
	$post['segurado'] = $dados['segurado'];
	$post['transportadora'] = $dados['transportadora'];

	//inserir quando 01
	if (!empty($post['dt_cadastro'])) {
		$r->setSOS($post);
		echo '<script>alert("Registrado com sucesso!");window.location.href="despesas_sos.php?num_processo='.$_GET['num_processo'].'"</script>';
	}
}
?>

<div class="container-fluid conteudo">	
	<div class="row">
		<div class="col-sm-1"></div>
		<div class="col-sm-10">
		
			<h3>Despesas SOS do Relatório Geral</h3>
			<hr>

			<div class="well">
				<input class="form-control Processo seach_proc_sos" placeholder="Pesquisar Processo">
				<hr>
				<div class="resposta"></div>
			</div>

			<div class="well">
				<?php if(!empty($_GET['num_processo'])): ?>
					<div class="row">
						<div class="col-sm-6">
							<label>Processo Mega Nrº</label>
							<input type="text" name="" class="form-control" value="<?=$dados['num_processo']; ?>" readonly="">
						</div>
						<div class="col-sm-6">
							<label>Processo Allianz Nrº</label>
							<input type="text" name="" class="form-control" value="<?=$dados['num_sinistro']; ?>" readonly="">
						</div>
					</div>	
					<div class="row">
						<div class="col-sm-4">
							<label>Seguradora:</label>
							<input type="text" name="" class="form-control" value="<?=utf8_decode($dados['seguradora']); ?>" readonly="">
						</div>
						<div class="col-sm-4">
							<label>Segurado:</label>
							<input type="text" name="" class="form-control" value="<?=utf8_decode($dados['segurado']); ?>" readonly="">
						</div>
						<div class="col-sm-4">
							<label>Transportador</label>
							<input type="text" name="" class="form-control" value="<?=utf8_decode($dados['transportadora']); ?>" readonly="">
						</div>
					</div>	

					<hr>
					
					<form method="POST">
						<label>Data:</label>
						<input type="date" name="dt_cadastro" class="form-control" required="">
						<label>Descrição Detalhada das Despesas SOS:</label>
						<textarea name="descricao" class="form-control" required=""></textarea>
						<label>Valor:</label>
						<input type="text" name="valor" class="form-control money" required="">
						<br>
						<button class="btn btn-primary">Registrar</button>
					</form>

				<?php endif; ?>		
			</div>

		</div>
		<div class="col-sm-1"></div>
	</div>
</div>

<?php require 'footer.php'; ?>
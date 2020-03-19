<?php
if (empty($_GET['type'])) {
	header('Location: index.php');
}
require 'header.php';
$nav = new Navegacao();

if (!empty($_GET['num_processo'])) {
	$ajax = new Ajax();

	$dados = $ajax->getProc(addslashes($_GET['num_processo']));
}

$post = filter_input_array(INPUT_POST, FILTER_DEFAULT);

?>
<style type="text/css">
	.resposta{
		font-size: 12px;
	}
</style>
<?php if($_GET['type'] == 'despesas_proprias'): ?>
	<div class="container-fluid conteudo">	
		<div class="row">
			<div class="col-sm-1"></div>
			<div class="col-sm-10">
			
				<h3>RDP - Recibo Despesas Próprias</h3>
				<hr>

				<div class="well">
					<input class="form-control seach_proc" placeholder="Pesquisar Processo">
					<input type="hidden" name="" class="type" value="<?=$_GET['type']; ?>">
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
								<input type="text" name="" class="form-control" value="<?=$dados['seguradora']; ?>" readonly="">
							</div>
							<div class="col-sm-4">
								<label>Segurado:</label>
								<input type="text" name="" class="form-control" value="<?=$dados['segurado']; ?>" readonly="">
							</div>
							<div class="col-sm-4">
								<label>Transportador</label>
								<input type="text" name="" class="form-control" value="<?=$dados['transportadora']; ?>" readonly="">
							</div>
						</div>	

						<hr>
						
						<h4>Quadro 01 - <button class="formQ1">+</button></h4>
						
						<!-- quadro 1

						km ida
						km deslocamento interno
						km retorno
						refeicao
						hospedagem
						pedagios
						xerox
						sedex
						outros -->
						
						<hr>
						<form method="POST">
							<div class="form_area"></div>
							<button class="btn btn-success btn-action">Salvar</button>
						</form>

						<hr>
					<?php endif; ?>
					
					<!-- <h4>Quadro 02</h4>
					<button class="btn btn-success formQ1">+</button>
	
	quadro 2

honorario sos
honorario averiguação
honorario limpeza do local
certificado de vistoria


					<ul>
						<li>Quantidade</li>
						<li>Descrição - SOS</li>
						<li>Valor Unitario</li>
						<li>Valor Total</li>
					</ul>	
					<ul>
						<li>Sub Total</li>
						<li>Total Geral</li>
					</ul> -->			
				</div>

			</div>
			<div class="col-sm-1"></div>
		</div>
	</div>

	
<?php endif; ?>
<?php require 'footer.php'; ?>
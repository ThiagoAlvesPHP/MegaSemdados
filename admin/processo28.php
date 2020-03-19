<?php
require 'header.php';
$sql = new Processos();
$num_processo = addslashes($_GET['num_processo']);
$p = $sql->getProcesso($num_processo);

$docs = $sql->processo_doc_anexos($num_processo);

?>

<br><br><br>
<div class="row">
	<div class="col-sm-1"></div>
	<div class="col-sm-10">
		<div class="panel panel-success">
	      <div class="panel-heading">
	      	 Cadastro de Processo
	      </div>
	      <div class="panel-body">
	      	<?php require 'navbarProcesso.php'; ?>
	      	<hr>
	      	<h3>Documentos Anexos / Digitalizados</h3>
	      	<div class="well">
	      		<form method="POST">
	      			
	      			<?php 
	      			if (!empty($docs)) {
	      				if (isset($_POST['mercadoria'])) {
	      					$mercadoria = addslashes($_POST['mercadoria']);
	      					$transporte = addslashes($_POST['transporte']);
	      					$condutor = addslashes($_POST['condutor']);
	      					$veiculo_sinistrado = addslashes($_POST['veiculo_sinistrado']);
	      					$condutor_transbordo = addslashes($_POST['condutor_transbordo']);
	      					$veiculo_transbordo = addslashes($_POST['veiculo_transbordo']);
	      					$outros = addslashes($_POST['outros']);

	      					$sql->upDocsAnexos($num_processo, $mercadoria, $transporte, $condutor, $veiculo_sinistrado, $condutor_transbordo, $veiculo_transbordo, $outros);
	      					?>
							<script>
								window.location.href = "processo29.php?num_processo=<?=$num_processo; ?>";
							</script>
							<?php
	      				}
	      				?>
	      			<label>Mercadoria:</label>
	      			<textarea name="mercadoria" class="form-control"><?=htmlspecialchars($docs['mercadoria']); ?></textarea>
	      			<label>Transporte:</label>
	      			<textarea name="transporte" class="form-control"><?=htmlspecialchars($docs['transporte']); ?></textarea>
	      			<label>Condutor - Veículo Transportador:</label>
	      			<textarea name="condutor" class="form-control"><?=htmlspecialchars($docs['condutor']); ?></textarea>
	      			<label>Veículo Transportador Sinistrado:</label>
	      			<textarea name="veiculo_sinistrado" class="form-control"><?=htmlspecialchars($docs['veiculo_sinistrado']); ?></textarea>
	      			<label>Condutor - Veículo Transbordo:</label>
	      			<textarea name="condutor_transbordo" class="form-control"><?=htmlspecialchars($docs['condutor_transbordo']); ?></textarea>
	      			<label>Veículo Transbordo:</label>
	      			<textarea name="veiculo_transbordo" class="form-control"><?=htmlspecialchars($docs['veiculo_transbordo']); ?></textarea>
	      			<label>Outros Documentos Emitidos/Reunidos pelo Vistoriador:</label>
	      			<textarea name="outros" class="form-control"><?=htmlspecialchars($docs['outros']); ?></textarea>
	      				<?php

	      			} else {
	      				if (isset($_POST['mercadoria'])) {
	      					$mercadoria = addslashes($_POST['mercadoria']);
	      					$transporte = addslashes($_POST['transporte']);
	      					$condutor = addslashes($_POST['condutor']);
	      					$veiculo_sinistrado = addslashes($_POST['veiculo_sinistrado']);
	      					$condutor_transbordo = addslashes($_POST['condutor_transbordo']);
	      					$veiculo_transbordo = addslashes($_POST['veiculo_transbordo']);
	      					$outros = addslashes($_POST['outros']);

	      					$sql->setDocsAnexos($num_processo, $mercadoria, $transporte, $condutor, $veiculo_sinistrado, $condutor_transbordo, $veiculo_transbordo, $outros);
	      					?>
							<script>
								window.location.href = "processo29.php?num_processo=<?=$num_processo; ?>";
							</script>
							<?php
	      				}
	      				?>
	      			<label>Mercadoria:</label>
	      			<textarea name="mercadoria" class="form-control"></textarea>
	      			<label>Transporte:</label>
	      			<textarea name="transporte" class="form-control"></textarea>
	      			<label>Condutor - Veículo Transportador:</label>
	      			<textarea name="condutor" class="form-control"></textarea>
	      			<label>Veículo Transportador Sinistrado:</label>
	      			<textarea name="veiculo_sinistrado" class="form-control"></textarea>
	      			<label>Condutor - Veículo Transbordo:</label>
	      			<textarea name="condutor_transbordo" class="form-control"></textarea>
	      			<label>Veículo Transbordo:</label>
	      			<textarea name="veiculo_transbordo" class="form-control"></textarea>
	      			<label>Outros Documentos Emitidos/Reunidos pelo Vistoriador:</label>
	      			<textarea name="outros" class="form-control"></textarea>
	      				<?php
	      			}
	      			?>

	      			<br>
				    <div class="row">
		      			<div class="col-sm-10"></div>
		      			<div class="col-sm-2">
							<a href="processo27.php?num_processo=<?=$num_processo; ?>" class="btn btn-danger">Voltar</a>	
							<button class="btn btn-primary">Proximo</button>	
		      			</div>
		      		</div>
		      	</form>
	      	</div>
	      </div>
	    </div>
	</div>
	<div class="col-sm-1"></div>
</div>

<?php
require 'footer.php';
?>
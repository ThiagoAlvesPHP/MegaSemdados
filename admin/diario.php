<?php
require 'header.php';
$sql = new Processos();
//SEGURADOS
$getCorretora = $sql->getCorretora();
$num_processo = addslashes($_GET['num_processo']);
$p = $sql->getProcesso($num_processo);

if (!empty($_POST['detalhes'])) {
	$detalhes = addslashes($_POST['detalhes']);
	$valor = addslashes($_POST['valor']);
	$dt = addslashes($_POST['dt_hs']);

	$explode = explode('/', $dt);
	$explode2 = explode(' ', $explode[2]);
	$dt_hs = $explode2[0].'-'.$explode[1].'-'.$explode[0].' '.$explode2[1];

	$sql->setDiario($num_processo, $detalhes, $valor, $dt_hs, $id_user);
	?>
	<script>
		alert("Registrado com sucesso!");
		window.location.href = "diario.php?num_processo=<?=$num_processo; ?>";
	</script>
	<?php
}
//DELETANDO DIARIO
if (isset($_GET['id'])) {
	$sql->delDiario(addslashes($_GET['id']));
	?>
	<script>
		alert("Registrado Deletado!");
		window.location.href = "diario.php?num_processo=<?=$num_processo; ?>";
	</script>
	<?php
}

$t = $sql->getDiario($num_processo);
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
	      	<h3>Diário de Bordo - Uso Interno</h3>
	      	<div class="well">
	      		
	      		<!-- Modal -->
				<button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">+</button>
				<div id="myModal" class="modal fade" role="dialog">
				  <div class="modal-dialog">
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal">&times;</button>
				        <h4 class="modal-title">Histórico do Processo</h4>
				      </div>
				      <div class="modal-body">
				        <p>
				        	<form method="POST">
				        		<label>Detalhamento:</label>
				        		<textarea name="detalhes" class="form-control"></textarea>
				        		<label>Valor da Importância:</label>
				        		<input type="text" name="valor" class="form-control money">
				        		<label>Data e hora para Notificação por e-mail:</label>
				        		<input type="text" name="dt_hs" id="dt_hs_comunicado" class="form-control">
				        	
				        </p>
				      </div>
				      <div class="modal-footer">
				        <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
				        <button class="btn btn-primary">Salvar</button>
				        </form>
				      </div>
				    </div>
				  </div>
				</div>
				
				<hr>

				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th>Ação</th>
								<th>Criado em</th>
								<th>Criado por</th>
								<th>informação</th>
								<th>Valor</th>
								<th>Notificar em</th>
							</tr>
						</thead>
						<?php
						foreach ($t as $tab) {
							?>
						<tbody>
							<tr>
								<td>
									<a href="diario.php?num_processo=<?=$num_processo; ?>&id=<?=$tab['id']; ?>" class="fas fa-trash-alt"></a>
								</td>
								<td><?=date('d/m/Y H:i:s', strtotime($tab['dt_criacao'])); ?></td>
								<td><?=$tab['nome']; ?></td>
								<td><?=$tab['detalhes']; ?></td>
								<td>R$<?=number_format($tab['valor'], 2, '.', ''); ?></td>
								<td><?=date('d/m/Y H:i:s', strtotime($tab['dt_hs'])); ?></td>
							</tr>
						</tbody>
							<?php
						}
						?>
						
					</table>
				</div>

	      	</div>
	      </div>
	    </div>
	</div>
	<div class="col-sm-1"></div>
</div>

<?php
require 'footer.php';
?>
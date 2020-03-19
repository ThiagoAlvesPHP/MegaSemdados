<?php
require 'header.php';
$sql = new Processos();

$num_processo = addslashes($_GET['num_processo']);
$p = $sql->getProcesso($num_processo);

//GERANDO E SALVANDO INVENTARIO
if (isset($_GET['inventario']) && $_GET['inventario'] == "active") {
	$token = date('ymd').rand(0, 99999).date('s');
	$sql->seInventario($num_processo, $token, $id_user);
	?>
	<script>
		alert("Inventario de Produto <?=$token; ?> gerado!");
		window.location.href = "processo31.php?num_processo=<?=$num_processo; ?>";
	</script>
	<?php
}

$Inventario = $sql->getInventario($num_processo);
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
	      	<h3>Inventário de Produtos</h3>
	      	<div class="well">
      			<a href="processo31.php?num_processo=<?=$num_processo; ?>&inventario=active" type="button" class="btn btn-info">+</a>
      			<hr>

      			<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th>Ação</th>
								<th>CV Número</th>
								<th>Criado em</th>
								<th>Criado por</th>
							</tr>
						</thead>
						<?php 
						foreach ($Inventario as $c) {
							?>
						<tbody>
							<tr>
								<td>
									<a href="processo31.inventario.php?num_processo=<?=$num_processo; ?>&id_inventario=<?=$c['id']; ?>" class="fa fa-tasks" target="_blank"></a>
									<a href="processo31.pdf.php?num_processo=<?=$num_processo; ?>&id_inventario=<?=$c['id']; ?>" class="fas fa-print" target="_blank"></a>
								</td>
								<td><?=$c['token']; ?></td>
								<td><?=date('d/m/Y H:i:s', strtotime($c['dt_criacao'])); ?></td>
								<td><?=$c['nome']; ?></td>
							</tr>
						</tbody>
							<?php
						}
						?>
					</table>
				</div>

			    <div class="row">
	      			<div class="col-sm-10"></div>
	      			<div class="col-sm-2">
						<a href="processo30.php?num_processo=<?=$num_processo; ?>" class="btn btn-danger">Voltar</a>	
						<a href="processoDocArq.php?num_processo=<?=$num_processo; ?>" class="btn btn-primary">Proximo</a>
	      			</div>
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
<?php
require 'header.php';
$sql = new Processos();
//SEGURADOS
$getCidades = $sql->getCidades();
$num_processo = addslashes($_GET['num_processo']);
$p = $sql->getProcesso($num_processo);

$getApPv = $sql->getDetVistoria($num_processo);

//REGISTRANDO
if (isset($_POST['det_vistoria'])) {
	$det_vistoria = addslashes($_POST['det_vistoria']);
	$sql->setDetVistoria($num_processo, $det_vistoria);
	?>
	<script>
		window.location.href = "processo23.php?num_processo=<?=$num_processo; ?>";
	</script>
	<?php
}
//ATUALIZAR
if (isset($_POST['det_vistoriaUP'])) {
	$det_vistoria = addslashes($_POST['det_vistoriaUP']);

	$sql->upDetVistoria($num_processo, $det_vistoria);
	?>
	<script>
		window.location.href = "processo23.php?num_processo=<?=$num_processo; ?>";
	</script>
	<?php
}
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
	      	<h3>Detalhes da Vistoria</h3>
	      	<div class="well">
	      		<form method="POST">
	      			<?php
	      			if (!empty($getApPv)) {
	      				?>
	      				<label>Descreva os Detalhes da Vistoria:</label>
		      			<textarea name="det_vistoriaUP" style="height: 200px;" class="form-control"><?=$getApPv['detalhes']; ?></textarea>
	      				<?php
	      			} else {
	      				?>
	      				<label>Descreva os Detalhes da Vistoria:</label>
		      			<textarea name="det_vistoria" style="height: 200px;" class="form-control"></textarea>
	      				<?php
	      			}
	      			?>
	      			<br>
				    <div class="row">
		      			<div class="col-sm-10"></div>
		      			<div class="col-sm-2">
							<a href="processo21.php?num_processo=<?=$num_processo; ?>" class="btn btn-danger">Voltar</a>	
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
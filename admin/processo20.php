<?php
require 'header.php';
$sql = new Processos();
//SEGURADOS
$getCidades = $sql->getCidades();
$num_processo = addslashes($_GET['num_processo']);
$p = $sql->getProcesso($num_processo);

$getApPv = $sql->getApPv($num_processo);

//REGISTRANDO
if (isset($_POST['apurados'])) {
	$apurados = addslashes($_POST['apurados']);
	$providencias = addslashes($_POST['providencias']);

	$sql->setApProv($num_processo, $apurados, $providencias);
	?>
	<script>
		window.location.href = "processo21.php?num_processo=<?=$num_processo; ?>";
	</script>
	<?php
}
//ATUALIZAR
if (isset($_POST['apuradosUP'])) {
	$apurados = addslashes($_POST['apuradosUP']);
	$providencias = addslashes($_POST['providenciasUP']);

	$sql->upApProv($num_processo, $apurados, $providencias);
	?>
	<script>
		window.location.href = "processo21.php?num_processo=<?=$num_processo; ?>";
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
	      	<h3>Dos Fatos Apurados e Providências</h3>
	      	<div class="well">
	      		<form method="POST">
	      			<?php
	      			if (!empty($getApPv)) {
	      				?>
	      				<label>Dos Fatos Apurados:</label>
		      			<textarea name="apuradosUP" style="height: 200px;" class="form-control"><?=$getApPv['apurados']; ?></textarea>
		      			<label>Das Providências:</label>
		      			<textarea name="providenciasUP" style="height: 200px;" class="form-control"><?=$getApPv['providencias']; ?></textarea>
	      				<?php
	      			} else {
	      				?>
	      				<label>Dos Fatos Apurados:</label>
		      			<textarea name="apurados" style="height: 200px;" class="form-control"></textarea>
		      			<label>Das Providências:</label>
		      			<textarea name="providencias" style="height: 200px;" class="form-control"></textarea>
	      				<?php
	      			}
	      			?>
	      			<br>
				    <div class="row">
		      			<div class="col-sm-10"></div>
		      			<div class="col-sm-2">
							<a href="processo19.php?num_processo=<?=$num_processo; ?>" class="btn btn-danger">Voltar</a>	
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
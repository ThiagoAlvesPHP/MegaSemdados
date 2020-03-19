<?php
require 'header.php';
$sql = new Processos();
//SEGURADOS
$getCidades = $sql->getCidades();
$num_processo = addslashes($_GET['num_processo']);
$p = $sql->getProcesso($num_processo);

$getRegPolicial = $sql->getRegPolicial($num_processo);

if (isset($_POST['midia'])) {
	$midia = addslashes($_POST['midia']);
	$sql->upMidia($num_processo, $midia);
		?>
	<script>
		window.location.href = "processo11.php?num_processo=<?=$num_processo; ?>";
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
	      	<h3>Dados de Repercussão na Mídia</h3>
	      	<div class="well">
	      		<form method="POST">
	      			<div class="row">
		      			<div class="col-sm-1">
		      				<input type="checkbox" id="active1" name="">
		      				<label>Sim?</label>
		      			</div>
		      			<div class="col-sm-11">
							<label>Detalhes:</label>
		      				<textarea readonly="" name="midia" style="height: 200px;" class="form-control res1"><?=$getRegPolicial['midia']; ?></textarea>
		      			</div>
		      		</div>
		      		<br>
				    <div class="row">
			      			<div class="col-sm-10"></div>
			      			<div class="col-sm-2">
								<a href="processo09.php?num_processo=<?=$num_processo; ?>" class="btn btn-danger">Voltar</a>	
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
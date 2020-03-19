<?php
require 'header.php';
$sql = new Processos();
//SEGURADOS
$getTransportadora = $sql->getTransportadora();
$num_processo = addslashes($_GET['num_processo']);
$p = $sql->getProcesso($num_processo);

//REGISTRANDO SEGURADO
if (!empty($_POST['id_transportadora'])) {
	$id_transportadora = addslashes($_POST['id_transportadora']);

	$sql->setProcesso03($num_processo, $id_transportadora);
	?>
	<script>
		window.location.href = "processo04.php?num_processo=<?=$num_processo; ?>";
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
	      	<h3>Dados do Transportador</h3>
	      	<div class="well">
	      		<form method="POST">
	      			<div class="row">
	      				<div class="col-sm-6">
	      					<label><span style="color: red;">*</span> Segurado:</label>
				      		<select name="id_transportadora" multiple class="form-control trasp">
				      			<?php
				      			if (!empty($p['id_transportadora'])) {
				      				foreach ($getTransportadora as $value) {
				      					if ($p['id_transportadora'] == $value['id']) {
				      						echo '<option selected value="'.$value['id'].'">'.$value['razao_social'].'</option>';
				      					} else {
				      						echo '<option value="'.$value['id'].'">'.$value['razao_social'].'</option>';
				      					}
					      			}
				      			} else {
				      				foreach ($getTransportadora as $value) {
					      				echo '<option value="'.$value['id'].'">'.$value['razao_social'].'</option>';
					      			}
				      			}
				      			?>
						    </select>
	      				</div>
	      				<div class="col-sm-6">
	      					<label><span style="color: red;">*</span> CNPJ:</label>
	      					<?php
	      					if (!empty($p['id_transportadora'])) {
			      				foreach ($getTransportadora as $value) {
			      					if ($p['id_transportadora'] == $value['id']) {
			      						echo '<input id="cnpjT" readonly="" class="form-control" value="'.$value['cnpj'].'">';
			      					}
				      			}
			      			} else {
			      				echo '<input class="form-control" id="cnpjT" readonly="">';
			      			}
	      					?>
				    		
	      				</div>
	      			</div>
		      		<br>
				    
				    <br>
				    <div class="row">
			      			<div class="col-sm-10"></div>
			      			<div class="col-sm-2">
								<a href="processo02.php?num_processo=<?=$num_processo; ?>" class="btn btn-danger">Voltar</a>	
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
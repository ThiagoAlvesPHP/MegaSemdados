<?php
require 'header.php';
$sql = new Processos();
//SEGURADOS
$getCorretora = $sql->getCorretora();
$num_processo = addslashes($_GET['num_processo']);
$p = $sql->getProcesso($num_processo);

//REGISTRANDO SEGURADO
if (!empty($_POST['id_corretora'])) {
	$id_corretora = addslashes($_POST['id_corretora']);

	$sql->setProcesso04($num_processo, $id_corretora);
	?>
	<script>
		window.location.href = "processo05.php?num_processo=<?=$num_processo; ?>";
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
	      	<h3>Dados do Corretor</h3>
	      	<div class="well">
	      		<form method="POST">
	      			<div class="row">
	      				<div class="col-sm-6">
	      					<label><span style="color: red;">*</span> Segurado:</label>
				      		<select name="id_corretora" multiple class="form-control corretora">
				      			<?php
				      			if (!empty($p['id_corretora'])) {
				      				foreach ($getCorretora as $value) {
				      					if ($p['id_corretora'] == $value['id']) {
				      						echo '<option selected value="'.$value['id'].'">'.$value['razao_social'].'</option>';
				      					} else {
				      						echo '<option value="'.$value['id'].'">'.$value['razao_social'].'</option>';
				      					}
					      			}
				      			} else {
				      				foreach ($getCorretora as $value) {
					      				echo '<option value="'.$value['id'].'">'.$value['razao_social'].'</option>';
					      			}
				      			}
				      			
				      			?>
						    </select>
	      				</div>
	      				<div class="col-sm-6">
	      					<label><span style="color: red;">*</span> CNPJ:</label>
	      					<?php
	      					if (!empty($p['id_corretora'])) {
			      				foreach ($getCorretora as $value) {
			      					if ($p['id_corretora'] == $value['id']) {
			      						echo '<input id="cnpjC" readonly="" class="form-control" value="'.$value['cnpj'].'">';
			      					}
				      			}
			      			} else {
			      				echo '<input class="form-control" id="cnpjC" readonly="">';
			      			}
	      					?>
	      				</div>
	      			</div>
		      		<br>
				    
				    <br>
				    <div class="row">
			      			<div class="col-sm-10"></div>
			      			<div class="col-sm-2">
								<a href="processo03.php?num_processo=<?=$num_processo; ?>" class="btn btn-danger">Voltar</a>	
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
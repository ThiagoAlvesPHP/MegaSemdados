<?php
require 'header.php';
$sql = new Processos();
//SEGURADOS
$getSegurados = $sql->getSegurados();
$getApolicesProc = $sql->getApolicesProc();
$num_processo = addslashes($_GET['num_processo']);
$p = $sql->getProcesso($num_processo);

//REGISTRANDO SEGURADO
if (!empty($_POST['num_apolice'])) {
	$id_segurado = addslashes($_POST['id_empresa']);
	$id_apolice = addslashes($_POST['num_apolice']);

	$sql->setProcesso02($num_processo, $id_segurado, $id_apolice);
	?>
	<script>
		window.location.href = "processo03.php?num_processo=<?=$num_processo; ?>";
	</script>
	<?php
}
?>
<input hidden="" value="<?=$p['id_ramo']; ?>" id="id_ramo">
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
		      	<h3>Dados do Segurado</h3>
		      	<div class="well">
		      		<form method="POST">
		      			<div class="row">
		      				<div class="col-sm-6">
		      					<label><span style="color: red;">*</span> Segurado:</label>
					      		<select name="id_empresa" multiple class="form-control seg">
					      			<?php
					      			if (!empty($p['id_segurado'])) {
					      				foreach ($getSegurados as $value) {
					      					if ($p['id_segurado'] == $value['id']) {
					      						echo '<option selected value="'.$value['id'].'">'.$value['razao_social'].'</option>';
					      					} else {
					      						echo '<option value="'.$value['id'].'">'.$value['razao_social'].'</option>';
					      					}
						      			}
					      			} else {
					      				foreach ($getSegurados as $value) {
						      				echo '<option value="'.$value['id'].'">'.$value['razao_social'].'</option>';
						      			}
					      			}
					      			
					      			?>
							    </select>
		      				</div>
		      				<div class="col-sm-6">
		      					<label><span style="color: red;">*</span> CNPJ:</label>
		      					<?php
		      					if (!empty($p['id_segurado'])) {
		      						foreach ($getSegurados as $value) {
					      				if ($p['id_segurado'] == $value['id']) {
					      					echo '<input class="form-control" id="cnpj" readonly="" value="'.$value['cnpj'].'">';
					      				}
					      			}
		      						
		      					} else {
		      						echo '<input class="form-control" id="cnpj" readonly="" value="">';
		      					}
		      					?>
					    		
					    		<div id="num_apolice">
					    			<label><span style="color: red;">*</span> Apólice Numero:</label>
					    			<select name="num_apolice" class="form-control">
					    			<?php
			      					if (!empty($p['id_apolice'])) {
			      						foreach ($getApolicesProc as $value) {
						      				if ($p['id_apolice'] == $value['id']) {
						      					echo '<option name="num_apolice" class="form-control" id="cnpj" value="'.$value['id'].'">'.$value['num_apolice'].'</option>';
						      				}
						      			}
			      					} else {
			      						echo '<option class="form-control" id="cnpj" readonly="" value=""></option>';
			      					}
			      					?>
					    			</select>
					    		</div>
		      				</div>
		      			</div>
			      		<br>
					    
					    <br>
					    <div class="row">
				      			<div class="col-sm-10"></div>
				      			<div class="col-sm-2">
									<a href="processo.php?num_processo=<?=$num_processo; ?>" class="btn btn-danger">Voltar</a>	
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
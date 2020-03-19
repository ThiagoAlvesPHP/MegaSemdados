<?php
require 'header.php';
$sql = new Processos();
//SEGURADOS
$getCidades = $sql->getCidades();
$num_processo = addslashes($_GET['num_processo']);
$p = $sql->getProcesso($num_processo);

//REGISTRANDO SEGURADO
if (!empty($_POST['cidade1']) && !empty($_POST['cidade2'])) {	
	$cidade1 = addslashes($_POST['cidade1']);
	$cidade2 = addslashes($_POST['cidade2']);

	$sql->setProcesso05($num_processo, $cidade1, $cidade2);
	?>
	<script>
		window.location.href = "processo06.php?num_processo=<?=$num_processo; ?>";
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
	      	<h3>Dados do Percurso do Transporte</h3>
	      	<div class="well">
	      		<form method="POST">
	      			<div class="row">
	      				<div class="col-sm-6">
	      					<label><span style="color: red;">*</span> UF/Município de Origem:</label>
	      					<input type="text" name="city1" id="city1" class="form-control" placeholder="Digite o nome da cidade">
	      					<br>
				      		<select name="cidade1" multiple class="form-control" id="cidades1">
				      			<?php
				      			if (!empty($p['cidade1'])) {
				      				$d  = $sql->getCidadeID($p['cidade1']);

				      				echo '<option selected value="'.$d['id'].'">'.utf8_encode($d['nome']).' - '.$d['uf'].' - '.$d['sigla'].'</option>';
				      			} else {
				      				foreach ($getCidades as $value) {
					      				echo '<option value="'.$value['id'].'">'.utf8_encode($value['nome']).' - '.$value['uf'].' - '.$value['sigla'].'</option>';
					      			}
				      			}
				      			?>
						    </select>
	      				</div>
	      				<div class="col-sm-6">
	      					<label><span style="color: red;">*</span> UF/Município de Destino:</label>
	      					<input type="text" name="city2" id="city2" class="form-control" placeholder="Digite o nome da cidade">
	      					<br>
				      		<select name="cidade2" multiple class="form-control" id="cidades2">
				      			<?php
				      			if (!empty($p['cidade2'])) {
				      				$d  = $sql->getCidadeID($p['cidade2']);
				      				
				      				echo '<option selected value="'.$d['id'].'">'.utf8_encode($d['nome']).' - '.$d['uf'].' - '.$d['sigla'].'</option>';
				      			} else {
				      				foreach ($getCidades as $value) {
					      				echo '<option value="'.$value['id'].'">'.utf8_encode($value['nome']).' - '.$value['uf'].' - '.$value['sigla'].'</option>';
					      			}
				      			}
				      			?>
						    </select>
	      				</div>
	      			</div>
		      		<br>
				    
				    <br>
				    <div class="row">
			      			<div class="col-sm-10"></div>
			      			<div class="col-sm-2">
								<a href="processo04.php?num_processo=<?=$num_processo; ?>" class="btn btn-danger">Voltar</a>	
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
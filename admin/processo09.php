<?php
require 'header.php';
$sql = new Processos();
//SEGURADOS
$getCidades = $sql->getCidades();
$num_processo = addslashes($_GET['num_processo']);
$p = $sql->getProcesso($num_processo);

$getRegPolicial = $sql->getRegPolicial($num_processo);
$post = filter_input_array(INPUT_POST, FILTER_DEFAULT);
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
	      	<h3>Dados do Registro Policial</h3>
	      	<div class="well">
	      		<?php
	      		//ATUALIZANDO DADOS
	      		if (!empty($getRegPolicial)) {
	      			if (isset($_POST['orgao_acidente'])) {
	      				$post['num_processo'] = $num_processo;
	      				$sql->upRegPolicial($post);
	      				?>
						<script>
							window.location.href = "processo10.php?num_processo=<?=$num_processo; ?>";
						</script>
						<?php
	      			}
	      			?>
	      		<form method="POST">
	      			<input type="checkbox" id="active1" name="">
	      			<label>Boletim de Ocorrência do Acidente</label>
	      			<div class="row">
		      			<div class="col-sm-6">
		      				<label>Órgão:</label>
		      				<input type="text" value="<?=$getRegPolicial['orgao_acidente'] ?>" name="orgao_acidente" class="form-control res1" readonly="">
		      			</div>
		      			<div class="col-sm-6">
							<label>Número:</label>
		      				<input type="text" value="<?=$getRegPolicial['num_acidente'] ?>" name="num_acidente" class="form-control res1" readonly="">
		      			</div>
		      		</div>
		      		<br>
		      		<input type="checkbox" id="active2" name="">
		      		<label>Boletim de Ocorrência de Saque</label>
	      			<div class="row">
		      			<div class="col-sm-6">
		      				<label>Órgão:</label>
		      				<input type="text" value="<?=$getRegPolicial['orgao_saque'] ?>" name="orgao_saque" class="form-control res2" readonly="">
		      			</div>
		      			<div class="col-sm-6">
							<label>Número:</label>
		      				<input type="text" value="<?=$getRegPolicial['num_saque'] ?>" name="num_saque" class="form-control res2" readonly="">
		      			</div>
		      		</div>
		      		<br>
		      		<?php
		      		if ($getRegPolicial['inquerito'] == 1) {
		      			echo '<input checked type="checkbox" value="1" name="inquerito">';
		      		} else {
		      			echo '<input type="checkbox" value="1" name="inquerito">';
		      		}
		      		?>
		      		<label>Aberto Inquérito</label>
		      		<?php
		      		if ($getRegPolicial['investigacao'] == 1) {
		      			echo '<input checked type="checkbox" value="1" name="investigacao">';
		      		} else {
		      			echo '<input type="checkbox" value="1" name="investigacao">';
		      		}
		      		?>
		      		<label>Investigação em Andamento</label>
		      		<br>
				    <div class="row">
		      			<div class="col-sm-10"></div>
		      			<div class="col-sm-2">
							<a href="processo08.php?num_processo=<?=$num_processo; ?>" class="btn btn-danger">Voltar</a>	
							<button class="btn btn-primary">Proximo</button>	
		      			</div>
		      		</div>
		      	</form>
	      			<?php
	      		} else {
	      			if (isset($post['orgao_acidente'])) {
	      				$post['num_processo'] = $num_processo;
	      				$sql->setRegPolicial($post);
	      				?>
						<script>
							window.location.href = "processo10.php?num_processo=<?=$num_processo; ?>";
						</script>
						<?php
	      			}
	      			?>
	      		<form method="POST">
	      			<input type="checkbox" id="active1" name="">
	      			<label>Boletim de Ocorrência do Acidente</label>
	      			<div class="row">
		      			<div class="col-sm-6">
		      				<label>Órgão:</label>
		      				<input type="text" name="orgao_acidente" class="form-control res1" readonly="">
		      			</div>
		      			<div class="col-sm-6">
							<label>Número:</label>
		      				<input type="text" name="num_acidente" class="form-control res1" readonly="">
		      			</div>
		      		</div>
		      		<br>
		      		<input type="checkbox" id="active2" name="">
		      		<label>Boletim de Ocorrência de Saque</label>
	      			<div class="row">
		      			<div class="col-sm-6">
		      				<label>Órgão:</label>
		      				<input type="text" name="orgao_saque" class="form-control res2" readonly="">
		      			</div>
		      			<div class="col-sm-6">
							<label>Número:</label>
		      				<input type="text" name="num_saque" class="form-control res2" readonly="">
		      			</div>
		      		</div>
		      		<br>
		      		<input type="checkbox" name="inquerito" value="1">
		      		<label>Aberto Inquérito</label>
		      		<input type="checkbox" name="investigacao" value="1">
		      		<label>Investigação em Andamento</label>
		      		<br>
				    <div class="row">
		      			<div class="col-sm-10"></div>
		      			<div class="col-sm-2">
							<a href="processo08.php?num_processo=<?=$num_processo; ?>" class="btn btn-danger">Voltar</a>	
							<button class="btn btn-primary">Proximo</button>	
		      			</div>
		      		</div>
		      	</form>
	      			<?php
	      		}
	      		?>
	      		
	      	</div>
	      </div>
	    </div>
	</div>
	<div class="col-sm-1"></div>
</div>

<?php
require 'footer.php';
?>
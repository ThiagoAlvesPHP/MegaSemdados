<?php
require 'header.php';

if (isset($_GET['num_processo']) && !empty($_GET['num_processo'])) {
	$sql = new Processos();
	$num_processo = addslashes($_GET['num_processo']);

	$p = $sql->getProcesso($num_processo);
	$nav_ramo = $sql->nav_ramo();
	$nav_moeda = $sql->nav_moeda();

	if(empty($p)){
		echo '<script>alert("Nenhum Processo encontrado com esse número '.$num_processo.'");</script>';
		echo '<script>window.location.href="index.php";</script>';
	}

	//CAPTURANDO INFORMAÇÕES DO POST
	if (isset($_POST['num_sinistro'])) {

		if (empty($_POST['num_sinistro'])) {
			$_POST['num_sinistro'] = '0001';
		} else {
			$num_sinistro = addslashes($_POST['num_sinistro']);
		}
		//DADOS DO FORMULARIO ANTERIOR
		$id_ramo = addslashes($_POST['id_ramo']);
		$moeda = addslashes($_POST['moeda']);
		$valor_mercadoria = addslashes(str_replace(",", ".", $_POST['valor_mercadoria']));
		$comunicante = addslashes($_POST['comunicante']);
		//REORGANIZANDO A DATA E HORA
		$dt = addslashes($_POST['dt_hs_comunicado']);
		$explode = explode('/', $dt);
		$explode2 = explode(' ', $explode[2]);
		$dt_hs_comunicado = $explode2[0].'-'.$explode[1].'-'.$explode[0].' '.$explode2[1];
		
		$sql->setProcesso01($num_processo, $num_sinistro, $id_ramo, $moeda, $valor_mercadoria, $comunicante, $dt_hs_comunicado);
		?>
		<script>
			window.location.href = "processo02.php?num_processo=<?=$num_processo; ?>";
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
		      	<h3>Dados Iniciais Processo</h3>
		      	<div class="well">
		      		<form method="POST">
			      		<div class="row">
			      			<div class="col-sm-6">
			      				<label>Seguradora:</label>
			      				<input readonly="" value="<?=utf8_decode($p['razao_social']); ?>" class="form-control">
			      			</div>
			      			<div class="col-sm-3">
			      				<label>CNPJ:</label>
			      				<input readonly="" value="<?=$p['cnpj']; ?>" class="form-control">
			      			</div>
			      			<div class="col-sm-3">
			      				<label>Número Sinistro CIA:</label>
			      				<input type="text" name="num_sinistro" class="form-control" value="<?=$p['num_sinistro']; ?>">
			      			</div>
			      		</div><br>
			      		<div class="row">
			      			<div class="col-sm-6">
			      				<label>Ramo de Seguro:</label>
			      				<select class="form-control" name="id_ramo">
			      					<?php
			      					if (!empty($p['id_ramo'])) {
			      						foreach ($nav_ramo as $ramo) {
			      							if ($p['id_ramo'] == $ramo['id']) {
			      								echo '<option selected value="'.$ramo['id'].'">'.$ramo['ramo'].'</option>';
			      							} else {
			      								echo '<option value="'.$ramo['id'].'">'.$ramo['ramo'].'</option>';
			      							}
			      						}
			      					} else {
			      						foreach ($nav_ramo as $ramo) {
				      						echo '<option value="'.$ramo['id'].'">'.$ramo['ramo'].'</option>';
				      					}
			      					}
			      					?>
			      				</select>
			      			</div>
			      			<div class="col-sm-3">
			      				<label>Moeda:</label>
			      				<select class="form-control" name="moeda">
			      					<?php
			      					if (!empty($p['moeda'])) {
			      						foreach ($nav_moeda as $moeda) {
			      							if ($p['moeda'] == $moeda['id']) {
			      								echo '<option selected value="'.$moeda['id'].'">'.$moeda['nome'].'</option>';
			      							}
			      							echo '<option value="'.$moeda['id'].'">'.$moeda['nome'].'</option>';
			      						}
			      					} else {
			      						foreach ($nav_moeda as $moeda) {
				      						if ($moeda['moeda'] == 'BRL') {
				      							echo '<option selected value="'.$moeda['id'].'">'.utf8_encode($moeda['nome']).'</option>';
				      						} else {
				      							echo '<option value="'.$moeda['id'].'">'.utf8_encode($moeda['nome']).'</option>';
				      						}
				      					}
			      					}
			      					?>
			      				</select>
			      			</div>
			      			<div class="col-sm-3">
			      				<label>Valor da Mercadoria:</label>
			      				<input type="text" name="valor_mercadoria" class="form-control money" value="<?php if(!empty($p['valor_mercadoria'])){ echo number_format($p['valor_mercadoria'], 2, '.',''); } else {
			      					
			      				} ?>">
			      			</div>
			      		</div><br>
			      		<div class="row">
			      			<div class="col-sm-6">
			      				<label>Comunicante:</label>
			      				<input type="text" name="comunicante" class="form-control" value="<?=$p['comunicante']; ?>">
			      			</div>
			      			<div class="col-sm-6">
			      				<label>Data e Hora do Comunicado:</label>
			      				<input type="text" id="dt_hs_comunicado" name="dt_hs_comunicado" class="form-control" value="<?=date('d/m/Y H:i:s', strtotime($p['dt_hs_comunicado'])); ?>">
			      			</div>
			      		</div>
			      		
			      		<hr>
			      		<div class="row">
			      			<div class="col-sm-10"></div>
			      			<div class="col-sm-2">
								<a class="btn btn-default">Voltar</a>	
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
	}
?>

<?php
require 'footer.php';
?>
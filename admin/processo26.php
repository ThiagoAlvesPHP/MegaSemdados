<?php
require 'header.php';
$sql = new Processos();

$num_processo = addslashes($_GET['num_processo']);
$p = $sql->getProcesso($num_processo);

$getNavPassagemMot = $sql->getNavPassagemMot();
$getDiagrama = $sql->getDiagrama();
$getStatusConh = $sql->getStatusConhecimento();
$getTacografo = $sql->getStatusTacografo();

$getCausasSinistros = $sql->getCausasSinistros($num_processo);
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
	      	<h3>Consequências e Causas do Sinistro</h3>
	      	<div class="well">
	      		<form method="POST">
	      			<button type="button" class="btn btn-info" data-toggle="collapse" data-target="#demo">Aplicável?</button>
							<?php
							if (!empty($getCausasSinistros)) {
							//UPDATE
							if (isset($_POST['vel_permitida'])) {
								$vel_permitida = addslashes($_POST['vel_permitida']);
								$qt_km = addslashes($_POST['qt_km']);
								$id_nav_passagem_mot = addslashes($_POST['id_nav_passagem_mot']);
								
								$id_nav_diagrama = addslashes($_POST['id_nav_diagrama']);
								$vel_apurada = addslashes($_POST['vel_apurada']);
								$id_status_conhecimento = addslashes($_POST['id_status_conhecimento']);
								$id_status_torografia = addslashes($_POST['id_status_torografia']);
								$obs = addslashes($_POST['obs']);
								$sql->upCausaSinistro($num_processo, $vel_permitida, $qt_km, $id_nav_passagem_mot, $id_nav_diagrama, $vel_apurada, $id_status_conhecimento, $id_status_torografia, $obs);
								?>
								<script>
									window.location.href = "processo27.php?num_processo=<?=$num_processo; ?>";
								</script>
								<?php
							}
								?>
						<div id="demo" class="collapse show"><br>
						<div class="row">
							<div class="col-sm-6">
								<label>Velocidade Permitida no Local:</label>
								<input type="text" value="<?=$getCausasSinistros['vel_permitida']; ?>" name="vel_permitida" class="form-control">
								<label>Quantidade de Kms desde última parada:</label>
								<input type="text" value="<?=$getCausasSinistros['qt_km']; ?>" name="qt_km" class="form-control">
								<label>Frequência de passagem do motorista pelo local:</label>
								<select class="form-control" name="id_nav_passagem_mot">
									<?php
									foreach ($getNavPassagemMot as $m) {
										if ($getCausasSinistros['id_nav_passagem_mot'] == $m['id']) {
											echo '<option selected value="'.$m['id'].'">'.$m['nome'].'</option>';
										} else {
											echo '<option value="'.$m['id'].'">'.$m['nome'].'</option>';
										}
									}
									?>
								</select>
								<label>Registro Diagrama Disponível no atendimento:</label>
								<select class="form-control" name="id_nav_diagrama">
									<?php
									foreach ($getDiagrama as $m) {
										if ($getCausasSinistros['id_nav_diagrama'] == $m['id']) {
											echo '<option selected value="'.$m['id'].'">'.$m['nome'].'</option>';
										} else {
											echo '<option value="'.$m['id'].'">'.$m['nome'].'</option>';
										}
									}
									?>
								</select>
							</div>
							<div class="col-sm-6">
								<label>Velocidade apurada no Evento:</label>
								<input type="text" value="<?=$getCausasSinistros['vel_apurada']; ?>" name="vel_apurada" class="form-control">
								<label>Condutor conhece a rodovia e trecho no Local:</label>
								<select class="form-control" name="id_status_conhecimento">
									<?php
									foreach ($getStatusConh as $m) {
										if ($getCausasSinistros['id_status_conhecimento'] == $m['id']) {
											echo '<option selected value="'.$m['id'].'">'.$m['nome'].'</option>';
										} else {
											echo '<option value="'.$m['id'].'">'.$m['nome'].'</option>';
										}
									}
									?>
								</select>
								<label>Aparelho de Tacógrafo disponível no veículo:</label>
								<select class="form-control" name="id_status_torografia">
									<?php
									foreach ($getTacografo as $m) {
										if ($getCausasSinistros['id_status_torografia'] == $m['id']) {
											echo '<option selected value="'.$m['id'].'">'.$m['nome'].'</option>';
										} else {
											echo '<option value="'.$m['id'].'">'.$m['nome'].'</option>';
										}
									}
									?>
								</select>
								<label> Observações:</label>
								<input type="text" name="obs" value="<?=$getCausasSinistros['obs']; ?>" class="form-control">
							</div>
							</div>
						<br>
					</div>
								<?php
							} else {
							//REGISTRAR
							if (isset($_POST['vel_permitida'])) {
								$vel_permitida = addslashes($_POST['vel_permitida']);
								$qt_km = addslashes($_POST['qt_km']);
								$id_nav_passagem_mot = addslashes($_POST['id_nav_passagem_mot']);
								
								$id_nav_diagrama = addslashes($_POST['id_nav_diagrama']);
								$vel_apurada = addslashes($_POST['vel_apurada']);
								$id_status_conhecimento = addslashes($_POST['id_status_conhecimento']);
								$id_status_torografia = addslashes($_POST['id_status_torografia']);
								$obs = addslashes($_POST['obs']);
								$sql->setCausaSinistro($num_processo, $vel_permitida, $qt_km, $id_nav_passagem_mot, $id_nav_diagrama, $vel_apurada, $id_status_conhecimento, $id_status_torografia, $obs);
								?>
								<script>
									window.location.href = "processo27.php?num_processo=<?=$num_processo; ?>";
								</script>
								<?php
							}
								?>
							<div id="demo" class="collapse"><br>
							<div class="row">
							<div class="col-sm-6">
								<label>Velocidade Permitida no Local:</label>
								<input type="text" name="vel_permitida" class="form-control">
								<label>Quantidade de Kms desde última parada:</label>
								<input type="text" name="qt_km" class="form-control">
								<label>Frequência de passagem do motorista pelo local:</label>
								<select class="form-control" name="id_nav_passagem_mot">
									<?php
									foreach ($getNavPassagemMot as $m) {
										echo '<option value="'.$m['id'].'">'.$m['nome'].'</option>';
									}
									?>
								</select>
								<label>Registro Diagrama Disponível no atendimento:</label>
								<select class="form-control" name="id_nav_diagrama">
									<?php
									foreach ($getDiagrama as $m) {
										echo '<option value="'.$m['id'].'">'.$m['nome'].'</option>';
									}
									?>
								</select>
							</div>
							<div class="col-sm-6">
								<label>Velocidade apurada no Evento:</label>
								<input type="text" name="vel_apurada" class="form-control">
								<label>Condutor conhece a rodovia e trecho no Local:</label>
								<select class="form-control" name="id_status_conhecimento">
									<?php
									foreach ($getStatusConh as $m) {
										echo '<option value="'.$m['id'].'">'.$m['nome'].'</option>';
									}
									?>
								</select>
								<label>Aparelho de Tacógrafo disponível no veículo:</label>
								<select class="form-control" name="id_status_torografia">
									<?php
									foreach ($getTacografo as $m) {
										echo '<option value="'.$m['id'].'">'.$m['nome'].'</option>';
									}
									?>
								</select>
								<label> Observações:</label>
								<input type="text" name="obs" class="form-control">
							</div>
							</div>
						<br>
					</div>
								<?php
							}
							?>
				    <div class="row">
		      			<div class="col-sm-10"></div>
		      			<div class="col-sm-2">
							<a href="processo25.php?num_processo=<?=$num_processo; ?>" class="btn btn-danger">Voltar</a>	
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
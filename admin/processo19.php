<?php
require 'header.php';
$sql = new Processos();
//SEGURADOS
$getCidades = $sql->getCidades();
$num_processo = addslashes($_GET['num_processo']);
$p = $sql->getProcesso($num_processo);
$getStatus = $sql->getStatus();
$getTercForm = $sql->getTercForm($num_processo);

//REGISTRANDO
if (!empty($_POST['terc_env'])) {
	$terc_env = addslashes($_POST['terc_env']);
	$dec_terc = addslashes($_POST['dec_terc']);
	$terc_culp = addslashes($_POST['terc_culp']);
	$dados_terc = addslashes($_POST['dados_terc']);
	$ressarc = addslashes($_POST['ressarc']);
	$rel_compl = addslashes($_POST['rel_compl']);

	$sql->setTercEnvolvido($num_processo, $terc_env, $dec_terc, $terc_culp, $dados_terc, $ressarc, $rel_compl);
	?>
	<script>
		window.location.href = "processo20.php?num_processo=<?=$num_processo; ?>";
	</script>
	<?php
}
//ATUALIZANDO
if (!empty($_POST['terc_envUP'])) {
	$terc_env = addslashes($_POST['terc_envUP']);
	$dec_terc = addslashes($_POST['dec_tercUP']);
	$terc_culp = addslashes($_POST['terc_culpUP']);
	$dados_terc = addslashes($_POST['dados_tercUP']);
	$ressarc = addslashes($_POST['ressarcUP']);
	$rel_compl = addslashes($_POST['rel_complUP']);

	$sql->upTercEnvolvido($num_processo, $terc_env, $dec_terc, $terc_culp, $dados_terc, $ressarc, $rel_compl);
	?>
	<script>
		window.location.href = "processo20.php?num_processo=<?=$num_processo; ?>";
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
	      	<h3>Terceiro Envolvido</h3>
	      	<div class="well">
	      		<form method="POST">
	      			<?php 
		      			if (!empty($getTercForm)) {
		      				?>
								<br>
								<div class="row">
									<div class="col-sm-4">
										<label>Envolvimento de Terceiro:</label>
										<select name="terc_envUP" class="form-control">
											<?php
											foreach ($getStatus as $s) {
												if ($s['id'] == $getTercForm['terc_env']) {
													echo '<option selected value="'.$s['id'].'">'.$s['status'].'</option>';
												} else {
													echo '<option value="'.$s['id'].'">'.$s['status'].'</option>';
												}
											}
											?>
										</select>
										<label>Declaração do Terceiro:</label>
										<select name="dec_tercUP" class="form-control">
											<?php
											foreach ($getStatus as $s) {
												if ($s['id'] == $getTercForm['dec_terc']) {
													echo '<option selected value="'.$s['id'].'">'.$s['status'].'</option>';
												} else {
													echo '<option value="'.$s['id'].'">'.$s['status'].'</option>';
												}
											}
											?>
										</select>
									</div>
									<div class="col-sm-4">
										<label>Terceiro Culpado:</label>
										<select name="terc_culpUP" class="form-control">
											<?php
											foreach ($getStatus as $s) {
												if ($s['id'] == $getTercForm['terc_culp']) {
													echo '<option selected value="'.$s['id'].'">'.$s['status'].'</option>';
												} else {
													echo '<option value="'.$s['id'].'">'.$s['status'].'</option>';
												}
											}
											?>
										</select>
										<label>Dados do Terceiro:</label>
										<select name="dados_tercUP" class="form-control">
											<?php
											foreach ($getStatus as $s) {
												if ($s['id'] == $getTercForm['dados_terc']) {
													echo '<option selected value="'.$s['id'].'">'.$s['status'].'</option>';
												} else {
													echo '<option value="'.$s['id'].'">'.$s['status'].'</option>';
												}
											}
											?>
										</select>
									</div>
									<div class="col-sm-4">
										<label>Passível de Ressarcimento:</label>
										<select name="ressarcUP" class="form-control">
											<?php
											foreach ($getStatus as $s) {
												if ($s['id'] == $getTercForm['ressarc']) {
													echo '<option selected value="'.$s['id'].'">'.$s['status'].'</option>';
												} else {
													echo '<option value="'.$s['id'].'">'.$s['status'].'</option>';
												}
											}
											?>
										</select>
										<label>Relatório Complementar anexo:</label>
										<select name="rel_complUP" class="form-control">
											<?php
											foreach ($getStatus as $s) {
												if ($s['id'] == $getTercForm['rel_compl']) {
													echo '<option selected value="'.$s['id'].'">'.$s['status'].'</option>';
												} else {
													echo '<option value="'.$s['id'].'">'.$s['status'].'</option>';
												}
											}
											?>
										</select>
									</div>
								</div>
		      				<?php
		      			} else {
		      				?>
		      				<button type="button" class="btn btn-info" data-toggle="collapse" data-target="#demo">Aplicável ?</button>
		      				<div id="demo" class="collapse">
								<br>
								<div class="row">
									<div class="col-sm-4">
										<label>Envolvimento de Terceiro:</label>
										<select name="terc_env" class="form-control">
											<?php
											foreach ($getStatus as $s) {
												echo '<option value="'.$s['id'].'">'.$s['status'].'</option>';
											}
											?>
										</select>
										<label>Declaração do Terceiro:</label>
										<select name="dec_terc" class="form-control">
											<?php
											foreach ($getStatus as $s) {
												echo '<option value="'.$s['id'].'">'.$s['status'].'</option>';
											}
											?>
										</select>
									</div>
									<div class="col-sm-4">
										<label>Terceiro Culpado:</label>
										<select name="terc_culp" class="form-control">
											<?php
											foreach ($getStatus as $s) {
												echo '<option value="'.$s['id'].'">'.$s['status'].'</option>';
											}
											?>
										</select>
										<label>Dados do Terceiro:</label>
										<select name="dados_terc" class="form-control">
											<?php
											foreach ($getStatus as $s) {
												echo '<option value="'.$s['id'].'">'.$s['status'].'</option>';
											}
											?>
										</select>
									</div>
									<div class="col-sm-4">
										<label>Passível de Ressarcimento:</label>
										<select name="ressarc" class="form-control">
											<?php
											foreach ($getStatus as $s) {
												echo '<option value="'.$s['id'].'">'.$s['status'].'</option>';
											}
											?>
										</select>
										<label>Relatório Complementar anexo:</label>
										<select name="rel_compl" class="form-control">
											<?php
											foreach ($getStatus as $s) {
												echo '<option value="'.$s['id'].'">'.$s['status'].'</option>';
											}
											?>
										</select>
									</div>
								</div>
							</div>
		      				<?php
		      			}
		      		?>
					<br>
				    <div class="row">
			      			<div class="col-sm-10"></div>
			      			<div class="col-sm-2">
								<a href="processo18.php?num_processo=<?=$num_processo; ?>" class="btn btn-danger">Voltar</a>	
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
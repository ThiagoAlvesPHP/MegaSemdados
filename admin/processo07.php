<?php
require 'header.php';
$sql = new Processos();
//SEGURADOS
$getCidades = $sql->getCidades();
$get_at = $sql->getAtividadesP();
$get_atua = $sql->getAtuacaoP();
$get_evento = $sql->getEventosP();


$num_processo = addslashes($_GET['num_processo']);
$p = $sql->getProcesso($num_processo);

$dbAc = $sql->getDadosAcontecimento($num_processo);

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
	      		<h3>Dados do Acontecimento</h3>
	      		<div class="well">
	      			<?php
	      			if (!empty($dbAc)) {

	      			//UPDATE DE DADOS DO PROCESSO
	      			if (isset($post['atividade'])) {
						$id_atividade = $post['atividade'];
						$id_atuacao = $post['atuacao'];
						$id_nat_evento = $post['nat_evento'];
						$id_cidade = $post['cidade'];
						$dt_hs = $post['dt_hs'];

						$explode = explode('/', $dt_hs);
						$explode2 = explode(' ', $explode[2]);
						$dt_hss = $explode2[0].'-'.$explode[1].'-'.$explode[0].' '.$explode2[1];
						$local_os = $post['local_os'];
						$pres_representante = $post['pres_representante'];
						$lc_preservado = $post['lc_preservado'];
						$risco_saque = $post['risco_saque'];
						$risco_ambiental = $post['risco_ambiental'];
						$descricao = $post['descricao'];

						$sql->upDadosAcontecimento($num_processo, $id_atividade, $id_atuacao, $id_nat_evento, $id_cidade, $dt_hss, $local_os, $pres_representante, $lc_preservado, $risco_saque, $risco_ambiental, $descricao);
						?>
						<script>
							window.location.href = "processo08.php?num_processo=<?=$num_processo; ?>";
						</script>
						<?php
					}
	      				?>
	      			<form method="POST">
	      				<div class="row">
	      					<div class="col-sm-4">
	      						<label>Atividade:</label>
	      						<select name="atividade" class="form-control">
	      							<?php
	      							foreach ($get_at as $a) {
	      								if ($dbAc['id_atividade'] == $a['id']) {
	      									echo '<option selected value="'.$a['id'].'">'.$a['atividade'].'</option>';
	      								}
	      								echo '<option value="'.$a['id'].'">'.$a['atividade'].'</option>';
	      							}
	      							?>
	      						</select>
	      					</div>
	      					<div class="col-sm-4">
	      						<label>Atuação:</label>
	      						<select name="atuacao" class="form-control">
	      							<?php
	      							foreach ($get_atua as $a) {
	      								if ($dbAc['id_atuacao'] == $a['id']) {
	      									echo '<option selected value="'.$a['id'].'">'.$a['atuacao'].'</option>';
	      								}
	      								echo '<option value="'.$a['id'].'">'.$a['atuacao'].'</option>';
	      							}
	      							?>
	      						</select>
	      					</div>
	      					<div class="col-sm-4">
	      						<label>Natureza do Evento:</label>
	      						<select name="nat_evento" class="form-control">
	      							<?php
	      							foreach ($get_evento as $a) {
	      								if ($dbAc['id_nat_evento'] == $a['id']) {
	      									echo '<option selected value="'.$a['id'].'">'.$a['nat_evento'].'</option>';
	      								}
	      								echo '<option value="'.$a['id'].'">'.$a['nat_evento'].'</option>';
	      							}
	      							?>
	      						</select>
	      					</div>
	      				</div>
	      				<br>
	      				<div class="row">
	      					<div class="col-sm-6">
	      						<label>Município do Evento:</label>
	      						<input type="text" name="city1" id="city1" class="form-control" placeholder="Digite o nome de uma cidade">
	      						<select multiple="" id="cidades1" name="cidade" class="form-control">
	      						<?php
      							if (!empty($dbAc['id_cidade'])) {
      								$d  = $sql->getCidadeID($dbAc['id_cidade']);
			      				
			      					echo '<option selected value="'.$d['id'].'">'.$d['nome'].' - '.$d['uf'].' - '.$d['sigla'].'</option>';
      							}
	      						?>
	      						</select>
	      					</div>
	      					<div class="col-sm-6">
	      						<label>Data e Hora:</label>
	      						<input type="text" id="dt_hs_comunicado" value="<?=date('d/m/Y H:i:s', strtotime($dbAc['dt_hs']));?>" name="dt_hs" class="form-control"><br>
	      						<label>Local da Ocorrência</label>
	      						<input type="text" value="<?=$dbAc['local_os']; ?>" name="local_os" class="form-control">
	      					</div>
	      				</div><br>
	      				<div class="row">
	      					<div class="col-sm-3">
	      						<label>Motorista/Representantes no Local:</label>
	      						<select name="pres_representante" class="form-control">
	      							<?php
	      							if ($dbAc['pres_representante'] == 1) {
	      								echo '<option value="1">Sim</option>';
	      								echo '<option value="0">Não</option>';
	      							} else {
	      								echo '<option value="0">Não</option>';
	      								echo '<option value="1">Sim</option>';
	      							}
	      							?>
	      						</select>
	      					</div>
	      					<div class="col-sm-3">
	      						<label>Local Preservado:</label>
	      						<select name="lc_preservado" class="form-control">
	      							<?php
	      							if ($dbAc['lc_preservado'] == 1) {
	      								echo '<option value="1">Sim</option>';
	      								echo '<option value="0">Não</option>';
	      							} else {
	      								echo '<option value="0">Não</option>';
	      								echo '<option value="1">Sim</option>';
	      							}
	      							?>
	      						</select>
	      					</div>
	      					<div class="col-sm-3">
	      						<label>Risco de Saque:</label>
	      						<select name="risco_saque" class="form-control">
	      							<?php
	      							if ($dbAc['risco_saque'] == 1) {
	      								echo '<option value="1">Sim</option>';
	      								echo '<option value="0">Não</option>';
	      							} else {
	      								echo '<option value="0">Não</option>';
	      								echo '<option value="1">Sim</option>';
	      							}
	      							?>
	      						</select>
	      					</div>
	      					<div class="col-sm-3">
	      						<label>Risco Ambiental:</label>
	      						<select name="risco_ambiental" class="form-control">
	      							<?php
	      							if ($dbAc['risco_ambiental'] == 1) {
	      								echo '<option value="1">Sim</option>';
	      								echo '<option value="0">Não</option>';
	      							} else {
	      								echo '<option value="0">Não</option>';
	      								echo '<option value="1">Sim</option>';
	      							}
	      							?>
	      						</select>
	      					</div>
	      				</div><br>
	      				<label>Descrição do Evento</label>
	      				<textarea class="form-control" name="descricao" style="height: 200px;"><?=$dbAc['descricao']; ?></textarea><br>
	      				<div class="row">
			      			<div class="col-sm-10"></div>
			      			<div class="col-sm-2">
								<a href="processo06.php?num_processo=<?=$num_processo; ?>" class="btn btn-danger">Voltar</a>	
								<button class="btn btn-primary">Proximo</button>	
			      			</div>
			      		</div>
	      			</form>	      				
	      				<?php
	      			} else {

	      			//CADASTRO DE DADOS DO ACONTECIMENTO
	      			if (isset($post['atividade'])) {
						$id_atividade = $post['atividade'];
						$id_atuacao = $post['atuacao'];
						$id_nat_evento = $post['nat_evento'];
						$id_cidade = $post['cidade'];
						$dt_hs = $post['dt_hs'];

						$explode = explode('/', $dt_hs);
						$explode2 = explode(' ', $explode[2]);
						$dt_hss = $explode2[0].'-'.$explode[1].'-'.$explode[0].' '.$explode2[1];
						$local_os = $post['local_os'];
						$pres_representante = $post['pres_representante'];
						$lc_preservado = $post['lc_preservado'];
						$risco_saque = $post['risco_saque'];
						$risco_ambiental = $post['risco_ambiental'];
						$descricao = $post['descricao'];

						$sql->setDadosAcontecimento($num_processo, $id_atividade, $id_atuacao, $id_nat_evento, $id_cidade, $dt_hss, $local_os, $pres_representante, $lc_preservado, $risco_saque, $risco_ambiental, $descricao);
						?>
						<script>
							window.location.href = "processo08.php?num_processo=<?=$num_processo; ?>";
						</script>
						<?php
					}

	      				?>
	      			<form method="POST">
	      				<div class="row">
	      					<div class="col-sm-4">
	      						<label>Atividade:</label>
	      						<select name="atividade" class="form-control">
	      							<?php
	      							foreach ($get_at as $a) {
	      								echo '<option value="'.$a['id'].'">'.$a['atividade'].'</option>';
	      							}
	      							?>
	      						</select>
	      					</div>
	      					<div class="col-sm-4">
	      						<label>Atuação:</label>
	      						<select name="atuacao" class="form-control">
	      							<?php
	      							foreach ($get_atua as $a) {
	      								echo '<option value="'.$a['id'].'">'.$a['atuacao'].'</option>';
	      							}
	      							?>
	      						</select>
	      					</div>
	      					<div class="col-sm-4">
	      						<label>Natureza do Evento:</label>
	      						<select name="nat_evento" class="form-control">
	      							<?php
	      							foreach ($get_evento as $a) {
	      								echo '<option value="'.$a['id'].'">'.$a['nat_evento'].'</option>';
	      							}
	      							?>
	      						</select>
	      					</div>
	      				</div>
	      				<br>
	      				<div class="row">
	      					<div class="col-sm-6">
	      						<label>Município do Evento:</label>
	      						<input type="text" name="city1" id="city1" class="form-control" placeholder="Digite o nome de uma cidade">
	      						<select multiple="" id="cidades1" name="cidade" class="form-control">
	      						<?php
	      						foreach ($getCidades as $c) {
	      							echo '<option value="'.$c['id'].'">'.$c['nome'].' - '.$c['uf'].' - '.$c['sigla'].'</option>';
	      						}
	      						?>
	      						</select>
	      					</div>
	      					<div class="col-sm-6">
	      						<label>Data e Hora:</label>
	      						<input type="text" id="dt_hs_comunicado" name="dt_hs" class="form-control"><br>
	      						<label>Local da Ocorrência</label>
	      						<input type="text" name="local_os" class="form-control">
	      					</div>
	      				</div><br>
	      				<div class="row">
	      					<div class="col-sm-3">
	      						<label>Motorista/Representantes no Local:</label>
	      						<select name="pres_representante" class="form-control">
	      							<option value="0">Não</option>
	      							<option value="1">Sim</option>
	      						</select>
	      					</div>
	      					<div class="col-sm-3">
	      						<label>Local Preservado:</label>
	      						<select name="lc_preservado" class="form-control">
	      							<option value="0">Não</option>
	      							<option value="1">Sim</option>
	      						</select>
	      					</div>
	      					<div class="col-sm-3">
	      						<label>Risco de Saque:</label>
	      						<select name="risco_saque" class="form-control">
	      							<option value="0">Não</option>
	      							<option value="1">Sim</option>
	      						</select>
	      					</div>
	      					<div class="col-sm-3">
	      						<label>Risco Ambiental:</label>
	      						<select name="risco_ambiental" class="form-control">
	      							<option value="0">Não</option>
	      							<option value="1">Sim</option>
	      						</select>
	      					</div>
	      				</div><br>
	      				<label>Descrição do Evento</label>
	      				<textarea class="form-control" name="descricao" style="height: 200px;"></textarea><br>
	      				<div class="row">
			      			<div class="col-sm-10"></div>
			      			<div class="col-sm-2">
								<a href="processo06.php?num_processo=<?=$num_processo; ?>" class="btn btn-danger">Voltar</a>	
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
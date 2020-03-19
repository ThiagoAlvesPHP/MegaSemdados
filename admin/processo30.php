<?php
require 'header.php';
$sql = new Processos();
//SEGURADOS
$getCidades = $sql->getCidades();
$num_processo = addslashes($_GET['num_processo']);
$p = $sql->getProcesso($num_processo);

if (isset($_GET['vistoria']) && $_GET['vistoria'] == "active") {
	$token = date('ymd').rand(0, 99999).date('s');
	$sql->setCertificadoVistoria($num_processo, $token, $id_user);
	?>
	<script>
		alert("Certificado de vistoria <?=$token; ?> gerado!");
		window.location.href = "processo30.php?num_processo=<?=$num_processo; ?>";
	</script>
	<?php
}

$certVist = $sql->getCertificadoVistoria($num_processo);
$getManifestosP = $sql->getManifestosP($num_processo);
$t = 0;
foreach ($getManifestosP as $v) {
	$t += $v['valor'];
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
	      	<div class="row">
	      		<div class="col-sm-6">
	      			<h3>Certificado de Vistoria</h3>
	      		</div>
	      		<div class="col-sm-6">
	      			<label>Valor IS / Valor CV:</label>
					<input class="form-control" value="R$<?=number_format($p['valor_mercadoria'], 2, ',', '.'); ?> / R$<?=number_format($t, 2, ',', '.'); ?>" readonly="">
	      		</div>
	      	</div>
	      	<?php
      		if ($p['valor_mercadoria'] > $t) {
      			echo '<br><div class="alert alert-danger" style="font-size: 25px;">
					  <strong>Observação!</strong> Valor IS divergente do Valor da soma das Notas do CV !.</div>';
      		}
      		?>
	      	<hr>
	      	<div class="well">
	      		<a href="processo30.php?num_processo=<?=$num_processo; ?>&vistoria=active" type="button" class="btn btn-info">+</a>
				<hr>
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th>Ação</th>
								<th>CV Número</th>
								<th>Criado em</th>
								<th>Criado por</th>
								<th>Atualizado em</th>
								<th>Atualizado por</th>
							</tr>
						</thead>
						<?php 
						foreach ($certVist as $c) {
							?>
						<tbody>
							<tr>
								<td>
									<a href="processo30.manifesto.php?num_processo=<?=$num_processo; ?>&num_vistoria=<?=$c['id']; ?>" class="fa fa-tasks"></a>
									<a href="processo30.pdf.php?num_processo=<?=$num_processo; ?>&num_vistoria=<?=$c['id']; ?>" class="fas fa-print" target="_blank"></a>
								</td>
								<td><?=$c['token']; ?></td>
								<td><?=date('d/m/Y H:i:s', strtotime($c['dt_criacao'])); ?></td>
								<td><?=$c['nome']; ?></td>
								<td>
									<?php
									if (!empty($c['dt_at'])) {
										echo date('d/m/Y H:i:s', strtotime($c['dt_at']));
									} else {
										echo '----';
									}
									?>
								</td>
								<td>
									<?php
									if (!empty($c['id_user_alt'])) {
										$u = $sql->getFuncID($c['id_user_alt']);
										echo $u['nome'];
									} else {
										echo '----';
									}
									?>
								</td>
							</tr>
						</tbody>
							<?php
						}
						?>
					</table>
				</div>

			    <div class="row">
	      			<div class="col-sm-10"></div>
	      			<div class="col-sm-2">
						<a href="processo29.php?num_processo=<?=$num_processo; ?>" class="btn btn-danger">Voltar</a>	
						<a href="processo31.php?num_processo=<?=$num_processo; ?>" class="btn btn-primary">Proximo</a>	
	      			</div>
	      		</div>
	      	</div>
	      </div>
	    </div>
	</div>
	<div class="col-sm-1"></div>
</div>

<?php
require 'footer.php';
?>
<?php 
require 'header.php';
$sql = new Processos();
$ramo = $sql->nav_ramo(); 
$getSegurados = $sql->getSegurados();

if (isset($_GET['id_ramo'])) {
	$processos = $sql->getProcessoRamo(addslashes($_GET['id_ramo']));
}
?>
<div class="container conteudo">
	<div class="panel panel-success">
		      <div class="panel-heading">
		      	<h3>Consultar Processo por Ramo</h3>
		      </div>
		      <div class="panel-body">
		      	<form method="GET">
		      		<label>Ramo de Seguro:</label>
			      	<select class="form-control" name="id_ramo">
			      		<?php foreach($ramo as $r): ?>
			      			<?php if(isset($_GET['id_ramo'])): ?>
			      				<?php if($_GET['id_ramo'] == $r['id']): ?>
			      					<option selected="" value="<?=$r['id']; ?>"><?=$r['ramo']; ?></option>
			      				<?php else: ?>
			      					<option value="<?=$r['id']; ?>"><?=$r['ramo']; ?></option>
			      				<?php endif; ?>
			      			<?php else: ?>
			      				<option value="<?=$r['id']; ?>"><?=$r['ramo']; ?></option>
			      			<?php endif; ?>
			      		<?php endforeach; ?>
			      	</select>
			      	<br>
			      	<button class="btn btn-primary">Consultar</button>
		      	</form>
		      	<br>
		      	<?php if(isset($_GET['id_ramo'])): ?>
		      		<form method="POST">
		      			<input type="text" value="<?=$_GET['id_ramo']; ?>" name="id_ramo" id="id-ramo" hidden>
		      			<input type="text" name="search" class="form-control" id="search-motorista" placeholder="Consultar Motorista" autofocus="">
		      		</form>
		      	<?php endif; ?>
		      	<hr>
	      		<div class="table table-responsive">
	      			<table class="table table-hover resultado">
	      				<thead>
	      					<tr>
	      						<th>Processo</th>
	      						<th>Motorista</th>
	      						<th>Data de Nascimento</th>
	      						<th>Tempo de Profissão</th>
	      						<th>CNH</th>
	      						<th>Categoria</th>
	      						<th>Validade</th>
	      						<th>Veículo</th>
	      						<th>Placa Cavalo Mecânico</th>
	      						<th>Placa Carreta 1º Semi Reboque</th>
	      						<th>Placa Carreta 2º Semi Reboque</th>
	      						<th>Ano do Caminhão - Cavalo Mecânico</th>
	      						<th>Ano do Caminhão - Carreta 1º Semi Reboque</th>
	      						<th>Ano do Caminhão - Carreta 2º Semi Reboque</th>
	      						<th>Causa/Tipo</th>
	      						<th>Local do Acidente</th>
	      						<th>Segurado</th>
	      						<th>Data e Hora do acidentes</th>
	      						<th>Número do Sinistro</th>
	      					</tr>
	      				</thead>
	      				<?php if(isset($_GET['id_ramo'])): ?>
	      					<?php foreach($processos as $p): 
	      						$m = $sql->getP16($p['num_processo']);
	      						$v = $sql->getP15($p['num_processo']);
	      						$get_evento = $sql->getEventosP();
								$dbAc = $sql->getDadosAcontecimento($p['num_processo']);



								$cidade = $sql->getCidadeID($dbAc['id_cidade']);
	      						
								$p = $sql->getProcesso($p['num_processo']);
	      						?>


	      						<tbody style="font-size: 13px;">
	      							<?php if($m['p17'] > date('Y-m-d')): ?>
	      							<tr class="success">
	      							<?php else: ?>
	      							<tr class="danger">
	      							<?php endif; ?>
	      								<?php if(!empty($m['p3'])): ?>
	      									<td><?=$p['num_processo']; ?></td>
		      								<td><?=$m['p3']; ?></td>
		      								<td><?=date('d/m/Y', strtotime($m['p9'])); ?></td>
		      								<td><?=$m['p4']; ?></td>
		      								<td><?=$m['p15']; ?></td>
		      								<td><?=$m['p16']; ?></td>
		      								<td><?=date('d/m/Y', strtotime($m['p17'])); ?></td>
		      								<td><?=$v['p9']; ?></td>
		      								<td><?=$v['p7']; ?></td>
		      								<td><?=$v['p14']; ?></td>
		      								<td><?=$v['p21']; ?></td>
		      								<td><?=$v['p11']; ?></td>
		      								<td><?=$v['p18']; ?></td>
		      								<td><?=$v['p25']; ?></td>
		      								<td>
		      									<?php
		      									foreach ($get_evento as $a) {
				      								if ($dbAc['id_nat_evento'] == $a['id']) {
				      									echo $a['nat_evento'];
				      								}
				      							}
		      									?>
		      								</td>
		      								<td><?=utf8_encode($cidade['nome']).' - '.$cidade['uf']; ?></td>
		      								<td>
		      									<?php
		      									if (!empty($p['id_segurado'])) {
								      				foreach ($getSegurados as $value) {
								      					if ($p['id_segurado'] == $value['id']) {
								      						echo $value['razao_social'];
								      					}
									      			}
								      			}
		      									?>
		      								</td>
		      								<td><?=date('d/m/Y H:i:s', strtotime($dbAc['dt_hs'])); ?></td>
		      								<td><?=$p['num_sinistro']; ?></td>
	      								<?php endif; ?>
	      							</tr>
	      						</tbody>
	      					<?php endforeach; ?>
	      				<?php endif; ?>
	      			</table>
	      		</div>
		      </div>
		    </div>
</div>
<?php require 'footer.php'; ?>
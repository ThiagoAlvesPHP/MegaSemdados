<?php  
	require 'header.php';
	if (isset($_GET['num_processo']) && !empty($_GET['num_processo'])) {
		$num_processo = addslashes($_GET['num_processo']);
		$sql = new Processos();
		$p = $sql->ProcessoNum_Processo($num_processo);
		$natEvento = $sql->natEventoID($p['id_nat_evento']);
		$pastas = $sql->getPtDocCliente($num_processo);
		$historico = $sql->getEvento($num_processo);
		$emp = $sql->getEmpresaID($dados['id_empresa']);
	}
?>
<div class="container">
	<div class="panel panel-primary">
		<div class="panel-heading"><h3>Dados do Processo</h3></div>
		<div class="panel-body">
			<div class="well">
				<div class="row">
					<div class="col-sm-8">
						<label>Seguradora</label>
						<input class="form-control" value="<?=$p['seguradora']; ?>" readonly="">
					</div>
					<div class="col-sm-4">
						<label>CNPJ:</label>
						<input class="form-control" value="<?=$p['cnpj1']; ?>" readonly="">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label>Status Processo:</label>
						<input class="form-control" readonly="" value="<?php
						if($p['status'] == 1){echo 'Concluído';} 
						elseif($p['status'] == 2){echo 'Em Andamento';} 
						elseif($p['status'] == 3) {echo 'Pendente';}
						?>">
					</div>
					<div class="col-sm-4">
						<label>Segurado:</label>
						<input class="form-control" readonly="" value="<?=$p['segurado']; ?>">
					</div>
					<div class="col-sm-4">
						<label>CNPJ:</label>
						<input class="form-control" readonly="" value="<?=$p['cnpj2']; ?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<label>Detalhes do Status do Processo:</label>
						<div class="well">
							<?php 
							if (!empty($historico)) { 
								foreach ($historico as $value) {
									echo '<strong>'.htmlspecialchars(date('d/m/Y H:i:s', strtotime($value['dt_cadastrado'])).': ').'</strong>'; 
									echo htmlspecialchars($value['evento']).'<br>'; 
								}
							} 
							?>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label>Processo Número:</label>
						<input class="form-control" readonly="" value="P<?=htmlspecialchars(str_replace('/', '', $p['num_processo'])); ?>">
					</div>
					<div class="col-sm-4">
						<label>Cia Sinistro Número:</label>
						<input class="form-control" readonly="" value="<?=$p['num_sinistro']; ?>">
					</div>
					<div class="col-sm-4">
						<label>Apólice Número:</label>
						<input class="form-control" readonly="" value="<?=$p['num_apolice']; ?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label>Ramo de Seguro:</label>
						<input class="form-control" readonly="" value="<?=$p['ramo']; ?>">
					</div>
					<div class="col-sm-3">
						<label>Natureza do Evento:</label>
						<input class="form-control" value="<?=$natEvento['nat_evento']; ?>" readonly="">
					</div>
					<div class="col-sm-3">
						<label>Moeda:</label>
						<input class="form-control" readonly="" value="<?=$p['moeda']; ?>">
					</div>
					<div class="col-sm-3">
						<label>Valor da Mercadoria:</label>
						<input class="form-control" readonly="" value="<?=number_format($p['valor_mercadoria'], 2, '.',''); ?>">
					</div>
				</div>
			</div>
			<hr>


			<!-- DOCUMENTOS DO PROCESSO -->
			<div class="well">
				<form method="POST" target="_blank" action="arquivos.php">
				<div class="table-responsive">
				<table class="table">
				<thead>
					<tr>
						<th width="80">
							<input type="checkbox" id="select">
						</th>
						<th width="100">Documento</th>
						<th>Detalhes</th>
						<th>Pasta</th>
					</tr>
				</thead>
				
				<?php
					foreach ($pastas as $v) {
						if ($v['segurado'] == 1 AND $emp['segurado'] == 1) {

							?>
							<tbody>
								<tr>
									<td>
										<input value="<?=$v['id_img']; ?>" type="checkbox" class="sel" name="select[]">
									</td>
									<td>
										<?php
										$img = explode('.', $v['img']);
										if ($img[1] == 'jpeg' OR $img[1] == 'jpg') {
											echo '<img width="50" src="../admin/'.$v['url'].'/'.$v['img'].'" class="img-responsive" data-toggle="modal" data-target="#'.$v['id_img'].'">';
										}
										if ($img[1] == 'pdf') {
											echo '<img width="50" src="../admin/assets/img/pdf.png" class="img-responsive"data-toggle="modal" data-target="#'.$v['id_img'].'">';
										}
										?>
									</td>
									<td>
										<?php 
										$a = explode('.', $v['comentario']);
										echo $a[0];
										?>
									</td>
									<td>
										<?=$v['pasta']; ?>
									</td>
								</tr>
							</tbody>
							<!-- Modal -->
							<div id="<?=$v['id_img']; ?>" class="modal fade" role="dialog">
							  <div class="modal-dialog">
							    <!-- Modal content-->
							    <div class="modal-content">
							      <div class="modal-header">
							        <button type="button" class="close" data-dismiss="modal">&times;</button>
							        <h4 class="modal-title">Documento Nº <?=$v['id_img']; ?> | <?=$v['pasta']; ?></h4>
							      </div>
							      <div class="modal-body">
							        <p>
							        	<?php
							        	if ($img[1] == 'jpeg' OR $img[1] == 'jpg') {
											echo '<img width="100%" src="../admin/'.$v['url'].'/'.$v['img'].'" class="img-responsive" data-toggle="modal" data-target="#'.$v['id_img'].'">';
										}
										if ($img[1] == 'pdf') {
											echo '<embed width="100%" height="400px" name="plugin" id="plugin" src="../admin/'.$v['url'].'/'.$v['img'].'" type="application/pdf" internalinstanceid="18">';
										}
							        	?>
							        </p>
							      </div>
							      <div class="modal-footer">
							      	<a target="_blank" download="" class="btn btn-primary" href="../admin/<?=$v['url']?>/<?=$v['img']?>">Download</a>
							        <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
							      </div>
							    </div>

							  </div>
							</div>
							<?php
						}
						if ($v['seguradora'] == 1 AND $emp['seguradora'] == 1) {
							?>
							<tbody>
								<tr>
									<td>
										<input value="<?=$v['id_img']; ?>" type="checkbox" class="sel" name="select[]">
									</td>
									<td>
										<?php
										$img = explode('.', $v['img']);
										if ($img[1] == 'jpeg' OR $img[1] == 'jpg') {
											echo '<img width="50" src="../admin/'.$v['url'].'/'.$v['img'].'" class="img-responsive" data-toggle="modal" data-target="#'.$v['id_img'].'">';
										}
										if ($img[1] == 'pdf') {
											echo '<img width="50" src="../admin/assets/img/pdf.png" class="img-responsive"data-toggle="modal" data-target="#'.$v['id_img'].'">';
										}
										?>
									</td>
									<td>
										<?php 
										$a = explode('.', $v['comentario']);
										echo $a[0];
										?>
									</td>
									<td>
										<?=$v['pasta']; ?>
									</td>
								</tr>
							</tbody>
							<!-- Modal -->
							<div id="<?=$v['id_img']; ?>" class="modal fade" role="dialog">
							  <div class="modal-dialog">

							    <!-- Modal content-->
							    <div class="modal-content">
							      <div class="modal-header">
							        <button type="button" class="close" data-dismiss="modal">&times;</button>
							        <h4 class="modal-title">Documento Nº <?=$v['id_img']; ?> | <?=$v['pasta']; ?></h4>
							      </div>
							      <div class="modal-body">
							        <p>
							        	<?php
							        	if ($img[1] == 'jpeg' OR $img[1] == 'jpg') {
											echo '<img width="100%" src="../admin/'.$v['url'].'/'.$v['img'].'" class="img-responsive" data-toggle="modal" data-target="#'.$v['id_img'].'">';
										}
										if ($img[1] == 'pdf') {
											echo '<embed width="100%" height="400px" name="plugin" id="plugin" src="../admin/'.$v['url'].'/'.$v['img'].'" type="application/pdf" internalinstanceid="18">';
										}
							        	?>
							        </p>
							      </div>
							      <div class="modal-footer">
							      	<a target="_blank" download="" class="btn btn-primary" href="../admin/<?=$v['url']?>/<?=$v['img']?>">Download</a>
							        <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
							      </div>
							    </div>

							  </div>
							</div>
							<?php
						}
						if ($v['corretora'] == 1 AND $emp['corretora'] == 1) {
							?>
							<tbody>
								<tr>
									<td>
										<input value="<?=$v['id_img']; ?>" type="checkbox" class="sel" name="select[]">
									</td>
									<td>
										<?php
										$img = explode('.', $v['img']);
										if ($img[1] == 'jpeg' OR $img[1] == 'jpg') {
											$url = '../admin/'.$v['url'].'/'.$v['img'];

											echo '<img width="50" src="'.$url.'" class="img-responsive" data-toggle="modal" data-target="#'.$v['id_img'].'">';
										}
										if ($img[1] == 'pdf') {
											$url = '../admin/'.$v['url'].'/'.$v['img'];
											echo '<img width="50" src="../admin/assets/img/pdf.png" class="img-responsive"data-toggle="modal" data-target="#'.$v['id_img'].'">';
										}
										?>
									</td>
									<td>
										<?php 
										$a = explode('.', $v['comentario']);
										echo $a[0];
										?>
									</td>
									<td>
										<?=$v['pasta']; ?>
									</td>
								</tr>
							</tbody>
							<!-- Modal -->
							<div id="<?=$v['id_img']; ?>" class="modal fade" role="dialog">
							  <div class="modal-dialog">

							    <!-- Modal content-->
							    <div class="modal-content">
							      <div class="modal-header">
							        <button type="button" class="close" data-dismiss="modal">&times;</button>
							        <h4 class="modal-title">Documento Nº <?=$v['id_img']; ?> | <?=$v['pasta']; ?></h4>
							      </div>
							      <div class="modal-body">
							        <p>
							        	<?php
							        	if ($img[1] == 'jpeg' OR $img[1] == 'jpg') {
											echo '<img width="100%" src="../admin/'.$v['url'].'/'.$v['img'].'" class="img-responsive" data-toggle="modal" data-target="#'.$v['id_img'].'">';
										}
										if ($img[1] == 'pdf') {
											echo '<embed width="100%" height="400px" name="plugin" id="plugin" src="../admin/'.$v['url'].'/'.$v['img'].'" type="application/pdf" internalinstanceid="18">';
										}
							        	?>
							        </p>
							      </div>
							      <div class="modal-footer">
							      	<a target="_blank" download="" class="btn btn-primary" href="../admin/<?=$v['url']?>/<?=$v['img']?>">Download</a>
							        <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
							      </div>
							    </div>

							  </div>
							</div>
							<?php
						}
					}
				?>
				</table>
				</div>
				<input type="text" hidden="" name="n_pro" value="<?=$num_processo; ?>">
				<input type="email" name="email" class="form-control" placeholder="Digite um e-mail"><br>
				<button value="e" name="e" class="btn btn-success">E-mail</button>
				<button value="b" name="b" class="btn btn-primary">Baixar</button>
				</form>
			</div>
		</div>
	</div>
</div>
<?php  
	require 'footer.php';
?>
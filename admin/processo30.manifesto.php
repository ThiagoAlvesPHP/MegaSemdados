<?php
require 'header.php';
$sql = new Processos();

$num_processo = addslashes($_GET['num_processo']);
$id_vistoria = addslashes($_GET['num_vistoria']);

$getMedidaP = $sql->getMedidaP();
$dadosVistoria = $sql->getCertificadoVistoriaID($id_vistoria);

$p = $sql->getProcesso($num_processo);
$segurado = $sql->getSeguradoid($p['id_segurado']);
$getNavFrete = $sql->getNavFrete();
$getNavPrejuizo = $sql->getNavPrejuizo();

$table = $sql->getManifesto($num_processo, $id_vistoria);

$t = 0;
foreach ($table as $v) {
	$t += $v['m7'];
}

//DELETANDO MANIFESTO + NFe
if (isset($_GET['id'])) {
	$sql->delManifestoNFe(addslashes($_GET['id']));

	echo '<script>alert("Deletado com sucesso!");</script>';
	echo '<script>window.location.href="'.URL.'processo30.manifesto.php?num_processo='.$num_processo.'&num_vistoria='.$id_vistoria.'"</script>';
}

//REGISTRANDO MANIFESTO
if (!empty($_POST['m3'])) {
	$post = filter_input_array(INPUT_POST, FILTER_DEFAULT);

	$post['m7'] = str_replace(',', '.', str_replace('.', '', addslashes($post['m7'])));

	if ($sql->setManifesto($num_processo, $id_vistoria, $post, $id_user, $p['valor_mercadoria'])) {
		echo '<script>alert("Registrado com sucesso!");</script>';
		echo '<script>window.location.href="'.URL.'processo30.manifesto.php?num_processo='.$num_processo.'&num_vistoria='.$id_vistoria.'"</script>';
	} else {
		echo '<script>alert("Manifesto não foi registrado!");</script>';
		echo '<script>window.location.href="'.URL.'processo30.manifesto.php?num_processo='.$num_processo.'&num_vistoria='.$id_vistoria.'"</script>';
	}
}

//ATUALIZANDO MANIFESTO
if (!empty($_POST['m1UP'])) {
	$post = filter_input_array(INPUT_POST, FILTER_DEFAULT);
	$post['m7UP'] = str_replace(',', '.', str_replace('.', '', addslashes($post['m7UP'])));
	
	if ($sql->upManifesto($num_processo, $post, $p['valor_mercadoria'])) {
		echo '<script>alert("Manifesto atualizado com sucesso!");</script>';
		echo '<script>window.location.href="'.URL.'processo30.manifesto.php?num_processo='.$num_processo.'&num_vistoria='.$id_vistoria.'"</script>';
	} else {
		echo '<script>alert("Manifesto não foi registrado!");</script>';
		echo '<script>window.location.href="'.URL.'processo30.manifesto.php?num_processo='.$num_processo.'&num_vistoria='.$id_vistoria.'"</script>';
	}
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
	      	<?php require 'navbarProcesso.php';
	      	$dbAc = $sql->getDadosAcontecimento($num_processo);
	      	$get_evento = $sql->getEventosP();
	      	?>
	      	<br>
	      	<div class="row">
	      		<div class="col-sm-4">
	      			<label>Segurado:</label>
	      			<input value="<?=$segurado['razao_social']; ?>" class="form-control" value="" readonly="">
	      		</div>
	      		<div class="col-sm-4">
	      			<label>Natureza do Evento:</label>
	      			<input class="form-control" value="<?php 
	      			foreach ($get_evento as $a) {
						if ($dbAc['id_nat_evento'] == $a['id']) {
							echo $a['nat_evento'];
						}
	      			}?>" readonly="">
	      		</div>
	      		<div class="col-sm-4">
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
	      	<h4>Manifesto/CTe</h4>
	      	<div class="well">
	      	<!-- Modal -->
			<button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">+</button>
			<div id="myModal" class="modal fade" role="dialog">
			  <div class="modal-dialog modal-lg">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal">&times;</button>
			        <h4 class="modal-title">Novo Manifesto</h4>
			      </div>
			      <div class="modal-body">
			        <p>
			        	<form method="POST">
			        		<div class="row">
			        			<div class="col-sm-3">
			        				<label>Manifesto Nº</label>
			        				<input type="text" name="m1" class="form-control">
			        			</div>
			        			<div class="col-sm-3">
			        				<label>Emissão:</label>
			        				<input type="date" name="m2" class="form-control">
			        			</div>
			        			<div class="col-sm-3">
			        				<label>CTe Nº</label>
			        				<input type="text" name="m3" class="form-control">
			        			</div>
			        			<div class="col-sm-3">
			        				<label>Emissão:</label>
			        				<input type="date" name="m4" class="form-control">
			        			</div>
			        		</div>
			        		<br>
			        		<div class="row">
			        			<div class="col-sm-3">
			        				<label>NFe Nº</label>
			        				<input type="text" name="m5" class="form-control">
			        			</div>
			        			<div class="col-sm-3">
			        				<label>Emissão:</label>
			        				<input type="date" name="m6" class="form-control">
			        			</div>
			        			<div class="col-sm-3">
			        				<label>Valor:</label>
			        				<input type="text" name="m7" class="form-control money3">
			        			</div>
			        			<div class="col-sm-3">
			        				<label>Tipo de Mercadoria:</label>
			        				<input type="text" name="tipo_mercadoria" class="form-control">
			        			</div>
			        		</div>
			        		<br>
			        		<div class="row">
			        			<div class="col-sm-4">
			        				<label>Remetente:</label>
			        				<input type="text" name="m8" class="form-control">
			        			</div>
			        			<div class="col-sm-4">
			        				<label>Destinatário:</label>
			        				<input type="text" name="m9" class="form-control">
			        			</div>
			        			<div class="col-sm-4">
			        				<label>Mercadoria:</label>
			        				<input type="text" name="m10" class="form-control">
			        			</div>
			        		</div>
			        		<br>
			        		<div class="row">
			        			<div class="col-sm-6">
			        				<label>Qtd. Volume:</label>
			        				<input type="text" name="m11" class="form-control">
			        			</div>
			        			<div class="col-sm-6">
			        				<label>Qtd. Vol. Resgatado:</label>
			        				<input type="text" name="m12" class="form-control">
			        			</div>
			        		</div>
			        		<br>
			        		<div class="row">
			        			<div class="col-sm-6">
			        				<label>Frete:</label>
			        				<select name="m13" class="form-control">
			        					<?php 
			        					foreach ($getNavFrete as $f) {
			        						echo '<option value="'.$f['id'].'">'.$f['frete'].'</option>';
			        					}
			        					?>
			        				</select>
			        			</div>
			        			<div class="col-sm-6">
			        				<label>Tipo de Prejuízo:</label>
			        				<select name="m14" class="form-control">
			        					<?php 
			        					foreach ($getNavPrejuizo as $f) {
			        						echo '<option value="'.$f['id'].'">'.$f['nome'].'</option>';
			        					}
			        					?>
			        				</select>
			        			</div>
			        		</div>
			        		<br>
			        		<div class="row">
			        			<div class="col-sm-3">
			        				<label>DT. Venc. 1:</label>
			        				<input type="date" name="m15" class="form-control">
			        			</div>
			        			<div class="col-sm-3">
			        				<label>VL. Venc. 1:</label>
			        				<input type="text" name="m16" class="form-control money">
			        			</div>
			        			<div class="col-sm-3">
			        				<label>DT. Venc. 2:</label>
			        				<input type="date" name="m17" class="form-control">
			        			</div>
			        			<div class="col-sm-3">
			        				<label>VL. Venc. 2:</label>
			        				<input type="text" name="m18" class="form-control money">
			        			</div>
			        		</div>
			        		<br>
			        		<div class="row">
			        			<div class="col-sm-3">
			        				<label>DT. Venc. 3:</label>
			        				<input type="date" name="m19" class="form-control">
			        			</div>
			        			<div class="col-sm-3">
			        				<label>VL. Venc. 3:</label>
			        				<input type="text" name="m20" class="form-control money">
			        			</div>
			        			<div class="col-sm-3">
			        				<label>DT. Venc. 4:</label>
			        				<input type="date" name="m21" class="form-control">
			        			</div>
			        			<div class="col-sm-3">
			        				<label>VL. Venc. 4:</label>
			        				<input type="text" name="m22" class="form-control money">
			        			</div>
			        		</div>
			        		<br>
			        		<div class="row">
			        			<div class="col-sm-6">
			        				<label>DT. Venc. 5:</label>
			        				<input type="date" name="m23" class="form-control">
			        			</div>
			        			<div class="col-sm-6">
			        				<label>VL. Venc. 5:</label>
			        				<input type="text" name="m24" class="form-control money">
			        			</div>
			        		</div>
			        </p>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
			        <button class="btn btn-primary">Salvar</button>
			        </form>
			      </div>
			    </div>
			  </div>
			</div>
			<!-- Fim do Modal -->


			<div class="table-responsive">
				<table class="table" style="font-size: 12px;">
					<thead>
						<tr>
							<th>Ação</th>
							<th>Manifesto</th>
							<th>Emissão</th>
							<th>CTe</th>
							<th>Emissão</th>
							<th>NFe</th>
							<th>Emissão</th>
							<th>Valor NFe</th>
							<th>Remetente</th>
							<th>Destinatário</th>
							<th>Mercadoria</th>
							<th>QTD. Volumes</th>
							<th>Volumes Resg.</th>
							<th>Tipo Prejuízo</th>
							<th>Valor Venc. 1</th>
							<th>Data Venc. 1</th>
							<th>Valor Venc. 2</th>
							<th>Data Venc. 2</th>
							<th>Valor Venc. 3</th>
							<th>Data Venc. 3</th>
							<th>Valor Venc. 4</th>
							<th>Data Venc. 4</th>
							<th>Valor Venc. 5</th>
							<th>Data Venc. 5</th>
							<th>Criado em</th>
							<th>Criado por</th>
						</tr>
					</thead>
					<?php 
					foreach ($table as $m) {
						?>
					<tbody>
						<tr>
							<td>
								<a href="" class="fa fa-edit" data-toggle="modal" data-target="#<?=$m['id']; ?>" title="Editar"></a>
								<a href="processo30.nfe.php?num_processo=<?=$num_processo; ?>&id_vistoria=<?=$id_vistoria; ?>&manifesto=<?=$m['id']; ?>" class="fa fa-tasks" title="Notas/NFe"></a>
								<a href="processo30.manifesto.php?num_processo=<?=$num_processo ?>&num_vistoria=<?=$id_vistoria; ?>&id=<?=$m['id']; ?>" class="fas fa-trash-alt" title="Deletar"></a>

								<?php require 'modal.php'; ?>

							</td>
							<td><?=$m['m1']; ?></td>
							<td><?=date('d/m/Y', strtotime($m['m2'])); ?></td>
							<td><?=$m['m3']; ?></td>
							<td><?=date('d/m/Y', strtotime($m['m4'])); ?></td>
							<td><?=$m['m5']; ?></td>
							<td><?=date('d/m/Y', strtotime($m['m6'])); ?></td>
							<td>R$<?=number_format($m['m7'], 2, ',', '.'); ?></td>
							<td><?=$m['m8']; ?></td>
							<td><?=$m['m9']; ?></td>
							<td><?=$m['m10']; ?></td>
							<td><?=$m['m11']; ?></td>
							<td><?=$m['m12']; ?></td>
							<td><?=$m['prej']; ?></td>
							<td><?php 
							if (!empty($m['m16'])) {
								echo 'R$'.number_format($m['m16'], 2, ',', '.');
							} else {
								echo '----';
							}
							?></td>
							<td><?=date('d/m/Y', strtotime($m['m15'])); ?></td>
							<td>
							<?php 
							if (!empty($m['m18'])) {
								echo 'R$'.number_format($m['m18'], 2, ',', '.');
							} else {
								echo '----';
							}
							?>
							</td>
							<td><?=date('d/m/Y', strtotime($m['m17'])); ?></td>
							<td>
							<?php 
							if (!empty($m['m20'])) {
								echo 'R$'.number_format($m['m20'], 2, ',', '.');
							} else {
								echo '----';
							}
							?>
							</td>
							<td><?=date('d/m/Y', strtotime($m['m19'])); ?></td>
							<td>
							<?php 
							if (!empty($m['m22'])) {
								echo 'R$'.number_format($m['m22'], 2, ',', '.');
							} else {
								echo '----';
							}
							?>
							</td>
							<td><?=date('d/m/Y', strtotime($m['m21'])); ?></td>
							<td>
							<?php 
							if (!empty($m['m24'])) {
								echo 'R$'.number_format($m['m24'], 2, ',', '.');
							} else {
								echo '----';
							}
							?>
							</td>
							<td><?=date('d/m/Y', strtotime($m['m23'])); ?></td>
							<td><?=date('d/m/Y H:i:s', strtotime($m['dt_cadastro'])); ?></td>
							<td><?=$m['func']; ?></td>
						</tr>
					</tbody>
						<?php
					}
					?>
				</table>
			</div>
			<hr>
			<?php
			if (!empty($_POST['volume1'])) {
				$post = filter_input_array(INPUT_POST, FILTER_DEFAULT);

				$sql->upVistoria($post, $id_vistoria);
				echo '<script>alert("Registrado com sucesso!");</script>';
				echo '<script>window.location.href="'.URL.'processo30.manifesto.php?num_processo='.$num_processo.'&num_vistoria='.$id_vistoria.'"</script>';
			}
			?>
			<form method="POST">
				<h3>Detalhes da Mercadoria - Embarcados</h3>
				<div class="row">
					<div class="col-sm-4">
						<label>Volume:</label>
						<input type="text" value="<?=$dadosVistoria['volume1']; ?>" name="volume1" class="form-control">
					</div>
					<div class="col-sm-4">
						<label>Unid. Medida:</label>
						<select name="id_uni_medida1" class="form-control">
							<?php
							foreach ($getMedidaP as $m) {
								if ($dadosVistoria['id_uni_medida1'] == $m['id']) {
									echo '<option selected value="'.$m['id'].'">'.$m['nome'].'</option>';
								} else {
									echo '<option value="'.$m['id'].'">'.$m['nome'].'</option>';
								}
							}
							?>
						</select>
					</div>
					<div class="col-sm-4">
						<label>Peso:</label>
						<input type="text" value="<?=$dadosVistoria['peso1']; ?>" name="peso1" class="form-control">
					</div>
				</div>
				<h3>Detalhes da Mercadoria - Selecionados</h3>
				<div class="row">
					<div class="col-sm-4">
						<label>Volume:</label>
						<input type="text" value="<?=$dadosVistoria['volume2']; ?>" name="volume2" class="form-control">
					</div>
					<div class="col-sm-4">
						<label>Unid. Medida:</label>
						<select name="id_uni_medida2" class="form-control">
							<?php
							foreach ($getMedidaP as $m) {
								if ($dadosVistoria['id_uni_medida2'] == $m['id']) {
									echo '<option selected value="'.$m['id'].'">'.$m['nome'].'</option>';
								} else {
									echo '<option value="'.$m['id'].'">'.$m['nome'].'</option>';
								}
							}
							?>
						</select>
					</div>
					<div class="col-sm-4">
						<label>Peso:</label>
						<input type="text" value="<?=$dadosVistoria['peso2']; ?>" name="peso2" class="form-control">
					</div>
				</div>
				<h3>Risco/Danos Ambientais: </h3>
				<?php
				if (!empty($dadosVistoria['risco'])) {
					if($dadosVistoria['risco'] == 1){
					?>
					<input checked="" type="radio" name="risco" value="1">Sim - 
					<input type="radio" name="risco" value="2">Não
					<?php
					} else {
					?>
					<input type="radio" name="risco" value="1">Sim - 
					<input checked="checked" type="radio" name="risco" value="2">Não
					<?php
					}
				} else {
				?>
				<input type="radio" name="risco" value="1">Sim - 
				<input type="radio" name="risco" value="2">Não
				<?php
				}
				?>
				
				<h3>Apuração de Prejuízo</h3>
				<textarea name="prejuizo" class="form-control"><?=$dadosVistoria['prejuizo']; ?></textarea>
				<h3>Salvado</h3>
				<textarea name="salvado" class="form-control"><?=$dadosVistoria['salvado']; ?></textarea>
				<h3>Documentos Anexos</h3>
				<textarea name="anexos" class="form-control"><?=$dadosVistoria['anexos']; ?></textarea>
				<br>
				<a class="btn btn-danger" href="processo30.php?num_processo=<?=$num_processo; ?>">Voltar</a>
				<button class="btn btn-primary">Salvar</button>
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
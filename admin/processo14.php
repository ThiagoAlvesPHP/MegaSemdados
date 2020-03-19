<?php
require 'header.php';
$sql = new Processos();
//SEGURADOS
$getCidades = $sql->getCidades();
$num_processo = addslashes($_GET['num_processo']);
$p = $sql->getProcesso($num_processo);
$form1 = $sql->getform1P14($num_processo);
$fretes = $sql->getNavFrete();
$nav_tipo_doc = $sql->nav_tipo_doc2();
$nav_moeda = $sql->nav_moeda();

$getDocForm2 = $sql->getDocForm2($num_processo);

//REGISTRANDO FORM 1
if (!empty($_POST['rntrc']) && !empty($_POST['frete'])) {
	$rntrc = addslashes($_POST['rntrc']);
	$frete = addslashes($_POST['frete']);

	$sql->setDocForm1($num_processo, $rntrc, $frete);
	?>
	<script>
		window.location.href = "processo14.php?num_processo=<?=$num_processo; ?>";
	</script>
	<?php
}
//ATUALIZANDO FORM 1
if (!empty($_POST['rntrcUP']) && !empty($_POST['freteUP'])) {
	$rntrc = addslashes($_POST['rntrcUP']);
	$frete = addslashes($_POST['freteUP']);

	$sql->upDocForm1($num_processo, $rntrc, $frete);
	?>
	<script>
		window.location.href = "processo14.php?num_processo=<?=$num_processo; ?>";
	</script>
	<?php
}


//REGISTRANDO DANOS TRANSPORTE
if (isset($_POST['tipo_doc'])) {
	$tipo_doc = addslashes($_POST['tipo_doc']);
	$num_doc = addslashes($_POST['num_doc']);
	$id_moeda = addslashes($_POST['id_moeda']);
	$nrtrc = addslashes($_POST['nrtrc']);
	$valor = addslashes(str_replace(",", ".", $_POST['valor']));
	$efeito_seguro = addslashes($_POST['efeito_seguro']);
	$valor_efeito = addslashes(str_replace(",", ".", $_POST['valor_efeito']));

	$sql->setDocForm2($num_processo, $tipo_doc, $num_doc, $id_moeda, $nrtrc, $valor, $efeito_seguro, $valor_efeito);
	?>
	<script>
		window.location.href = "processo14.php?num_processo=<?=$num_processo; ?>";
	</script>
	<?php
}

//ATUALIZAR
if (isset($_POST['tipo_docUP'])) {
	$id = addslashes($_POST['idUP']);
	$tipo_doc = addslashes($_POST['tipo_docUP']);
	$num_doc = addslashes($_POST['num_docUP']);
	$id_moeda = addslashes($_POST['id_moedaUP']);
	$nrtrc = addslashes($_POST['nrtrcUP']);
	$valor = addslashes(str_replace(",", ".", $_POST['valorUP']));
	$efeito_seguro = addslashes($_POST['efeito_seguroUP']);
	$valor_efeito = addslashes(str_replace(",", ".", $_POST['valor_efeitoUP']));

	$sql->upDocForm2($id, $tipo_doc, $num_doc, $id_moeda, $nrtrc, $valor, $efeito_seguro, $valor_efeito);
	?>
	<script>
		window.location.href = "processo14.php?num_processo=<?=$num_processo; ?>";
	</script>
	<?php
}

//DELETAR
if (isset($_GET['id']) && !empty($_GET['id'])) {
	$sql->delDocForm2(addslashes($_GET['id']));
	?>
	<script>
		alert("Deletado com Sucesso!");
		window.location.href = "processo14.php?num_processo=<?=$num_processo; ?>";
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
	      	<h3>Documentação do Transporte</h3>
	      	<div class="well">
	      		<form method="POST">
	      			<div class="row">
	      				<div class="col-sm-2">
	      					<label>Nr. RNTRC</label>
	      				</div>
	      				<div class="col-sm-3">
	      					<?php
	      						if (!empty($form1)) {
	      							echo '<input value="'.$form1['rntrc'].'" type="text" name="rntrcUP" class="form-control">';
	      						} else {
	      							echo '<input type="text" name="rntrc" class="form-control">';
	      						}
	      					?>
	      				</div>
	      				<div class="col-sm-1">
	      					<label>Frete</label>
	      				</div>
	      				<div class="col-sm-4">
	      					<?php
	      						if (!empty($form1)) {
	      							?>
	      							<select class="form-control" name="freteUP">
	      								<?php
	      								foreach ($fretes as $f) {
	      								 	if ($f['id'] == $form1['frete']) {
	      								 		echo '<option selected value="'.$f['id'].'">'.$f['frete'].'</option>';
	      								 	} else {
	      								 		echo '<option value="'.$f['id'].'">'.$f['frete'].'</option>';
	      								 	}

	      								} 
	      								?>
	      							</select>
	      							<?php
	      						} else {
	      							?>
	      							<select class="form-control" name="frete">
	      								<option value="NULL">----</option>
	      								<?php
	      								foreach ($fretes as $f) {
	      								 	echo '<option value="'.$f['id'].'">'.$f['frete'].'</option>';
	      								} 
	      								?>
	      							</select>
	      							<?php
	      						}
	      					?>
	      				</div>
	      				<div class="col-sm-2">
	      					<button class="btn btn-primary">Salvar</button>
	      				</div>
	      			</div>
	      		</form>
	      		<hr>

	      		<!-- MODAL -->
	      		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">+</button>

				<div id="myModal" class="modal fade" role="dialog">
				  <div class="modal-dialog">
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal">&times;</button>
				        <h4 class="modal-title">Dados do Transporte</h4>
				      </div>
				      <form method="POST">
				      <div class="modal-body">
				        <p>
			        		<div class="row">
			        			<div class="col-sm-6">
			        				<label>Documento:</label>
					        		<select name="tipo_doc" class="form-control">
					        			<?php
					        			foreach ($nav_tipo_doc as $dn) {
					        				echo '<option value="'.$dn['id'].'">'.utf8_encode($dn['tipo_doc']).'</option>';
					        			}
					        			?>
					        		</select>
					        		<label>Documento N.:</label>
					        		<input type="text" name="num_doc" class="form-control">
					        		<label>Moeda:</label>
					        		<select name="id_moeda" class="form-control">
					        			<?php
					        			foreach ($nav_moeda as $dn) {
					        				echo '<option value="'.$dn['id'].'">'.$dn['nome'].'</option>';
					        			}
					        			?>
					        		</select>
					        		<label>Nr. RNTRC:</label>
					        		<input type="text" name="nrtrc" class="form-control">
			        			</div>
			        			<div class="col-sm-6">
			        				<label>Valor:</label>
					        		<input type="text" name="valor" class="form-control money">
					        		<label>Efeito Seguro:</label>
					        		<input type="text" name="efeito_seguro" class="form-control">
					        		<label>Valor Efeito Seguro:</label>
					        		<input type="text" name="valor_efeito" class="form-control money">
			        			</div>
			        		</div>
			        		<br>
				        </p>
				      </div>
				      <div class="modal-footer">
				        <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
				        <button class="btn btn-primary">Salvar</button>
				      </div>
				      </form>
				    </div>
				  </div>
				</div>
				<!-- FIM MODAL -->

	      		<form method="POST">
					<div class="table-responsive">
						<table class="table" style="font-size: 12px;">
							<thead>
								<tr>
									<th>Ação</th>
									<th>CIOT</th>
									<th>Documento</th>
									<th>Número</th>
									<th>Moeda</th>
									<th>Valor</th>
									<th>Efeito Seguro</th>
									<th>Valor Efeito Seguro</th>
								</tr>
							</thead>
							<?php
							foreach ($getDocForm2 as $dnC) {
								?>
							<tbody>
								<tr>
									<td>
										<a href="" class="fa fa-edit" data-toggle="modal" data-target="#<?=$dnC['id']; ?>"></a>
										<a href="processo14.php?num_processo=<?=$num_processo ?>&id=<?=$dnC['id']; ?>" class="fas fa-trash-alt"></a>
				<!-- MODAL -->
				<div id="<?=$dnC['id']; ?>" class="modal fade" role="dialog">
				  <div class="modal-dialog">
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal">&times;</button>
				        <h4 class="modal-title">Dados do Container</h4>
				      </div>
				      <form method="POST">
				      	<input type="text" name="idUP" hidden="" value="<?=$dnC['id']; ?>">
				      <div class="modal-body">
				        <p>
				        	<div class="row">
			        			<div class="col-sm-6">
			        				<label>Documento:</label>
					        		<select name="tipo_docUP" class="form-control">
					        			<?php
					        			foreach ($nav_tipo_doc as $dn) {
					        				if ($dnC['tipo_doc'] == $dn['id']) {
					        					echo '<option selected value="'.$dn['id'].'">'.utf8_encode($dn['tipo_doc']).'</option>';
					        				}
					        				echo '<option value="'.$dn['id'].'">'.utf8_encode($dn['tipo_doc']).'</option>';
					        			}
					        			?>
					        		</select>
					        		<label>Documento N.:</label>
					        		<input type="text" value="<?=$dnC['num_doc']; ?>" name="num_docUP" class="form-control">
					        		<label>Moeda:</label>
					        		<select name="id_moedaUP" class="form-control">
					        			<?php
					        			foreach ($nav_moeda as $dn) {
					        				if ($dnC['id_moeda'] == $dn['id']) {
					        					echo '<option selected value="'.$dn['id'].'">'.$dn['nome'].'</option>';
					        				}
					        				echo '<option value="'.$dn['id'].'">'.$dn['nome'].'</option>';
					        			}
					        			?>
					        		</select>
					        		<label>Documento N.:</label>
					        		<input type="text" value="<?=$dnC['nrtrc']; ?>" name="nrtrcUP" class="form-control">
			        			</div>
			        			<div class="col-sm-6">
			        				<label>Valor:</label>
					        		<input type="text" value="<?=number_format($dnC['valor'], 2, '.',''); ?>" name="valorUP" class="form-control money">
					        		<label>Efeito Seguro:</label>
					        		<input type="text" value="<?=$dnC['efeito_seguro']; ?>" name="efeito_seguroUP" class="form-control">
					        		<label>Valor Efeito Seguro:</label>
					        		<input type="text" value="<?=number_format($dnC['valor_efeito'], 2, '.',''); ?>" name="valor_efeitoUP" class="form-control money">
			        			</div>
			        		</div>
				        </p>
				      <div class="modal-footer">
				        <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
				        <button class="btn btn-primary">Salvar</button>
				      </div>
				      </form>
				    </div>
				  </div>
				</div>
				<!-- FIM MODAL -->
									</td>
									<td><?=htmlspecialchars($dnC['nrtrc']); ?></td>
									<td>
										<?=htmlspecialchars(utf8_encode($dnC['nome_cod'])); ?>
									</td>
									<td><?=htmlspecialchars($dnC['num_doc']); ?></td>
									<td><?=htmlspecialchars($dnC['nome']); ?></td>
									<td>R$<?=number_format($dnC['valor'], 2, '.','') ?></td>
									<td><?=htmlspecialchars($dnC['efeito_seguro']); ?></td>
									<td>R$<?=number_format($dnC['valor_efeito'], 2, '.','') ?></td>
								</tr>
							</tbody>
								<?php
							}
							?>
							
						</table>
					</div>
					<br>
				    <div class="row">
		      			<div class="col-sm-10"></div>
		      			<div class="col-sm-2">
							<a href="processo13.php?num_processo=<?=$num_processo; ?>" class="btn btn-danger">Voltar</a>	
							<a href="processo15.php?num_processo=<?=$num_processo; ?>" class="btn btn-primary">Proximo</a>	
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
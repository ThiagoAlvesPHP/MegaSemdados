<?php
require 'header.php';
$sql = new Processos();
//SEGURADOS
$getCidades = $sql->getCidades();
$num_processo = addslashes($_GET['num_processo']);
$p = $sql->getProcesso($num_processo);

//REGISTRANDO DANOS CONTAINER
if (isset($_POST['num_registro'])) {
	$num_registro = addslashes($_POST['num_registro']);
	$armador = addslashes($_POST['armador']);
	$ano_fabricacao = addslashes($_POST['ano_fabricacao']);
	$modelo = addslashes($_POST['modelo']);
	$danos = addslashes($_POST['danos']);
	$valor_averbado = addslashes(str_replace(",", ".", $_POST['valor_averbado']));
	$valor_depreciado = addslashes(str_replace(",", ".", $_POST['valor_depreciado']));
	$valor_reparo = addslashes(str_replace(",", ".", $_POST['valor_reparo']));
	$lacres = addslashes($_POST['lacres']);

	$sql->setDanosContainerP($num_processo, $num_registro, $armador, $ano_fabricacao, $modelo, $danos, $valor_averbado, $valor_depreciado, $valor_reparo, $lacres);
	?>
	<script>
		window.location.href = "processo12.php?num_processo=<?=$num_processo; ?>";
	</script>
	<?php
}

//UPDATE DANOS CONTAINER
if (isset($_POST['num_registroUP'])) {
	$id = $_POST['idUP'];
	$num_registro = addslashes($_POST['num_registroUP']);
	$armador = addslashes($_POST['armadorUP']);
	$ano_fabricacao = addslashes($_POST['ano_fabricacaoUP']);
	$modelo = addslashes($_POST['modeloUP']);
	$danos = addslashes($_POST['danosUP']);
	$valor_averbado = addslashes(str_replace(",", ".", $_POST['valor_averbadoUP']));
	$valor_depreciado = addslashes(str_replace(",", ".", $_POST['valor_depreciadoUP']));
	$valor_reparo = addslashes(str_replace(",", ".", $_POST['valor_reparoUP']));
	$lacres = addslashes($_POST['lacresUP']);

	$sql->upDanosContainerP($id, $num_registro, $armador, $ano_fabricacao, $modelo, $danos, $valor_averbado, $valor_depreciado, $valor_reparo, $lacres);
	?>
	<script>
		window.location.href = "processo12.php?num_processo=<?=$num_processo; ?>";
	</script>
	<?php
}

//DELETAR DADOS DO CONTAINER
if (isset($_GET['id']) && !empty($_GET['id'])) {
	$sql->delDadosContainerP(addslashes($_GET['id']));
	?>
	<script>
		alert("Deletado com Sucesso!");
		window.location.href = "processo12.php?num_processo=<?=$num_processo; ?>";
	</script>
	<?php
}

$getNavAvarias = $sql->getNavAvarias();
$dnContainer = $sql->getDnContainerP($num_processo);

$getInforP = $sql->getInforP($num_processo);
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
	      	<h3>Dados do Container</h3>
	      	<div class="well">
	      		<form method="POST">
	      			<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">+</button>

					<!-- Modal -->
					<div id="myModal" class="modal fade" role="dialog">
					  <div class="modal-dialog">
					    <div class="modal-content">
					      <div class="modal-header">
					        <button type="button" class="close" data-dismiss="modal">&times;</button>
					        <h4 class="modal-title">Dados do Container</h4>
					      </div>
					      <form method="POST">
					      <div class="modal-body">
					        <p>
				        		<div class="row">
				        			<div class="col-sm-6">
				        				<label>N Registro:</label>
						        		<input type="text" name="num_registro" class="form-control">
						        		<label>Armador:</label>
						        		<input type="text" name="armador" class="form-control">
						        		<label>Avarias:</label>
						        		<select name="danos" class="form-control">
						        			<?php
						        			foreach ($getNavAvarias as $dn) {
						        				echo '<option value="'.$dn['id'].'">'.utf8_encode($dn['dano']).'</option>';
						        			}
						        			?>
						        		</select>
						        		<label>Valor Avervado:</label>
						        		<input type="text" name="valor_averbado" class="form-control money">
				        			</div>
				        			<div class="col-sm-6">
				        				<label>Ano Fabricação:</label>
						        		<input type="text" name="ano_fabricacao" class="form-control">
						        		<label>Tipo Modelo:</label>
						        		<input type="text" name="modelo" class="form-control">
						        		<label>Valor Depreciado:</label>
						        		<input type="text" name="valor_depreciado" class="form-control money">
						        		<label>Valor de Reparo:</label>
						        		<input type="text" name="valor_reparo" class="form-control money">
				        			</div>
				        		</div>
				        		<label>Lacre:</label>
				        		<input type="text" name="lacres" class="form-control">
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
					<br>
					<div class="table-responsive">
						<table class="table" style="font-size: 12px;">
							<thead>
								<tr>
									<th>Ação</th>
									<th>N. Registro</th>
									<th>Armador</th>
									<th>Ano Fabricação</th>
									<th>Tipo Modelo</th>
									<th>Danos/Avarias</th>
									<th>Valor Averbado</th>
									<th>Valor Depreciado</th>
									<th>Valor Reparo</th>
									<th>Lacres</th>
								</tr>
							</thead>
							<?php
							foreach ($dnContainer as $dnC) {
								?>
							<tbody>
								<tr>
									<td>
										<a href="" class="fa fa-edit" data-toggle="modal" data-target="#<?=$dnC['id']; ?>"></a>
										<a href="processo12.php?num_processo=<?=$num_processo ?>&id=<?=$dnC['id']; ?>" class="fas fa-trash-alt"></a>
				<!-- Modal -->
				<div id="<?=$dnC['id']; ?>" class="modal fade" role="dialog">
				  <div class="modal-dialog">
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal">&times;</button>
				        <h4 class="modal-title">Dados do Container</h4>
				      </div>
				      <form method="POST">
				      <div class="modal-body">
				        <p>
			        		<div class="row">
			        			<div class="col-sm-6">
			        				<input name="idUP" hidden="" value="<?=$dnC['id']; ?>">
			        				<label>N Registro:</label>
					        		<input type="text" value="<?=htmlspecialchars($dnC['num_registro']); ?>" name="num_registroUP" class="form-control">
					        		<label>Armador:</label>
					        		<input type="text" value="<?=htmlspecialchars($dnC['armador']); ?>" name="armadorUP" class="form-control">
					        		<label>Avarias:</label>
					        		<select name="danosUP" class="form-control">
					        			<?php
					        			foreach ($getNavAvarias as $dn) {
					        				if ($dnC['danos'] == $dn['id']) {
					        					echo '<option selected value="'.$dn['id'].'">'.utf8_encode($dn['dano']).'</option>';
					        				} else {
					        					echo '<option value="'.$dn['id'].'">'.utf8_encode($dn['dano']).'</option>';
					        				}
					        			}
					        			?>
					        		</select>
					        		<label>Valor Avervado:</label>
					        		<input type="text" value="<?=number_format($dnC['valor_averbado'], 2, '.','') ?>" name="valor_averbadoUP" class="form-control money">
			        			</div>
			        			<div class="col-sm-6">
			        				<label>Ano Fabricação:</label>
					        		<input type="text" value="<?=htmlspecialchars($dnC['ano_fabricacao']); ?>" name="ano_fabricacaoUP" class="form-control">
					        		<label>Tipo Modelo:</label>
					        		<input type="text" value="<?=htmlspecialchars($dnC['modelo']); ?>" name="modeloUP" class="form-control">
					        		<label>Valor Depreciado:</label>
					        		<input type="text" value="<?=number_format($dnC['valor_depreciado'], 2, '.','') ?>" name="valor_depreciadoUP" class="form-control money">
					        		<label>Valor de Reparo:</label>
					        		<input type="text" value="<?=number_format($dnC['valor_reparo'], 2, '.','') ?>" name="valor_reparoUP" class="form-control money">
			        			</div>
			        		</div>
			        		<label>Lacre:</label>
			        		<input type="text" value="<?=htmlspecialchars($dnC['lacres']); ?>" name="lacresUP" class="form-control">
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
									</td>
									<td>
										<?=htmlspecialchars($dnC['num_registro']); ?>
									</td>
									<td><?=htmlspecialchars($dnC['armador']); ?></td>
									<td><?=htmlspecialchars($dnC['ano_fabricacao']); ?></td>
									<td><?=htmlspecialchars($dnC['modelo']); ?></td>
									<td><?=htmlspecialchars(utf8_encode($dnC['dano'])); ?></td>
									<td>R$<?=number_format($dnC['valor_averbado'], 2, '.','') ?></td>
									<td>R$<?=number_format($dnC['valor_depreciado'], 2, '.','') ?></td>
									<td>R$<?=number_format($dnC['valor_reparo'], 2, '.','') ?></td>
									<td><?=htmlspecialchars($dnC['lacres']); ?></td>
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
							<a href="processo11.php?num_processo=<?=$num_processo; ?>" class="btn btn-danger">Voltar</a>	
							<a href="processo13.php?num_processo=<?=$num_processo; ?>" class="btn btn-primary">Proximo</a>	
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
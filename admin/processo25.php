<?php
require 'header.php';
$sql = new Processos();
$total = 0;
//SEGURADOS
$getCidades = $sql->getCidades();
$num_processo = addslashes($_GET['num_processo']);
$p = $sql->getProcesso($num_processo);

$getPrejCusto = $sql->getPrejCusto($num_processo);
$nav_esforco = $sql->getNavEsforco();
$getCusto = $sql->getCusto($num_processo);

//DELETAR DADOS DO CONTAINER
if (isset($_GET['id']) && !empty($_GET['id'])) {
	$sql->delCusto(addslashes($_GET['id']));
	?>
	<script>
		alert("Deletado com Sucesso!");
		window.location.href = "processo25.php?num_processo=<?=$num_processo; ?>";
	</script>
	<?php
}

//REGISTRANDO
if (!empty($_POST['esforcoUP'])) {
	$idUP = addslashes($_POST['idUP']);
	$esforco = addslashes($_POST['esforcoUP']);
	$qt = addslashes($_POST['qtUP']);
	$valor = addslashes($_POST['valorUP']);
	$sql->upCusto($idUP, $esforco, $qt, $valor, $id_user);
	?>
	<script>
		window.location.href = "processo25.php?num_processo=<?=$num_processo; ?>";
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
	      	<h3>Estimativa de Prejuízo e Custo (S.O.S)</h3>
	      	<div class="well">
	      		<form method="POST">
	      			<h3>Estimativa de Prejuízo</h3>
	      			<div class="row">
	      				<div class="col-sm-3">
	      					<h4>Danos:</h4>
	      					<h4>Dispersão:</h4>
	      					<h4>Falta / Saque / Roubo:</h4>
	      					<h4 style="color: blue;"><strong>SubTotal:</strong></h4>
	      				</div>
	      				<div class="col-sm-3">
	      					<?php 
	      					if (!empty($getPrejCusto)) {
	      						//ATUALIZANDO
	      						if (!empty($_POST['danos'])) {
	      							$danos = addslashes($_POST['danos']);
	      							$dispersao = addslashes($_POST['dispersao']);
	      							$fsr = addslashes($_POST['fsr']);

	      							$sql->upPrejCusto($num_processo, $danos, $dispersao, $fsr);
	      							?>
									<script>
										window.location.href = "processo25.php?num_processo=<?=$num_processo; ?>";
									</script>
									<?php
	      						}
	      						$total = $getPrejCusto['danos']+$getPrejCusto['dispersao']+$getPrejCusto['fsr'];

	      						?>
	      						<input type="text" value="<?=number_format($getPrejCusto['danos'], 2, '.',''); ?>" name="danos" id="danos" class="form-control money" placeholder="0,00">
		      					<input type="text" value="<?=number_format($getPrejCusto['dispersao'], 2, '.', ''); ?>" name="dispersao" id="dispersao" class="form-control money" placeholder="0,00">
		      					<input type="text" value="<?=number_format($getPrejCusto['fsr'], 2, '.', ''); ?>" name="fsr" id="fsr" class="form-control money" placeholder="0,00">
		      					<input readonly="" value="<?=number_format($total, 2, '.', ''); ?>" id="res01" class="form-control" placeholder="0,00"><br>
	      						<?php
	      					} else {
	      						//REGISTRANDO
	      						if (!empty($_POST['danos'])) {
	      							$danos = addslashes($_POST['danos']);
	      							$dispersao = addslashes($_POST['dispersao']);
	      							$fsr = addslashes($_POST['fsr']);

	      							$sql->setPrejCusto($num_processo, $danos, $dispersao, $fsr);
	      							?>
									<script>
										window.location.href = "processo25.php?num_processo=<?=$num_processo; ?>";
									</script>
									<?php
	      						}
	      						?>
	      						<input type="text" name="danos" id="danos" class="form-control money" placeholder="0,00">
		      					<input type="text" name="dispersao" id="dispersao" class="form-control money" placeholder="0,00">
		      					<input type="text" name="fsr" id="fsr" class="form-control money" placeholder="0,00">
		      					<input readonly="" id="res01" class="form-control" placeholder="0,00"><br>
	      						<?php
	      					}
	      					?>
	      					<button class="btn btn-success">Salvar</button>
	      				</div>
	      				<div class="col-sm-6"></div>
	      			</div>
		      	</form><hr>
		      	<h3>Estimativa de Custo (S.O.S)</h3>

		      	<?php
		      	//REGISTRANDO
		      	if (!empty($_POST['esforco'])) {
					$esforco = addslashes($_POST['esforco']);
					$qt = addslashes($_POST['qt']);
					$valor = addslashes($_POST['valor']);
					$sql->setCusto($num_processo, $esforco, $qt, $valor, $id_user);
					?>
					<script>
						window.location.href = "processo25.php?num_processo=<?=$num_processo; ?>";
					</script>
					<?php
				}
		      	?>

		      	<form method="POST">
	      			<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">+</button>

					<!-- MODAL -->
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
				        		<label>Documento:</label>
				        		<select name="esforco" class="form-control">
				        			<?php
				        			foreach ($nav_esforco as $dn) {
				        				echo '<option value="'.$dn['id'].'">'.utf8_encode($dn['nome']).'</option>';
				        			}
				        			?>
				        		</select>
				        		<label>Quantidade:</label>
				        		<input type="number" name="qt" class="form-control">
				        		<label>Valor Unitário:</label>
				        		<input type="text" name="valor" class="form-control money">
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
									<th>Operação</th>
									<th>Quantidade</th>
									<th>Valor Unit</th>
									<th>Valor Total</th>
									<th>Lançado em</th>
									<th>Lançado por</th>
								</tr>
							</thead>
							<?php
							$SubTotal = 0;
							foreach ($getCusto as $dnC) {
								?>
							<tbody>
								<tr>
									<td>
										<a href="" class="fa fa-edit" data-toggle="modal" data-target="#<?=$dnC['id']; ?>"></a>
										<a href="processo25.php?num_processo=<?=$num_processo ?>&id=<?=$dnC['id']; ?>" class="fas fa-trash-alt"></a>


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
										        	<label>Documento:</label>
									        		<select name="esforcoUP" class="form-control">
									        			<?php
									        			foreach ($nav_esforco as $dn) {
									        				if ($dn['id'] == $dnC['id_esforco']) {
									        					echo '<option selected value="'.$dn['id'].'">'.utf8_encode($dn['nome']).'</option>';
									        				} else {
									        					echo '<option value="'.$dn['id'].'">'.utf8_encode($dn['nome']).'</option>';
									        				}
									        				
									        			}
									        			?>
									        		</select>
									        		<label>Quantidade:</label>
									        		<input type="number" value="<?=$dnC['qt']; ?>" name="qtUP" class="form-control">
									        		<label>Valor Unitário:</label>
									        		<input type="text" name="valorUP" value="<?=number_format($dnC['valor'], 2, '.',''); ?>" class="form-control money">
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
									<td>
										<?=htmlspecialchars(utf8_encode($dnC['esforco'])); ?>
									</td>
									<td><?=htmlspecialchars($dnC['qt']); ?></td>
									<td>R$<?=number_format($dnC['valor'], 2, '.',''); ?></td>
									<td>R$<?php 
									$sub = $dnC['valor']*$dnC['qt'];
									echo number_format($sub, 2, '.','') ?></td>
									<td><?=date('d/m/Y H:i:s', strtotime($dnC['dt_cadastro'])); ?></td>
									<td><?=$dnC['nome']; ?></td>
								</tr>
							</tbody>
								<?php
								$SubTotal += $sub;
							}
							$tot = $SubTotal + $total;
							?>
							
						</table>
					</div>
					<hr>
					<div class="row">
						<div class="col-sm-2">
							<h4 style="color: blue"><strong>SubTotal:</strong></h4>
						</div>
						<div class="col-sm-4">
							<input class="form-control" readonly="" value="R$<?=number_format($SubTotal, 2, '.',''); ?>">
						</div>
						<div class="col-sm-2">
							<h4 style="color: red"><strong>Total:</strong></h4>
						</div>
						<div class="col-sm-4">
							<input class="form-control" readonly="" value="R$<?=number_format($tot, 2, '.',''); ?>">
						</div>
					</div>
					<hr>
				    <div class="row">
		      			<div class="col-sm-10"></div>
		      			<div class="col-sm-2">
							<a href="processo24.php?num_processo=<?=$num_processo; ?>" class="btn btn-danger">Voltar</a>	
							<a href="processo26.php?num_processo=<?=$num_processo; ?>" class="btn btn-primary">Proximo</a>	
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
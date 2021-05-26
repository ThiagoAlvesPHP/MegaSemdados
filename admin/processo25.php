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

//UPDATE Estimativa de Custo (S.O.S)
if (!empty($_POST['esforcoUP'])) {
	$_POST['id_esforcoUP'] = $_POST['esforcoUP'];
	$_POST['id_userUP'] = $id_user;
	unset($_POST['esforcoUP']);
	$sql->upCusto($_POST);
	?>
	<script>
		window.location.href = "processo25.php?num_processo=<?=$num_processo; ?>";
	</script>
	<?php
}
$is = (!empty($p['valor_mercadoria']))?$p['valor_mercadoria']:'0';
?>
<style type="text/css">
	.processo25 .title{
		margin-top: 15px;
	}
</style>
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
	      				<div class="col-sm-3 processo25">
	      					<h4>IS:</h4>
	      					<h4 class="title">Dispersão:</h4>
	      					<h4 class="title">Falta / Saque:</h4>
	    					
	      					<h4 class="title" style="color: red;">Sub Total:</h4>

	      					<h4 class="title">Total Entregue</h4>

	      					<h4 class="title" style="color: green;">Total Recusado / Danos</h4>

	      					<h4 class="title">Aproveitamento Salvados:</h4>

	      					<h4 class="title" style="color: green;">Prejuizo Final (Mercadoria)</h4>

	      					<h4 class="title">Franquia/POS:</h4>
	      					
	      					<h4  class="title"style="color: red;"><strong>Prejuízo Final:</strong></h4>
	      				</div>
	      				<div class="col-sm-3">
	      					<?php 
	      					//atualizando dados
	      					if (!empty($getPrejCusto)) {
	      						$post = filter_input_array(INPUT_POST, FILTER_DEFAULT);
	      						//ATUALIZANDO
	      						if (!empty($post['dispersao'])) {
	      							$sql->upPrejCusto($num_processo, $post);
	      							?>
									<script>
										window.location.href = "processo25.php?num_processo=<?=$num_processo; ?>";
									</script>
									<?php
	      						}

	      						$subtotal = $is - $getPrejCusto['dispersao'] - $getPrejCusto['fsr'];
	      						$danos = $subtotal - $getPrejCusto['franquia'];
	      						$prejuizo = $danos - $getPrejCusto['aproveitamento_salvados'];
	      						$prejuizoFinal = $prejuizo - $getPrejCusto['pos'] + $getPrejCusto['dispersao'] + $getPrejCusto['fsr'];

	      						//sos e terceiro
	      						$sos = 0;
	      						$terceiro = 0;
								foreach ($getCusto as $key => $value) {
									if ($value['definicao'] == 0) {
										$sos += $value['valor']*$value['qt'];
									} else {
										$terceiro += $value['valor']*$value['qt'];
									}
								}

	      						?>
	      						<!-- IS -->
	      						<input type="text" value="<?=number_format($is, 2, '.', ''); ?>" class="form-control" readonly="">
	      						<!-- Dispersão -->
		      					<input type="text" value="<?=number_format($getPrejCusto['dispersao'], 2, '.', ''); ?>" name="dispersao" id="dispersao" class="form-control money">
		      					<!-- Falta e Saque -->
		      					<input type="text" value="<?=number_format($getPrejCusto['fsr'], 2, '.', ''); ?>" name="fsr" id="fsr" class="form-control money">

		      					<!-- SUB TOTAL -->
		      					<input type="text" style="color: red;" value="<?=number_format($subtotal, 2, '.', ''); ?>" class="form-control" placeholder="0,00" readonly="">
		      					
		      					<!-- Total Entregue / lugar de franquia -->
		      					<input type="text" value="<?=number_format($getPrejCusto['franquia'], 2, '.', ''); ?>" name="franquia" id="franquia" class="form-control money">

		      					<!-- Total Recusado / Danos -->
		      					<input type="text" style="color: green;" value="<?=number_format($danos, 2, '.',''); ?>" class="form-control" readonly="">

		      					<!-- APROVEITAMENTO DE SALVADOS -->
		      					<input type="text" value="<?=number_format($getPrejCusto['aproveitamento_salvados'], 2, '.',''); ?>" name="aproveitamento_salvados" name="aproveitamento_salvados" class="form-control money">

		      					<!-- PREJUIZO FINAL MERCADORIA - danos - salvados -->
		      					<input type="text" style="color: green;" value="<?=number_format($prejuizo, 2, '.', ''); ?>" class="form-control" readonly="">

		      					<!-- PREJUIZO FINAL MERCADORIA - danos - salvados -->
		      					<input type="text" value="<?=number_format($getPrejCusto['pos'], 2, '.', ''); ?>" name="pos" class="form-control money">

		      					<!-- PREJUIZO FINAL  Prejuizo Final (Mercadoria) + SOS Cia Seguradora: -->
		      					<input readonly="" style="color: red;" value="<?=number_format($prejuizoFinal, 2, '.', ''); ?>" class="form-control">

		      					<br>
	      						<?php
	      					} 


	      					//registrando dados
	      					else {
	      						$post = filter_input_array(INPUT_POST, FILTER_DEFAULT);
	      						//REGISTRANDO
	      						if (!empty($post['dispersao'])) {
	      							$sql->setPrejCusto($num_processo, $post);
	      							?>
									<script>
										window.location.href = "processo25.php?num_processo=<?=$num_processo; ?>";
									</script>
									<?php
	      						}

	      						$sos = 0;
	      						$terceiro = 0;
								foreach ($getCusto as $key => $value) {
									if ($value['definicao'] == 0) {
										$sos += $value['valor']*$value['qt'];
									} else {
										$terceiro += $value['valor']*$value['qt'];
									}
								}
	      						?>
	      						<!-- IS -->
	      						<input type="text" value="<?=number_format($is, 2, '.', ''); ?>" class="form-control" readonly="">
	      						<!-- Dispersão -->
		      					<input type="text" name="dispersao" id="dispersao" class="form-control money" placeholder="0,00">
		      					<!-- Falta e Saque -->
		      					<input type="text" name="fsr" id="fsr" class="form-control money" placeholder="0,00">

		      					<!-- SUB TOTAL -->
		      					<input type="text" style="color: red;" value="<?=number_format($is, 2, '.', ''); ?>" class="form-control money" placeholder="0,00" readonly="">
		      					
		      					<!-- Total Entregue / lugar de franquia -->
		      					<input type="text" name="franquia" id="franquia" class="form-control money" placeholder="0,00">

		      					<!-- Total Recusado / Danos -->
		      					<input type="text" style="color: green;" class="form-control money" readonly="" placeholder="0,00">

		      					<!-- APROVEITAMENTO DE SALVADOS -->
		      					<input type="text" name="aproveitamento_salvados" name="aproveitamento_salvados" class="form-control money" placeholder="0,00">

		      					<!-- PREJUIZO FINAL MERCADORIA - danos - salvados -->
		      					<input type="text" style="color: green;" class="form-control money" readonly="" placeholder="0,00">

		      					<!-- PREJUIZO FINAL MERCADORIA - danos - salvados -->
		      					<input type="text" name="pos" class="form-control money" placeholder="0,00">

		      					<!-- PREJUIZO FINAL  Prejuizo Final (Mercadoria) + SOS Cia Seguradora: -->
		      					<input readonly="" style="color: red;" id="res01" class="form-control" placeholder="0,00">
		      					<br>
	      						<?php
	      					}
	      					?>
	      					<button class="btn btn-success">Salvar</button>
	      				</div>
	      			</div>
		      	</form>

		      	<hr>
		      	<div class="row">
		      		<div class="col-sm-6">
		      			<label>SOS Cia Seguradora:</label>
		      			<input class="form-control" value="<?=number_format($sos, 2, '.', ''); ?>" readonly="">
		      		</div>
		      		<div class="col-sm-6">
		      			<label>SOS Terceiros ( Comprador ):</label>
		      			<input class="form-control" value="<?=number_format($terceiro, 2, '.', ''); ?>" readonly="">
		      		</div>
		      	</div>
		      	<hr>

		      	<h3>Estimativa de Custo (S.O.S)</h3>
		      	<?php
		      	//REGISTRANDO
		      	if (!empty($_POST['esforco'])) {
					$_POST['id_esforco'] = $_POST['esforco'];
					unset($_POST['esforco']);
					$_POST['num_processo'] = $num_processo;
					$_POST['id_user'] = $id_user;

					$sql->setCusto($_POST);
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
				        				echo '<option value="'.$dn['id'].'">'.$dn['nome'].'</option>';
				        			}
				        			?>
				        		</select>
				        		<label>Quantidade:</label>
				        		<input type="number" name="qt" class="form-control">
				        		<label>Valor Unitário:</label>
				        		<input type="text" name="valor" class="form-control money">
				        		<br>
				        		<input type="radio" name="definicao" value="0" id="value1"> 
				        		<label for="value1">SOS Cia Seguradora</label><br>
				        		<input type="radio" name="definicao" value="1" id="value2"> 
				        		<label for="value2">SOS Terceiros</label>
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
									<th>Definição</th>
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
										        					echo '<option selected value="'.$dn['id'].'">'.$dn['nome'].'</option>';
										        				} else {
										        					echo '<option value="'.$dn['id'].'">'.$dn['nome'].'</option>';
										        				}
										        				
										        			}
										        			?>
										        		</select>
										        		<label>Quantidade:</label>
										        		<input type="number" value="<?=$dnC['qt']; ?>" name="qtUP" class="form-control">
										        		<label>Valor Unitário:</label>
										        		<input type="text" name="valorUP" value="<?=number_format($dnC['valor'], 2, '.',''); ?>" class="form-control money">
										        		<br>
										        		<input type="radio" <?=($dnC['definicao'] == 0)?'checked=""':''; ?> name="definicaoUP" value="0" id="value1"> 
										        		<label for="value1">SOS Cia Seguradora</label><br>
										        		<input type="radio" <?=($dnC['definicao'] == 1)?'checked=""':''; ?> name="definicaoUP" value="1" id="value2"> 
										        		<label for="value2">SOS Terceiros</label>
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
										<?=htmlspecialchars($dnC['esforco']); ?>
									</td>
									<td><?=htmlspecialchars($dnC['qt']); ?></td>
									<td>R$<?=number_format($dnC['valor'], 2, '.',''); ?></td>
									<td>R$<?php 
									$sub = $dnC['valor']*$dnC['qt'];
									echo number_format($sub, 2, '.','') ?></td>
									<td><?=($dnC['definicao'] == 0)?'SOS Cia Seguradora':'SOS Terceiros'; ?></td>
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
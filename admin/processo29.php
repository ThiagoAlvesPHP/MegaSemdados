<?php
require 'header.php';
$sql = new Processos();
//SEGURADOS
$getCidades = $sql->getCidades();
$num_processo = addslashes($_GET['num_processo']);
$p = $sql->getProcesso($num_processo);

$nav_lancamento = $sql->nav_lancamento();
$nav_atividade = $sql->nav_atividade();

//REGISTRAR
if (!empty($_POST['operacao'])) {
	$operacao = addslashes($_POST['operacao']);
	$atividade1 = addslashes($_POST['atividade1']);
	$atividade2 = addslashes($_POST['atividade2']);
	$valor_receber = addslashes($_POST['valor_receber']);
	$valor_pagar = addslashes($_POST['valor_pagar']);
	$dt_pagamento = addslashes($_POST['dt_pagamento']);

	$sql->setLancamentos($num_processo, $operacao, $atividade1, $atividade2, $valor_receber, $valor_pagar, $dt_pagamento, $id_user);
		?>
	<script>
		window.location.href = "processo29.php?num_processo=<?=$num_processo; ?>";
	</script>
	<?php
}
//ATUALIZAR
if (!empty($_POST['operacaoUP'])) {
	$idL = addslashes($_POST['idL']);
	$operacao = addslashes($_POST['operacaoUP']);
	$atividade1 = addslashes($_POST['atividade1UP']);
	$atividade2 = addslashes($_POST['atividade2UP']);
	$valor_receber = addslashes($_POST['valor_receberUP']);
	$valor_pagar = addslashes($_POST['valor_pagarUP']);
	$dt_pagamento = addslashes($_POST['dt_pagamentoUP']);

	$sql->upLancamentos($idL, $operacao, $atividade1, $atividade2, $valor_receber, $valor_pagar, $dt_pagamento, $id_user);
		?>
	<script>
		window.location.href = "processo29.php?num_processo=<?=$num_processo; ?>";
	</script>
	<?php
}

//DELETAR
if (isset($_GET['id']) && !empty($_GET['id'])) {
	$sql->delLancamento(addslashes($_GET['id']));
	?>
	<script>
		alert("Deletado com Sucesso!");
		window.location.href = "processo29.php?num_processo=<?=$num_processo; ?>";
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
	      	<h3>Lançamentos (Débitos e Créditos)</h3>
	      	<div class="well">
	      			<button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">+</button>
					<!-- Modal -->
					<div id="myModal" class="modal fade" role="dialog">
					  <div class="modal-dialog">

					    <!-- Modal content-->
					    <div class="modal-content">
					      <div class="modal-header">
					        <button type="button" class="close" data-dismiss="modal">&times;</button>
					        <h4 class="modal-title">Informar Lançamento</h4>
					      </div>
					      <div class="modal-body">
					        <p>
					        	<form method="POST">
						        	<div class="row">
						        		<div class="col-sm-6">
						        			<label>Débito ou Crédito:</label>
						        			<select name="operacao" class="form-control">
						        			<?php 
						        			foreach ($nav_lancamento as $l) {
						        				echo '<option value="'.$l['id'].'">'.$l['nome'].'</option>';
						        			}
						        			?>
						        			</select>
						        		</div>
						        		<div class="col-sm-6">
						        			<label>Atividade:</label>
						        			<select name="atividade1" class="form-control">
						        			<?php 
						        			foreach ($nav_atividade as $l) {
						        				echo '<option value="'.$l['id'].'">'.$l['nome'].'</option>';
						        			}
						        			?>
						        			</select>
						        		</div>
						        	</div>
						        	<label>Atividade:</label>
						        	<textarea name="atividade2" class="form-control"></textarea>
						        	<label>Valor à Receber:</label>
						        	<input type="text" name="valor_receber" class="form-control money">
						        	<label>Valor à Pagar:</label>
						        	<input type="text" name="valor_pagar" class="form-control money">
						        	<label>Data do Pgto/Progr.:</label>
						        	<input type="date" name="dt_pagamento" class="form-control">
						        <br>
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
					<hr>
					<div class="table-responsive">
						<table style="font-size: 12px;" class="table">
							<thead>
								<tr>
									<th>Ação</th>
									<th>Operação</th>
									<th>Atividade</th>
									<th>Detalhes</th>
									<th>Valor à Faturar</th>
									<th>Valor à Pagar</th>
									<th>Data/Prog</th>
									<th>Lançado em</th>
									<th>Lançado por</th>
								</tr>
							</thead>
							<?php 
							$lanc = $sql->getLancamentos($num_processo);
							foreach ($lanc as $l) {
								?>
							<tbody>
								<tr>
									<td>
										<a href="" class="fa fa-edit" data-toggle="modal" data-target="#<?=$l['id']; ?>"></a>
										<a href="processo29.php?num_processo=<?=$num_processo ?>&id=<?=$l['id']; ?>" class="fas fa-trash-alt"></a>


		<!-- Modal -->
		<div id="<?=$l['id']; ?>" class="modal fade" role="dialog">
		  <div class="modal-dialog">
		    <!-- Modal content-->
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		        <h4 class="modal-title">Informar Lançamento</h4>
		      </div>
		      <div class="modal-body">
		        <p>
		        	<form method="POST">
		        		<input type="text" hidden="" name="idL" value="<?=$l['id']; ?>">
		        		<div class="row">
			        		<div class="col-sm-6">
			        			<label>Débito ou Crédito:</label>
			        			<select name="operacaoUP" class="form-control">
			        			<?php 
			        			foreach ($nav_lancamento as $la) {
			        				if ($l['operacao'] == $la['id']) {
			        					echo '<option selected value="'.$la['id'].'">'.$la['nome'].'</option>';
			        				} else {
			        					echo '<option value="'.$la['id'].'">'.$la['nome'].'</option>';
			        				}
			        			}
			        			?>
			        			</select>
			        		</div>
			        		<div class="col-sm-6">
			        			<label>Atividade:</label>
			        			<select name="atividade1UP" class="form-control">
			        			<?php 
			        			foreach ($nav_atividade as $la) {
			        				if ($l['atividade1'] == $la['id']) {
			        					echo '<option selected value="'.$la['id'].'">'.$la['nome'].'</option>';
			        				} else {
			        					echo '<option value="'.$la['id'].'">'.$la['nome'].'</option>';
			        				}
			        			}
			        			?>
			        			</select>
			        		</div>
			        	</div>
			        	<label>Atividade:</label>
			        	<textarea name="atividade2UP" class="form-control"><?=htmlspecialchars($l['atividade2']); ?></textarea>
			        	<label>Valor à Receber:</label>
			        	<input type="text" value="<?=number_format($l['valor_receber'], 2,'.','') ?>" name="valor_receberUP" class="form-control money">
			        	<label>Valor à Pagar:</label>
			        	<input type="text" value="<?=number_format($l['valor_pagar'], 2,'.','') ?>" name="valor_pagarUP" class="form-control money">
			        	<label>Data do Pgto/Progr.:</label>
			        	<input type="date" value="<?=$l['dt_pagamento']; ?>" name="dt_pagamentoUP" class="form-control">
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
					


									</td>
									<td><?=$l['n']; ?></td>
									<td><?=$l['name']; ?></td>
									<td><?=htmlspecialchars($l['atividade2']); ?></td>
									<td>R$<?=number_format($l['valor_receber'], 2,'.','') ?></td>
									<td>R$<?=number_format($l['valor_pagar'], 2,'.','') ?></td>
									<td><?=date('d/m/Y', strtotime($l['dt_pagamento'])); ?></td>
									<td><?=date('d/m/Y H:i:s', strtotime($l['dt_cadastro'])); ?></td>
									<td><?=htmlspecialchars($l['func']) ?></td>
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
							<a href="processo28.php?num_processo=<?=$num_processo; ?>" class="btn btn-danger">Voltar</a>	
							<a href="processo30.php?num_processo=<?=$num_processo; ?>" class="btn btn-primary">Proximo</a>	
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
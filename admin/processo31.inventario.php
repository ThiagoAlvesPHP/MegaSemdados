<?php
require 'header.php';
$sql = new Processos();

$num_processo = addslashes($_GET['num_processo']);
$id_inventario = addslashes($_GET['id_inventario']);
$p = $sql->getProcesso($num_processo);

$getCidades = $sql->getCidades();
$segurado = $sql->getSeguradoid($p['id_segurado']);
$dbAc = $sql->getDadosAcontecimento($num_processo);
$get_evento = $sql->getEventosP();
$Inventario = $sql->getInventarioID($id_inventario);
$invID = $sql->getInventario2ID($id_inventario);
$getMedidaP = $sql->getMedidaP();

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
	      			<label>Data de Emissão:</label>
	      			<input type="date" class="form-control" value="<?=date('Y-m-d', strtotime($Inventario['dt_criacao'])); ?>" readonly="">
	      		</div>
	      	</div>
	      	<hr>
	      	<h3>Inventário de Salvados</h3>
	      	<div class="well">
	      		<?php
	      		if (!empty($invID)) {
	      			//AUALIZAR
	      			if (!empty($_POST['v1'])) {
						$v1 = addslashes($_POST['v1']);
						$v2 = addslashes($_POST['v2']);
						$v3 = addslashes($_POST['v3']);
						$v4 = addslashes($_POST['v4']);
						$v5 = addslashes($_POST['v5']);
						$v6 = addslashes($_POST['v6']);
						$v7 = addslashes($_POST['v7']);
						$v8 = addslashes($_POST['v8']);
						$v9 = addslashes($_POST['v9']);
						$city1 = addslashes($_POST['cidade1']);
						$v11 = addslashes($_POST['v11']);
						$v12 = addslashes($_POST['v12']);
						$v13 = addslashes($_POST['v13']);

						$v14 = str_replace(',', '.', str_replace('.', '', addslashes($_POST['v14'])));

						$v15 = addslashes($_POST['v15']);
						$v16 = addslashes($_POST['v16']);

						$v17 = str_replace(',', '.', str_replace('.', '', addslashes($_POST['v17'])));

						$v18 = addslashes($_POST['v18']);
						$v19 = addslashes($_POST['v19']);

						$sql->upInventario2($num_processo, $id_inventario, $v1, $v2, $v3, $v4, $v5, $v6, $v7, $v8, $v9, $city1, $v11, $v12, $v13, $v14, $v15, $v16, $v17, $v18, $v19, $id_user);
						?>
						<script>
							window.location.href = "processo31.inventario.php?num_processo=<?=$num_processo; ?>&id_inventario=<?=$id_inventario; ?>";
						</script>
						<?php
					}
	      			?>
	      		<form method="POST">
      				<div class="row">
      					<div class="col-sm-3">
      						<label>Notas Fiscais Nº:</label>
      						<input type="text" value="<?=$invID['v1']; ?>" class="form-control" name="v1">
      					</div>
      					<div class="col-sm-3">
      						<label>Data de Emissão:</label>
      						<input type="date" value="<?=$invID['v2']; ?>" class="form-control" name="v2">
      					</div>
      					<div class="col-sm-3">
      						<label>DACTE / CTRC:</label>
      						<input type="text" value="<?=$invID['v3']; ?>" class="form-control" name="v3">
      					</div>
      					<div class="col-sm-3">
      						<label>Data de Emissão:</label>
      						<input type="date" value="<?=$invID['v4']; ?>" class="form-control" name="v4">
      					</div>
      				</div>
      				<label>Local Armazenado:</label>
      				<input type="text" value="<?=$invID['v5']; ?>" class="form-control" name="v5">
      				<div class="row">
      					<div class="col-sm-3">
      						<label>Dados da Empresa:</label>
      						<input type="text" value="<?=$invID['v6']; ?>" class="form-control" name="v6">
      					</div>
      					<div class="col-sm-3">
      						<label>Endereço:</label>
      						<input type="text" value="<?=$invID['v7']; ?>" class="form-control" name="v7">
      					</div>
      					<div class="col-sm-3">
      						<label>Bairro:</label>
      						<input type="text" value="<?=$invID['v8']; ?>" class="form-control" name="v8">
      					</div>
      					<div class="col-sm-3">
      						<label>CEP:</label>
      						<input type="text" value="<?=$invID['v9']; ?>" class="form-control cep" name="v9">
      					</div>
      				</div>

      				<label>UF/Cidade:</label>
  					<input type="text" name="city1" id="city1" class="form-control" placeholder="Digite o nome da cidade">
  					<br>
		      		<select name="cidade1" multiple class="form-control" id="cidades1">
		      			<?php
		      			if (!empty($invID['city1'])) {
		      				$d  = $sql->getCidadeID($invID['city1']);

		      				echo '<option selected value="'.$d['id'].'">'.$d['nome'].' - '.$d['uf'].' - '.$d['sigla'].'</option>';
		      			} else {
		      				foreach ($getCidades as $value) {
			      				echo '<option value="'.$value['id'].'">'.$value['nome'].' - '.$value['uf'].' - '.$value['sigla'].'</option>';
			      			}
		      			}
		      			?>
				    </select>

				    <div class="row">
      					<div class="col-sm-4">
      						<label>Telefone:</label>
      						<input type="text" value="<?=$invID['v11']; ?>" class="form-control" name="v11">
      					</div>
      					<div class="col-sm-4">
      						<label>Contato:</label>
      						<input type="text" value="<?=$invID['v12']; ?>" class="form-control" name="v12">
      					</div>
      					<div class="col-sm-4">
      						<label>E-mail:</label>
      						<input type="email" value="<?=$invID['v13']; ?>" class="form-control" name="v13">
      					</div>
      				</div>
      				<div class="row">
      					<div class="col-sm-4">
      						<label>Prazo de Armazenamento sem Custo:</label>
      						<input type="text" value="<?=$invID['v19']; ?>" class="form-control" name="v19">
      					</div>
      					<div class="col-sm-4">
      						<label>Custo de Armazenagem:</label>
      						<input type="text" value="<?=number_format($invID['v14'], 2, '.', ','); ?>"  class="form-control money3" name="v14">
      					</div>
      					<div class="col-sm-4">
      						<label>Período:</label>
      						<input type="text" value="<?=$invID['v15']; ?>" class="form-control" name="v15">
      					</div>
      				</div>
      				<div class="row">
      					<div class="col-sm-6">
      						<label>Adicionais:</label>
      						<input type="text" value="<?=$invID['v16']; ?>" class="form-control" name="v16">
      					</div>
      					<div class="col-sm-6">
      						<label>Valor de Mercado:</label>
      						<input type="text" value="<?=number_format($invID['v17'], 2, '.', ','); ?>" class="form-control money3" name="v17">
      					</div>
      				</div>
      				<h3>Observações Adicionais:</h3>
      				<textarea style="height: 200px;" name="v18" class="form-control"><?=$invID['v18']; ?></textarea>
      				<br>
      				<button class="btn btn-primary">Salvar</button>
      			</form>









	      			<?php
	      		} else {
	      			//REGISTRAR
	      			if (!empty($_POST['v1'])) {
						$v1 = addslashes($_POST['v1']);
						$v2 = addslashes($_POST['v2']);
						$v3 = addslashes($_POST['v3']);
						$v4 = addslashes($_POST['v4']);
						$v5 = addslashes($_POST['v5']);
						$v6 = addslashes($_POST['v6']);
						$v7 = addslashes($_POST['v7']);
						$v8 = addslashes($_POST['v8']);
						$v9 = addslashes($_POST['v9']);
						$city1 = addslashes($_POST['cidade1']);
						$v11 = addslashes($_POST['v11']);
						$v12 = addslashes($_POST['v12']);
						$v13 = addslashes($_POST['v13']);

						$v14 = str_replace(',', '.', str_replace('.', '', addslashes($_POST['v14'])));

						$v15 = addslashes($_POST['v15']);
						$v16 = addslashes($_POST['v16']);

						$v17 = str_replace(',', '.', str_replace('.', '', addslashes($_POST['v17'])));

						$v18 = addslashes($_POST['v18']);
						$v19 = addslashes($_POST['v19']);

						$sql->setInventario2($num_processo, $id_inventario, $v1, $v2, $v3, $v4, $v5, $v6, $v7, $v8, $v9, $city1, $v11, $v12, $v13, $v14, $v15, $v16, $v17, $v18, $v19, $id_user);
						?>
						<script>
							window.location.href = "processo31.inventario.php?num_processo=<?=$num_processo; ?>&id_inventario=<?=$id_inventario; ?>";
						</script>
						<?php
					}
	      			?>

	      		<form method="POST">
      				<div class="row">
      					<div class="col-sm-3">
      						<label>Notas Fiscais Nº:</label>
      						<input type="text" class="form-control" name="v1">
      					</div>
      					<div class="col-sm-3">
      						<label>Data de Emissão:</label>
      						<input type="date" class="form-control" name="v2">
      					</div>
      					<div class="col-sm-3">
      						<label>DACTE / CTRC:</label>
      						<input type="text" class="form-control" name="v3">
      					</div>
      					<div class="col-sm-3">
      						<label>Data de Emissão:</label>
      						<input type="date" class="form-control" name="v4">
      					</div>
      				</div>
      				<label>Local Armazenado:</label>
      				<input type="text" class="form-control" name="v5">
      				<div class="row">
      					<div class="col-sm-3">
      						<label>Dados da Empresa:</label>
      						<input type="text" class="form-control" name="v6">
      					</div>
      					<div class="col-sm-3">
      						<label>Endereço:</label>
      						<input type="text" class="form-control" name="v7">
      					</div>
      					<div class="col-sm-3">
      						<label>Bairro:</label>
      						<input type="text" class="form-control" name="v8">
      					</div>
      					<div class="col-sm-3">
      						<label>CEP:</label>
      						<input type="text" class="form-control cep" name="v9">
      					</div>
      				</div>

      				<label>UF/Cidade:</label>
  					<input type="text" name="city1" id="city1" class="form-control" placeholder="Digite o nome da cidade">
  					<br>
		      		<select name="cidade1" multiple class="form-control" id="cidades1">
		      			<?php
		      			foreach ($getCidades as $value) {
		      				echo '<option value="'.$value['id'].'">'.$value['nome'].' - '.$value['uf'].' - '.$value['sigla'].'</option>';
		      			}
		      			?>
				    </select>

				    <div class="row">
      					<div class="col-sm-4">
      						<label>Telefone:</label>
      						<input type="text" class="form-control" name="v11">
      					</div>
      					<div class="col-sm-4">
      						<label>Contato:</label>
      						<input type="text" class="form-control" name="v12">
      					</div>
      					<div class="col-sm-4">
      						<label>E-mail:</label>
      						<input type="email" class="form-control" name="v13">
      					</div>
      				</div>
      				<div class="row">
      					<div class="col-sm-4">
      						<label>Prazo de Armazenamento sem Custo:</label>
      						<input type="text" class="form-control" name="v19">
      					</div>
      					<div class="col-sm-4">
      						<label>Custo de Armazenagem:</label>
      						<input type="text" class="form-control money3" name="v14">
      					</div>
      					<div class="col-sm-4">
      						<label>Período:</label>
      						<input type="text" class="form-control" name="v15">
      					</div>
      				</div>
      				<div class="row">
      					<div class="col-sm-6">
      						<label>Adicionais:</label>
      						<input type="text" class="form-control" name="v16">
      					</div>
      					<div class="col-sm-6">
      						<label>Valor de Mercado:</label>
      						<input type="text" class="form-control money3" name="v17">
      					</div>
      				</div>
      				<h3>Observações Aidcionais:</h3>
      				<textarea style="height: 200px;" name="v18" class="form-control"></textarea>
      				<br>
      				<button class="btn btn-primary">Salvar</button>
      			</form>
	      			<?php
	      		}

	      		//REGISTRANDO
	      		if (!empty($_POST['d1'])) {
	      			$d1 = addslashes($_POST['d1']);
	      			$d2 = addslashes($_POST['d2']);
	      			$d3 = addslashes($_POST['d3']);
	      			$d4 = str_replace(',', '.', str_replace('.', '', addslashes($_POST['d4'])));
	      			$d5 = str_replace(',', '.', str_replace('.', '', addslashes($_POST['d5'])));

	      			$d6 = addslashes($_POST['d6']);
	      			$d7 = $d4 * $d5;

	      			$d8 = str_replace(',', '.', str_replace('.', '', addslashes($_POST['d8'])));


	      			$sql->setInventario3($num_processo, $id_inventario, $d1, $d2, $d3, $d4, $d5, $d6, $d7, $d8, $id_user);
					?>
					<script>
						window.location.href = "processo31.inventario.php?num_processo=<?=$num_processo; ?>&id_inventario=<?=$id_inventario; ?>";
					</script>
					<?php
	      		}

	      		//DELETANDO DESCRIÇAO DE LOTE
				if (isset($_GET['id'])) {
					$sql->delInventario3(addslashes($_GET['id']));
					?>
					<script>
						alert("Deletado com sucesso!");
						window.location.href = "processo31.inventario.php?num_processo=<?=$num_processo; ?>&id_inventario=<?=$id_inventario; ?>";
					</script>
					<?php
				}

				//ATUALIZANDO
	      		if (!empty($_POST['d1UP'])) {
	      			$d1 = addslashes($_POST['d1UP']);
	      			$d2 = addslashes($_POST['d2UP']);
	      			$d3 = addslashes($_POST['d3UP']);
	      			$d4 = str_replace(',', '.', str_replace('.', '', addslashes($_POST['d4UP'])));

	      			$d5 = str_replace(',', '.', str_replace('.', '', addslashes($_POST['d5UP'])));

	      			$d6 = addslashes($_POST['d6UP']);
	      			$d7 = $d4 * $d5;
	      			$d8 = str_replace(',', '.', str_replace('.', '', addslashes($_POST['d8UP'])));
	      			$idUP = addslashes($_POST['idUP']);

	      			$sql->upInventario3($idUP, $d1, $d2, $d3, $d4, $d5, $d6, $d7, $d8);
					?>
					<script>
						window.location.href = "processo31.inventario.php?num_processo=<?=$num_processo; ?>&id_inventario=<?=$id_inventario; ?>";
					</script>
					<?php
	      		}

	      		$list = $sql->getInventario3($id_inventario);
	      		?>
      			<hr>
      			
      			<label>Descrição do Lote</label><br>
      			<!-- Modal -->
      			<button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">+</button>
				<div id="myModal" class="modal fade" role="dialog">
				  <div class="modal-dialog modal-lg">
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal">&times;</button>
				        <h4 class="modal-title">Descrição do Lote</h4>
				      </div>
				      <div class="modal-body">
				        <p>
				        	<form method="POST">
				        		<div class="row">
				        			<div class="col-sm-4">
				        				<label>Nota Fiscal N.:</label>
				        				<input type="text" class="form-control" name="d1">
				        			</div>
				        			<div class="col-sm-4">
				        				<label>Mercadoria:</label>
				        				<input type="text" class="form-control" name="d2">
				        			</div>
				        			<div class="col-sm-4">
				        				<label>Unidade de Medida:</label>
				        				<select class="form-control" name="d3">
				        					<?php
											foreach ($getMedidaP as $m) {
												echo '<option value="'.$m['id'].'">'.$m['nome'].'</option>';
											}
											?>
				        				</select>
				        			</div>
				        		</div>
				        		<div class="row">
				        			<div class="col-sm-4">
				        				<label>Quantidade:</label>
				        				<input type="text" id="qtIn" class="form-control money3" name="d4">
				        			</div>
				        			<div class="col-sm-4">
				        				<label>Valor Unitário:</label>
				        				<input type="text" id="valueIn" class="form-control money5" name="d5">
				        			</div>
				        			<div class="col-sm-4">
				        				<label>% de Venda:</label>
				        				<input type="text" class="form-control money" name="d6">
				        			</div>
				        		</div>
				        		<div class="row">
				        			<div class="col-sm-6">
				        				<label>Valor Total:</label>
				        				<input type="text" id="totIn" readonly="" class="form-control money3">
				        			</div>
				        			<div class="col-sm-6">
				        				<label>Estimativa de Venda:</label>
				        				<input type="text" class="form-control money3" name="d8">
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
				<!-- Fim Modal -->

				<hr>
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th>Ação</th>
								<th>Nota Fiscal</th>
								<th>Mercadoria</th>
								<th>Unid Medida</th>
								<th>Qt</th>
								<th>Valor Unit</th>
								<th>Total</th>
								<th>% de Venda</th>
								<th>Estimativa de Venda</th>
								<th>Criado em</th>
								<th>Criado por</th>
							</tr>
						</thead>
						<?php
						foreach ($list as $l) {
							?>
						<tbody>
							<tr>
								<td>
									<a href="" class="fa fa-edit" data-toggle="modal" data-target="#<?=$l['id']; ?>" title="Editar"></a>
									<a href="processo31.inventario.php?num_processo=<?=$num_processo ?>&id_inventario=<?=$id_inventario; ?>&id=<?=$l['id']; ?>" class="fas fa-trash-alt" title="Deletar"></a>
				<!-- Modal -->
					<div id="<?=$l['id']; ?>" class="modal fade" role="dialog">
				  <div class="modal-dialog modal-lg">
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal">&times;</button>
				        <h4 class="modal-title">Descrição do Lote</h4>
				      </div>
				      <div class="modal-body">
				        <p>
				        	<form method="POST">
				        		<input type="text" name="idUP" hidden="" value="<?=$l['id']; ?>">
				        		<div class="row">
				        			<div class="col-sm-4">
				        				<label>Nota Fiscal N.:</label>
				        				<input type="text" value="<?=$l['d1']; ?>" class="form-control" name="d1UP">
				        			</div>
				        			<div class="col-sm-4">
				        				<label>Mercadoria:</label>
				        				<input type="text" value="<?=$l['d2']; ?>" class="form-control" name="d2UP">
				        			</div>
				        			<div class="col-sm-4">
				        				<label>Unidade de Medida:</label>
				        				<select class="form-control" name="d3UP">
				        					<?php
											foreach ($getMedidaP as $m) {
												if ($l['d3'] == $m['id']) {
													echo '<option selected value="'.$m['id'].'">'.$m['nome'].'</option>';
												} else {
													echo '<option value="'.$m['id'].'">'.$m['nome'].'</option>';
												}
											}
											?>
				        				</select>
				        			</div>
				        		</div>
				        		<div class="row">
				        			<div class="col-sm-4">
				        				<label>Quantidade:</label>
				        				<input type="text" id="qtInUp" value="<?=number_format($l['d4'], 2, ',', '.'); ?>" class="form-control money3" name="d4UP">
				        			</div>
				        			<div class="col-sm-4">
				        				<label>Valor Unitário:</label>
				        				<input type="text" id="valueInUp" value="<?=number_format($l['d5'], 5, '.', ''); ?>"" class="form-control money5" name="d5UP">
				        			</div>
				        			<div class="col-sm-4">
				        				<label>% de Venda:</label>
				        				<input type="text" value="<?=number_format($l['d6'], 2, '.', ''); ?>" class="form-control money" name="d6UP">
				        			</div>
				        		</div>
				        		<div class="row">
				        			<div class="col-sm-6">
				        				<label>Valor Total::</label>
				        				<input type="text" id="totInUp" value="<?=number_format($l['d7'], 2, '.', ''); ?>" readonly="" class="form-control money3">
				        			</div>
				        			<div class="col-sm-6">
				        				<label>Estimativa de Venda:</label>
				        				<input type="text" value="<?=number_format($l['d8'], 2, '.', ''); ?>" class="form-control money3" name="d8UP">
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
				<!-- Fim Modal -->

								</td>
								<td><?=$l['d1']; ?></td>
								<td><?=$l['d2']; ?></td>
								<td><?=$l['uni']; ?></td>
								<td><?=$l['d4']; ?></td>
								<td>R$<?=number_format($l['d5'], 2, ',', '.'); ?></td>
								<td>R$<?=number_format($l['d7'], 2, ',', '.'); ?></td>
								<td><?=number_format($l['d6'], 2, '.', ''); ?></td>
								<td>R$<?=number_format($l['d8'], 2, ',', '.'); ?></td>
								<td><?=date('d/m/Y H:i:s', strtotime($l['dt_criacao'])); ?></td>
								<td><?=$l['nome']; ?></td>
							</tr>
						</tbody>
							<?php
						}
						?>
					</table>
				</div>


      			<br>
	      	</div>
	      </div>
	    </div>
	</div>
	<div class="col-sm-1"></div>
</div>

<?php
require 'footer.php';
?>
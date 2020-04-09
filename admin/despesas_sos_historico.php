<?php
require 'header.php';
$nav = new Navegacao();

if (!empty($_GET['num_processo'])) {
	$ajax = new Ajax();
	$r = new Rdp();

	$dados = $ajax->getProc(addslashes($_GET['num_processo']));
	$sos = $r->getSosAll(addslashes($_GET['num_processo']));

	$post = filter_input_array(INPUT_POST, FILTER_DEFAULT);

	if (!empty($post['id'])) {

		$r->upSOS($post);
		echo '<script>alert("Registrado com sucesso!");window.location.href="despesas_sos_historico.php?num_processo='.$_GET['num_processo'].'"</script>';
	}

	if (!empty($_GET['del'])) {
		$r->delSOS(addslashes($_GET['del']));
		echo '<script>alert("Deletado com sucesso!");window.location.href="despesas_sos_historico.php?num_processo='.$_GET['num_processo'].'"</script>';
	}

	$total = 0;
}

?>
<div class="container-fluid conteudo">	
	<div class="row">
		<div class="col-sm-1"></div>
		<div class="col-sm-10">
		
			<h3>Despesas SOS do Relatório Geral - Histórico</h3>
			<hr>

			<div class="well">
				<input class="form-control Processo seach_sos_historico" placeholder="Pesquisar Processo">
				<hr>
				<div class="resposta"></div>
			</div>

			<div class="well">
				<?php if(!empty($_GET['num_processo'])): ?>
					<div class="row">
						<div class="col-sm-11"></div>
						<div class="col-sm-1">
							<h1>
								<a href="sos_print.php?num_processo=<?=$_GET['num_processo']; ?>" title="Imprimir" target="_blank" class="fas fa-print"></a>
							</h1>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-6">
							<label>Processo Mega Nrº</label>
							<input type="text" name="" class="form-control" value="<?=$dados['num_processo']; ?>" readonly="">
						</div>
						<div class="col-sm-6">
							<label>Processo Allianz Nrº</label>
							<input type="text" name="" class="form-control" value="<?=$dados['num_sinistro']; ?>" readonly="">
						</div>
					</div>	
					<div class="row">
						<div class="col-sm-4">
							<label>Seguradora:</label>
							<input type="text" name="" class="form-control" value="<?=utf8_decode($dados['seguradora']); ?>" readonly="">
						</div>
						<div class="col-sm-4">
							<label>Segurado:</label>
							<input type="text" name="" class="form-control" value="<?=utf8_decode($dados['segurado']); ?>" readonly="">
						</div>
						<div class="col-sm-4">
							<label>Transportador</label>
							<input type="text" name="" class="form-control" value="<?=utf8_decode($dados['transportadora']); ?>" readonly="">
						</div>
					</div>
					<hr>

					<!-- INICIO DE TABELA -->
					<div class="table table-responsive">
						<table id="quadro01" class="table table-hover display" style="width:100%">
						    <thead>
						        <tr>
						            <th>Ação</th>
						            <th>Data</th>
						            <th>Descrição</th>
						            <th>Registrado por</th>
						            <th>Valor</th>
						        </tr>
						    </thead>
						    <?php 
						    	foreach ($sos as $value): 
						    	$total += $value['valor']; 
						    ?>
						    <tbody>
						    	<tr>
						    		<td>	
						    			<a class="far fa-edit" data-toggle="modal" data-target="#edit<?=$value['id']; ?>"></a>
						    			<!-- MODAl -->
						    			<div id="edit<?=$value['id']; ?>" class="modal fade" role="dialog">
										  <div class="modal-dialog">
										    <div class="modal-content">
										      <div class="modal-header">
										        <button type="button" class="close" data-dismiss="modal">&times;</button>
										        <h4 class="modal-title">Despesas SOS do Relatório Geral</h4>
										      </div>
										      <div class="modal-body">
										      	
										        <p>
										        	<form method="POST">
										        		<input type="hidden" name="id" value="<?=$value['id']; ?>">
														
														<label>Descrição</label><input type="text" name="descricao" class="form-control" value="<?=$value['descricao']; ?>" required="" autocomplete="off">
														<label>Valor</label><input type="text" name="valor" class="form-control money" required="" value="<?=$value['valor']; ?>" autocomplete="off">
														<br>
														<button class="btn btn-success">Editar</button>
													</form>
										        </p>
										      </div>
										      <div class="modal-footer">
										        <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
										      </div>
										    </div>
										  </div>
										</div>

										<a href="despesas_sos_historico.php?num_processo=<?=$_GET['num_processo'].'&del='.$value['id']; ?>" style="color: red;" class="far fa-trash-alt"></a>
						    		</td>
						    		<td><?=date('d/m/Y', strtotime($value['dt_cadastro'])); ?></td>
						    		<td><?=$value['descricao']; ?></td>
						    		<td><?=$value['nome']; ?></td>
						    		<td>R$<?=number_format($value['valor'],2,',','.'); ?></td>
						    	</tr>
						    </tbody>
						    <?php endforeach; ?>
						</table>
					</div>	
					<!-- FIM DE TABELA -->
					<!-- TOTAL -->
					<div class="table table-responsive">
						<table class="table table-hover" style="font-size: 20px;">
						    <thead>
						        <tr>
						            <th>Total Geral</th>
						            <th width="100">R$<?=number_format($total, 2, ',', '.'); ?></th>
						        </tr>
						    </thead>
						</table>
					</div>
					<!-- FIM TOTAL -->
					
				<?php endif; ?>	

			</div>

		</div>
		<div class="col-sm-1"></div>
	</div>
</div>

<?php require 'footer.php'; ?>
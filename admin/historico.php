<?php
require 'header.php';
$contas = new Financeiro();
$nav = new Navegacao();
$form_pag = $nav->getFormPag();
//se type não estiver preenchido
if (!isset($_GET['type']) && empty($_GET['type'])) {
	echo '<script>alert("Tipo de conta não selecionado!");window.location.href = "index.php"</script>';
}
//capturando dados via post
$post = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$get = filter_input_array(INPUT_GET, FILTER_DEFAULT);
//verificar se type é pagar ou receber e preencher variavel
if ($get['type'] == 'receber') {
	$type_register = 2;
} else {
	$type_register = 1;
}
//verificar se get mes existe e fazer consulta em db conforme a existencia
if (isset($get['mes'])) {
	$dados = $contas->getContas($type_register, addslashes($get['mes']), addslashes($get['ano']));
} else {
	$dados = $contas->getContas($type_register);
}
//deletar conta
if (isset($get['id']) && !empty($get['id'])) {
	$contas->delConta($get['id']);
	echo '<script>alert("Deletado com sucesso!");window.location.href = "historico.php?type='.$get['type'].'"</script>';
}


?>
<div class="container-fluid conteudo">	
	<div class="row">
		<div class="col-sm-1"></div>
		<div class="col-sm-10">
		<?php if($_GET['type'] == 'pagar'): ?>
			<div class="panel panel-primary">
			  <div class="panel-heading">
			  	<h3>Contas a Pagar</h3>
			  </div>
			  <div class="panel-body">
			  	<!-- FORMULARIO DE CONSULTA -->
			  	<form method="GET">
			  		<input type="text" name="type" value="pagar" hidden="">
			  		<div class="row">
			  			<div class="col-sm-4">
					  		<select class="form-control" name="mes">
					  			<?php
	                  for ($i=1; $i < 13; $i++) { 
	                      $dt = date('Y-'.$i);
	                      if ($i == date('m')) {
	                      	if (utf8_decode(strftime("%B", strtotime($dt))) == 'mar?o') {
		                          echo '<option selected="" value="'.$i.'">'.ucfirst(strftime("Março", strtotime($dt))).'</option>';
		                      } else {
		                          echo '<option selected="" value="'.$i.'">'.ucfirst(strftime("%B", strtotime($dt))).'</option>';
		                      }
	                      } else {
	                      	if (utf8_decode(strftime("%B", strtotime($dt))) == 'mar?o') {
		                          echo '<option value="'.$i.'">'.ucfirst(strftime("Março", strtotime($dt))).'</option>';
		                      } else {
		                          echo '<option value="'.$i.'">'.ucfirst(strftime("%B", strtotime($dt))).'</option>';
		                      }
	                      }
	                  }
                  ?>
					  		</select>
			  			</div>
			  			<div class="col-sm-4">
					  		<select name="ano" class="form-control">
					  			<?php for ($i=2020; $i <= 2030; $i++): ?>
					  				<?php if($i == date('Y')): ?>
					  					<option selected=""><?=$i; ?></option>
					  				<?php else: ?>
					  					<option><?=$i; ?></option>
					  				<?php endif; ?>
					  			<?php endfor; ?>
					  		</select>
			  			</div>
			  			<div class="col-sm-4">
			  				<button class="btn btn-primary btn-block">Consultar</button>
			  			</div>
			  		</div>
			  	</form>
			  	<hr>
			  	<!-- tabela de exibição de contas -->
			  	<?php if(isset($_GET['mes'])): ?>
			  		<div class="table table-responsive">
				  		<table class="table table-hover">
				  			<thead>
				  				<tr>
				  					<th>Fornecedor</th>
				  					<th>Descrição</th>
				  					<th>Valor</th>
				  					<th>Forma de pagamento</th>
				  					<th>Vencimento</th>
				  					<th>Registrado por</th>
				  					<th>Registrado em</th>
				  					<th>Ação</th>
				  				</tr>
				  			</thead>
				  			<?php if(!empty($dados)): ?>
				  				<?php foreach($dados as $c): 
				  					$user = $n->getFuncionario($c['id_user']);
				  					?>
				  					<tbody>
						  				<tr>
						  					<td>
						  						<?=htmlspecialchars($c['fornecedor']); ?>
						  					</td>
						  					<td>
						  						<?=htmlspecialchars($c['descricao']); ?>
						  					</td>
						  					<td>
						  						R$<?=number_format($c['valor'], 2, ',', '.'); ?>
						  					</td>
						  					<td>
						  						<?php foreach($form_pag as $f): ?>
						  							<?php if($c['form_pag'] == $f['id']): ?>
						  								<?php echo $f['descricao']; ?>
						  							<?php endif; ?>
						  						<?php endforeach; ?>
						  					</td>
						  					<td>
						  						<?=date('d/m/Y', strtotime($c['vencimento'])); ?>
						  					</td>
						  					<td>
						  						<?=$user['nome']; ?>
						  					</td>
						  					<td>
						  						<?=date('d/m/Y', strtotime($c['dt_cadastro'])); ?>
						  					</td>
						  					<td>
						  						<a href="historico.php?type=<?=$_GET['type']; ?>&id=<?=$c['id']; ?>" class="far fa-trash-alt" title="Deletar" style="color: red;"></a>
						  					</td>
						  				</tr>
						  			</tbody>
				  				<?php endforeach; ?>
				  			<?php else: ?>
				  				<tbody>
					  				<tr>
					  					<?php for ($i=0; $i < 8; $i++): ?>
					  						<td>Nenhum Registro</td>
					  					<?php endfor; ?>
					  				</tr>
					  			</tbody>
				  			<?php endif; ?>
				  		</table>
				  	</div>
			  	<?php else: ?>
				  	<div class="table table-responsive">
				  		<table class="table table-hover">
				  			<thead>
				  				<tr>
				  					<th>Fornecedor</th>
				  					<th>Descrição</th>
				  					<th>Valor</th>
				  					<th>Forma de pagamento</th>
				  					<th>Vencimento</th>
				  					<th>Registrado por</th>
				  					<th>Registrado em</th>
				  					<th>Ação</th>
				  				</tr>
				  			</thead>
				  			<?php if(!empty($dados)): ?>
				  				<?php foreach($dados as $c): 
				  					$user = $n->getFuncionario($c['id_user']);
				  					?>
				  					<tbody>
						  				<tr>
						  					<td>
						  						<?=htmlspecialchars($c['fornecedor']); ?>
						  					</td>
						  					<td>
						  						<?=htmlspecialchars($c['descricao']); ?>
						  					</td>
						  					<td>
						  						R$<?=number_format($c['valor'], 2, ',', '.'); ?>
						  					</td>
						  					<td>
						  						<?php foreach($form_pag as $f): ?>
						  							<?php if($c['form_pag'] == $f['id']): ?>
						  								<?php echo $f['descricao']; ?>
						  							<?php endif; ?>
						  						<?php endforeach; ?>
						  					</td>
						  					<td>
						  						<?=date('d/m/Y', strtotime($c['vencimento'])); ?>
						  					</td>
						  					<td>
						  						<?=$user['nome']; ?>
						  					</td>
						  					<td>
						  						<?=date('d/m/Y', strtotime($c['dt_cadastro'])); ?>
						  					</td>
						  					<td>
						  						<a href="historico.php?type=<?=$_GET['type']; ?>&id=<?=$c['id']; ?>" class="far fa-trash-alt" title="Deletar" style="color: red;"></a>
						  					</td>
						  				</tr>
						  			</tbody>
				  				<?php endforeach; ?>
				  			<?php else: ?>
				  				<tbody>
					  				<tr>
					  					<?php for ($i=0; $i < 8; $i++): ?>
					  						<td>Nenhum Registro</td>
					  					<?php endfor; ?>
					  				</tr>
					  			</tbody>
				  			<?php endif; ?>
				  		</table>
				  	</div>
			  	<?php endif; ?>
			  </div>
			</div>
		<?php else: ?>
			<div class="panel panel-primary">
			  <div class="panel-heading">
			  	<h3>Contas a Receber</h3>
			  </div>
			  <div class="panel-body">
			  	<!-- FORMULARIO DE CONSULTA -->
			  	<form method="GET">
			  		<input type="text" name="type" value="receber" hidden="">
			  		<div class="row">
			  			<div class="col-sm-4">
					  		<select class="form-control" name="mes">
					  			<?php
	                  for ($i=1; $i < 13; $i++) { 
	                      $dt = date('Y-'.$i);
	                      if ($i == date('m')) {
	                      	if (utf8_decode(strftime("%B", strtotime($dt))) == 'mar?o') {
		                          echo '<option selected="" value="'.$i.'">'.ucfirst(strftime("Março", strtotime($dt))).'</option>';
		                      } else {
		                          echo '<option selected="" value="'.$i.'">'.ucfirst(strftime("%B", strtotime($dt))).'</option>';
		                      }
	                      } else {
	                      	if (utf8_decode(strftime("%B", strtotime($dt))) == 'mar?o') {
		                          echo '<option value="'.$i.'">'.ucfirst(strftime("Março", strtotime($dt))).'</option>';
		                      } else {
		                          echo '<option value="'.$i.'">'.ucfirst(strftime("%B", strtotime($dt))).'</option>';
		                      }
	                      }
	                  }
                  ?>
					  		</select>
			  			</div>
			  			<div class="col-sm-4">
					  		<select name="ano" class="form-control">
					  			<?php for ($i=2020; $i <= 2030; $i++): ?>
					  				<?php if($i == date('Y')): ?>
					  					<option selected=""><?=$i; ?></option>
					  				<?php else: ?>
					  					<option><?=$i; ?></option>
					  				<?php endif; ?>
					  			<?php endfor; ?>
					  		</select>
			  			</div>
			  			<div class="col-sm-4">
			  				<button class="btn btn-primary btn-block">Consultar</button>
			  			</div>
			  		</div>
			  	</form>
			  	<hr>
			  	<!-- tabela de exibição de contas -->
			  	<div class="table table-responsive">
			  		<table class="table table-hover">
			  			<thead>
			  				<tr>
			  					<th>Fornecedor</th>
			  					<th>Descrição</th>
			  					<th>Valor</th>
			  					<th>Forma de pagamento</th>
			  					<th>Vencimento</th>
			  					<th>Registrado por</th>
			  					<th>Registrado em</th>
			  					<th>Ação</th>
			  				</tr>
			  			</thead>
			  			<?php if(!empty($dados)): ?>
			  				<?php foreach($dados as $c): 
			  					$user = $n->getFuncionario($c['id_user']);
			  					?>
			  					<tbody>
					  				<tr>
					  					<td>
					  						<?=htmlspecialchars($c['fornecedor']); ?>
					  					</td>
					  					<td>
					  						<?=htmlspecialchars($c['descricao']); ?>
					  					</td>
					  					<td>
					  						R$<?=number_format($c['valor'], 2, ',', '.'); ?>
					  					</td>
					  					<td>
					  						<?php foreach($form_pag as $f): ?>
					  							<?php if($c['form_pag'] == $f['id']): ?>
					  								<?php echo $f['descricao']; ?>
					  							<?php endif; ?>
					  						<?php endforeach; ?>
					  					</td>
					  					<td>
					  						<?=date('d/m/Y', strtotime($c['vencimento'])); ?>
					  					</td>
					  					<td>
					  						<?=$user['nome']; ?>
					  					</td>
					  					<td>
					  						<?=date('d/m/Y', strtotime($c['dt_cadastro'])); ?>
					  					</td>
					  					<td>
					  						<a href="historico.php?type=<?=$_GET['type']; ?>&id=<?=$c['id']; ?>" class="far fa-trash-alt" title="Deletar" style="color: red;"></a>
					  					</td>
					  				</tr>
					  			</tbody>
			  				<?php endforeach; ?>
			  			<?php else: ?>
			  				<tbody>
				  				<tr>
				  					<?php for ($i=0; $i < 8; $i++): ?>
				  						<td>Nenhum Registro</td>
				  					<?php endfor; ?>
				  				</tr>
				  			</tbody>
			  			<?php endif; ?>
			  		</table>
			  	</div>
			  </div>
			</div>
		<?php endif; ?>
		</div>
		<div class="col-sm-1"></div>
	</div>
</div>

<?php require 'footer.php'; ?>


<?php
require 'header.php';
$sql = new Processos();
$num_processo = addslashes($_GET['num_processo']);
$id_vistoria = addslashes($_GET['id_vistoria']);
$manifesto = addslashes($_GET['manifesto']);

$p = $sql->getProcesso($num_processo);
$man = $sql->getManifestoID($manifesto);
$uni = $sql->getMedidaP();
$getNFe = $sql->getManifestoNFeIDmanifesto($manifesto);

//REGISTRAR
if (!empty($_POST['descricao'])) {
	$valor_prej = 0;
	$post = filter_input_array(INPUT_POST, FILTER_DEFAULT);
	
	$post['valor_uni'] = str_replace(',', '.', str_replace('.', '', addslashes($post['valor_uni'])));
	$post['valor_desc'] = str_replace(',', '.', str_replace('.', '', addslashes($post['valor_desc'])));


	$valor_prej = $post['qt']*$post['valor_uni'];
	$tx1 = $valor_prej/100 * $post['icms'];
	$tx2 = $valor_prej/100 * $post['ipi'];
	$post['total'] = $valor_prej + $tx1 + $tx2 - $post['valor_desc'];

	$sql->setNFe($num_processo, $id_vistoria, $manifesto, $post, $id_user);
	
	echo '<script>alert("Registrado com sucesso!");</script>';
	echo '<script>window.location.href="'.URL.'processo30.nfe.php?num_processo='.$num_processo.'&id_vistoria='.$id_vistoria.'&manifesto='.$manifesto.'";</script>';
}

//ATUALIZAR
if (!empty($_POST['descricaoUP'])) {
	$post = filter_input_array(INPUT_POST, FILTER_DEFAULT);

	$valor_prej = 0;
	$post['valor_uniUP'] = addslashes(str_replace(',', '.', str_replace('.', '', addslashes($post['valor_uniUP']))));
	$post['valor_descUP'] = addslashes(str_replace(',', '.', str_replace('.', '', addslashes($post['valor_descUP']))));

	$valor_prej = $post['qtUP']*$post['valor_uniUP'];
	$tx1 = $valor_prej/100 * $post['icmsUP'];
	$tx2 = $valor_prej/100 * $post['ipiUP'];
	$post['totalUP'] = $valor_prej + $tx1 + $tx2 - $post['valor_descUP'];

	$sql->upNFe($post);

	echo '<script>alert("Atualizado com sucesso!");</script>';
	echo '<script>window.location.href="'.URL.'processo30.nfe.php?num_processo='.$num_processo.'&id_vistoria='.$id_vistoria.'&manifesto='.$manifesto.'";</script>';
}

//DELETANDO NFe
if (isset($_GET['id'])) {
	$sql->delNFe(addslashes($_GET['id']));

	echo '<script>alert("Deletado com sucesso!");</script>';
	echo '<script>window.location.href="'.URL.'processo30.nfe.php?num_processo='.$num_processo.'&id_vistoria='.$id_vistoria.'&manifesto='.$manifesto.'";</script>';
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
	      	<div class="row">
	      		<div class="col-sm-3">
	      			<label>Manifesto:</label>
	      			<input readonly="" value="<?=$man['m1']; ?>" class="form-control">
	      		</div>
	      		<div class="col-sm-3">
	      			<label>CTe:</label>
	      			<input readonly="" value="<?=$man['m3']; ?>" class="form-control">
	      		</div>
	      		<div class="col-sm-3">
	      			<label>NFe:</label>
	      			<input readonly="" value="<?=$man['m5']; ?>" class="form-control">
	      		</div>
	      		<div class="col-sm-3">
	      			<label>Valor NFe:</label>
	      			<input readonly="" value="R$<?=number_format($man['m7'], 2, ',', '.'); ?>" class="form-control">
	      		</div>
	      	</div>
	      	<hr>
	      	<div class="well">
	      		<form method="POST">
	      			<label>Descrição da Mercadoria:</label>
	      			<input type="text" name="descricao" class="form-control">
	      			<div class="row">
		      			<div class="col-sm-6">
		      				<label>Quantidade:</label>
	      					<input type="text" id="qt" name="qt" class="form-control">
		      			</div>
		      			<div class="col-sm-6">
		      				<label>Peso:</label>
	      					<input type="text" name="peso" class="form-control money">
		      			</div>
		      			
		      		</div>
		      		<div class="row">
		      			<div class="col-sm-6">
		      				<label>Valor Unitário:</label>
	      					<input type="text" id="valor_uni" name="valor_uni" class="form-control money4">
		      			</div>
		      			<div class="col-sm-6">
		      				<label>Unidade de Medida:</label>
	      					<select name="id_unidade" class="form-control">
	      						<?php
	      						foreach ($uni as $u) {
	      							echo '<option value="'.$u['id'].'">'.$u['nome'].'</option>';
	      						}
	      						?>
	      					</select>
		      			</div>
		      		</div>
		      		<div class="row">
		      			<div class="col-sm-3">
		      				<label>ICSM ST.:</label>
	      					<input type="text" id="icms" name="icms" class="form-control taxas">
		      			</div>
		      			<div class="col-sm-3">
		      				<label>IPI:</label>
	      					<input type="text" id="ipi" name="ipi" class="form-control taxas">
		      			</div>
		      			<div class="col-sm-3">
		      				<label>Valor Desconto:</label>
	      					<input type="text" id="valor_desc" name="valor_desc" class="form-control money3">
		      			</div>
		      			<div class="col-sm-3">
		      				<label>Valor Prezuízo:</label>
	      					<input type="text" readonly="" id="total" class="form-control money3">
		      			</div>
		      		</div>

	      			<br>
				    <div class="row">
		      			<div class="col-sm-9"></div>
		      			<div class="col-sm-3">
							<a href="processo30.manifesto.php?num_processo=<?=$num_processo; ?>&num_vistoria=<?=$id_vistoria; ?>" class="btn btn-danger">Cancelar</a>	
							<button class="btn btn-primary">Salvar</button>	
		      			</div>
		      		</div>
		      	</form>
		      	<hr>
		      	<div class="table-responsive">
		      		<table class="table" style="font-size: 12px;">
		      			<thead>
		      				<tr>
		      					<th>Ação</th>
		      					<th>Descr. Mercadoria</th>
		      					<th>Quantidade</th>
		      					<th>Valor Unitário</th>
		      					<th>Medida</th>
		      					<th>ICMS ST.</th>
		      					<th>IPI</th>
		      					<th>Valor Desconto</th>
		      					<th>Valor Prejuízo</th>
		      					<th>Criado em</th>
		      					<th>Criado por</th>
		      				</tr>
		      			</thead>
		      			<?php
		      			foreach ($getNFe as $n) {
		      				?>
		      			<tbody>
		      				<tr>
		      					<td>
		      						<a href="" class="fa fa-edit" data-toggle="modal" data-target="#<?=$n['id']; ?>" title="Editar"></a>
		      						<a href="processo30.nfe.php?num_processo=<?=$num_processo ?>&id_vistoria=<?=$id_vistoria; ?>&manifesto=<?=$manifesto; ?>&id=<?=$n['id']; ?>" class="fas fa-trash-alt" title="Deletar"></a>

		      						<?php require 'modal.php'; ?>
		      					</td>
		      					<td><?=$n['descricao']; ?></td>
		      					<td><?=$n['qt']; ?></td>
		      					<td>R$<?=number_format($n['valor_uni'], 9, ',', '.'); ?></td>
		      					<td><?=$n['nome']; ?></td>
		      					<td><?=$n['icms']; ?></td>
		      					<td><?=$n['ipi']; ?></td>
		      					<td>R$<?=number_format($n['valor_desc'], 2, ',', '.'); ?></td>
		      					<td>R$<?=number_format($n['total'], 2, ',', '.'); ?></td>
		      					<td><?=date('d/m/Y H:i:s', strtotime($n['dt_criacao'])); ?></td>
		      					<td><?=$n['func']; ?></td>
		      				</tr>
		      			</tbody>
		      				<?php
		      			}
		      			?>
		      			
		      		</table>
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
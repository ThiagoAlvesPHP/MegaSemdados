<?php
require 'header.php';
$post = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$get = filter_input_array(INPUT_GET, FILTER_DEFAULT);
//verificar se processo esta preenchido
if (!empty($get['num_processo'])) {
	$sql = new Processos();
	$num_processo = $get['num_processo'];
	$p = $sql->getProcesso($num_processo);
	if(empty($sql->getProcesso($num_processo))){
		echo '<script>alert("Nenhum Processo encontrado com esse número '.$num_processo.'");</script>';
		echo '<script>window.location.href="index.php";</script>';
	}
}
//consultar se teve registro
$dados = $sql->getAllTickDocsProcesso($num_processo);

if (!empty($dados)) {
	//registrar 
	if (!empty($post)) {
		$post['num_processo'] = $num_processo;
		$sql->upTickDocs($post);
		echo '<script>alert("Atualizado com sucesso!");</script>';
		echo '<script>window.location.href="tickDocs.php?num_processo='.$num_processo.'";</script>';
	}
} else {
	//registrar 
	if (!empty($post)) {
		$post['num_processo'] = $num_processo;
		$sql->setTickDocs($post);
		echo '<script>alert("Registrado com sucesso!");</script>';
		echo '<script>window.location.href="tickDocs.php?num_processo='.$num_processo.'";</script>';
	}
}

$docs = array(
	'nfdanfe'			=>	'NF/Danfe', 
	'dacte'				=>	'Dacte/Conhecimento', 
	'cnh_sinitrado'		=>	'CNH Motorista Sinistrado', 
	'crvl_sinistrado'	=>	'CRLV Veículo Sinistrado',
	'tacografo'			=>	'Diagrama Tacógrafo', 
	'declaracao'		=>	'Declaração Condutor Sinistrado', 
	'bo_acidente'		=>	'BO Acidente',
	'bo_saque'			=>	'BO saque', 
	'apreensao'			=>	'Auto de Apreensão',
	'cnh_transbordo'	=>	'CNH Transbordo', 
	'crvl_transbordo'	=>	'CRLV Transbordo',
	'ticket'			=>	'Ticket Descarga', 
	'comprovante'		=>	'Comprovante de Entrega', 
	'envolvido'			=>	'3º Envolvido/Culpado',
	'chapa'				=>	'Recibo Chapa', 
	'recibo_transbordo'	=>	'Recibo Transbordo', 
	'recibo_vigilancia'	=>	'Recibo Vigilância', 
	'recibo_munk'		=>	'Recibo Munck', 
	'recibo_materiais'	=>	'Recibo Matérias'
);
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
	      	<h3>Documentos Pendentes</h3>
	      	<div class="well">
	      		<form method="POST">
	      			<div class="table tablle-responsive">
	      				<table class="table">
	      					<thead>
	      						<tr>
	      							<th>Documento</th>
	      							<th>Sim</th>
	      							<th>Não</th>
	      							<th>Desconsiderar</th>
	      						</tr>
	      					</thead>
	      					<?php foreach ($docs as $name => $item): ?>
	      					<tbody>
	      						<tr>
	      							<!-- caso já tenha sido preenchido no db -->
	      							<?php if(!empty($dados)): ?>
	      								<td><?=$item; ?></td>
		      							<td>
		      								<input <?=($dados[0][$name] == 1)?'checked=""':''; ?> type="radio" value="1" name="<?=$name; ?>">
		      							</td>
		      							<td>
		      								<input <?=($dados[0][$name] == 2)?'checked=""':''; ?> type="radio" value="2" name="<?=$name; ?>">
		      							</td>
		      							<td>
		      								<input <?=($dados[0][$name] == 3 OR $dados[0][$name] == NULL)?'checked=""':''; ?> type="radio" value="3" name="<?=$name; ?>">
		      							</td>
	      							<?php else: ?>
	      								<td><?=$item; ?></td>
		      							<td>
		      								<input type="radio" value="1" name="<?=$name; ?>">
		      							</td>
		      							<td>
		      								<input type="radio" value="2" name="<?=$name; ?>">
		      							</td>
		      							<td>
		      								<input type="radio" value="3" name="<?=$name; ?>">
		      							</td>
	      							<?php endif; ?>
	      						</tr>
	      					</tbody>
	      					<?php endforeach; ?>
	      				</table>
	      			</div>
	      			<?php if(!empty($dados)): ?>
	      				<button class="btn btn-primary">Atualizar</button>
	      			<?php else: ?>
	      				<button class="btn btn-success">Salvar</button>
	      			<?php endif; ?>
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
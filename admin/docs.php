<?php 
require 'header.php';
$sql = new Usuario();

//FUNCIONARIOS
$funcAll = (new Funcionarios())->getFunc();

//SE O CAMPO TITULO ESTA PREENCHIDO & SE O ARQUIVO FOI ENVIADO
if (!empty($_POST['titulo']) && !empty($_FILES['arquivo'])){
	//VERIFICA SE O ARQUIVO É PDF
	if ($_FILES['arquivo']['type'] == "application/pdf") {

		$arquivo = md5($_FILES['arquivo']['name'].time().rand(0,999)).'.pdf';
		move_uploaded_file($_FILES['arquivo']['tmp_name'], 'assets/docs/'.$arquivo);
		
		$sql->setDocs(addslashes($_POST['titulo']), $arquivo);
		echo '<script>alert("Documento Inserido com Sucesso!"); window.location.href = "docs.php";</script>';
	} else {
		$alert = '<div class="alert alert-danger"><strong>Alerta </strong> Arquivo não esta em formato PDF!</div>';
	}
}

//REMOVER DOCUMENTO
if (!empty($_GET['idDel'])) {
	$id = addslashes($_GET['idDel']);
	unlink('assets/docs/'.addslashes($_GET['arquivo']));
	$sql->delDoc($id);
	$sql->delDocLiberados($id);
	echo '<script>alert("Documento Deletado com Sucesso!"); window.location.href = "docs.php";</script>';
}

//MEUS DOCUMENTOS
$docs = $sql->getDocs();
//DOCUMENTOS RECEBIDOS
$docsRecebidos = $sql->getDocsRecebidos();
?>
<style type="text/css">
	.titulos{
		text-align: center;
	}
	.table{
		font-size: 12px;
	}
	.fa-thumbs-up{
		color: green;
	}
	.fa-thumbs-down{
		color: red;
	}
</style>
<br><br><br>
<div class="container">
	<div class="panel panel-primary">
	  <div class="panel-heading">
	  	<h3>Inserção de Documentos</h3>
	  </div>
	  <div class="panel-body">
	  	<div class="row">
	  		<div class="col-sm-4">
	  			<h4 class="titulos">Inserir Documento</h4>
	  			<?php
	  			if (isset($alert)) {
	  				echo $alert;
	  			}
	  			?>
	  			<hr>
	  			<form method="POST" enctype="multipart/form-data">
	  				<label>Título do Documento</label>
	  				<input type="text" name="titulo" class="form-control" required="">
	  				<label>Documento (PDF)</label>
	  				<input type="file" name="arquivo" class="form-control" required="">
	  				<br>
	  				<button class="btn btn-success btn-block">Enviar</button>
	  			</form>
	  		</div>
	  		<div class="col-sm-4">
	  			<h4 class="titulos">Meus Documentos</h4>
	  			<hr>
	  			<div class="table-responsive">
	  				<table class="table table-hover">
	  					<thead>
	  						<tr>
	  							<th>Título</th>
	  							<th>Ação</th>
	  						</tr>
	  					</thead>
	  					<?php if (!empty($docs)): foreach ($docs as $v): ?>
	  					<tbody>
	  						<tr>
	  							<td><?=htmlspecialchars($v['titulo']); ?></td>
	  							<td>
	  								<a class="far fa-eye" title="Visualizar" data-toggle="modal" data-target="#v<?=$v['id']; ?>"></a>

	  								<div id="v<?=$v['id']; ?>" class="modal fade" role="dialog">
	                                    <div class="modal-dialog">
	                                      <div class="modal-content">
	                                        <div class="modal-header">
	                                          <button type="button" class="close" data-dismiss="modal">&times;</button>
	                                          <h4 class="modal-title">
	                                              <?=$v['titulo']; ?>
	                                          </h4>
	                                        </div>
	                                        <div class="modal-body">
	                                          <iframe width="100%" height="500px" src="assets/docs/<?=$v['arquivo']; ?>"></iframe>
	                                        </div>
	                                        <div class="modal-footer">
	                                          <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
	                                        </div>
	                                      </div>
	                                    </div>
                                  	</div>

	  								<a style="color: green;" title="Liberar Visualização" class="fas fa-users" data-toggle="modal" data-target="#edit<?=$v['id']; ?>"></a>

	  								<div id="edit<?=$v['id']; ?>" class="modal fade" role="dialog">
	                                    <div class="modal-dialog">
	                                      <div class="modal-content">
	                                        <div class="modal-header">
	                                          <button type="button" class="close" data-dismiss="modal">&times;</button>
	                                          <h4 class="modal-title">
	                                          	<?=$v['id']; ?> - <?=$v['titulo']; ?>
	                                          </h4>
	                                        </div>
	                                        <div class="modal-body">
	                                          	<div class="table-responsive">
	                                          		<table class="table">
	                                          			<thead>
	                                          				<tr>
	                                          					<th>Funcionarios</th>
	                                          					<th>Ação</th>
	                                          				</tr>
	                                          			</thead>
	                                          			<?php
	                                          			foreach ($funcAll as $f):
	                                          			$liberados = $sql->getDocsLiberados($v['id'], $f['id']);
	                                          			?>
	                                          			<tbody>
	                                          				<tr>
	                                          					<td>
	                                          						<?=$f['nome']; ?>
	                                          					</td>
	                                          					<td>
	                                          						<?php
	                                          						if (!empty($liberados)) {
	                                          						?>
	                                          						<a class="far fa-thumbs-up cad" title="<?=$v['id']; ?>/<?=$f['id']; ?>/Liberado"></a>
	                                          						<?php
	                                          						} else {
	                                          						?>
	                                          						<a class="far fa-thumbs-down cad" title="<?=$v['id']; ?>/<?=$f['id']; ?>/Bloqueado"></a>
	                                          						<?php
	                                          						}
	                                          						?>
	                                          					</td>
	                                          				</tr>
	                                          			</tbody>
	                                          			<?php
	                                          			endforeach;
	                                          			?>
	                                          		</table>
	                                          	</div>
	                                        </div>
	                                        <div class="modal-footer">
	                                          <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
	                                        </div>
	                                      </div>
	                                    </div>
                                  	</div>

	  								<a href="?idDel=<?=$v['id']; ?>&arquivo=<?=$v['arquivo']; ?>" title="Deletar" class="fas fa-trash-alt" style="color: red;"></a>

	  								
	  							</td>
	  						</tr>
	  					</tbody>
	  					<?php endforeach; endif; ?>
	  				</table>
	  			</div>
	  		</div>
	  		<div class="col-sm-4">
	  			<h4 class="titulos">Documentos Recebidos</h4>
	  			<hr>
	  			<div class="table-responsive">
	  				<table class="table">
	  					<thead>
	  						<tr>
	  							<th>Título</th>
	  							<th>Enviado por</th>
	  							<th>Ação</th>
	  						</tr>
	  					</thead>
	  					<?php foreach ($docsRecebidos as $d): ?>
	  					<tbody>
	  						<tr>
	  							<td><?=$d['titulo']; ?></td>
	  							<td><?=$d['nome']; ?></td>
	  							<td>
	  								<a class="far fa-eye" title="Visualizar" data-toggle="modal" data-target="#d<?=$d['id']; ?>"></a>

	  								<div id="d<?=$d['id']; ?>" class="modal fade" role="dialog">
	                                    <div class="modal-dialog">
	                                      <div class="modal-content">
	                                        <div class="modal-header">
	                                          <button type="button" class="close" data-dismiss="modal">&times;</button>
	                                          <h4 class="modal-title">
	                                              <?=$d['titulo']; ?>
	                                          </h4>
	                                        </div>
	                                        <div class="modal-body">
	                                          <iframe width="100%" height="500px" src="assets/docs/<?=$d['arquivo']; ?>"></iframe>
	                                        </div>
	                                        <div class="modal-footer">
	                                          <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
	                                        </div>
	                                      </div>
	                                    </div>
                                  	</div>
	  							</td>
	  						</tr>
	  					</tbody>
	  					<?php endforeach; ?>
	  				</table>
	  			</div>
	  		</div>
	  	</div>
	  </div>
	</div>
</div>

<?php require 'footer.php' ?>
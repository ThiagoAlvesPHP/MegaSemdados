<?php
require 'header.php';
$sql = new Processos();
//SEGURADOS
$num_processo = addslashes($_GET['num_processo']);
$p = $sql->getProcesso($num_processo);
$eventos = $sql->getEventos($num_processo);

//EXCLUIR EVENTO
if (isset($_GET['id']) && !empty($_GET['id'])) {
	$id = addslashes($_GET['id']);
	$sql->delEvento($id);
	?>
	<script>
		window.location.href = "processoHistorico.php?num_processo=<?=$num_processo; ?>";
	</script>
	<?php
}
//REGISTRAR EVENTO
if (!empty($_POST['evento'])) {
	$evento = addslashes($_POST['evento']);
	$sql->setEventoProcesso($num_processo, $id_user, $evento);
	?>
	<script>
		window.location.href = "processoHistorico.php?num_processo=<?=$num_processo; ?>";
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
	      	<a href="">HOME</a>
	      </div>
	      <div class="panel-body">
	      	<?php require 'navbarProcesso.php'; ?>
	      	<hr>
	      	<h3>Histórico do Processo</h3>
	      	<div class="well">
	      		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">+</button>

				<!-- Modal -->
				<div id="myModal" class="modal fade" role="dialog">
				  <div class="modal-dialog">

				    <!-- Modal content-->
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal">&times;</button>
				        <h4 class="modal-title">Histórico do Processo</h4>
				      </div>
				      <div class="modal-body">
				        <p>Evento atual do Processo</p>
				        <form method="POST">
				        	<textarea name="evento" autofocus="" class="form-control" style="height: 100px;"></textarea>
				      		<br>
				      		<button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
					      	<button class="btn btn-primary">Salvar</button>
				        </form>
				      </div>
				    </div>

				  </div>
				</div>
				<hr>
				<div class="table-responsive">
				 	<table class="table table-hover">
					    <thead style="background: #000; color: #fff;">
					      <tr>
					        <th width="50">Ação</th>
					        <th width="150">Criado em</th>
					        <th width="120">Criado por</th>
					        <th>Evento</th>
					      </tr>
					    </thead>
					    <?php
					    foreach ($eventos as $e) {
					    	?>
					    	<tbody>
						    	<tr>
						    		<td>
						    			<a href="processoHistorico.php?num_processo=<?=$num_processo; ?>&id=<?=$e['id']; ?>" class="fa fa-trash"></a>
						    		</td>
						    		<td><?=date('d/m/Y H:i:s', strtotime($e['dt_cadastrado'])) ?></td>
						    		<td><?=htmlspecialchars($e['nome']); ?></td>
						    		<td><?=htmlspecialchars($e['evento']); ?></td>
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
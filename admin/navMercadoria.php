<?php  
require 'header.php';
$sql2 = new Funcionarios();
$nivel = $sql2->getFuncionario($id_user);
if ($nivel['nivel'] <> 2) {
	?>
	<script>
		alert("Você não tem altorização para acessar essa área!");
		window.location.assign("index.php");
	</script>
	<?php
}

$sql = new Processos();

$menu1 = $sql->getMercadoriasP();
$menu2 = $sql->getEmbalagemP();
$menu3 = $sql->getMedidaP();
$menu4 = $sql->getStatusMerP();
$menu5 = $sql->getStatusEmbP();

//ATUALIZAR MENU1
if (!empty($_POST['menu1'])) {
	$s = (new Navegacao())->navMercadoriaUp(addslashes($_POST['menu1']), addslashes($_POST['menu1_id']));
	echo '<script> alert("Atualizado com sucesso!"); window.location.assign("navMercadoria.php");</script>';
}
//ATUALIZAR MENU2
if (!empty($_POST['menu2'])) {
	$s = (new Navegacao())->navEmbalagemUp(addslashes($_POST['menu2']), addslashes($_POST['menu2_id']));
	echo '<script> alert("Atualizado com sucesso!"); window.location.assign("navMercadoria.php");</script>';
}
//ATUALIZAR MENU3
if (!empty($_POST['menu3'])) {
	$s = (new Navegacao())->navUnidadeUp(addslashes($_POST['menu3']), addslashes($_POST['menu3_id']));
	echo '<script> alert("Atualizado com sucesso!"); window.location.assign("navMercadoria.php");</script>';
}
//ATUALIZAR MENU4
if (!empty($_POST['menu4'])) {
	$s = (new Navegacao())->navStatusMercUp(addslashes($_POST['menu4']), addslashes($_POST['menu4_id']));
	echo '<script> alert("Atualizado com sucesso!"); window.location.assign("navMercadoria.php");</script>';
}
//ATUALIZAR MENU5
if (!empty($_POST['menu5'])) {
	$s = (new Navegacao())->navStatusEmbUp(addslashes($_POST['menu5']), addslashes($_POST['menu5_id']));
	echo '<script> alert("Atualizado com sucesso!"); window.location.assign("navMercadoria.php");</script>';
}

//REGISTRAR MENU1
if (!empty($_POST['form1'])) {
	$s = (new Navegacao())->setMercadoria(addslashes($_POST['form1']));
	echo '<script> alert("Registrado com sucesso!"); window.location.assign("navMercadoria.php");</script>';
}
//REGISTRAR MENU2
if (!empty($_POST['form2'])) {
	$s = (new Navegacao())->setEmbalagem(addslashes($_POST['form2']));
	echo '<script> alert("Registrado com sucesso!"); window.location.assign("navMercadoria.php");</script>';
}
//REGISTRAR MENU3
if (!empty($_POST['form3'])) {
	$s = (new Navegacao())->setUnidade(addslashes($_POST['form3']));
	echo '<script> alert("Registrado com sucesso!"); window.location.assign("navMercadoria.php");</script>';
}
//REGISTRAR MENU4
if (!empty($_POST['form4'])) {
	$s = (new Navegacao())->setStatusMerc(addslashes($_POST['form4']));
	echo '<script> alert("Registrado com sucesso!"); window.location.assign("navMercadoria.php");</script>';
}
//REGISTRAR MENU5
if (!empty($_POST['form5'])) {
	$s = (new Navegacao())->setStatusEmb(addslashes($_POST['form5']));
	echo '<script> alert("Registrado com sucesso!"); window.location.assign("navMercadoria.php");</script>';
}

?>
<br><br><br>
<div class="container">
	<div class="row">
		<div class="col-sm-6">
			<div class="panel panel-primary">
				<div class="panel-heading">
			    	Mercadoria - Navegação
			    </div>
			    <div class="panel-body">
			    	<div class="row">
			    		<div class="col-sm-6">
			    			<form method="POST">
				    			<label>Tipo de Mercadoria - <a data-toggle="tab" href="#m1">Menu 1</a></label>
				    			<input type="text" name="form1" class="form-control"><br>
				    			<button class="btn btn-success">Registrar</button>
				    		</form>
			    		</div>
			    		<div class="col-sm-6">
			    			<form method="POST">
				    			<label>Tipo de Embalagem - <a data-toggle="tab" href="#m2">Menu 2</a></label>
				    			<input type="text" name="form2" class="form-control"><br>
				    			<button class="btn btn-success">Registrar</button>
				    		</form>
			    		</div>
			    	</div>
		    		<hr>
		    		<div class="row">
		    			<div class="col-sm-6">
		    				<form method="POST">
				    			<label>Unidade de Medida - <a data-toggle="tab" href="#m3">Menu 3</a></label>
				    			<input type="text" name="form3" class="form-control"><br>
				    			<button class="btn btn-success">Registrar</button>
				    		</form>
		    			</div>
		    			<div class="col-sm-6">
		    				<form method="POST">
				    			<label>Danos a Mercadoria - <a data-toggle="tab" href="#m4">Menu 4</a></label>
				    			<input type="text" name="form4" class="form-control"><br>
				    			<button class="btn btn-success">Registrar</button>
				    		</form>
		    			</div>
		    		</div>
		    		
		    		<hr>
		    		<form method="POST">
		    			<label>Danos a Embalagem - <a data-toggle="tab" href="#m5">Menu 5</a></label>
		    			<input type="text" name="form5" class="form-control"><br>
		    			<button class="btn btn-success">Registrar</button>
		    		</form>
		    	</div>
		    </div>
		</div>
		<div class="col-sm-6">
			<div class="panel panel-primary">
		      <div class="panel-heading">
		      	Lista Navegações
		      </div>
		      <div class="panel-body">

		      	<ul class="nav nav-tabs">
				  <li class="active"><a data-toggle="tab" href="#m1">Menu 1</a></li>
				  <li><a data-toggle="tab" href="#m2">Menu 2</a></li>
				  <li><a data-toggle="tab" href="#m3">Menu 3</a></li>
				  <li><a data-toggle="tab" href="#m4">Menu 4</a></li>
				  <li><a data-toggle="tab" href="#m5">Menu 5</a></li>
				</ul>

				<div class="tab-content">
				  <div id="m1" class="tab-pane fade in active">
				    <h3>Tipo de Mercadoria</h3>
				    <div class="table-responsive">
				    	<table class="table table-hover">
				    		<thead>
				    			<tr>
				    				<th>Ação</th>
				    				<th>Tipos de Mercadorias</th>
				    			</tr>
				    		</thead>
				    		<?php
				    		foreach ($menu1 as $v) {
				    		?>
				    		<tbody>
				    			<tr>
				    				<td>

				    					<a class="fa fa-edit" href="" data-toggle="modal" data-target="#menu1<?=$v['id']; ?>"></a>

				    					<div id="menu1<?=$v['id']; ?>" class="modal fade" role="dialog">
										  <div class="modal-dialog">
										    <!-- Modal content-->
										    <div class="modal-content">
										      <div class="modal-header">
										        <button type="button" class="close" data-dismiss="modal">&times;</button>
										        <h4 class="modal-title">Tipo de Mercadoria</h4>
										      </div>
										      <div class="modal-body">
										        <form method="POST">
										        	<input type="text" hidden="" name="menu1_id" value="<?=$v['id']; ?>">
										        	<input type="text" name="menu1" class="form-control" value="<?=utf8_encode($v['nome']); ?>"><br>
										        	<button class="btn btn-primary">Atualizar</button>
										        </form>
										      </div>
										      <div class="modal-footer">
										        <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
										      </div>
										    </div>
										  </div>
										</div>

				    				</td>
				    				<td>
				    					<?=utf8_encode($v['nome']); ?>
				    				</td>
				    			</tr>
				    		</tbody>
				    		<?php
				    		}
				    		?>
				    		
				    	</table>
				    </div>
				  </div>
				  <div id="m2" class="tab-pane fade">
				    <h3>Tipo de Embalagem</h3>
				    <div class="table-responsive">
				    	<table class="table table-hover">
				    		<thead>
				    			<tr>
				    				<th>Ação</th>
				    				<th>Tipos de Embalagem</th>
				    			</tr>
				    		</thead>
				    		<?php
				    		foreach ($menu2 as $v) {
				    		?>
				    		<tbody>
				    			<tr>
				    				<td>
				    					<a class="fa fa-edit" href="" data-toggle="modal" data-target="#menu2<?=$v['id']; ?>"></a>

				    					<div id="menu2<?=$v['id']; ?>" class="modal fade" role="dialog">
										  <div class="modal-dialog">
										    <!-- Modal content-->
										    <div class="modal-content">
										      <div class="modal-header">
										        <button type="button" class="close" data-dismiss="modal">&times;</button>
										        <h4 class="modal-title">Tipo de Embalagem</h4>
										      </div>
										      <div class="modal-body">
										        <form method="POST">
										        	<input type="text" hidden="" name="menu2_id" value="<?=$v['id']; ?>">
										        	<input type="text" name="menu2" class="form-control" value="<?=utf8_encode($v['embalagem']); ?>"><br>
										        	<button class="btn btn-primary">Atualizar</button>
										        </form>
										      </div>
										      <div class="modal-footer">
										        <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
										      </div>
										    </div>
										  </div>
										</div>
				    				</td>
				    				<td>
				    					<?=utf8_encode($v['embalagem']); ?>
				    				</td>
				    			</tr>
				    		</tbody>
				    		<?php
				    		}
				    		?>
				    		
				    	</table>
				    </div>
				  </div>
				  <div id="m3" class="tab-pane fade">
				    <h3>Unidade de Medida</h3>

				    <div class="table-responsive">
				    	<table class="table table-hover">
				    		<thead>
				    			<tr>
				    				<th>Ação</th>
				    				<th>Unidade de Medidas</th>
				    			</tr>
				    		</thead>
				    		<?php
				    		foreach ($menu3 as $v) {
				    		?>
				    		<tbody>
				    			<tr>
				    				<td>
				    					<a class="fa fa-edit" href="" data-toggle="modal" data-target="#menu3<?=$v['id']; ?>"></a>

				    					<div id="menu3<?=$v['id']; ?>" class="modal fade" role="dialog">
										  <div class="modal-dialog">
										    <!-- Modal content-->
										    <div class="modal-content">
										      <div class="modal-header">
										        <button type="button" class="close" data-dismiss="modal">&times;</button>
										        <h4 class="modal-title">Unidade de Medida</h4>
										      </div>
										      <div class="modal-body">
										        <form method="POST">
										        	<input type="text" hidden="" name="menu3_id" value="<?=$v['id']; ?>">
										        	<input type="text" name="menu3" class="form-control" value="<?=utf8_encode($v['nome']); ?>"><br>
										        	<button class="btn btn-primary">Atualizar</button>
										        </form>
										      </div>
										      <div class="modal-footer">
										        <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
										      </div>
										    </div>
										  </div>
										</div>
				    				</td>
				    				<td>
				    					<?=utf8_encode($v['nome']); ?>
				    				</td>
				    			</tr>
				    		</tbody>
				    		<?php
				    		}
				    		?>
				    		
				    	</table>
				    </div>

				  </div>
				  <div id="m4" class="tab-pane fade">
				    <h3>Danos a Mercadoria</h3>

				    <div class="table-responsive">
				    	<table class="table table-hover">
				    		<thead>
				    			<tr>
				    				<th>Ação</th>
				    				<th>Danos a Mercadorias</th>
				    			</tr>
				    		</thead>
				    		<?php
				    		foreach ($menu4 as $v) {
				    		?>
				    		<tbody>
				    			<tr>
				    				<td>
				    					<a class="fa fa-edit" href="" data-toggle="modal" data-target="#menu4<?=$v['id']; ?>"></a>

				    					<div id="menu4<?=$v['id']; ?>" class="modal fade" role="dialog">
										  <div class="modal-dialog">
										    <!-- Modal content-->
										    <div class="modal-content">
										      <div class="modal-header">
										        <button type="button" class="close" data-dismiss="modal">&times;</button>
										        <h4 class="modal-title">Danos a Mercadorias</h4>
										      </div>
										      <div class="modal-body">
										        <form method="POST">
										        	<input type="text" hidden="" name="menu4_id" value="<?=$v['id']; ?>">
										        	<input type="text" name="menu4" class="form-control" value="<?=utf8_encode($v['status']); ?>"><br>
										        	<button class="btn btn-primary">Atualizar</button>
										        </form>
										      </div>
										      <div class="modal-footer">
										        <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
										      </div>
										    </div>
										  </div>
										</div>
				    				</td>
				    				<td>
				    					<?=utf8_encode($v['status']); ?>
				    				</td>
				    			</tr>
				    		</tbody>
				    		<?php
				    		}
				    		?>
				    		
				    	</table>
				    </div>

				  </div>
				  <div id="m5" class="tab-pane fade">
				    <h3>Danos a Embalagem</h3>

				    <div class="table-responsive">
				    	<table class="table table-hover">
				    		<thead>
				    			<tr>
				    				<th>Ação</th>
				    				<th>Danos a Embalagem</th>
				    			</tr>
				    		</thead>
				    		<?php
				    		foreach ($menu5 as $v) {
				    		?>
				    		<tbody>
				    			<tr>
				    				<td>
				    					<a class="fa fa-edit" href="" data-toggle="modal" data-target="#menu5<?=$v['id']; ?>"></a>

				    					<div id="menu5<?=$v['id']; ?>" class="modal fade" role="dialog">
										  <div class="modal-dialog">
										    <!-- Modal content-->
										    <div class="modal-content">
										      <div class="modal-header">
										        <button type="button" class="close" data-dismiss="modal">&times;</button>
										        <h4 class="modal-title">Danos a Embalagem</h4>
										      </div>
										      <div class="modal-body">
										        <form method="POST">
										        	<input type="text" hidden="" name="menu5_id" value="<?=$v['id']; ?>">
										        	<input type="text" name="menu5" class="form-control" value="<?=utf8_encode($v['status']); ?>"><br>
										        	<button class="btn btn-primary">Atualizar</button>
										        </form>
										      </div>
										      <div class="modal-footer">
										        <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
										      </div>
										    </div>
										  </div>
										</div>
				    				</td>
				    				<td>
				    					<?=utf8_encode($v['status']); ?>
				    				</td>
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
		</div>
	</div>
</div>

<?php  
require 'footer.php';
?>
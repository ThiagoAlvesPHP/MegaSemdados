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

$menu1 = $sql->getNavAvarias();
$menu2 = $sql->nav_moeda();
$menu3 = $sql->nav_tipo_doc();
$menu4 = $sql->getNavFrete();
$menu5 = $sql->nav_tipo_doc2();

//ATUALIZAR MENU1
if (!empty($_POST['menu1'])) {
	$s = (new Navegacao())->navAvariasUp(addslashes($_POST['menu1']), addslashes($_POST['menu1_id']));
	echo '<script> alert("Atualizado com sucesso!"); window.location.assign("nav_12_13_14.php");</script>';
}
//ATUALIZAR MENU3
if (!empty($_POST['menu3'])) {
	$s = (new Navegacao())->navTipoDoc1sUp(addslashes($_POST['menu3']), addslashes($_POST['menu3_id']));
	echo '<script> alert("Atualizado com sucesso!"); window.location.assign("nav_12_13_14.php");</script>';
}
//ATUALIZAR MENU4
if (!empty($_POST['menu4'])) {
	$s = (new Navegacao())->navFretesUp(addslashes($_POST['menu4']), addslashes($_POST['menu4_id']));
	echo '<script> alert("Atualizado com sucesso!"); window.location.assign("nav_12_13_14.php");</script>';
}
//ATUALIZAR MENU5
if (!empty($_POST['menu5'])) {
	$s = (new Navegacao())->navTipoDoc2sUp(addslashes($_POST['menu5']), addslashes($_POST['menu5_id']));
	echo '<script> alert("Atualizado com sucesso!"); window.location.assign("nav_12_13_14.php");</script>';
}

//REGISTRAR MENU1
if (!empty($_POST['form1'])) {
	$s = (new Navegacao())->setAvarias(addslashes($_POST['form1']));
	echo '<script> alert("Registrado com sucesso!"); window.location.assign("nav_12_13_14.php");</script>';
}
//REGISTRAR MENU3
if (!empty($_POST['form3'])) {
	$s = (new Navegacao())->setTipoDoc01(addslashes($_POST['form3']));
	echo '<script> alert("Registrado com sucesso!"); window.location.assign("nav_12_13_14.php");</script>';
}
//REGISTRAR MENU4
if (!empty($_POST['form4'])) {
	$s = (new Navegacao())->setFrete(addslashes($_POST['form4']));
	echo '<script> alert("Registrado com sucesso!"); window.location.assign("nav_12_13_14.php");</script>';
}
//REGISTRAR MENU5
if (!empty($_POST['form5'])) {
	$s = (new Navegacao())->setTipoDoc02(addslashes($_POST['form5']));
	echo '<script> alert("Registrado com sucesso!"); window.location.assign("nav_12_13_14.php");</script>';
}

?>
<br><br><br>
<div class="container">
	<div class="row">
		<div class="col-sm-6">
			<div class="panel panel-primary">
				<div class="panel-heading">
			    	Paginas 12, 13, 14  - Navegação
			    </div>
			    <div class="panel-body">
			    	<div class="row">
			    		<div class="col-sm-12">
			    			<form method="POST">
				    			<label>Avarias - <a data-toggle="tab" href="#m1">Menu 1</a></label>
				    			<input type="text" name="form1" class="form-control"><br>
				    			<button class="btn btn-success">Registrar</button>
				    		</form>
			    		</div>
			    	</div>
		    		<hr>
		    		<div class="row">
		    			<div class="col-sm-6">
		    				<form method="POST">
				    			<label>Tipo de Doc 01 - <a data-toggle="tab" href="#m2">Menu 2</a></label>
				    			<input type="text" name="form3" class="form-control"><br>
				    			<button class="btn btn-success">Registrar</button>
				    		</form>
		    			</div>
		    			<div class="col-sm-6">
		    				<form method="POST">
				    			<label>Frete - <a data-toggle="tab" href="#m3">Menu 3</a></label>
				    			<input type="text" name="form4" class="form-control"><br>
				    			<button class="btn btn-success">Registrar</button>
				    		</form>
		    			</div>
		    		</div>
		    		
		    		<hr>
		    		<form method="POST">
		    			<label>Tipos de Doc 02 - <a data-toggle="tab" href="#m4">Menu 4</a></label>
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
				</ul>

				<div class="tab-content">
				  <div id="m1" class="tab-pane fade in active">
				    <h3>Tipo de Avarias</h3>
				    <div class="table-responsive">
				    	<table class="table table-hover">
				    		<thead>
				    			<tr>
				    				<th>Ação</th>
				    				<th>Tipos de Avarias</th>
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
										        	<input type="text" name="menu1" class="form-control" value="<?=$v['dano']; ?>"><br>
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
				    					<?=$v['dano']; ?>
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
				    <h3>Tido de Doc 01</h3>

				    <div class="table-responsive">
				    	<table class="table table-hover">
				    		<thead>
				    			<tr>
				    				<th>Ação</th>
				    				<th>Tipo Doc.</th>
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
										        <h4 class="modal-title">Tipo de Doc 01</h4>
										      </div>
										      <div class="modal-body">
										        <form method="POST">
										        	<input type="text" hidden="" name="menu3_id" value="<?=$v['id']; ?>">
										        	<input type="text" name="menu3" class="form-control" value="<?=$v['tipo_doc']; ?>"><br>
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
				    					<?=$v['tipo_doc']; ?>
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
				    <h3>Frete</h3>

				    <div class="table-responsive">
				    	<table class="table table-hover">
				    		<thead>
				    			<tr>
				    				<th>Ação</th>
				    				<th>Frete</th>
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
										        <h4 class="modal-title">Frete</h4>
										      </div>
										      <div class="modal-body">
										        <form method="POST">
										        	<input type="text" hidden="" name="menu4_id" value="<?=$v['id']; ?>">
										        	<input type="text" name="menu4" class="form-control" value="<?=$v['frete']; ?>"><br>
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
				    					<?=$v['frete']; ?>
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
				    <h3>Tipos de Doc 02</h3>

				    <div class="table-responsive">
				    	<table class="table table-hover">
				    		<thead>
				    			<tr>
				    				<th>Ação</th>
				    				<th>Tipos de Doc</th>
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
										        <h4 class="modal-title">Tipos de Doc 02</h4>
										      </div>
										      <div class="modal-body">
										        <form method="POST">
										        	<input type="text" hidden="" name="menu5_id" value="<?=$v['id']; ?>">
										        	<input type="text" name="menu5" class="form-control" value="<?=$v['tipo_doc']; ?>"><br>
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
				    					<?=$v['tipo_doc']; ?>
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
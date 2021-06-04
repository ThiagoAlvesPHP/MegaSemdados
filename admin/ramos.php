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

$sql = new Ramos();
$at = $sql->getRamos();
?>
<br><br><br>
<div class="container">
	<div class="row">
		<div class="col-sm-6">
			<div class="panel panel-primary">
			<?php  
			if (isset($_GET['id']) && !empty($_GET['id'])) {
				$getRamo = $sql->getRamo(addslashes($_GET['id']));

				if (!empty($_POST['ramoUP'])) {
					$ramo = addslashes($_POST['ramoUP']);
					$sql->upRamo($ramo, addslashes($_GET['id']));
					?>
					<script>
						alert("Alterado com sucesso!");
						window.location.assign("ramos.php");
					</script>
					<?php
				}
				?>
				<div class="panel-heading">
		      	Edição de Ramo
			    </div>
			    <div class="panel-body">
			      	<form method="POST">
			      		<label>Ramo</label>
			      		<input type="text" value="<?=$getRamo['ramo']; ?>" name="ramoUP" class="form-control">
			      		<br>
			      		<a class="btn btn-danger" href="index.php">Voltar</a>
			      		<button class="btn btn-success">Atualizar</button>
			      	</form>
			    </div>
				<?php
			} else {
				if (!empty($_POST['ramo'])) {
					$ramo = addslashes($_POST['ramo']);
					$sql->setRamo($ramo);
					?>
					<script>
						alert("Registrado com sucesso!");
						window.location.assign("ramos.php");
					</script>
					<?php
				}
				?>
				<div class="panel-heading">
		      	Cadastro de Ramos
			    </div>
			    <div class="panel-body">
			      	<form method="POST">
			      		<label>Ramo</label>
			      		<input type="text" name="ramo" class="form-control">
			      		<br>
			      		<a class="btn btn-danger" href="index.php">Voltar</a>
			      		<button class="btn btn-success">Registrar</button>
			      	</form>
			    </div>
				<?php
			}
			?>
		      
		    </div>
		</div>
		<div class="col-sm-6">
			<div class="panel panel-primary">
		      <div class="panel-heading">
		      	Lista de Ramos
		      </div>
		      <div class="panel-body">
		      	<div class="table-responsive">
		      		<table class="table table-hover">
		      			<thead>
		      				<tr>
		      					<th width="50">Ação</th>
		      					<th>Ramo</th>
		      				</tr>
		      			</thead>
		      			<?php  
		      			foreach ($at as $a) {
		      				?>
		      				<tbody>
			      				<tr>
			      					<td>
			      						<a class="fa fa-edit" href="ramos.php?id=<?=$a['id']; ?>"></a>
			      					</td>
			      					<td><?=htmlspecialchars($a['ramo']); ?></td>
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

<?php  
require 'footer.php';
?>
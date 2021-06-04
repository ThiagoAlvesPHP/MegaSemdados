<?php  
require 'header.php';
$sql = new Atividades();
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

if (!empty($_POST['atividade'])) {
	$atividade = addslashes($_POST['atividade']);
	$sql->setAtididade($atividade);
	?>
	<script>
		alert("Registrado com sucesso!");
		window.location.assign("atividades.php");
	</script>
	<?php
}

$at = $sql->getAtividades();
?>
<br><br><br>
<div class="container">
	<div class="row">
		<div class="col-sm-6">
			<div class="panel panel-primary">
			<?php  
			if (isset($_GET['id']) && !empty($_GET['id'])) {
				$getAtividade = $sql->getAtividade(addslashes($_GET['id']));

				if (!empty($_POST['atividadeUP'])) {
					$atividade = addslashes($_POST['atividadeUP']);
					$sql->upAtididade($atividade, addslashes($_GET['id']));
					?>
					<script>
						alert("Alterado com sucesso!");
						window.location.assign("atividades.php");
					</script>
					<?php
				}
				?>
				<div class="panel-heading">
		      	Edição de Atividade
			    </div>
			    <div class="panel-body">
			      	<form method="POST">
			      		<label>Atividade</label>
			      		<input type="text" value="<?=$getAtividade['atividade']; ?>" name="atividadeUP" class="form-control"><br>
			      		<a class="btn btn-danger" href="index.php">Voltar</a>
			      		<button class="btn btn-success">Atualizar</button>
			      	</form>
			    </div>
				<?php
			} else {
				?>
				<div class="panel-heading">
		      	Cadastro de Atividades
			    </div>
			    <div class="panel-body">
			      	<form method="POST">
			      		<label>Atividade</label>
			      		<input type="text" name="atividade" class="form-control"><br>
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
		      	Lista de Atividades
		      </div>
		      <div class="panel-body">
		      	<div class="table-responsive">
		      		<table class="table table-hover">
		      			<thead>
		      				<tr>
		      					<th width="50">Ação</th>
		      					<th>Atividade</th>
		      				</tr>
		      			</thead>
		      			<?php  
		      			foreach ($at as $a) {
		      				?>
		      				<tbody>
			      				<tr>
			      					<td>
			      						<a class="fa fa-edit" href="atividades.php?id=<?=$a['id']; ?>"></a>
			      					</td>
			      					<td><?=htmlspecialchars($a['atividade']); ?></td>
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
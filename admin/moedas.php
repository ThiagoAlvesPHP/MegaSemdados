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

$sql = new Moedas();
$at = $sql->getMoedas();
?>
<br><br><br>
<div class="container">
	<div class="row">
		<div class="col-sm-6">
			<div class="panel panel-primary">
			<?php  
			if (isset($_GET['id']) && !empty($_GET['id'])) {
				$getMoeda = $sql->getMoeda(addslashes($_GET['id']));

				if (!empty($_POST['moedaUP']) && !empty($_POST['nomeUP'])) {
					$moeda = addslashes($_POST['moedaUP']);
					$nome = addslashes($_POST['nomeUP']);
					$sql->upMoeda($moeda, $nome, addslashes($_GET['id']));
					?>
					<script>
						alert("Alterado com sucesso!");
						window.location.assign("moedas.php");
					</script>
					<?php
				}
				?>
				<div class="panel-heading">
		      	Edição de Moedas
			    </div>
			    <div class="panel-body">
			      	<form method="POST">
			      		<label>Moeda</label>
			      		<input type="text" value="<?=$getMoeda['moeda']; ?>" name="moedaUP" class="form-control">
			      		<label>Nome</label>
			      		<input type="text" value="<?=$getMoeda['nome']; ?>" name="nomeUP" class="form-control">
			      		<br>
			      		<a class="btn btn-danger" href="index.php">Voltar</a>
			      		<button class="btn btn-success">Atualizar</button>
			      	</form>
			    </div>
				<?php
			} else {
				if (!empty($_POST['moeda']) && !empty($_POST['nome'])) {
					$moeda = addslashes($_POST['moeda']);
					$nome = addslashes($_POST['nome']);
					$sql->setMoeda($moeda, $nome);
					?>
					<script>
						alert("Registrado com sucesso!");
						window.location.assign("moedas.php");
					</script>
					<?php
				}
				?>
				<div class="panel-heading">
		      	Cadastro de Moedas
			    </div>
			    <div class="panel-body">
			      	<form method="POST">
			      		<label>Moeda</label>
			      		<input type="text" name="moeda" class="form-control">
			      		<label>Nome</label>
			      		<input type="text" name="nome" class="form-control">
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
		      	Lista de Moedas
		      </div>
		      <div class="panel-body">
		      	<div class="table-responsive">
		      		<table class="table table-hover">
		      			<thead>
		      				<tr>
		      					<th width="50">Ação</th>
		      					<th width="100">Moeda</th>
		      					<th>Nome</th>
		      				</tr>
		      			</thead>
		      			<?php  
		      			foreach ($at as $a) {
		      				?>
		      				<tbody>
			      				<tr>
			      					<td>
			      						<a class="fa fa-edit" href="moedas.php?id=<?=$a['id']; ?>"></a>
			      					</td>
			      					<td><?=htmlspecialchars($a['moeda']); ?></td>
			      					<td><?=htmlspecialchars($a['nome']); ?></td>
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
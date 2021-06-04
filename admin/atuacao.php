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

$sql = new Atuacao();
$at = $sql->getAtuacao();
?>
<br><br><br>
<div class="container">
	<div class="row">
		<div class="col-sm-6">
			<div class="panel panel-primary">
			<?php  
			if (isset($_GET['id']) && !empty($_GET['id'])) {
				$getAtuacaoID = $sql->getAtuacaoID(addslashes($_GET['id']));

				if (!empty($_POST['atuacaoUP'])) {
					$atuacao = addslashes($_POST['atuacaoUP']);
					$sql->upAtuacao($atuacao, addslashes($_GET['id']));
					?>
					<script>
						alert("Alterado com sucesso!");
						window.location.assign("atuacao.php");
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
			      		<input type="text" value="<?=$getAtuacaoID['atuacao']; ?>" name="atuacaoUP" class="form-control">
			      		<br>
			      		<a class="btn btn-danger" href="index.php">Voltar</a>
			      		<button class="btn btn-success">Atualizar</button>
			      	</form>
			    </div>
				<?php
			} else {
				if (!empty($_POST['atuacao'])) {
					$atuacao = addslashes($_POST['atuacao']);
					$sql->setAtuacao($atuacao);
					?>
					<script>
						alert("Registrado com sucesso!");
						window.location.assign("atuacao.php");
					</script>
					<?php
				}
				?>
				<div class="panel-heading">
		      	Cadastro de Atuação
			    </div>
			    <div class="panel-body">
			      	<form method="POST">
			      		<label>Atuação</label>
			      		<input type="text" name="atuacao" class="form-control">
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
		      	Lista de Atuaçao
		      </div>
		      <div class="panel-body">
		      	<div class="table-responsive">
		      		<table class="table table-hover">
		      			<thead>
		      				<tr>
		      					<th width="50">Ação</th>
		      					<th>Atuação</th>
		      				</tr>
		      			</thead>
		      			<?php  
		      			foreach ($at as $a) {
		      				?>
		      				<tbody>
			      				<tr>
			      					<td>
			      						<a class="fa fa-edit" href="atuacao.php?id=<?=$a['id']; ?>"></a>
			      					</td>
			      					<td><?=htmlspecialchars($a['atuacao']); ?></td>
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
<?php
require 'header.php';
$sql = new Cadastros();
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

//CADASTRO DE FUNCIONARIO
if (!empty($_POST['nome'])) {
	$nome = addslashes($_POST['nome']);
	$cpf = addslashes($_POST['cpf']);
	$rg = addslashes($_POST['rg']);
	$dt_nasc = addslashes($_POST['dt_nasc']);
	$email = addslashes($_POST['email']);
	$login = addslashes($_POST['login']);
	$senha = addslashes($_POST['senha']);
	$nivel = addslashes($_POST['nivel']);

	$ver = $sql->setFuncionario($nome, $cpf, $rg, $dt_nasc, $email, $login, $senha, $nivel);
	if ($ver == true) {
		?>
		<script>
			alert("Registrado com sucesso!");
			window.location.assign("funcionarioCad.php");
		</script>
		<?php
	} else {
		$alert = '<div class="alert alert-danger">
					  <strong>Alerta!</strong> CPF e/ou Login já estão cadastrados.
					</div>';
	}
}

$dbFunc = new Funcionarios();
//FUNCIONARIOS
$funcAll = $dbFunc->getFunc();
?>
<br><br><br>
<div class="container">
	<div class="row">
		<div class="col-sm-6">
			<div class="panel panel-primary">
		      <div class="panel-heading">
		      	<label>Alterar dados de Funcionário</label>
		      </div>
		      <div class="panel-body">
		      	<?php
		      	if (isset($alert) && !empty($alert)) {
		      		echo $alert;
		      	}

		      	if (isset($_GET['id']) && !empty($_GET['id'])) {
		      		$id = addslashes($_GET['id']);
		      		$dados = $dbFunc->getFuncionario($id);

		      		//ALTERANDO DADOS DO FUNCIONARIO
		      		if (!empty($_POST['nomeUP'])) {
		      			$nomeUP = addslashes($_POST['nomeUP']);
		      			$cpfUP = addslashes($_POST['cpfUP']);
		      			$rgUP = addslashes($_POST['rgUP']);
		      			$dt_nascUP = addslashes($_POST['dt_nascUP']);
		      			$emailUP = addslashes($_POST['emailUP']);
		      			$nivelUP = addslashes($_POST['nivelUP']);
		      			$statusUP = addslashes($_POST['statusUP']);

		      			$dbFunc->upFunc($nomeUP, $cpfUP, $rgUP, $dt_nascUP, $emailUP, $nivelUP, $statusUP, $id);
		      			?>
						<script>
							alert("Alterado com sucesso!");
							window.location.assign("funcionarioCad.php");
						</script>
						<?php
		      		}
		      		//ALTERAR SENHA
		      		if (!empty($_POST['newSenha'])) {
		      			$senha = addslashes($_POST['newSenha']);

		      			$dbFunc->upPassFun($senha, $id);
		      			?>
						<script>
							alert("Senha alterada com sucesso!");
							window.location.assign("funcionarioCad.php");
						</script>
						<?php
		      		}

		      		//NOME + STATUS
		      		echo '<strong style="float: left;">'.$dados['nome'].' /</strong> ';
	      			if ($dados['status'] == 1) {
	      				echo '<span class="fa fa-check-circle" style="color: green; margin-left:5px;"> Ativo</span>';
	      			} else {
	      				echo '<span class="fa fa-minus-circle" style="color: red; margin-left:5px;"> Inativo</span>';
	      			}
	      			?>
		      		<hr>
		      		<form method="POST">
			      		<label>Nome:</label>
			      		<input type="text" name="nomeUP" class="form-control" placeholder="Nome Completo" value="<?=$dados['nome']; ?>">
			      		<div class="row">
			      			<div class="col-sm-6">
			      				<label>CPF:</label>
			      				<input type="text" id="cpf" name="cpfUP" class="form-control" placeholder="Número do CPF" value="<?=$dados['cpf']; ?>">
			      			</div>
			      			<div class="col-sm-6">
			      				<label>RG:</label>
			      				<input type="text" name="rgUP" class="form-control" value="<?=$dados['rg']; ?>">
			      			</div>
			      		</div>
			      		<label>Data de Nascimento:</label>
			      		<input type="date" name="dt_nascUP" class="form-control" value="<?=$dados['dt_nasc']; ?>">
			      		<label>E-mail:</label>
			      		<input type="email" name="emailUP" class="form-control" value="<?=$dados['email']; ?>">
			      		
			      		<label>Nível:</label>
			      		<select name="nivelUP" class="form-control">
			      			<?php
			      			if ($dados['nivel'] == 1) {
			      				echo '<option value="1">Funcionário</option>';
			      				echo '<option value="2">Administrativo</option>';
			      			} else {
			      				echo '<option value="2">Administrativo</option>';
			      				echo '<option value="1">Funcionário</option>';
			      			}
			      			?>
			      		</select>

			      		<label style="float: left;">Status: </label>
			      		<select name="statusUP" class="form-control">
			      			<?php
			      			if ($dados['status'] == 1) {
			      				echo '<option value="1">Ativo</option>';
			      				echo '<option value="0">Inativo</option>';
			      			} else {
			      				echo '<option value="0">Inativo</option>';
			      				echo '<option value="1">Ativo</option>';
			      			}
			      			?>
			      		</select><br>


	      				<a href="index.php" class="btn btn-danger">Voltar</a>
	      				<button class="btn btn-primary">Atualizar</button>

	      				<button style="float: right;" type="button" class="btn btn-info" data-toggle="modal" data-target="#altSenha">Alterar Senha</button>
			      			
			      		
			      	</form>	

					  <!-- MODA ALTERAR SENHA -->
					  <div class="modal fade" id="altSenha" role="dialog">
					    <div class="modal-dialog modal-sm">
					      <div class="modal-content">
					        <div class="modal-header">
					          <button type="button" class="close" data-dismiss="modal">&times;</button>
					          <h4 class="modal-title">Aletar Senha</h4>
					        </div>
					        <div class="modal-body">
					          <form method="POST">
					          	<label>Nova Senha</label>
					          	<input type="password" required="" placeholder="Digite a Nova Senha" name="newSenha" class="form-control"><br>
					          	<button class="btn btn-primary btn-block">Alterar</button>
					          </form>
					        </div>
					        <div class="modal-footer">
					          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					        </div>
					      </div>
					    </div>
					  </div>

		      		<?php
		      	} else {
		      		?>
		      		<form method="POST">
			      		<label>Nome:</label>
			      		<input type="text" name="nome" class="form-control" placeholder="Nome Completo" required="">
			      		<div class="row">
			      			<div class="col-sm-6">
			      				<label>CPF:</label>
			      				<input type="text" id="cpf" name="cpf" class="form-control" placeholder="Número do CPF" required="">
			      			</div>
			      			<div class="col-sm-6">
			      				<label>RG:</label>
			      				<input type="text" name="rg" class="form-control" placeholder="Número do RG" required="">
			      			</div>
			      		</div>
			      		<label>Data de Nascimento:</label>
			      		<input type="date" name="dt_nasc" class="form-control" placeholder="Data de Nascimento" required="">
			      		<label>E-mail:</label>
			      		<input type="email" name="email" class="form-control" placeholder="Digite o E-mail" required="">
			      		<label>Login:</label>
			      		<input type="text" name="login" class="form-control" placeholder="Digite um Login" required="">
			      		<label>Senha:</label>
			      		<input type="password" name="senha" class="form-control" placeholder="Digite uma Senha" required="">
			      		<label>Nível:</label>
			      		<select name="nivel" class="form-control">
			      			<option value="1">Funcionário</option>
			      			<option value="2">Administrativo</option>
			      		</select><br>
			      		<a href="index.php" class="btn btn-danger">Voltar</a>
			      		<button class="btn btn-success">Registrar</button>
			      	</form>
		      		<?php
		      	}
		      	?>
		      	
		      </div>
		    </div>
		</div>
		<div class="col-sm-6">
			<div class="panel panel-primary">
		      <div class="panel-heading">
		      	<div class="row">
	      			<div class="col-sm-12">
	      				<label>Funcionários Cadastrados</label>
	      			</div>
	      		</div>
		      </div>
		      <div class="panel-body">
		      	<div class="table-responsive">
		      		<table class="table table-hover">
		      			<thead>
		      				<tr>
		      					<th>Nome</th>
		      					<th>CPF</th>
		      					<th>Status</th>
		      					<th>Ação</th>
		      				</tr>
		      			</thead>
		      			<?php
		      			foreach ($funcAll as $f) {
		      				?>
		      				<tbody>
			      				<tr>
			      					<td><?=htmlspecialchars($f['nome']); ?></td>
			      					<td><?=htmlspecialchars($f['cpf']); ?></td>
			      					<td>
			      						<?php
			      						if ($f['status'] == 1) {
						      				echo '<span class="fa fa-check-circle" style="color: green; margin-left:5px;"> Ativo</span>';
						      			} else {
						      				echo '<span class="fa fa-minus-circle" style="color: red; margin-left:5px;"> Inativo</span>';
						      			}
			      						?>
			      					</td>
			      					<td width="50px">
			      						<a href="funcionarioCad.php?id=<?=$f['id']; ?>" class="btn btn-info">Editar</a>
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


<?php
require 'footer.php';
?>
<script type="text/javascript">
	$(function(){
	  $('#cpf').mask('000.000.000-00');  
	  
	});
</script>
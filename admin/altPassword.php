<?php
require 'header.php';

if (!empty($_POST['senha']) && !empty($_POST['newsenha'])) {
	$senha = addslashes($_POST['senha']);
	$newsenha = addslashes($_POST['newsenha']);
	//SE SENHA DIGITADA FOR IGUAL A ATUAL
	if (md5($senha) == $usuario['senha']) {
		$n->upPassFun($newsenha, $id_user);
		?>
		<script>
			alert("Alterado com sucesso!");
			window.location.assign("altPassword.php");
		</script>
		<?php
	} else {
		$alert = '<div class="alert alert-danger">
				  <strong>Alerta!</strong> Sua senha atual foi digitada incorretamente</div>';
	}
}
?>
<br><br><br>
<div class="container">
	<div class="panel panel-success">
      	<div class="panel-heading">
      		<h3>Alteração de Senha</h3>
      	</div>
      	<div class="panel-body">
      		<?php
      		if (isset($alert)) {
      			echo $alert;
      		}
      		?>
      		<form method="POST">
      			<label>Senha Atual</label>
      			<input type="password" name="senha" class="form-control" placeholder="Digite sua senha atual">
      			<hr>
      			<label>Nova Senha</label>
      			<input type="password" name="newsenha" class="form-control" placeholder="Digite sua nova senha"><br>
      			<button class="btn btn-primary">Alterar</button>
      		</form>
      	</div>
    </div>
</div>
<?php
require 'footer.php';
?>
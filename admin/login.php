<?php
require 'autoload.php';
//SE USUARIO ESTIVER LOGADO ENVIAR PARA INDEX.PHP
if (isset($_SESSION['cLogin']) && !empty($_SESSION['cLogin'])) {
	header('Location: index.php');
}

$sql = new login();
//LOGANDO NO SISTEMA
if (!empty($_POST['login']) && !empty($_POST['senha'])) {
	$login = addslashes($_POST['login']);
	$senha = addslashes($_POST['senha']);

	$_POST['g-recaptcha-response'] = true;

	if (!empty($_POST['g-recaptcha-response'])) {
		if ($sql->logar($login, $senha)) {
			header('Location: index.php');
		} else {
			$alert = '<div class="alert alert-danger">
						  <strong>Alerta!</strong> Login e/ou senha incorretos ou status inativo.
						</div>';
		}
	} else {
		$alert = '<div class="alert alert-danger">
						  <strong>Alerta!</strong> Recaptcha não esta preenchido!.
						</div>';
	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Área de Login Administrativo</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="assets/img/favicon.png" type="image/x-icon"/>
	<link rel="stylesheet" href="assets/css/bootstrap.css">
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>
	<style type="text/css">
		body{
			background-image: linear-gradient( to right, #00CED1, blue );
		}
	</style>
	<script type="text/javascript">
      var verifyCallback = function(response) {
        
      };
      var onloadCallback = function() {
        grecaptcha.render('rec', {
          'sitekey' : '6LftKq8UAAAAANuvq7Aa1_UviJKp0-96fFoyUlug',
          'callback' : verifyCallback,
          'theme' : 'ligth'
        });
      };
    </script>
</head>
<body>

<div class="container">
	<div class="row">
		<div class="col-sm-3"></div>
		<div class="col-sm-6">
			<br><br>
			<div class="alert alert-success">
				<center>
					<img src="assets/img/MegaB.png" width="200px" class="img-rounded">
					<br>
					<h4>Área Administrativa</h4>
					<?php
					if (isset($alert) && !empty($alert)) {
						echo $alert;
					}
					?>
					<hr>
				</center>
				<form method="POST" action="?">
					<label>Login:</label>
					<input type="text" name="login" autofocus="" class="form-control" required="">
					<label>Senha:</label>
					<input type="password" name="senha" class="form-control" required="">
					<br>
					<center>
						<div id="rec"></div>
					</center>
					<br>
					<button class="btn btn-success btn-lg btn-block" value="getResponse">Logar</button>
					<br>
					<a href="../index.php">Pagina Anterior</a>
				</form>
			</div>
		</div>
		<div class="col-sm-3"></div>
	</div>
</div>

<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"
        async defer>
	</script>

</body>
</html>
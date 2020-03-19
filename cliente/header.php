<?php
require 'autoload.php';
  if (isset($_SESSION['cLoginCliente']) && !empty($_SESSION['cLoginCliente'])) {
    $id_user = addslashes($_SESSION['cLoginCliente']);

  } else {
    header('Location: login.php');
  }

  $url = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
  $exp = explode('.', $url);

  if ($exp[1] == 'cliente') {
    echo '<script>alert("URL Corrigida, tente logar novamente!");</script>';
    echo '<script>window.location.href="https://www.megasystemreguladora.com.br/cliente/index.php";</script>';
  }

  $user = new Cliente();
  $dados = $user->cliente($id_user);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Mega Adm</title>
	<meta charset="utf-8">
  <link rel="icon" href="../admin/assets/img/favicon.png" type="image/x-icon"/>
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<link rel="stylesheet" href="assets/css/bootstrap.css">
  <link rel="stylesheet" href="assets/css/fontawesome/css/all.min.css">
  <link rel="stylesheet" href="assets/datetime/jquery.datetimepicker.css">
  <style type="text/css">
    .navbar{
      background-color: #191970;
    }
    #navbar li a{
      color: #fff;
    }
    #navbar ul li ul a{
      color: #000;
    }
    .navbar .navbar-brand{
      color: #fff;
    }
  </style>
</head>
<body style="background: #DCDCDC;">

<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php">Mega Reguladora</a>
    </div>
    <div class="collapse navbar-collapse" id="navbar">
      <ul class="nav navbar-nav">
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><b><?=$dados['apelido']; ?></b> <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li class="divider"></li>
              <li><a href="config.php">Alterar Senha</a></li>
              <li class="divider"></li>
              <li><a href="sair.php">Sair</a></li>
              <li class="divider"></li>
            </ul>
          </li>
      </ul>
    </div>
  </div>
</nav>
<br><br><br>
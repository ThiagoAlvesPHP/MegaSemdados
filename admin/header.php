<?php
require 'autoload.php';
$url = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$conexao = 'localhost';
preg_match( "/{$conexao}/i", $url, $match);

if (!empty($match)) {
  define("URL", "http://localhost/MEGA_SANDRO/admin/");
} else {
  define("URL", "https://megasystemreguladora.com.br/admin/");
}


  if (isset($_SESSION['cLogin']) && !empty($_SESSION['cLogin'])) {
    $id_user = addslashes($_SESSION['cLogin']);
    $n = new Funcionarios();

    $usuario = $n->getFuncionario($id_user);
  } else {
    header('Location: login.php');
  }
?>
<!DOCTYPE html>
<html>
<head>
	<title>Mega Adm</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
  <link rel="icon" href="assets/img/favicon.png" type="image/x-icon"/>
	<link rel="stylesheet" href="assets/css/bootstrap.css">
  <link rel="stylesheet" href="assets/css/fontawesome/css/all.min.css">
  <link rel="stylesheet" href="assets/datetime/jquery.datetimepicker.css">
  <!-- <link rel="stylesheet" href="assets/css/datatable.css"> -->
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/Chart_js/Chart.min.js"></script>
  <script src="assets/js/Chart_js/Chart.bundle.js"></script>
  <script src="assets/js/Chart_js/utils.js"></script>
  <script src="assets/js/sweetalert.js"></script>
  <!-- <script src="assets/js/datatable.js"></script> -->
  <link rel="stylesheet" type="text/css" href="assets/css/header.css">
</head>

<body>

  <nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
      </div>
      <div class="collapse navbar-collapse" id="navbar">
        <ul class="nav navbar-nav">
            <!-- cadastros -->
            <li id="menu1" class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fas fa-align-justify"></i> 
                <b>Cadastros</b> <span class="caret"></span>
              </a>
              <ul id="submenu1" class="dropdown-menu">
                <li class="divider"></li>
                <li>
                  <a href="pessoaPJGrid.php">
                    <i class="fas fa-balance-scale"></i> 
                    Pessoa Juridica
                  </a>
                </li>
                <li class="divider"></li>
                <li>
                  <a href="pessoaPFGrid.php">
                    <i class="fas fa-user-friends"></i> 
                    Pessoa Fisica
                  </a>
                </li>
                <li class="divider"></li>
                <li>
                  <a href="apoliceGrid.php">
                    <i class="far fa-file"></i> 
                    Apólice do Segurado
                  </a>
                </li>
                <li class="divider"></li>
              </ul>
            </li>
            <!-- processos -->
            <li id="menu2" class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <b>
                  <i class="fas fa-chalkboard-teacher"></i> Processos
                </b> 
                <span class="caret"></span>
              </a>
              <ul id="submenu2" class="dropdown-menu">
                <li class="divider"></li>
                <li>
                  <a href="processoGrid.php">
                    <i class="fas fa-chalkboard-teacher"></i> Processos
                  </a>
                </li>
                <li class="divider"></li>
                <li>
                  <a href="processoRamo.php">
                    <i class="fas fa-search"></i> 
                    Processo por Ramo
                  </a>
                </li>
                <li class="divider"></li>
                <li>
                  <a href="newProcesso.php">
                    <i class="fas fa-newspaper"></i> 
                    Iniciar Novo Processo
                  </a>
                </li>
                <li class="divider"></li>
              </ul>
            </li>
            <!-- gerenciamento -->
            <li class="dropdown" id="menu3">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <b>
                  <i class="fas fa-tasks"></i> 
                  Gerenciamento
                </b> 
                <span class="caret"></span>
              </a>
              <ul id="submenu3" class="dropdown-menu">
                <li class="divider"></li>
                <li><a href="funcionarioCad.php">Cadastro de Funcionário</a></li>
                <li class="divider"></li>
                <li><a href="tipoDoc.php">Tipo Doc. Processo</a></li>
                <li class="divider"></li>
                <li><a href="moedas.php">Tipo de Moeda</a></li>
                <li class="divider"></li>
                <li><a href="ramos.php">Tipo de Ramos</a></li>
                <li class="divider"></li>
                <li><a href="atividades.php">Tipo de Atividade</a></li>
                <li class="divider"></li>
                <li><a href="atuacao.php">Tipo de Atuação</a></li>
                <li class="divider"></li>
                <li><a href="natEvento.php">Natureza do Evento</a></li>
                <li class="divider"></li>
                <li><a href="navMercadoria.php">Mercadoria</a></li>
                <li class="divider"></li>
                <li><a href="nav_12_13_14.php">Navegação 12-13-14</a></li>
                <li class="divider"></li>
                <li><a href="nav_15_16.php">Navegação 15-16</a></li>
                <li class="divider"></li>
              </ul>
            </li>

            <li id="menu4" class="dropdown">
              <a href="#" class="dropdown-toggle text-menu" data-toggle="dropdown">
                <i class="fas fa-coins"></i>
                <b>Financeiro</b> 
                <span class="caret"></span>
              </a>
              <ul id="submenu4" class="dropdown-menu">
                <li class="divider"></li>
                <li class="dropdown-submenu">
                  <a href="">
                    <i class="fas fa-dollar-sign"></i>
                    Contas a Pagar
                  </a>
                  <ul class="dropdown-menu">
                    <li class="divider"></li>
                    <li>
                      <a href="contas.php?type=pagar">
                        <i class="fas fa-file-signature"></i>
                        Cadastrar
                      </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                      <a href="historico.php?type=pagar">
                        <i class="fas fa-money-check-alt"></i>
                        Historico
                      </a>
                    </li>
                    <li class="divider"></li>
                  </ul>
                </li>
                <li class="divider"></li>
                <li class="dropdown-submenu">
                  <a href="">
                    <i class="fas fa-dollar-sign"></i>
                    Contas a Receber
                  </a>
                  <ul class="dropdown-menu">
                    <li class="divider"></li>
                    <li>
                        <a href="contas.php?type=receber">
                          <i class="fas fa-file-signature"></i>
                          Cadastrar
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                      <a href="historico.php?type=receber">
                        <i class="fas fa-money-check-alt"></i>
                        Historico
                      </a>
                    </li>
                    <li class="divider"></li>
                  </ul>
                </li>

                <li class="divider"></li>
                <li class="dropdown-submenu">
                  <a href="">
                    <i class="fas fa-dollar-sign"></i>
                    RDP
                  </a>
                  <ul class="dropdown-menu">
                    <li class="divider"></li>
                    <li>
                        <a href="rdp.php">
                          <i class="fas fa-file-signature"></i>
                          Cadastrar
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                      <a href="rdp_historico.php">
                        <i class="fas fa-money-check-alt"></i>
                        Historico
                      </a>
                    </li>
                    <li class="divider"></li>
                  </ul>
                </li>
                <li class="divider"></li>

                <li class="dropdown-submenu">
                  <a href="">
                    <i class="fas fa-dollar-sign"></i>
                    Despesas SOS
                  </a>
                  <ul class="dropdown-menu">
                    <li class="divider"></li>
                    <li>
                        <a href="despesas_sos.php">
                          <i class="fas fa-file-signature"></i>
                          Cadastrar
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                      <a href="despesas_sos_historico.php">
                        <i class="fas fa-money-check-alt"></i>
                        Historico
                      </a>
                    </li>
                    <li class="divider"></li>
                  </ul>
                </li>
                <li class="divider"></li>
              </ul>
            </li>

            <li class="dropdown" id="menu5">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <b><i class="fas fa-user"></i> <?=$usuario['nome']; ?></b> <span class="caret"></span></a>
              <ul id="submenu5" class="dropdown-menu">
                <li class="divider"></li>
                <li><a href="altPassword.php">
                  <i class="fas fa-key"></i> Alterar minha senha</a>
                </li>
                <li class="divider"></li>
                <li><a href="docs.php">
                  <i class="fab fa-dochub"></i> Documentos</a>
                </li>
                <li class="divider"></li>
              </ul>
            </li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li>
            <?php 
            $ult_acesso = date('Y-m-d');
            $dd = (new Dashboard())->countDiarioBordo($ult_acesso);
            if (!empty($dd)) {
                if ($dd['count'] > 0) {
                  ?>
                 <a id="nt" class="fas fa-bell diario" title="Notificações do Diario de Bordo">/<?=$dd['count']; ?></a>
                 <?php
                } else {
                  ?>
                  <a class="fas fa-bell" title="Notificações do Diario de Bordo">/0</a>
                  <?php
                }
            }
            ?>
          </li>
          <li><a href="sair.php">
            <b><i class="fas fa-sign-out-alt"></i> Sair</b></a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div id="mySidenav" class="sidenav">
    <a id="about" href="index.php">
      <i class="fas fa-tachometer-alt"></i>
    </a>
    <a href="newProcesso.php" id="blog">Processo</a>
    <a id="contact">
      <form method="GET" action="processo.php">
        <input type="text" maxlength="7" name="num_processo" class="form-control seachProcesso" placeholder="Processo" title="Digite o número de um processo e aperte Enter">
      </form>
    </a>
  </div>

  <div id="not" hidden=""></div>
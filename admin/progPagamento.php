<?php
require 'header.php';
$sql = new Processos();
//SEGURADOS
$getCorretora = $sql->getCorretora();
$num_processo = addslashes($_GET['num_processo']);
$p = $sql->getProcesso($num_processo);

?>
<br><br><br>
<div class="row">
	<div class="col-sm-1"></div>
	<div class="col-sm-10">
		<div class="panel panel-success">
	      <div class="panel-heading">
	      	 Cadastro de Processo
	      </div>
	      <div class="panel-body">
	      	<?php require 'navbarProcesso.php'; ?>
	      	<hr>
	      	<h3>Dados do Corretor</h3>
	      	<div class="well">
	      		
	      	</div>
	      </div>
	    </div>
	</div>
	<div class="col-sm-1"></div>
</div>

<?php
require 'footer.php';
?>
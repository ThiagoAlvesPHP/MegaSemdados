<?php
require 'header.php';
$sql = new Processos();
$getProcessos = $sql->getProcessosUlt();

//SEGURADORAS
$getSeguradoras = $sql->getSeguradoras();
$ano = date('y');

if (!empty($_POST['id_empresa']) && !empty($_POST['modal_transport'])) {
	$id_empresa = addslashes($_POST['id_empresa']);
	$modal_transport = addslashes($_POST['modal_transport']);

	echo '<br><br><br>';

	if (!empty($getProcessos)) {
		$explode = explode('/', $getProcessos['num_processo']);
		$num_processo = $ano.'/'.($explode[1]+3);

	} else {
		$v2 = 1206+3;
		$num_processo = $ano.'/'.$v2;
	}

	
	$sql->setProcesso($num_processo, $id_empresa, $modal_transport, $id_user);
	?>
	<script>
		Swal.fire('Registrado com sucesso!');
		setTimeout(success,1500);
		function success(){
			window.location.assign("processo.php?num_processo=<?=$num_processo; ?>");
		}
		
	</script>
	<?php
}
?>

<br><br><br>
<div class="row">
	<div class="col-sm-1"></div>
	<div class="col-sm-10">
		<div class="panel panel-success">
	      <div class="panel-heading">
	      	Novo Processo / <a href="">Retornar</a>
	      </div>
	      <div class="panel-body">
	      	<form method="POST">
	      		<label><span style="color: red;">*</span> Seguradora/Cia:</label>
	      		<select name="id_empresa" multiple class="form-control">
	      			<?php
	      			foreach ($getSeguradoras as $value) {
	      				echo '<option value="'.$value['id'].'">'.$value['razao_social'].'</option>';
	      			}
	      			?>
			    </select><br>
			    <label><span style="color: red;">*</span> Modal de Transporte:</label>
			    <select name="modal_transport" class="form-control">
			    	<option>Selecione...</option>
			        <option value="Rodoviário">1 - Rodoviário</option>
			        <option value="Marítimo">2 - Marítimo</option>
			        <option value="Aério">3 - Aério</option>
			        <option value="Ferroviário">4 - Ferroviário</option>
			    </select><br>
			    <div class="row">
		      			<div class="col-sm-10"></div>
		      			<div class="col-sm-2">
							<a href="index.php" class="btn btn-danger">cancelar</a>	
							<button class="btn btn-primary">Salvar</button>	
		      			</div>
		      		</div>
	      	</form>
	      </div>
	    </div>
	</div>
	<div class="col-sm-1"></div>
</div>


<?php
require 'footer.php';
<?php
require 'header.php';
$get = filter_input_array(INPUT_GET, FILTER_DEFAULT);
//capturando envio post
$post = filter_input_array(INPUT_POST, FILTER_DEFAULT);

//ÁREA DE EDIÇÃO DE DADOS DO CLIENTE PESSOA FISICA
if (!empty($get['id'])) {
	$id = addslashes($get['id']);
	$db = new PJuridica();
	//SELECT DOS DADOS
	$dados = $db->getPJuridicaID($get['id']);

	//ATUALIZAÇÃO DE PESSOA FISICA
	if (!empty($_POST['razao_social'])) {
		
		$post['dt_at'] = date('Y-m-d');
		$post['id_user_at'] = $_SESSION['cLogin'];
		$post['id'] = $get['id'];

		/*echo "<br><br><br><pre>";

		print_r($post);
		exit;*/

		$db->upPJForm($post);
		?>
		<script>
			Swal.fire('Alterado com sucesso!');
			setTimeout(success,1500);
			function success(){
				window.location.assign("pessoaPJForm.php?id=<?=$get['id']; ?>");
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
		      	Dados Pessoa Juridica / <a href="pessoaPFGrid.php">Retornar</a>
		      </div>
		      <div class="panel-body">
		      	<form method="POST">
		      		<label>Razão Social:</label>
		      		<input type="text" name="razao_social" value="<?=$dados['razao_social']; ?>" class="form-control">

		      		<div class="row">
		      			<div class="col-sm-6">
		      				<label>E-mail:</label>
		      				<input type="email" name="email" value="<?=$dados['email']; ?>" class="form-control">
		      				
		      			</div>
		      			<div class="col-sm-6">
		      				<label>CNPJ:</label>
		      				<input type="text" id="cnpj" name="cnpj" value="<?=$dados['cnpj']; ?>" class="form-control">
		      			</div>
		      		</div>
					
		      		<div class="row">
		      			<div class="col-sm-6">
		      				<label>Telefone 01:</label>
		      				<input type="text" name="tel01" value="<?=$dados['tel01']; ?>" class="form-control">
		      			</div>
		      			<div class="col-sm-6">
		      				<label>Telefone 02:</label>
		      				<input type="text" name="tel02" value="<?=$dados['tel02']; ?>" class="form-control">
		      			</div>
		      		</div>

		      		<label>Outras:</label>
		      		<textarea class="form-control" name="outras" value="<?=$dados['outras']; ?>"></textarea>
		      		
		      		<br>
		      		<div class="row">
		      			<div class="col-sm-2">
		      				<label>Segurado?</label><br>
		      				<input type="radio" name="segurado" value="1" <?=($dados['segurado'] == 1)?'checked':''; ?>><label>Sim</label> 
		      				|
		      				<input type="radio" name="segurado" value="0" <?=($dados['segurado'] == 0)?'checked':''; ?>><label>Não</label>
		      			</div>
		      			<div class="col-sm-2">
		      				<label>Seguradora?</label><br>
		      				<input type="radio" name="seguradora" value="1" <?=($dados['seguradora'] == 1)?'checked':''; ?>><label>Sim</label> 
		      				|
		      				<input type="radio" name="seguradora" value="0" <?=($dados['seguradora'] == 0)?'checked':''; ?>><label>Não</label>
		      			</div>
		      			<div class="col-sm-2">
		      				<label>Transportadora?</label><br>
		      				<input type="radio" name="transportadora" value="1" <?=($dados['transportadora'] == 1)?'checked':''; ?>><label>Sim</label> 
		      				|
		      				<input type="radio" name="transportadora" value="0" <?=($dados['transportadora'] == 0)?'checked':''; ?>><label>Não</label>
		      			</div>
		      			<div class="col-sm-2">
		      				<label>Corretor (a)?</label><br>
		      				<input type="radio" name="corretora" value="1" <?=($dados['corretora'] == 1)?'checked':''; ?>><label>Sim</label> 
		      				|
		      				<input type="radio" name="corretora" value="0" <?=($dados['corretora'] == 0)?'checked':''; ?>><label>Não</label>
		      			</div>
		      			<div class="col-sm-2">
		      				<label>Status</label><br>
		      				<input type="radio" name="status" value="1" <?=($dados['status'] == 1)?'checked':''; ?>><label>Ativo</label> 
		      				|
		      				<input type="radio" name="status" value="0" <?=($dados['status'] == 0)?'checked':''; ?>><label>Inativo</label>
		      			</div>
		      		</div>
		      		<hr>
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
} else {
	$sql = new Cadastros();
	//CADASTRO DE PESSOA FISICA
	if (!empty($post['razao_social'])) {
		$post['id_user'] = $id_user;
		$sql->setPJForm($post);		
		?>
		<script>
			Swal.fire('Registrado com sucesso!');
			setTimeout(success,1500);
			function success(){
				window.location.assign("pessoaPJForm.php");
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
		      	Cadastro Pessoa Jurídica / <a href="pessoaPJGrid.php">Retornar</a>
		      </div>
		      <div class="panel-body">
		      	<form method="POST">
		      		<label><span style="color: red;">*</span> Razão Social:</label>
		      		<input type="text" required="" name="razao_social" placeholder="Razão Sozial" class="form-control">
		      		<div class="row">
		      			<div class="col-sm-4">
		      				<label>E-mail:</label>
		      				<input type="text" required="" name="email" placeholder="E-mail" class="form-control">
		      			</div>
		      			<div class="col-sm-8">
		      				<label>CNPF:</label>
		      				<input type="text" required="" id="cnpj" name="cnpj" placeholder="CNPJ" class="form-control">
		      			</div>
		      		</div>
		      		<div class="row">
		      			<div class="col-sm-6">
		      				<label>Telefone 01:</label>
		      				<input type="text" placeholder="Contato telefônico" name="tel01" class="form-control">
		      			</div>
		      			<div class="col-sm-6">
		      				<label>Telefone 02:</label>
		      				<input type="text" name="tel02" placeholder="Contato telefônico" class="form-control">
		      			</div>
		      		</div>
		      		<label>Outras:</label>
		      		<textarea class="form-control" placeholder="Outras Infomações podem ser informadas neste Campo" name="outras"></textarea>
		      		<br>
		      		<div class="row">
		      			<div class="col-sm-2">
		      				<input type="checkbox" name="segurado" value="1"><label>Segurado?</label>
		      			</div>
		      			<div class="col-sm-2">
		      				<input type="checkbox" name="seguradora" value="1"><label>Seguradora?</label>
		      			</div>
		      			<div class="col-sm-2">
		      				<input type="checkbox" name="transportadora" value="1"><label>Transportadora?</label>
		      			</div>
		      			<div class="col-sm-2">
		      				<input type="checkbox" name="corretora" value="1"><label>Corretor (a)?</label>
		      			</div>
		      			<div class="col-sm-2">
		      				<input type="checkbox" name="status" value="1" checked><label>Cadastro Ativo</label>
		      			</div>
		      		</div>
		      		<hr>
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
}

?>



<?php
require 'footer.php';
?>
<script type="text/javascript">
	$(function(){
	  $('#cnpj').mask('00.000.000/0000-00');  
	  
	});
</script>
<?php
require 'header.php';
//ÁREA DE EDIÇÃO DE DADOS DO CLIENTE PESSOA FISICA
if (isset($_GET['id']) && !empty($_GET['id'])) {
	$id = addslashes($_GET['id']);
	$db = new PJuridica();
	//SELECT DOS DADOS
	$dados = $db->getPJuridicaID($id);

	//ATUALIZAÇÃO DE PESSOA FISICA
	if (!empty($_POST['razao_socialUP'])) {
		$razao_social = addslashes($_POST['razao_socialUP']);
		$email = addslashes($_POST['emailUP']);
		$cnpj = addslashes($_POST['cnpjUP']);
		$tel01 = addslashes($_POST['tel01UP']);
		$tel02 = addslashes($_POST['tel02UP']);
		$outras = addslashes($_POST['outrasUP']);
		$segurado = addslashes($_POST['seguradoUP']);
		$seguradora = addslashes($_POST['seguradoraUP']);
		$transportadora = addslashes($_POST['transportadoraUP']);
		$corretora = addslashes($_POST['corretoraUP']);
		$status = addslashes($_POST['statusUP']);
		$dt_at = date('Y-m-d');

		$db->upPJForm($razao_social, $email, $cnpj, $tel01, $tel02, $outras, $segurado, $seguradora, $transportadora, $corretora, $status, $id_user, $dt_at, $id);
		?>
		<script>
			Swal.fire('Alterado com sucesso!');
			setTimeout(success,1500);
			function success(){
				window.location.assign("pessoaPJGrid.php");
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
		      		<input type="text" name="razao_socialUP" value="<?=$dados['razao_social']; ?>" class="form-control">
		      		
		      		
		      		<div class="row">
		      			<div class="col-sm-6">
		      				<label>E-mail:</label>
		      				<input type="email" name="emailUP" value="<?=$dados['email']; ?>" class="form-control">
		      				
		      			</div>
		      			<div class="col-sm-6">
		      				<label>CNPJ:</label>
		      				<input type="text" id="cnpj" name="cnpjUP" value="<?=$dados['cnpj']; ?>" class="form-control">
		      			</div>
		      		</div>
					
		      		<div class="row">
		      			<div class="col-sm-6">
		      				<label>Telefone 01:</label>
		      				<input type="text" name="tel01UP" value="<?=$dados['tel01']; ?>" class="form-control">
		      			</div>
		      			<div class="col-sm-6">
		      				<label>Telefone 02:</label>
		      				<input type="text" name="tel02UP" value="<?=$dados['tel02']; ?>" class="form-control">
		      			</div>
		      		</div>
		      		<label>Outras:</label>
		      		<textarea class="form-control" name="outrasUP" value="<?=$dados['outras']; ?>"></textarea>
		      		<br>
		      		<div class="row">
		      			<div class="col-sm-2">
		      				<?php
		      				if ($dados['segurado'] == 1) {
		      					echo '<input type="checkbox" name="seguradoUP" value="1" checked><label>Segurado?</label>';
		      				} else {
		      					echo '<input type="checkbox" name="seguradoUP" value="1"><label>Segurado?</label>';
		      				}
		      				?>
		      			</div>
		      			<div class="col-sm-2">
		      				<?php
		      				if ($dados['seguradora'] == 1) {
		      					echo '<input type="checkbox" name="seguradoraUP" value="1" checked><label>Seguradora?</label>';
		      				} else {
		      					echo '<input type="checkbox" name="seguradoraUP" value="1"><label>Seguradora?</label>';
		      				}
		      				?>
		      			</div>
		      			<div class="col-sm-2">
		      				<?php
		      				if ($dados['transportadora'] == 1) {
		      					echo '<input type="checkbox" name="transportadoraUP" value="1" checked><label>Transportadora?</label>';
		      				} else {
		      					echo '<input type="checkbox" name="transportadoraUP" value="1"><label>Transportadora?</label>';
		      				}
		      				?>
		      			</div>
		      			<div class="col-sm-2">
		      				<?php
		      				if ($dados['corretora'] == 1) {
		      					echo '<input type="checkbox" name="corretoraUP" value="1" checked><label>Corretor (a)?</label>';
		      				} else {
		      					echo '<input type="checkbox" name="corretoraUP" value="1"><label>Corretor (a)?</label>';
		      				}
		      				?>
		      			</div>
		      			<div class="col-sm-2">
		      				<?php
		      				if ($dados['status'] == 1) {
		      					echo '<input type="checkbox" name="statusUP" value="1" checked><label>Cadastro Ativo</label>';
		      				} else {
		      					echo '<input type="checkbox" name="statusUP" value="1"><label>Cadastro Ativo</label>';
		      				}
		      				?>
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
	if (!empty($_POST['razao_social'])) {
		$razao_social = addslashes($_POST['razao_social']);
		$email = addslashes($_POST['email']);
		$cnpj = addslashes($_POST['cnpj']);
		$tel01 = addslashes($_POST['tel01']);
		$tel02 = addslashes($_POST['tel02']);
		$outras = addslashes($_POST['outras']);
		$segurado = addslashes($_POST['segurado']);
		$seguradora = addslashes($_POST['seguradora']);
		$transportadora = addslashes($_POST['transportadora']);
		$corretora = addslashes($_POST['corretora']);
		$status = addslashes($_POST['status']);

		$sql->setPJForm($razao_social, $email, $cnpj, $tel01, $tel02, $outras, $segurado, $seguradora, $transportadora, $prestadora, $corretora, $status, $id_user);
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
<?php
require 'header.php';

//ÁREA DE EDIÇÃO DE DADOS DO CLIENTE PESSOA FISICA
if (isset($_GET['id_usuario']) && !empty($_GET['id_usuario'])) {
	$id = addslashes($_GET['id_usuario']);
	$db = new Pfisica();
	//SELECT DOS DADOS
	$dados = $db->getPFisica($id);

	//ATUALIZAÇÃO DE PESSOA FISICA
	if (!empty($_POST['apelidoUP'])) {
		$apelido = addslashes($_POST['apelidoUP']);
		$nome = addslashes($_POST['nomeUP']);
		$sobrenome = addslashes($_POST['sobrenomeUP']);
		$email = addslashes($_POST['emailUP']);
		$cpf = addslashes($_POST['cpfUP']);
		$rg = addslashes($_POST['rgUP']);
		$org_em = addslashes($_POST['org_emUP']);
		$dt_emissao = addslashes($_POST['dt_emissaoUP']);
		$sexo = addslashes($_POST['sexoUP']);
		$dt_nac = addslashes($_POST['dt_nacUP']);
		$tel01 = addslashes($_POST['tel01UP']);
		$tel02 = addslashes($_POST['tel02UP']);
		$outras = addslashes($_POST['outrasUP']);

		$status = addslashes($_POST['statusUP']);
		$dt_at = date('Y-m-d');

		$db->upPFForm($apelido, $nome, $sobrenome, $email, $cpf, $rg, $org_em, $dt_emissao, $sexo, $dt_nac, $tel01, $tel02, $outras, $status, $id_user, $dt_at, $id);
		?>
		<script>
			alert("Alterado com sucesso!");
			window.location.assign("pessoaPFGrid.php");
		</script>
		<?php
	}

	?>
	<br><br><br>
	<!--
		EDIÇÃO DE DADOS DA PESSOA FISICA
	-->
	<div class="row">
		<div class="col-sm-1"></div>
		<div class="col-sm-10">
			<div class="panel panel-success">
		      <div class="panel-heading">
		      	Dados Pessoa Física / <a href="pessoaPFGrid.php">Retornar</a>
		      </div>
		      <div class="panel-body">
		      	<form method="POST">
		      		<label>Apelido:</label>
		      		<input type="text" name="apelidoUP" value="<?=$dados['apelido']; ?>" class="form-control">
		      		<div class="row">
		      			<div class="col-sm-4">
		      				<label>Nome:</label>
		      				<input type="text" name="nomeUP" value="<?=$dados['nome']; ?>" class="form-control">
		      			</div>
		      			<div class="col-sm-8">
		      				<label>Sobrenome:</label>
		      				<input type="text" name="sobrenomeUP" value="<?=$dados['sobrenome']; ?>" class="form-control">
		      			</div>
		      		</div>
		      		
		      		<label>E-mail:</label>
		      		<input type="email" name="emailUP" value="<?=$dados['email']; ?>" class="form-control">
		      		<div class="row">
		      			<div class="col-sm-6">
		      				<label>CPF:</label>
		      				<input type="text" id="cpf" name="cpfUP" value="<?=$dados['cpf']; ?>" class="form-control">
		      			</div>
		      			<div class="col-sm-6">
		      				<label>RG:</label>
		      				<input type="text" name="rgUP" value="<?=$dados['rg']; ?>" class="form-control">
		      			</div>
		      		</div>
		      		
		      		<div class="row">
		      			<div class="col-sm-6">
		      				<label>Orgão Emissor:</label>
		      				<input type="text" name="org_emUP" value="<?=$dados['org_em']; ?>" class="form-control">
		      			</div>
		      			<div class="col-sm-6">
		      				<label>Data de Emissão:</label>
		      				<input type="date" name="dt_emissaoUP" value="<?=$dados['dt_emissao']; ?>" class="form-control">
		      			</div>
		      		</div>
		      		<div class="row">
		      			<div class="col-sm-6">
		      				<label>Sexo:</label>
		      				<select class="form-control" name="sexoUP">
		      					<option>Selecione...</option>
		      					<option value="Masculino">Masculino</option>
		      					<option value="Feminino">Feminino</option>
		      					<option value="Não Definido">Não Definido</option>
		      				</select>
		      			</div>
		      			<div class="col-sm-6">
		      				<label>Data de Nascimento:</label>
		      				<input type="date" name="dt_nacUP" value="<?=$dados['dt_nac']; ?>" class="form-control">
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
		      		<?php
      				if ($dados['status'] == 1) {
      					echo '<input type="checkbox" name="statusUP" value="1" checked><label>Cadastro Ativo</label>';
      				} else {
      					echo '<input type="checkbox" name="statusUP" value="1"><label>Cadastro Ativo</label>';
      				}
      				?>
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
	if (isset($_GET['id']) && !empty($_POST['apelido']) && !empty($_POST['nome']) && !empty($_POST['sobrenome']) && !empty($_POST['email'])) {
		$id_empresa = addslashes($_GET['id']);
		$apelido = addslashes($_POST['apelido']);
		$nome = addslashes($_POST['nome']);
		$sobrenome = addslashes($_POST['sobrenome']);
		$email = addslashes($_POST['email']);
		$senha = addslashes($_POST['senha']);
		$cpf = addslashes($_POST['cpf']);
		$rg = addslashes($_POST['rg']);
		$org_em = addslashes($_POST['org_em']);
		$dt_emissao = addslashes($_POST['dt_emissao']);
		$sexo = addslashes($_POST['sexo']);
		$dt_nac = addslashes($_POST['dt_nac']);
		$tel01 = addslashes($_POST['tel01']);
		$tel02 = addslashes($_POST['tel02']);
		$outras = addslashes($_POST['outras']);
		$status = addslashes($_POST['status']);

		$link = 'https://www.megasystemreguladora.com.br/cliente/login.php';
		$assunto = 'Notificação Mega Reguladora';
		$corpo = "Senha de acesso: ".$senha."\r\n\r\nAcesso o Link: ".$link;
		$cabecalho = "FROM: sandro@megareguladora.com.br"."\r\n".
					"Replay-To: ".$email."\r\n".
					"X-Mailer: PHP/".phpversion();
		mail($email, $assunto, $corpo, $cabecalho);

		$ver = $sql->setPFForm($id_empresa, $apelido, $nome, $sobrenome, $email, $senha, $cpf, $rg, $org_em, $dt_emissao, $sexo, $dt_nac, $tel01, $tel02, $outras, $status, $id_user);

		if ($ver == true) {
			?>
			<script>
				alert("Registrado com sucesso!");
				window.location.assign("pessoaPFForm.php?id=<?=$id_empresa; ?>");
			</script>
			<?php
		} else {
			?>
			<script>
				alert("E-mail já esta registrado!");
			</script>
			<?php
		}
	}

	$sqlF = new Pfisica();
	$fis = $sqlF->getPFisicasEmpresa(addslashes($_GET['id']));
	?>
	<br><br><br>
	<div class="container">
		<div class="row">
			<div class="col-sm-6">
				<div class="panel panel-success">
			      <div class="panel-heading">
			      	Cadastro Pessoa Física / <a href="pessoaPFGrid.php">Retornar</a>
			      </div>
			      <div class="panel-body">
			      	<form method="POST">
			      		<label><span style="color: red;">*</span> Apelido:</label>
			      		<input type="text" required="" name="apelido" placeholder="Apelido da pessoa" class="form-control">
			      		<div class="row">
			      			<div class="col-sm-4">
			      				<label><span style="color: red;">*</span> Nome:</label>
			      				<input type="text" required="" name="nome" placeholder="Nome da pessoa" class="form-control">
			      			</div>
			      			<div class="col-sm-8">
			      				<label><span style="color: red;">*</span> Sobrenome:</label>
			      				<input type="text" required="" name="sobrenome" placeholder="Sobrenome da pessoa" class="form-control">
			      			</div>
			      		</div>
			      		
			      		<label><span style="color: red;">*</span> E-mail:</label>
			      		<input type="email" required="" name="email" placeholder="E-mail da pessoa" class="form-control">
			      		<label><span style="color: red;">*</span> Senha:</label>
			      		<input type="password" required="" name="senha" placeholder="Senha da Pessoa" class="form-control">
			      		<div class="row">
			      			<div class="col-sm-6">
			      				<label>CPF:</label>
			      				<input type="text" id="cpf" placeholder="CPF" name="cpf" class="form-control">
			      			</div>
			      			<div class="col-sm-6">
			      				<label>RG:</label>
			      				<input type="text" name="rg" placeholder="Documento RG" class="form-control">
			      			</div>
			      		</div>
			      		
			      		<div class="row">
			      			<div class="col-sm-6">
			      				<label>Orgão Emissor:</label>
			      				<input type="text" name="org_em" placeholder="Orgão emissor do documento" class="form-control">
			      			</div>
			      			<div class="col-sm-6">
			      				<label>Data de Emissão:</label>
			      				<input type="date" name="dt_emissao" placeholder="Data de emissão do documento" class="form-control">
			      			</div>
			      		</div>
			      		<div class="row">
			      			<div class="col-sm-6">
			      				<label>Sexo:</label>
			      				<select class="form-control" name="sexo">
			      					<option>Selecione...</option>
			      					<option value="Masculino">Masculino</option>
			      					<option value="Feminino">Feminino</option>
			      					<option value="Não Definido">Não Definido</option>
			      				</select>
			      			</div>
			      			<div class="col-sm-6">
			      				<label>Data de Nascimento:</label>
			      				<input type="date" name="dt_nac" placeholder="Data de nascimento" class="form-control">
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
			      				<input type="checkbox" name="status" value="1" checked><label>Cadastro Ativo</label>
			      			</div>
			      		</div>
			      		<hr>
			      		<div class="row">
			      			<div class="col-sm-8"></div>
			      			<div class="col-sm-4">
								<a href="index.php" class="btn btn-danger">cancelar</a>	
								<button class="btn btn-primary">Salvar</button>	
			      			</div>
			      		</div>
			      	</form>
			      </div>
			    </div>
			</div>
			<div class="col-sm-6">
				<div class="panel panel-success">
			      <div class="panel-heading">
			      	<?php 
			      	if (!empty($e['razao_social'])) {
			      		echo 'Empresa: '.$e['razao_social'];
			      	} 
			      	?><br>
			      	Lista de Usuários / <a href="pessoaPFGrid.php">Retornar</a>
			      </div>
			      <div class="panel-body">
			      	<div class="table-responsive">
			      		<table class="table table-hover">
			      			<thead>
			      				<tr>
			      					<th>Ação</th>
			      					<th>Apelido</th>
			      					<th>E-mail</th>
			      				</tr>
			      			</thead>
			      			<?php
			      			if (!empty($_POST['senha'])) {
			      				$senha = addslashes($_POST['senha']);
			      				$idCli = addslashes($_POST['id']);
			      				$email = addslashes($_POST['email']);


			      				$link = 'https://www.megasystemreguladora.com.br/cliente/login.php';
								$assunto = 'Notificação Mega Reguladora';
								$corpo = "Senha de acesso: ".$senha."\r\n\r\nAcesso o Link: ".$link;
								$cabecalho = "FROM: sandro@megareguladora.com.br"."\r\n".
											"Replay-To: ".$email."\r\n".
											"X-Mailer: PHP/".phpversion();
								mail($email, $assunto, $corpo, $cabecalho);

								$sqlF->upPFFormPass($senha, $idCli);
								?>
								<script>
									alert("Alterado e enviado por E-mail com sucesso!");
									window.location.assign("pessoaPFGrid.php");
								</script>
								<?php
			      			}
			      			foreach ($fis as $f) {
			      				?>
			      				<tbody>
				      				<tr>
				      					<td>
				      						<a href="pessoaPFForm.php?id_usuario=<?=$f['id']; ?>" class="fa fa-edit" title="Editar dados da Pessoa"></a>

				      						<a type="button" class="fas fa-at" data-toggle="modal" data-target="#myModal" title="Nova Senha"></a>
											<div id="myModal" class="modal fade" role="dialog">
											<div class="modal-dialog">
											<div class="modal-content">
											  <div class="modal-header">
											    <button type="button" class="close" data-dismiss="modal">&times;</button>
											    <h4 class="modal-title">Digite a Nova Senha</h4>
											  </div>
											  <div class="modal-body">
											    <p>
											    	<form method="POST">
											    		<label>Nova Senha</label>
											    		<input type="password" name="senha" class="form-control"><br>
											    		<input type="text" name="email" class="form-control" readonly="" value="<?=$f['email']; ?>">
											    		<input type="text" hidden="" name="id" value="<?=$f['id']; ?>">
											    </p>
											  </div>
											  <div class="modal-footer">
											    <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
											    <button class="btn btn-primary">Salvar</button>
											    </form>
											  </div>
											</div>
											</div>
											</div>

				      					</td>
				      					<td>
				      						<?=htmlspecialchars($f['apelido']); ?>
				      					</td>
				      					<td>
				      						<?=htmlspecialchars($f['email']); ?>
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
}

?>



<?php
require 'footer.php';
?>
<script type="text/javascript">
	$(function(){
	  $('#cpf').mask('000.000.000-00');  
	  
	});
</script>
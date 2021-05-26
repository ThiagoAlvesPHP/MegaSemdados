<?php
require 'header.php';
$sql = new Processos();
//SEGURADOS
$getCidades = $sql->getCidades();
$num_processo = addslashes($_GET['num_processo']);
$p = $sql->getProcesso($num_processo);

$rem = $sql->getRemetente06($num_processo);
$dest = $sql->getDestinatario06($num_processo);
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
	      	<div class="well">
	      		<?php
	      		if (!empty($rem) && !empty($dest)) {
	      			$post = filter_input_array(INPUT_POST, FILTER_DEFAULT);
	      			//UPDATE DE REMETENTE E DESTINATARIO
	      			if (isset($post['razao_socialUP'])) {
	      				$razao_social = $post['razao_socialUP'];
	      				$endereco = $post['enderecoUP'];
	      				$responsavel = $post['responsavelUP'];
	      				$contato = $post['contatoUP'];
	      				$email = $post['emailUP'];
	      				$seguro_proprio = (!empty($post['seguroUP']))?$post['seguroUP']:'0';

	      				$razao_social2 = $post['razao_social2UP'];
	      				$endereco2 = $post['endereco2UP'];
	      				$responsavel2 = $post['responsavel2UP'];
	      				$contato2 = $post['contato2UP'];
	      				$email2 = $post['email2UP'];
	      				$seguro_proprio2 = (!empty($post['seguro2UP']))?$post['seguro2UP']:'0';
	      				
	      				//REGISTRANDO REMETENTE
	      				$sql->upRemetente($num_processo, $razao_social, $endereco, $responsavel, $contato, $email, $seguro_proprio);
	      				//REGISTRANDO DESTINATARIO
	      				$sql->upDestinatario($num_processo, $razao_social2, $endereco2, $responsavel2, $contato2, $email2, $seguro_proprio2);
	      				?>
						<script>
							window.location.href = "processo07.php?num_processo=<?=$num_processo; ?>";
						</script>
						<?php

	      			}
	      			?>
	      			<form method="POST">
		      			<div class="row">
		      				<h3>Dados do Remetente</h3>
		      				<label>Razão Social:</label>
		      				<input type="text" name="razao_socialUP" value="<?=$rem['razao_social']; ?>" placeholder="Razão Social" class="form-control">
		      				<label>Endereço:</label>
		      				<input type="text" value="<?=$rem['endereco']; ?>" name="enderecoUP" placeholder="Endereço" class="form-control">
		      				<label>Responsável:</label>
		      				<input type="text" value="<?=$rem['responsavel']; ?>" name="responsavelUP" placeholder="Responsável" class="form-control">
		      				<label>Telefone:</label>
		      				<input type="text" value="<?=$rem['contato']; ?>" name="contatoUP" placeholder="Contato" class="form-control">
		      				<label>E-mail:</label>
		      				<input type="text" value="<?=$rem['email']; ?>" name="emailUP" placeholder="E-mail" class="form-control">
		      				<label>Seguro Próprio: </label>
		      				<?php
		      				if ($rem['seguro_proprio'] == 1) {
		      					echo '<input value="1" checked type="checkbox" name="seguroUP">';
		      				} else {
		      					echo '<input value="1" type="checkbox" name="seguroUP">';
		      				}
		      				?>
		      				
		      			</div>
		      			<hr>
		      			<div class="row">
		      				<h3>Dados do Destinatario</h3>
		      				<label>Razão Social:</label>
		      				<input type="text" value="<?=$dest['razao_social']; ?>" name="razao_social2UP" placeholder="Razão Social" class="form-control">
		      				<label>Endereço:</label>
		      				<input type="text" value="<?=$dest['endereco']; ?>" name="endereco2UP" placeholder="Endereço" class="form-control">
		      				<label>Responsável:</label>
		      				<input type="text" value="<?=$dest['responsavel']; ?>" name="responsavel2UP" placeholder="Responsável" class="form-control">
		      				<label>Telefone:</label>
		      				<input type="text" value="<?=$dest['contato']; ?>" name="contato2UP" placeholder="Telefone" class="form-control">
		      				<label>E-mail:</label>
		      				<input type="text" value="<?=$dest['email']; ?>" name="email2UP" placeholder="E-mail" class="form-control">
		      				<label>Seguro Próprio: </label>
		      				<?php
		      				if ($dest['seguro_proprio'] == 1) {
		      					echo '<input value="1" checked type="checkbox" name="seguro2UP">';
		      				} else {
		      					echo '<input value="1" type="checkbox" name="seguro2UP">';
		      				}
		      				?>
		      			</div>
					    <br>
					    <div class="row">
			      			<div class="col-sm-10"></div>
			      			<div class="col-sm-2">
								<a href="processo05.php?num_processo=<?=$num_processo; ?>" class="btn btn-danger">Voltar</a>	
								<button class="btn btn-primary">Proximo</button>	
			      			</div>
			      		</div>
			      	</form>
	      			<?php
	      		} else {
	      			$post = filter_input_array(INPUT_POST, FILTER_DEFAULT);
	      			//CADASTRO DE REMETENTE E DESTINATARIO
	      			if (isset($post['razao_social'])) {
	      				$razao_social = $post['razao_social'];
	      				$endereco = $post['endereco'];
	      				$responsavel = $post['responsavel'];
	      				$contato = $post['contato'];
	      				$email = $post['email'];
	      				$seguro_proprio = (!empty($post['seguro_proprio']))?$post['seguro_proprio']:'';

	      				$razao_social2 = $post['razao_social2'];
	      				$endereco2 = $post['endereco2'];
	      				$responsavel2 = $post['responsavel2'];
	      				$contato2 = $post['contato2'];
	      				$email2 = $post['email2'];
	      				$seguro_proprio2 = (!empty($post['seguro_proprio2']))?$post['seguro_proprio2']:'';
	      				
	      				//REGISTRANDO REMETENTE
	      				$sql->setRemetente($num_processo, $razao_social, $endereco, $responsavel, $contato, $email, $seguro_proprio);
	      				//REGISTRANDO DESTINATARIO
	      				$sql->setDestinatario($num_processo, $razao_social2, $endereco2, $responsavel2, $contato2, $email2, $seguro_proprio2);
	      				?>
						<script>
							window.location.href = "processo07.php?num_processo=<?=$num_processo; ?>";
						</script>
						<?php

	      			}
	      			?>
	      			<form method="POST">
		      			<div class="row">
		      				<h3>Dados do Remetente</h3>
		      				<label>Razão Social:</label>
		      				<input type="text" name="razao_social" placeholder="Razão Social" class="form-control">
		      				<label>Endereço:</label>
		      				<input type="text" name="endereco" placeholder="Endereço" class="form-control">
		      				<label>Responsável:</label>
		      				<input type="text" name="responsavel" placeholder="Responsável" class="form-control">
		      				<label>Telefone:</label>
		      				<input type="text" name="contato" placeholder="Telefone" class="form-control">
		      				<label>E-mail:</label>
		      				<input type="text" name="email" placeholder="E-mail" class="form-control">
		      				<label>Seguro Próprio: </label>
		      				<input value="1" type="checkbox" name="seguro_proprio">
		      			</div>
		      			<hr>
		      			<div class="row">
		      				<h3>Dados do Destinatario</h3>
		      				<label>Razão Social:</label>
		      				<input type="text" name="razao_social2" placeholder="Razão Social" class="form-control">
		      				<label>Endereço:</label>
		      				<input type="text" name="endereco2" placeholder="Endereço" class="form-control">
		      				<label>Responsável:</label>
		      				<input type="text" name="responsavel2" placeholder="Responsável" class="form-control">
		      				<label>Telefone:</label>
		      				<input type="text" name="contato2" placeholder="Telefone" class="form-control">
		      				<label>E-mail:</label>
		      				<input type="text" name="email2" placeholder="E-mail" class="form-control">
		      				<label>Seguro Próprio: </label>
		      				<input value="1" type="checkbox" name="seguro_proprio2">
		      			</div>
					    <br>
					    <div class="row">
			      			<div class="col-sm-10"></div>
			      			<div class="col-sm-2">
								<a href="processo05.php?num_processo=<?=$num_processo; ?>" class="btn btn-danger">Voltar</a>	
								<button class="btn btn-primary">Proximo</button>	
			      			</div>
			      		</div>
			      	</form>
	      			<?php
	      		}
	      		?>
	      		
	      	</div>
	      </div>
	    </div>
	</div>
	<div class="col-sm-1"></div>
</div>

<?php
require 'footer.php';
?>
<?php
require 'header.php';
$sql = new Processos();
//SEGURADOS
$num_processo = addslashes($_GET['num_processo']);
$p = $sql->getProcesso($num_processo);

$getCidades = $sql->getCidades();
$nav_def_dest = $sql->nav_def_dest();
$nav_motivo_dec = $sql->nav_motivo_dec();

$getDestMerc = $sql->getDestMerc($num_processo);
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
	      	<h3>Definição de Destino da Mercadoria</h3>
	      	<div class="well">
	      		<form method="POST">
	      			<?php
	      				if (!empty($getDestMerc)) {
      					//ATUALIZANDO DADOS
      					if (isset($_POST['destinoUP'])) {
      						$destino = addslashes($_POST['destinoUP']);
      						$responsavel = addslashes($_POST['responsavelUP']);
      						$contato = addslashes($_POST['contatoUP']);
      						$motivo = addslashes($_POST['motivoUP']);
      						$representante = addslashes($_POST['representanteUP']);
      						$email = addslashes($_POST['emailUP']);
      						$empresa = addslashes($_POST['empresaUP']);
      						$endereco = addslashes($_POST['enderecoUP']);
      						$bairro = addslashes($_POST['bairroUP']);
      						$cep = addslashes($_POST['cepUP']);
      						$cidade = addslashes($_POST['cidade1']);
      						$responsavel2 = addslashes($_POST['responsavel2UP']);
      						$fone = addslashes($_POST['foneUP']);

      						$sql->upDestMerc($num_processo, $destino, $responsavel, $contato, $motivo, $representante, $email, $empresa, $endereco, $bairro, $cep, $cidade, $responsavel2, $fone);
      						?>
							<script>
								window.location.href = "processo25.php?num_processo=<?=$num_processo; ?>";
							</script>
							<?php
      					}
	      			?>
	      			<div class="row">
	      				<div class="col-sm-6">
	      					<label>Definição de Destino:</label>
	      					<select name="destinoUP" class="form-control">
	      						<?php
	      						foreach ($nav_def_dest as $a) {
	      							if ($getDestMerc['destino'] == $a['id']) {
	      								echo '<option selected value="'.$a['id'].'">'.$a['nome'].'</option>';
	      							} else {
	      								echo '<option value="'.$a['id'].'">'.$a['nome'].'</option>';
	      							}
	      						}
					      		?>
	      					</select>
	      					<label>Responsável pela decisão:</label>
	      					<input type="text" name="responsavelUP" value="<?=$getDestMerc['responsavel']; ?>" class="form-control">
	      					<label>Fone (s) de Contato:</label>
	      					<input type="text" name="contatoUP" value="<?=$getDestMerc['contato']; ?>" class="form-control">
	      				</div>
	      				<div class="col-sm-6">
	      					<label>Motivo da decisão:</label>
	      					<select name="motivoUP" class="form-control">
	      						<?php
	      						foreach ($nav_motivo_dec as $a) {
	      							if ($getDestMerc['motivo'] == $a['id']) {
	      								echo '<option selected value="'.$a['id'].'">'.$a['nome'].'</option>';
	      							} else {
	      								echo '<option value="'.$a['id'].'">'.$a['nome'].'</option>';
	      							}
	      						}
					      		?>
	      					</select>
	      					<label>Representante:</label>
	      					<input type="text" name="representanteUP" value="<?=$getDestMerc['representante']; ?>" class="form-control">
	      					<label>E-mail / Contato:</label>
	      					<input type="text" name="emailUP" value="<?=$getDestMerc['email']; ?>" class="form-control">
	      				</div>
	      			</div>
	      			<br>
	      			<h3>Destino da Mercadoria</h3>
	      			<button type="button" class="btn btn-info" data-toggle="collapse" data-target="#demo">Aplicável ?</button>
					<div id="demo" class="collapse show">
						<hr>
						<div class="row">
		      				<div class="col-sm-6">
		      					<label>Empresa:</label>
		      					<input type="text" name="empresaUP" value="<?=$getDestMerc['empresa']; ?>" class="form-control">
		      					<label>Endereço:</label>
		      					<input type="text" name="enderecoUP" value="<?=$getDestMerc['endereco']; ?>" class="form-control">
		      					<label>Bairo:</label>
		      					<input type="text" name="bairroUP" value="<?=$getDestMerc['bairro']; ?>" class="form-control">
		      					<label>CEP:</label>
		      					<input type="text" id="cep" name="cepUP" value="<?=$getDestMerc['cep']; ?>" class="form-control">
		      				</div>
		      				<div class="col-sm-6">
		      					<label>UF/Cidade:</label>
		      					<input type="text" name="city1" id="city1" class="form-control" placeholder="Digite o nome da cidade">
		      					<br>
					      		<select name="cidade1" multiple class="form-control" id="cidades1">
					      			<?php
					      			if (!empty($getDestMerc['cidade'])) {
					      				$d  = $sql->getCidadeID($getDestMerc['cidade']);

					      				echo '<option selected value="'.$d['id'].'">'.$d['nome'].' - '.$d['uf'].' - '.$d['sigla'].'</option>';
					      			} else {
					      				foreach ($getCidades as $value) {
						      				echo '<option value="'.$value['id'].'">'.$value['nome'].' - '.$value['uf'].' - '.$value['sigla'].'</option>';
						      			}
					      			}
					      			?>
							    </select>
		      				</div>
	      				</div>
	      				<div class="row">
	      					<div class="col-sm-6">
	      						<label>Responsável:</label>
	      						<input type="text" name="responsavel2UP" value="<?=$getDestMerc['responsavel2']; ?>" class="form-control">
	      					</div>
	      					<div class="col-sm-6">
	      						<label>Fone(s):</label>
	      						<input type="text" name="foneUP" value="<?=$getDestMerc['fone']; ?>" class="form-control">
	      					</div>
	      				</div>
					</div>
	      			<?php
	      				} else {
	      					//REGISTRANDO DADOS
	      					if (isset($_POST['destino'])) {
	      						$destino = addslashes($_POST['destino']);
	      						$responsavel = addslashes($_POST['responsavel']);
	      						$contato = addslashes($_POST['contato']);
	      						$motivo = addslashes($_POST['motivo']);
	      						$representante = addslashes($_POST['representante']);
	      						$email = addslashes($_POST['email']);
	      						$empresa = addslashes($_POST['empresa']);
	      						$endereco = addslashes($_POST['endereco']);
	      						$bairro = addslashes($_POST['bairro']);
	      						$cep = addslashes($_POST['cep']);
	      						$cidade = addslashes($_POST['cidade1']);
	      						$responsavel2 = addslashes($_POST['responsavel2']);
	      						$fone = addslashes($_POST['fone']);

	      						$sql->setDestMerc($num_processo, $destino, $responsavel, $contato, $motivo, $representante, $email, $empresa, $endereco, $bairro, $cep, $cidade, $responsavel2, $fone);
	      						?>
								<script>
									window.location.href = "processo25.php?num_processo=<?=$num_processo; ?>";
								</script>
								<?php
	      					}
	      					?>
	      			<div class="row">
	      				<div class="col-sm-6">
	      					<label>Definição de Destino:</label>
	      					<select name="destino" class="form-control">
	      						<?php
	      						foreach ($nav_def_dest as $a) {
	      							echo '<option value="'.$a['id'].'">'.$a['nome'].'</option>';
	      						}
	      						?>
	      					</select>
	      					<label>Responsável pela decisão:</label>
	      					<input type="text" name="responsavel" class="form-control">
	      					<label>Fone (s) de Contato:</label>
	      					<input type="text" name="contato" class="form-control">
	      				</div>
	      				<div class="col-sm-6">
	      					<label>Motivo da decisão:</label>
	      					<select name="motivo" class="form-control">
	      						<?php 
	      						foreach ($nav_motivo_dec as $a) {
	      							echo '<option value="'.$a['id'].'">'.$a['nome'].'</option>';
	      						}
	      						?>
	      					</select>
	      					<label>Representante:</label>
	      					<input type="text" name="representante" class="form-control">
	      					<label>E-mail / Contato:</label>
	      					<input type="text" name="email" class="form-control">
	      				</div>
	      			</div>
	      			<br>
	      			<h3>Destino da Mercadoria</h3>
	      			<button type="button" class="btn btn-info" data-toggle="collapse" data-target="#demo">Aplicável ?</button>
					<div id="demo" class="collapse">
						<hr>
						<div class="row">
		      				<div class="col-sm-6">
		      					<label>Empresa:</label>
		      					<input type="text" name="empresa" class="form-control">
		      					<label>Endereço:</label>
		      					<input type="text" name="endereco" class="form-control">
		      					<label>Bairo:</label>
		      					<input type="text" name="bairro" class="form-control">
		      					<label>CEP:</label>
		      					<input type="text" name="cep" class="form-control">
		      				</div>
		      				<div class="col-sm-6">
		      					<label>UF/Cidade:</label>
		      					<input type="text" name="city1" id="city1" class="form-control" placeholder="Digite o nome da cidade">
		      					<br>
					      		<select name="cidade1" multiple class="form-control" id="cidades1">
					      			<?php
					      			if (!empty($p['1'])) {
					      				$d  = $sql->getCidadeID($p['cidade1']);

					      				echo '<option selected value="'.$d['id'].'">'.$d['nome'].' - '.$d['uf'].' - '.$d['sigla'].'</option>';
					      			} else {
					      				foreach ($getCidades as $value) {
						      				echo '<option value="'.$value['id'].'">'.$value['nome'].' - '.$value['uf'].' - '.$value['sigla'].'</option>';
						      			}
					      			}
					      			?>
							    </select>
		      				</div>
	      				</div>
	      				<div class="row">
	      					<div class="col-sm-6">
	      						<label>Responsável:</label>
	      						<input type="text" name="responsavel2" class="form-control">
	      					</div>
	      					<div class="col-sm-6">
	      						<label>Fone(s):</label>
	      						<input type="text" name="fone" class="form-control">
	      					</div>
	      				</div>
					</div>
	      					<?php
	      				}
	      			?>
	      			
	      			<br>
				    <div class="row">
		      			<div class="col-sm-10"></div>
		      			<div class="col-sm-2">
							<a href="processo23.php?num_processo=<?=$num_processo; ?>" class="btn btn-danger">Voltar</a>	
							<button class="btn btn-primary">Proximo</button>	
		      			</div>
		      		</div>
		      	</form>
	      	</div>
	      </div>
	    </div>
	</div>
	<div class="col-sm-1"></div>
</div>

<?php
require 'footer.php';
?>
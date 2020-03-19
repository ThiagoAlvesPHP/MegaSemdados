<?php
require 'header.php';
$sql = new Processos();
//SEGURADOS
$getCidades = $sql->getCidades();
$num_processo = addslashes($_GET['num_processo']);
$p = $sql->getProcesso($num_processo);

$getP18form1 = $sql->processo18_form1($num_processo);
$getP18form2 = $sql->processo18_form2($num_processo);

$getNAv2 = $sql->nav_processo27_10();
$getNav = $sql->nav_processo16();
$getNav4 = $sql->nav_processo16_2();


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
	      		<form method="POST">
	      			<h3>Motorista do Veículo Transbordo</h3>
	      			<button type="button" class="btn btn-info" data-toggle="collapse" data-target="#demo">Aplicável ?</button>

	      			<?php 
	      			if (!empty($getP18form1)) {
	      				//ATUALIZANDO
		      			if (isset($_POST['p1'])) {
		      				$post = filter_input_array(INPUT_POST, FILTER_DEFAULT);
		      				$sql->upProcesso18($num_processo, $post);
		      				?>
							<script>
								window.location.href = "processo18.php?num_processo=<?=$num_processo; ?>";
							</script>
							<?php
		      			}

	      				?>
	      			<div id="demo" class="collapse show">
						<br>
						<div class="row">
							<div class="col-sm-3">
								<label>Vínculo:</label>
								<select class="form-control" name="p1">
									<?php
									foreach ($getNav as $n) {
										if ($getP18form1['p1'] == $n['id']) {
											echo '<option selected value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
										} else {
											echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
										}
										
									}
									?>
								</select>
							</div>
							<div class="col-sm-3">
								<label>Contato / Fone:</label>
								<input type="text" value="<?=$getP18form1['p2'] ?>" name="p2" class="form-control">
							</div>
							<div class="col-sm-3">
								<label>Nome:</label>
								<input type="text" value="<?=$getP18form1['p3'] ?>" name="p3" class="form-control">
							</div>
							<div class="col-sm-3">
								<label>Tempo de Profissão:</label>
								<input type="text" value="<?=$getP18form1['p4'] ?>" name="p4" class="form-control">
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-sm-3">
								<label>Endereço:</label>
								<input type="text" value="<?=$getP18form1['p5'] ?>" name="p5" class="form-control">
							</div>
							<div class="col-sm-3">
								<label>UF/ Estado Residência:</label>
								<input type="text" id="city1" class="form-control" placeholder="Digite o nome da cidade">
					      		<select name="p6" multiple class="form-control" id="cidades1">
					      			<?php
					      			$d  = $sql->getCidadeID($getP18form1['p6']);
					      				
					      			echo '<option selected value="'.$d['id'].'">'.utf8_encode($d['nome']).' - '.$d['uf'].' - '.$d['sigla'].'</option>';
					      			?>
							    </select>
							</div>
							<div class="col-sm-3">
								<label>UF/ Estado Nascimento:</label>
								<input type="text" id="city2" class="form-control" placeholder="Digite o nome da cidade">
					      		<select name="p7" multiple class="form-control" id="cidades2">
					      			<?php
					      			$d  = $sql->getCidadeID($getP18form1['p7']);
					      				
					      			echo '<option selected value="'.$d['id'].'">'.utf8_encode($d['nome']).' - '.$d['uf'].' - '.$d['sigla'].'</option>';
					      			?>
							    </select>
							</div>
							<div class="col-sm-3">
								<label>Estado Civil:</label>
								<select class="form-control" name="p8">
									<?php
									foreach ($getNav4 as $n) {
										if ($getP18form1['p8'] == $n['id']) {
											echo '<option selected value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
										} else {
											echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
										}
									}
									?>
								</select>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-sm-4">
								<label>Data Nascimento:</label>
								<input type="date" value="<?=$getP18form1['p9'] ?>" name="p9" class="form-control">
							</div>
							<div class="col-sm-4">
								<label>Nome do Pai:</label>
								<input type="text" value="<?=$getP18form1['p10'] ?>" name="p10" class="form-control">
							</div>
							<div class="col-sm-4">
								<label>Nome da Mãe:</label>
								<input type="text" value="<?=$getP18form1['p11'] ?>" name="p11" class="form-control">
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-sm-4">
								<label>RG:</label>
								<input type="text" value="<?=$getP18form1['p12'] ?>" name="p12" class="form-control">
							</div>
							<div class="col-sm-4">
								<label>Orgão Emissor:</label>
								<input type="text" value="<?=$getP18form1['p13'] ?>" name="p13" class="form-control">
							</div>
							<div class="col-sm-4">
								<label>CPF:</label>
								<input type="text" value="<?=$getP18form1['p14'] ?>" name="p14" class="form-control cpf">
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-sm-4">
								<label>CNH Reg.:</label>
								<input type="text" value="<?=$getP18form1['p15'] ?>" name="p15" class="form-control">
							</div>
							<div class="col-sm-4">
								<label>Categoria:</label>
								<input type="text" value="<?=$getP18form1['p16'] ?>" name="p16" class="form-control">
							</div>
							<div class="col-sm-4">
								<label>Validade:</label>
								<input type="date" value="<?=$getP18form1['p17'] ?>" name="p17" class="form-control">
							</div>
						</div>
						<br>
						<label>Observações:</label>
						<input type="text" value="<?=$getP18form1['p18'] ?>" name="p18" class="form-control">
						<br>
						<div class="row">
							<div class="col-sm-4">
								<label>Consulta de Cadastro para Ger. de Riscos:</label>
								<select id="rastreamento" class="form-control">
									<option value="0">----</option>
									<?php
									foreach ($getNAv2 as $n) {
										echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
									}
									?>
								</select>
							</div>
							<div class="col-sm-4">
								<label>Liberação Nr.:</label>
								<input type="text" value="<?=$getP18form1['p19'] ?>" name="p19" readonly="" class="form-control value">
							</div>
							<div class="col-sm-4">
								<label>Empresa Responsável:</label>
								<input type="text" value="<?=$getP18form1['p20'] ?>" name="p20" readonly=""  class="form-control value">
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-sm-11"></div>
							<div class="col-sm-1"><button class="btn btn-primary">Salvar</button></div>
						</div>
					</div>
	      				<?php
	      			} else {

	      			//RESGITRANDO
	      			if (isset($_POST['p1'])) {
	      				$post = filter_input_array(INPUT_POST, FILTER_DEFAULT);
	      				$sql->setProcesso18($num_processo, $post);
	      				?>
						<script>
							window.location.href = "processo18.php?num_processo=<?=$num_processo; ?>";
						</script>
						<?php
	      			}

	      				?>
	      			<div id="demo" class="collapse">
						<br>
						<div class="row">
							<div class="col-sm-3">
								<label>Vínculo:</label>
								<select class="form-control" name="p1">
									<?php
									foreach ($getNav as $n) {
										echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
									}
									?>
								</select>
							</div>
							<div class="col-sm-3">
								<label>Contato / Fone:</label>
								<input type="text" name="p2" class="form-control">
							</div>
							<div class="col-sm-3">
								<label>Nome:</label>
								<input type="text" name="p3" class="form-control">
							</div>
							<div class="col-sm-3">
								<label>Tempo de Profissão:</label>
								<input type="text" name="p4" class="form-control">
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-sm-3">
								<label>Endereço:</label>
								<input type="text" name="p5" class="form-control">
							</div>
							<div class="col-sm-3">
								<label>UF/ Estado Residência:</label>
								<input type="text" id="city1" class="form-control" placeholder="Digite o nome da cidade">
					      		<select name="p6" multiple class="form-control" id="cidades1">
					      			<?php
					      			foreach ($getCidades as $value) {
					      				echo '<option value="'.$value['id'].'">'.utf8_encode($value['nome']).' - '.$value['uf'].' - '.$value['sigla'].'</option>';
					      			}
					      			?>
							    </select>
							</div>
							<div class="col-sm-3">
								<label>UF/ Estado Nascimento:</label>
								<input type="text" id="city2" class="form-control" placeholder="Digite o nome da cidade">
					      		<select name="p7" multiple class="form-control" id="cidades2">
					      			<?php
					      			foreach ($getCidades as $value) {
					      				echo '<option value="'.$value['id'].'">'.utf8_encode($value['nome']).' - '.$value['uf'].' - '.$value['sigla'].'</option>';
					      			}
					      			?>
							    </select>
							</div>
							<div class="col-sm-3">
								<label>Estado Civil:</label>
								<select class="form-control" name="p8">
									<?php
									foreach ($getNav4 as $n) {
										echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
									}
									?>
								</select>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-sm-4">
								<label>Data Nascimento:</label>
								<input type="date" name="p9" class="form-control">
							</div>
							<div class="col-sm-4">
								<label>Nome do Pai:</label>
								<input type="text" name="p10" class="form-control">
							</div>
							<div class="col-sm-4">
								<label>Nome da Mãe:</label>
								<input type="text" name="p11" class="form-control">
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-sm-4">
								<label>RG:</label>
								<input type="text" name="p12" class="form-control">
							</div>
							<div class="col-sm-4">
								<label>Orgão Emissor:</label>
								<input type="text" name="p13" class="form-control">
							</div>
							<div class="col-sm-4">
								<label>CPF:</label>
								<input type="text" name="p14" class="form-control cpf">
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-sm-4">
								<label>CNH Reg.:</label>
								<input type="text" name="p15" class="form-control">
							</div>
							<div class="col-sm-4">
								<label>Categoria:</label>
								<input type="text" name="p16" class="form-control">
							</div>
							<div class="col-sm-4">
								<label>Validade:</label>
								<input type="date" name="p17" class="form-control">
							</div>
						</div>
						<br>
						<label>Observações:</label>
						<input type="text" name="p18" class="form-control">
						<br>
						<div class="row">
							<div class="col-sm-4">
								<label>Consulta de Cadastro para Ger. de Riscos:</label>
								<select id="rastreamento" class="form-control">
									<option value="0">----</option>
									<?php
									foreach ($getNAv2 as $n) {
										echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
									}
									?>
								</select>
							</div>
							<div class="col-sm-4">
								<label>Liberação Nr.:</label>
								<input type="text" name="p19" readonly="" class="form-control value">
							</div>
							<div class="col-sm-4">
								<label>Empresa Responsável:</label>
								<input type="text" name="p20" readonly=""  class="form-control value">
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-sm-11"></div>
							<div class="col-sm-1"><button class="btn btn-primary">Salvar</button></div>
						</div>
					</div>
	      				<?php
	      			}
	      			?>
					</form>
					<hr>
					<form method="POST">
	      			<h3>Motorista do Veículo Transbordo 2</h3>
	      			<button type="button" class="btn btn-info" data-toggle="collapse" data-target="#demo2">Aplicável ?</button>

	      			<?php 
	      			if (!empty($getP18form2)) {
	      				//ATUALIZANDO
		      			if (isset($_POST['a1'])) {
		      				$post = filter_input_array(INPUT_POST, FILTER_DEFAULT);
		      				$sql->upProcesso18form2($num_processo, $post);
		      				?>
							<script>
								window.location.href = "processo18.php?num_processo=<?=$num_processo; ?>";
							</script>
							<?php
		      			}

	      				?>
	      			<div id="demo2" class="collapse show">
						<br>
						<div class="row">
							<div class="col-sm-3">
								<label>Vínculo:</label>
								<select class="form-control" name="a1">
									<?php
									foreach ($getNav as $n) {
										if ($getP18form2['a1'] == $n['id']) {
											echo '<option selected value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
										} else {
											echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
										}
										
									}
									?>
								</select>
							</div>
							<div class="col-sm-3">
								<label>Contato / Fone:</label>
								<input type="text" value="<?=$getP18form2['p2'] ?>" name="p2" class="form-control">
							</div>
							<div class="col-sm-3">
								<label>Nome:</label>
								<input type="text" value="<?=$getP18form2['p3'] ?>" name="p3" class="form-control">
							</div>
							<div class="col-sm-3">
								<label>Tempo de Profissão:</label>
								<input type="text" value="<?=$getP18form2['p4'] ?>" name="p4" class="form-control">
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-sm-3">
								<label>Endereço:</label>
								<input type="text" value="<?=$getP18form2['p5'] ?>" name="p5" class="form-control">
							</div>
							<div class="col-sm-3">
								<label>UF/ Estado Residência:</label>
								<input type="text" id="city3" class="form-control" placeholder="Digite o nome da cidade">
					      		<select name="p6" multiple class="form-control" id="cidades3">
					      			<?php
					      			$d  = $sql->getCidadeID($getP18form2['p6']);
					      				
					      			echo '<option selected value="'.$d['id'].'">'.utf8_encode($d['nome']).' - '.$d['uf'].' - '.$d['sigla'].'</option>';
					      			?>
							    </select>
							</div>
							<div class="col-sm-3">
								<label>UF/ Estado Nascimento:</label>
								<input type="text" id="city4" class="form-control" placeholder="Digite o nome da cidade">
					      		<select name="p7" multiple class="form-control" id="cidades4">
					      			<?php
					      			$d  = $sql->getCidadeID($getP18form2['p7']);
					      				
					      			echo '<option selected value="'.$d['id'].'">'.utf8_encode($d['nome']).' - '.$d['uf'].' - '.$d['sigla'].'</option>';
					      			?>
							    </select>
							</div>
							<div class="col-sm-3">
								<label>Estado Civil:</label>
								<select class="form-control" name="p8">
									<?php
									foreach ($getNav4 as $n) {
										if ($getP18form2['p8'] == $n['id']) {
											echo '<option selected value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
										} else {
											echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
										}
									}
									?>
								</select>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-sm-4">
								<label>Data Nascimento:</label>
								<input type="date" value="<?=$getP18form2['p9'] ?>" name="p9" class="form-control">
							</div>
							<div class="col-sm-4">
								<label>Nome do Pai:</label>
								<input type="text" value="<?=$getP18form2['p10'] ?>" name="p10" class="form-control">
							</div>
							<div class="col-sm-4">
								<label>Nome da Mãe:</label>
								<input type="text" value="<?=$getP18form2['p11'] ?>" name="p11" class="form-control">
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-sm-4">
								<label>RG:</label>
								<input type="text" value="<?=$getP18form2['p12'] ?>" name="p12" class="form-control">
							</div>
							<div class="col-sm-4">
								<label>Orgão Emissor:</label>
								<input type="text" value="<?=$getP18form2['p13'] ?>" name="p13" class="form-control">
							</div>
							<div class="col-sm-4">
								<label>CPF:</label>
								<input type="text" value="<?=$getP18form2['p14'] ?>" name="p14" class="form-control cpf">
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-sm-4">
								<label>CNH Reg.:</label>
								<input type="text" value="<?=$getP18form2['p15'] ?>" name="p15" class="form-control">
							</div>
							<div class="col-sm-4">
								<label>Categoria:</label>
								<input type="text" value="<?=$getP18form2['p16'] ?>" name="p16" class="form-control">
							</div>
							<div class="col-sm-4">
								<label>Validade:</label>
								<input type="date" value="<?=$getP18form2['p17'] ?>" name="p17" class="form-control">
							</div>
						</div>
						<br>
						<label>Observações:</label>
						<input type="text" value="<?=$getP18form2['p18'] ?>" name="p18" class="form-control">
						<br>
						<div class="row">
							<div class="col-sm-4">
								<label>Consulta de Cadastro para Ger. de Riscos:</label>
								<select id="rastreamento" class="form-control">
									<option value="0">----</option>
									<?php
									foreach ($getNAv2 as $n) {
										echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
									}
									?>
								</select>
							</div>
							<div class="col-sm-4">
								<label>Liberação Nr.:</label>
								<input type="text" value="<?=$getP18form2['p19'] ?>" name="p19" readonly="" class="form-control value">
							</div>
							<div class="col-sm-4">
								<label>Empresa Responsável:</label>
								<input type="text" value="<?=$getP18form2['p20'] ?>" name="p20" readonly=""  class="form-control value">
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-sm-11"></div>
							<div class="col-sm-1"><button class="btn btn-primary">Salvar</button></div>
						</div>
					</div>
	      				<?php
	      			} else {

	      			//RESGITRANDO
	      			if (isset($_POST['a1'])) {
	      				$post = filter_input_array(INPUT_POST, FILTER_DEFAULT);
	      				$sql->setProcesso18form2($num_processo, $post);
	      				?>
						<script>
							window.location.href = "processo18.php?num_processo=<?=$num_processo; ?>";
						</script>
						<?php
	      			}

	      				?>
	      			<div id="demo2" class="collapse">
						<br>
						<div class="row">
							<div class="col-sm-3">
								<label>Vínculo:</label>
								<select class="form-control" name="a1">
									<?php
									foreach ($getNav as $n) {
										echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
									}
									?>
								</select>
							</div>
							<div class="col-sm-3">
								<label>Contato / Fone:</label>
								<input type="text" name="p2" class="form-control">
							</div>
							<div class="col-sm-3">
								<label>Nome:</label>
								<input type="text" name="p3" class="form-control">
							</div>
							<div class="col-sm-3">
								<label>Tempo de Profissão:</label>
								<input type="text" name="p4" class="form-control">
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-sm-3">
								<label>Endereço:</label>
								<input type="text" name="p5" class="form-control">
							</div>
							<div class="col-sm-3">
								<label>UF/ Estado Residência:</label>
								<input type="text" id="city3" class="form-control" placeholder="Digite o nome da cidade">
					      		<select name="p6" multiple class="form-control" id="cidades3">
					      			<?php
					      			foreach ($getCidades as $value) {
					      				echo '<option value="'.$value['id'].'">'.utf8_encode($value['nome']).' - '.$value['uf'].' - '.$value['sigla'].'</option>';
					      			}
					      			?>
							    </select>
							</div>
							<div class="col-sm-3">
								<label>UF/ Estado Nascimento:</label>
								<input type="text" id="city4" class="form-control" placeholder="Digite o nome da cidade">
					      		<select name="p7" multiple class="form-control" id="cidades4">
					      			<?php
					      			foreach ($getCidades as $value) {
					      				echo '<option value="'.$value['id'].'">'.utf8_encode($value['nome']).' - '.$value['uf'].' - '.$value['sigla'].'</option>';
					      			}
					      			?>
							    </select>
							</div>
							<div class="col-sm-3">
								<label>Estado Civil:</label>
								<select class="form-control" name="p8">
									<?php
									foreach ($getNav4 as $n) {
										echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
									}
									?>
								</select>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-sm-4">
								<label>Data Nascimento:</label>
								<input type="date" name="p9" class="form-control">
							</div>
							<div class="col-sm-4">
								<label>Nome do Pai:</label>
								<input type="text" name="p10" class="form-control">
							</div>
							<div class="col-sm-4">
								<label>Nome da Mãe:</label>
								<input type="text" name="p11" class="form-control">
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-sm-4">
								<label>RG:</label>
								<input type="text" name="p12" class="form-control">
							</div>
							<div class="col-sm-4">
								<label>Orgão Emissor:</label>
								<input type="text" name="p13" class="form-control">
							</div>
							<div class="col-sm-4">
								<label>CPF:</label>
								<input type="text" name="p14" class="form-control cpf">
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-sm-4">
								<label>CNH Reg.:</label>
								<input type="text" name="p15" class="form-control">
							</div>
							<div class="col-sm-4">
								<label>Categoria:</label>
								<input type="text" name="p16" class="form-control">
							</div>
							<div class="col-sm-4">
								<label>Validade:</label>
								<input type="date" name="p17" class="form-control">
							</div>
						</div>
						<br>
						<label>Observações:</label>
						<input type="text" name="p18" class="form-control">
						<br>
						<div class="row">
							<div class="col-sm-4">
								<label>Consulta de Cadastro para Ger. de Riscos:</label>
								<select id="rastreamento2" class="form-control">
									<option value="0">----</option>
									<?php
									foreach ($getNAv2 as $n) {
										echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
									}
									?>
								</select>
							</div>
							<div class="col-sm-4">
								<label>Liberação Nr.:</label>
								<input type="text" name="p19" readonly="" class="form-control value2">
							</div>
							<div class="col-sm-4">
								<label>Empresa Responsável:</label>
								<input type="text" name="p20" readonly=""  class="form-control value2">
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-sm-11"></div>
							<div class="col-sm-1"><button class="btn btn-primary">Salvar</button></div>
						</div>
					</div>
	      				<?php
	      			}
	      			?>
					</form>
					<hr>
				    <div class="row">
		      			<div class="col-sm-10"></div>
		      			<div class="col-sm-2">
							<a href="processo17.php?num_processo=<?=$num_processo; ?>" class="btn btn-danger">Voltar</a>	
							<a href="processo19.php?num_processo=<?=$num_processo; ?>" class="btn btn-primary">Proximo</a>	
		      			</div>
		      		</div>
		      	
	      	</div>
	      </div>
	    </div>
	</div>
	<div class="col-sm-1"></div>
</div>

<?php
require 'footer.php';
?>
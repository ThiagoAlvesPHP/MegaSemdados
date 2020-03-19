<?php
require 'header.php';
$sql = new Processos();
//SEGURADOS
$getCidades = $sql->getCidades();
$num_processo = addslashes($_GET['num_processo']);
$p = $sql->getProcesso($num_processo);

$getP17form1 = $sql->getP17form1($num_processo);
$getP17form2 = $sql->getP17form2($num_processo);
$getNAv2 = $sql->nav_processo27_10();
?>
<style type="text/css">
	.c{
		padding: 5px;
	}
</style>
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
	      		<h3>Veículo Transbordo</h3>
	      		<form method="POST">
	      			<button type="button" class="btn btn-info" data-toggle="collapse" data-target="#demo">Aplicável ?</button>
						<br>
						<?php 
						if (!empty($getP17form1)) {
						//ATUALIZANDO
		      			if (isset($_POST['a1'])) {
		      				$post = filter_input_array(INPUT_POST, FILTER_DEFAULT);
		      				$sql->upP17form1($num_processo, $post);
		      				?>
							<script>
								window.location.href = "processo17.php?num_processo=<?=$num_processo; ?>";
							</script>
							<?php
		      			}
							?>
						<div id="demo" class="collapse show">

						<div class="row">
							<div class="col-sm-6">
								<label>Proprietário:</label>
								<input type="text" value="<?=$getP17form1['a1']; ?>" name="a1" class="form-control">
								<label>Endereço Comercial:</label>
								<input type="text" value="<?=$getP17form1['a2']; ?>" name="a2" class="form-control">
								<label>Fone(s) Comercial:</label>
								<input type="text" value="<?=$getP17form1['a3']; ?>" name="a3" class="form-control">
							</div>
							<div class="col-sm-6">
								<label>CPF ou CNPJ::</label>
								<input type="text" value="<?=$getP17form1['a4']; ?>" name="a4" class="form-control">
								<label>UF/Município:</label>
		      					<input type="text" id="city2" class="form-control" placeholder="Digite o nome da cidade">
					      		<select name="a5" multiple class="form-control" id="cidades2">
					      			<?php
					      			$d  = $sql->getCidadeID($getP17form1['a5']);
					      				
					      			echo '<option selected value="'.$d['id'].'">'.utf8_encode($d['nome']).' - '.$d['uf'].' - '.$d['sigla'].'</option>';
					      			?>
							    </select>

								<label>E-mail:</label>
								<input type="text" value="<?=$getP17form1['a6']; ?>" name="a6" class="form-control">
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-sm-3">
								<label class="c">Veículo:</label><br>
								<label class="c">Placa:</label><br>
								<label class="c">Marca:</label><br>
								<label class="c">Modelo:</label><br>
								<label class="c">Cor:</label><br>
								<label class="c">Ano Fabricação:</label><br>
								<label class="c">Cód. Renavan:</label><br>
								<label class="c">Chassi:</label>
							</div>
							<div class="col-sm-3">
								<label>Cavalo Mecânico</label>
								<input type="text" value="<?=$getP17form1['a7']; ?>" name="a7" class="form-control">
								<input type="text" value="<?=$getP17form1['a8']; ?>" name="a8" class="form-control">
								<input type="text" value="<?=$getP17form1['a9']; ?>" name="a9" class="form-control">
								<input type="text" value="<?=$getP17form1['a10']; ?>" name="a10" class="form-control">
								<input type="text" value="<?=$getP17form1['a11']; ?>" name="a11" class="form-control">
								<input type="text" value="<?=$getP17form1['a12']; ?>" name="a12" class="form-control">
								<input type="text" value="<?=$getP17form1['a13']; ?>" name="a13" class="form-control">
							</div>
							<div class="col-sm-3">
								<label>Carreta 1º Semi Reboque</label>
								<input type="text" value="<?=$getP17form1['a14']; ?>" name="a14" class="form-control">
								<input type="text" value="<?=$getP17form1['a15']; ?>" name="a15" class="form-control">
								<input type="text" value="<?=$getP17form1['a16']; ?>" name="a16" class="form-control">
								<input type="text" value="<?=$getP17form1['a17']; ?>" name="a17" class="form-control">
								<input type="text" value="<?=$getP17form1['a18']; ?>" name="a18" class="form-control">
								<input type="text" value="<?=$getP17form1['a19']; ?>" name="a19" class="form-control">
								<input type="text" value="<?=$getP17form1['a20']; ?>" name="a20" class="form-control">
							</div>
							<div class="col-sm-3">
								<label>Carreta 2º Semi Reboque</label>
								<input type="text" value="<?=$getP17form1['a21']; ?>" name="a21" class="form-control">
								<input type="text" value="<?=$getP17form1['a22']; ?>" name="a22" class="form-control">
								<input type="text" value="<?=$getP17form1['a23']; ?>" name="a23" class="form-control">
								<input type="text" value="<?=$getP17form1['a24']; ?>" name="a24" class="form-control">
								<input type="text" value="<?=$getP17form1['a25']; ?>" name="a25" class="form-control">
								<input type="text" value="<?=$getP17form1['a26']; ?>" name="a26" class="form-control">
								<input type="text" value="<?=$getP17form1['a27']; ?>" name="a27" class="form-control">
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-sm-3">
								<label>Peso máximo permitido <span style="font-size: 10px;">(Veículo e Carga)</span>:</label>
								<input type="text" value="<?=$getP17form1['a28']; ?>" name="a28" class="form-control">
							</div>
							<div class="col-sm-3">
								<label>Sistema Rastreamento ?</label>
								<select id="rastreamento" class="form-control">
									<option value="0">----</option>
									<?php
									foreach ($getNAv2 as $n) {
										echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
									}
									?>
								</select>
							</div>
							<div class="col-sm-3">
								<label>CID Nr.:</label>
								<input type="text" value="<?=$getP17form1['a29']; ?>" readonly="" name="a29" class="form-control value">
							</div>
							<div class="col-sm-3">
								<label>Provedor:</label>
								<input type="text" value="<?=$getP17form1['a30']; ?>" readonly="" name="a30" class="form-control value">
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-sm-4">
								<label>Lacres?</label>
								<input type="text" value="<?=$getP17form1['a31']; ?>" name="a31" class="form-control">
								<input type="text" value="<?=$getP17form1['a32']; ?>" name="a32" class="form-control">
							</div>
							<div class="col-sm-4">
								<label>Lacres?</label>
								<input type="text" value="<?=$getP17form1['a33']; ?>" name="a33" class="form-control">
								<input type="text" value="<?=$getP17form1['a34']; ?>" name="a34" class="form-control">
							</div>
							<div class="col-sm-4">
								<label>Lacres?</label>
								<input type="text" value="<?=$getP17form1['a35']; ?>" name="a35" class="form-control">
								<input type="text" value="<?=$getP17form1['a36']; ?>" name="a36" class="form-control">
							</div>
						</div>
						<label>Observações:</label>
						<input type="text" value="<?=$getP17form1['a37']; ?>" name="a37" class="form-control">
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
		      				$sql->setP17form1($num_processo, $post);
		      				?>
							<script>
								window.location.href = "processo17.php?num_processo=<?=$num_processo; ?>";
							</script>
							<?php
		      			}

							?>
						<div id="demo" class="collapse">
						<div class="row">
							<div class="col-sm-6">
								<label>Proprietário:</label>
								<input type="text" name="a1" class="form-control">
								<label>Endereço Comercial:</label>
								<input type="text" name="a2" class="form-control">
								<label>Fone(s) Comercial:</label>
								<input type="text" name="a3" class="form-control">
							</div>
							<div class="col-sm-6">
								<label>CPF ou CNPJ::</label>
								<input type="text" name="a4" class="form-control">
								<label>UF/Município:</label>
		      					<input type="text" id="city2" class="form-control" placeholder="Digite o nome da cidade">
					      		<select name="a5" multiple class="form-control" id="cidades2">
					      			<?php
					      			foreach ($getCidades as $value) {
					      				echo '<option value="'.$value['id'].'">'.utf8_encode($value['nome']).' - '.$value['uf'].' - '.$value['sigla'].'</option>';
					      			}
					      			?>
							    </select>

								<label>E-mail:</label>
								<input type="text" name="a6" class="form-control">
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-sm-3">
								<label class="c">Veículo:</label><br>
								<label class="c">Placa:</label><br>
								<label class="c">Marca:</label><br>
								<label class="c">Modelo:</label><br>
								<label class="c">Cor:</label><br>
								<label class="c">Ano Fabricação:</label><br>
								<label class="c">Cód. Renavan:</label><br>
								<label class="c">Chassi:</label>
							</div>
							<div class="col-sm-3">
								<label>Cavalo Mecânico</label>
								<input type="text" name="a7" class="form-control">
								<input type="text" name="a8" class="form-control">
								<input type="text" name="a9" class="form-control">
								<input type="text" name="a10" class="form-control">
								<input type="text" name="a11" class="form-control">
								<input type="text" name="a12" class="form-control">
								<input type="text" name="a13" class="form-control">
							</div>
							<div class="col-sm-3">
								<label>Carreta 1º Semi Reboque</label>
								<input type="text" name="a14" class="form-control">
								<input type="text" name="a15" class="form-control">
								<input type="text" name="a16" class="form-control">
								<input type="text" name="a17" class="form-control">
								<input type="text" name="a18" class="form-control">
								<input type="text" name="a19" class="form-control">
								<input type="text" name="a20" class="form-control">
							</div>
							<div class="col-sm-3">
								<label>Carreta 2º Semi Reboque</label>
								<input type="text" name="a21" class="form-control">
								<input type="text" name="a22" class="form-control">
								<input type="text" name="a23" class="form-control">
								<input type="text" name="a24" class="form-control">
								<input type="text" name="a25" class="form-control">
								<input type="text" name="a26" class="form-control">
								<input type="text" name="a27" class="form-control">
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-sm-3">
								<label>Peso máximo permitido <span style="font-size: 10px;">(Veículo e Carga)</span>:</label>
								<input type="text" name="a28" class="form-control">
							</div>
							<div class="col-sm-3">
								<label>Sistema Rastreamento ?</label>
								<select id="rastreamento" class="form-control">
									<option value="0">----</option>
									<?php
									foreach ($getNAv2 as $n) {
										echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
									}
									?>
								</select>
							</div>
							<div class="col-sm-3">
								<label>CID Nr.:</label>
								<input type="text" readonly="" name="a29" class="form-control value">
							</div>
							<div class="col-sm-3">
								<label>Provedor:</label>
								<input type="text" readonly="" name="a30" class="form-control value">
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-sm-4">
								<label>Lacres?</label>
								<input type="text" name="a31" class="form-control">
								<input type="text" name="a32" class="form-control">
							</div>
							<div class="col-sm-4">
								<label>Lacres?</label>
								<input type="text" name="a33" class="form-control">
								<input type="text" name="a34" class="form-control">
							</div>
							<div class="col-sm-4">
								<label>Lacres?</label>
								<input type="text" name="a35" class="form-control">
								<input type="text" name="a36" class="form-control">
							</div>
						</div>
						<label>Observações:</label>
						<input type="text" name="a37" class="form-control">
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
		      	<h3>Veículo Transbordo 2</h3>
		      	<form method="POST">
	      			<button type="button" class="btn btn-info" data-toggle="collapse" data-target="#demo2">Aplicável ?</button>
						<br>
						<?php 
						if (!empty($getP17form2)) {
						//ATUALIZANDO
		      			if (isset($_POST['b1'])) {
		      				$post = filter_input_array(INPUT_POST, FILTER_DEFAULT);
		      				$sql->upP17form2($num_processo, $post);
		      				?>
							<script>
								window.location.href = "processo17.php?num_processo=<?=$num_processo; ?>";
							</script>
							<?php
		      			}
							?>
						<div id="demo2" class="collapse show">
						<div class="row">
							<div class="col-sm-6">
								<label>Proprietário:</label>
								<input type="text" value="<?=$getP17form2['b1']; ?>" name="b1" class="form-control">
								<label>Endereço Comercial:</label>
								<input type="text" value="<?=$getP17form2['a2']; ?>" name="a2" class="form-control">
								<label>Fone(s) Comercial:</label>
								<input type="text" value="<?=$getP17form2['a3']; ?>" name="a3" class="form-control">
							</div>
							<div class="col-sm-6">
								<label>CPF ou CNPJ::</label>
								<input type="text" value="<?=$getP17form2['a4']; ?>" name="a4" class="form-control">
								<label>UF/Município:</label>
		      					<input type="text" id="city1" class="form-control" placeholder="Digite o nome da cidade">
					      		<select name="a5" multiple class="form-control" id="cidades1">
					      			<?php
					      			$d  = $sql->getCidadeID($getP17form2['a5']);
					      				
					      			echo '<option selected value="'.$d['id'].'">'.utf8_encode($d['nome']).' - '.$d['uf'].' - '.$d['sigla'].'</option>';
					      			?>
							    </select>

								<label>E-mail:</label>
								<input type="text" value="<?=$getP17form2['a6']; ?>" name="a6" class="form-control">
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-sm-3">
								<label class="c">Veículo:</label><br>
								<label class="c">Placa:</label><br>
								<label class="c">Marca:</label><br>
								<label class="c">Modelo:</label><br>
								<label class="c">Cor:</label><br>
								<label class="c">Ano Fabricação:</label><br>
								<label class="c">Cód. Renavan:</label><br>
								<label class="c">Chassi:</label>
							</div>
							<div class="col-sm-3">
								<label>Cavalo Mecânico</label>
								<input type="text" value="<?=$getP17form2['a7']; ?>" name="a7" class="form-control">
								<input type="text" value="<?=$getP17form2['a8']; ?>" name="a8" class="form-control">
								<input type="text" value="<?=$getP17form2['a9']; ?>" name="a9" class="form-control">
								<input type="text" value="<?=$getP17form2['a10']; ?>" name="a10" class="form-control">
								<input type="text" value="<?=$getP17form2['a11']; ?>" name="a11" class="form-control">
								<input type="text" value="<?=$getP17form2['a12']; ?>" name="a12" class="form-control">
								<input type="text" value="<?=$getP17form2['a13']; ?>" name="a13" class="form-control">
							</div>
							<div class="col-sm-3">
								<label>Carreta 1º Semi Reboque</label>
								<input type="text" value="<?=$getP17form2['a14']; ?>" name="a14" class="form-control">
								<input type="text" value="<?=$getP17form2['a15']; ?>" name="a15" class="form-control">
								<input type="text" value="<?=$getP17form2['a16']; ?>" name="a16" class="form-control">
								<input type="text" value="<?=$getP17form2['a17']; ?>" name="a17" class="form-control">
								<input type="text" value="<?=$getP17form2['a18']; ?>" name="a18" class="form-control">
								<input type="text" value="<?=$getP17form2['a19']; ?>" name="a19" class="form-control">
								<input type="text" value="<?=$getP17form2['a20']; ?>" name="a20" class="form-control">
							</div>
							<div class="col-sm-3">
								<label>Carreta 2º Semi Reboque</label>
								<input type="text" value="<?=$getP17form2['a21']; ?>" name="a21" class="form-control">
								<input type="text" value="<?=$getP17form2['a22']; ?>" name="a22" class="form-control">
								<input type="text" value="<?=$getP17form2['a23']; ?>" name="a23" class="form-control">
								<input type="text" value="<?=$getP17form2['a24']; ?>" name="a24" class="form-control">
								<input type="text" value="<?=$getP17form2['a25']; ?>" name="a25" class="form-control">
								<input type="text" value="<?=$getP17form2['a26']; ?>" name="a26" class="form-control">
								<input type="text" value="<?=$getP17form2['a27']; ?>" name="a27" class="form-control">
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-sm-3">
								<label>Peso máximo permitido <span style="font-size: 10px;">(Veículo e Carga)</span>:</label>
								<input type="text" value="<?=$getP17form2['a28']; ?>" name="a28" class="form-control">
							</div>
							<div class="col-sm-3">
								<label>Sistema Rastreamento ?</label>
								<select id="rastreamento" class="form-control">
									<option value="0">----</option>
									<?php
									foreach ($getNAv2 as $n) {
										echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
									}
									?>
								</select>
							</div>
							<div class="col-sm-3">
								<label>CID Nr.:</label>
								<input type="text" value="<?=$getP17form2['a29']; ?>" readonly="" name="a29" class="form-control value">
							</div>
							<div class="col-sm-3">
								<label>Provedor:</label>
								<input type="text" value="<?=$getP17form2['a30']; ?>" readonly="" name="a30" class="form-control value">
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-sm-4">
								<label>Lacres?</label>
								<input type="text" value="<?=$getP17form2['a31']; ?>" name="a31" class="form-control">
								<input type="text" value="<?=$getP17form2['a32']; ?>" name="a32" class="form-control">
							</div>
							<div class="col-sm-4">
								<label>Lacres?</label>
								<input type="text" value="<?=$getP17form2['a33']; ?>" name="a33" class="form-control">
								<input type="text" value="<?=$getP17form2['a34']; ?>" name="a34" class="form-control">
							</div>
							<div class="col-sm-4">
								<label>Lacres?</label>
								<input type="text" value="<?=$getP17form2['a35']; ?>" name="a35" class="form-control">
								<input type="text" value="<?=$getP17form2['a36']; ?>" name="a36" class="form-control">
							</div>
						</div>
						<label>Observações:</label>
						<input type="text" value="<?=$getP17form2['a37']; ?>" name="a37" class="form-control">
						<br>
						<div class="row">
							<div class="col-sm-11"></div>
							<div class="col-sm-1"><button class="btn btn-primary">Salvar</button></div>
						</div>
					</div>

							<?php
						} else {

						//RESGITRANDO
		      			if (isset($_POST['b1'])) {
		      				$post = filter_input_array(INPUT_POST, FILTER_DEFAULT);
		      				$sql->setP17form2($num_processo, $post);
		      				?>
							<script>
								window.location.href = "processo17.php?num_processo=<?=$num_processo; ?>";
							</script>
							<?php
		      			}

							?>
						<div id="demo2" class="collapse">
						<div class="row">
							<div class="col-sm-6">
								<label>Proprietário:</label>
								<input type="text" name="b1" class="form-control">
								<label>Endereço Comercial:</label>
								<input type="text" name="a2" class="form-control">
								<label>Fone(s) Comercial:</label>
								<input type="text" name="a3" class="form-control">
							</div>
							<div class="col-sm-6">
								<label>CPF ou CNPJ::</label>
								<input type="text" name="a4" class="form-control">
								<label>UF/Município:</label>
		      					<input type="text" id="city1" class="form-control" placeholder="Digite o nome da cidade">
					      		<select name="a5" multiple class="form-control" id="cidades1">
					      			<?php
					      			foreach ($getCidades as $value) {
					      				echo '<option value="'.$value['id'].'">'.utf8_encode($value['nome']).' - '.$value['uf'].' - '.$value['sigla'].'</option>';
					      			}
					      			?>
							    </select>

								<label>E-mail:</label>
								<input type="text" name="a6" class="form-control">
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-sm-3">
								<label class="c">Veículo:</label><br>
								<label class="c">Placa:</label><br>
								<label class="c">Marca:</label><br>
								<label class="c">Modelo:</label><br>
								<label class="c">Cor:</label><br>
								<label class="c">Ano Fabricação:</label><br>
								<label class="c">Cód. Renavan:</label><br>
								<label class="c">Chassi:</label>
							</div>
							<div class="col-sm-3">
								<label>Cavalo Mecânico</label>
								<input type="text" name="a7" class="form-control">
								<input type="text" name="a8" class="form-control">
								<input type="text" name="a9" class="form-control">
								<input type="text" name="a10" class="form-control">
								<input type="text" name="a11" class="form-control">
								<input type="text" name="a12" class="form-control">
								<input type="text" name="a13" class="form-control">
							</div>
							<div class="col-sm-3">
								<label>Carreta 1º Semi Reboque</label>
								<input type="text" name="a14" class="form-control">
								<input type="text" name="a15" class="form-control">
								<input type="text" name="a16" class="form-control">
								<input type="text" name="a17" class="form-control">
								<input type="text" name="a18" class="form-control">
								<input type="text" name="a19" class="form-control">
								<input type="text" name="a20" class="form-control">
							</div>
							<div class="col-sm-3">
								<label>Carreta 2º Semi Reboque</label>
								<input type="text" name="a21" class="form-control">
								<input type="text" name="a22" class="form-control">
								<input type="text" name="a23" class="form-control">
								<input type="text" name="a24" class="form-control">
								<input type="text" name="a25" class="form-control">
								<input type="text" name="a26" class="form-control">
								<input type="text" name="a27" class="form-control">
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-sm-3">
								<label>Peso máximo permitido <span style="font-size: 10px;">(Veículo e Carga)</span>:</label>
								<input type="text" name="a28" class="form-control">
							</div>
							<div class="col-sm-3">
								<label>Sistema Rastreamento ?</label>
								<select id="rastreamento2" class="form-control">
									<option value="0">----</option>
									<?php
									foreach ($getNAv2 as $n) {
										echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
									}
									?>
								</select>
							</div>
							<div class="col-sm-3">
								<label>CID Nr.:</label>
								<input type="text" readonly="" name="a29" class="form-control value2">
							</div>
							<div class="col-sm-3">
								<label>Provedor:</label>
								<input type="text" readonly="" name="a30" class="form-control value2">
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-sm-4">
								<label>Lacres?</label>
								<input type="text" name="a31" class="form-control">
								<input type="text" name="a32" class="form-control">
							</div>
							<div class="col-sm-4">
								<label>Lacres?</label>
								<input type="text" name="a33" class="form-control">
								<input type="text" name="a34" class="form-control">
							</div>
							<div class="col-sm-4">
								<label>Lacres?</label>
								<input type="text" name="a35" class="form-control">
								<input type="text" name="a36" class="form-control">
							</div>
						</div>
						<label>Observações:</label>
						<input type="text" name="a37" class="form-control">
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
						<a href="processo16.php?num_processo=<?=$num_processo; ?>" class="btn btn-danger">Voltar</a>	
						<a href="processo18.php?num_processo=<?=$num_processo; ?>" class="btn btn-primary">Proximo</a>
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
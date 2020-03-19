<?php
require 'header.php';
$sql = new Processos();
//SEGURADOS
$getCidades = $sql->getCidades();
$num_processo = addslashes($_GET['num_processo']);
$p = $sql->getProcesso($num_processo);

$getNav = $sql->getNavProcesso15();
$getNAv2 = $sql->nav_processo27_10();

$getP15 = $sql->getP15($num_processo);
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
	      	<h3>Veículo Transportador</h3>
	      	<div class="well">
	      		<form method="POST">
	      			<?php
	      				if (!empty($getP15)) {
	      				//ATUALIZANDO
		      			if (isset($_POST['p1'])) {
		      				$post = filter_input_array(INPUT_POST, FILTER_DEFAULT);
		      				$sql->upProcesso15($num_processo, $post);
		      				?>
							<script>
								window.location.href = "processo16.php?num_processo=<?=$num_processo; ?>";
							</script>
							<?php
		      			}

	      					?>
	      			<button type="button" class="btn btn-info" data-toggle="collapse" data-target="#demo">Aplicável ?</button>
	      			<div id="demo" class="collapse show">
						<br>
						<div class="row">
							<div class="col-sm-6">
								<label>Proprietário:</label>
								<input type="text" value="<?=$getP15['p1']; ?>" name="p1" class="form-control">
								<label>Endereço Comercial:</label>
								<input type="text" value="<?=$getP15['p2']; ?>" name="p2" class="form-control">
								<label>Fone(s) Comercial:</label>
								<input type="text" value="<?=$getP15['p3']; ?>" name="p3" class="form-control">
							</div>
							<div class="col-sm-6">
								<label>CPF ou CNPJ::</label>
								<input type="text" value="<?=$getP15['p4']; ?>" name="p4" class="form-control">
								<label>UF/Município:</label>
		      					<input type="text" id="city1" class="form-control" placeholder="Digite o nome da cidade">
					      		<select name="p5" multiple class="form-control" id="cidades1">
					      			<?php
					      			$d  = $sql->getCidadeID($getP15['p5']);

				      				echo '<option selected value="'.$d['id'].'">'.utf8_encode($d['nome']).' - '.$d['uf'].' - '.$d['sigla'].'</option>';
					      			?>
							    </select>

								<label>E-mail:</label>
								<input type="text" value="<?=$getP15['p6']; ?>" name="p6" class="form-control">
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
								<input type="text" value="<?=$getP15['p7']; ?>" name="p7" class="form-control">
								<input type="text" value="<?=$getP15['p8']; ?>" name="p8" class="form-control">
								<input type="text" value="<?=$getP15['p9']; ?>" name="p9" class="form-control">
								<input type="text" value="<?=$getP15['p10']; ?>" name="p10" class="form-control">
								<input type="text" value="<?=$getP15['p11']; ?>" name="p11" class="form-control">
								<input type="text" value="<?=$getP15['p12']; ?>" name="p12" class="form-control">
								<input type="text" value="<?=$getP15['p13']; ?>" name="p13" class="form-control">
							</div>
							<div class="col-sm-3">
								<label>Carreta 1º Semi Reboque</label>
								<input type="text" value="<?=$getP15['p14']; ?>" name="p14" class="form-control">
								<input type="text" value="<?=$getP15['p15']; ?>" name="p15" class="form-control">
								<input type="text" value="<?=$getP15['p16']; ?>" name="p16" class="form-control">
								<input type="text" value="<?=$getP15['p17']; ?>" name="p17" class="form-control">
								<input type="text" value="<?=$getP15['p18']; ?>" name="p18" class="form-control">
								<input type="text" value="<?=$getP15['p19']; ?>" name="p19" class="form-control">
								<input type="text" value="<?=$getP15['p20']; ?>" name="p20" class="form-control">
							</div>
							<div class="col-sm-3">
								<label>Carreta 2º Semi Reboque</label>
								<input type="text" value="<?=$getP15['p21']; ?>" name="p21" class="form-control">
								<input type="text" value="<?=$getP15['p22']; ?>" name="p22" class="form-control">
								<input type="text" value="<?=$getP15['p23']; ?>" name="p23" class="form-control">
								<input type="text" value="<?=$getP15['p24']; ?>" name="p24" class="form-control">
								<input type="text" value="<?=$getP15['p25']; ?>" name="p25" class="form-control">
								<input type="text" value="<?=$getP15['p26']; ?>" name="p26" class="form-control">
								<input type="text" value="<?=$getP15['p27']; ?>" name="p27" class="form-control">
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-sm-3">
								<label>Peso máximo permitido <span style="font-size: 10px;">(Veículo e Carga)</span>:</label>
								<input type="text" value="<?=$getP15['p28']; ?>" name="p28" class="form-control">
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
								<input type="text" readonly="" value="<?=$getP15['p29']; ?>" name="p29" class="form-control value">
							</div>
							<div class="col-sm-3">
								<label>Provedor:</label>
								<input type="text" readonly="" value="<?=$getP15['p30']; ?>" name="p30" class="form-control value">
							</div>
						</div>
						<label>Observações:</label>
						<input type="text" value="<?=$getP15['p31']; ?>" name="p31" class="form-control">
						<h3>Estado de Conservação</h3>

						<div class="row">
							<div class="col-sm-3">
								<label class="c">Veículo:</label><br>
								<label class="c">Funilaria:</label><br>
								<label class="c">Mecânica:</label><br>
								<label class="c">Pintura:</label><br>
								<label class="c">Elétrica:</label><br>
								<label class="c">Pneus:</label><br>
								<label class="c">Lonas:</label><br>
								<label class="c">Sistema de Refrigeração:</label><br>
								<label class="c">Assoalho:</label><br>
								<label class="c">Estrutural Abertos:</label><br>
								<label class="c">Baú / Similares:</label>
							</div>
							<div class="col-sm-3">
								<label>Cavalo Mecânico</label>
								<select class="form-control" name="p32">
									<?php
									foreach ($getNav as $n) {
										if ($getP15['p32'] == $n['id']) {
											echo '<option selected value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
										} else {
											echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
										}
									}
									?>
								</select>
								<select class="form-control" name="p33">
									<?php
									foreach ($getNav as $n) {
										if ($getP15['p33'] == $n['id']) {
											echo '<option selected value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
										} else {
											echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
										}
									}
									?>
								</select>
								<select class="form-control" name="p34">
									<?php
									foreach ($getNav as $n) {
										if ($getP15['p34'] == $n['id']) {
											echo '<option selected value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
										} else {
											echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
										}
									}
									?>
								</select>
								<select class="form-control" name="p35">
									<?php
									foreach ($getNav as $n) {
										if ($getP15['p35'] == $n['id']) {
											echo '<option selected value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
										} else {
											echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
										}
									}
									?>
								</select>
								<select class="form-control" name="p36">
									<?php
									foreach ($getNav as $n) {
										if ($getP15['p36'] == $n['id']) {
											echo '<option selected value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
										} else {
											echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
										}
									}
									?>
								</select>
								<select class="form-control" name="p37">
									<?php
									foreach ($getNav as $n) {
										if ($getP15['p37'] == $n['id']) {
											echo '<option selected value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
										} else {
											echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
										}
									}
									?>
								</select>
								<select class="form-control" name="p38">
									<?php
									foreach ($getNav as $n) {
										if ($getP15['p38'] == $n['id']) {
											echo '<option selected value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
										} else {
											echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
										}
									}
									?>
								</select>
								<select class="form-control" name="p39">
									<?php
									foreach ($getNav as $n) {
										if ($getP15['p39'] == $n['id']) {
											echo '<option selected value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
										} else {
											echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
										}
									}
									?>
								</select>
								<select class="form-control" name="p40">
									<?php
									foreach ($getNav as $n) {
										if ($getP15['p40'] == $n['id']) {
											echo '<option selected value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
										} else {
											echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
										}
									}
									?>
								</select>
								<select class="form-control" name="p41">
									<?php
									foreach ($getNav as $n) {
										if ($getP15['p41'] == $n['id']) {
											echo '<option selected value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
										} else {
											echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
										}
									}
									?>
								</select>
							</div>
							<div class="col-sm-3">
								<label>Carreta 1º Semi Reboque</label>
								<select class="form-control" name="p42">
									<?php
									foreach ($getNav as $n) {
										if ($getP15['p42'] == $n['id']) {
											echo '<option selected value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
										} else {
											echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
										}
									}
									?>
								</select>
								<select class="form-control" name="p43">
									<?php
									foreach ($getNav as $n) {
										if ($getP15['p43'] == $n['id']) {
											echo '<option selected value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
										} else {
											echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
										}
									}
									?>
								</select>
								<select class="form-control" name="p44">
									<?php
									foreach ($getNav as $n) {
										if ($getP15['p44'] == $n['id']) {
											echo '<option selected value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
										} else {
											echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
										}
									}
									?>
								</select>
								<select class="form-control" name="p45">
									<?php
									foreach ($getNav as $n) {
										if ($getP15['p45'] == $n['id']) {
											echo '<option selected value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
										} else {
											echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
										}
									}
									?>
								</select>
								<select class="form-control" name="p46">
									<?php
									foreach ($getNav as $n) {
										if ($getP15['p46'] == $n['id']) {
											echo '<option selected value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
										} else {
											echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
										}
									}
									?>
								</select>
								<select class="form-control" name="p47">
									<?php
									foreach ($getNav as $n) {
										if ($getP15['p47'] == $n['id']) {
											echo '<option selected value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
										} else {
											echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
										}
									}
									?>
								</select>
								<select class="form-control" name="p48">
									<?php
									foreach ($getNav as $n) {
										if ($getP15['p48'] == $n['id']) {
											echo '<option selected value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
										} else {
											echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
										}
									}
									?>
								</select>
								<select class="form-control" name="p49">
									<?php
									foreach ($getNav as $n) {
										if ($getP15['p49'] == $n['id']) {
											echo '<option selected value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
										} else {
											echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
										}
									}
									?>
								</select>
								<select class="form-control" name="p50">
									<?php
									foreach ($getNav as $n) {
										if ($getP15['p50'] == $n['id']) {
											echo '<option selected value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
										} else {
											echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
										}
									}
									?>
								</select>
								<select class="form-control" name="p51">
									<?php
									foreach ($getNav as $n) {
										if ($getP15['p51'] == $n['id']) {
											echo '<option selected value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
										} else {
											echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
										}
									}
									?>
								</select>
							</div>
							<div class="col-sm-3">
								<label>Carreta 2º Semi Reboque</label>
								<select class="form-control" name="p52">
									<?php
									foreach ($getNav as $n) {
										if ($getP15['p52'] == $n['id']) {
											echo '<option selected value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
										} else {
											echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
										}
									}
									?>
								</select>
								<select class="form-control" name="p53">
									<?php
									foreach ($getNav as $n) {
										if ($getP15['p53'] == $n['id']) {
											echo '<option selected value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
										} else {
											echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
										}
									}
									?>
								</select>
								<select class="form-control" name="p54">
									<?php
									foreach ($getNav as $n) {
										if ($getP15['p54'] == $n['id']) {
											echo '<option selected value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
										} else {
											echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
										}
									}
									?>
								</select>
								<select class="form-control" name="p55">
									<?php
									foreach ($getNav as $n) {
										if ($getP15['p55'] == $n['id']) {
											echo '<option selected value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
										} else {
											echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
										}
									}
									?>
								</select>
								<select class="form-control" name="p56">
									<?php
									foreach ($getNav as $n) {
										if ($getP15['p56'] == $n['id']) {
											echo '<option selected value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
										} else {
											echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
										}
									}
									?>
								</select>
								<select class="form-control" name="p57">
									<?php
									foreach ($getNav as $n) {
										if ($getP15['p57'] == $n['id']) {
											echo '<option selected value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
										} else {
											echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
										}
									}
									?>
								</select>
								<select class="form-control" name="p58">
									<?php
									foreach ($getNav as $n) {
										if ($getP15['p58'] == $n['id']) {
											echo '<option selected value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
										} else {
											echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
										}
									}
									?>
								</select>
								<select class="form-control" name="p59">
									<?php
									foreach ($getNav as $n) {
										if ($getP15['p59'] == $n['id']) {
											echo '<option selected value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
										} else {
											echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
										}
									}
									?>
								</select>
								<select class="form-control" name="p60">
									<?php
									foreach ($getNav as $n) {
										if ($getP15['p60'] == $n['id']) {
											echo '<option selected value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
										} else {
											echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
										}
									}
									?>
								</select>
								<select class="form-control" name="p61">
									<?php
									foreach ($getNav as $n) {
										if ($getP15['p61'] == $n['id']) {
											echo '<option selected value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
										} else {
											echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
										}
									}
									?>
								</select>
							</div>
						</div>
					</div>
	      					<?php
	      				} else {
	      			//RESGITRANDO
	      			if (isset($_POST['p1'])) {
	      				$post = filter_input_array(INPUT_POST, FILTER_DEFAULT);
	      				$sql->setProcesso15($num_processo, $post);
	      				?>
						<script>
							window.location.href = "processo16.php?num_processo=<?=$num_processo; ?>";
						</script>
						<?php
	      			}
	      					?>
	      			<button type="button" class="btn btn-info" data-toggle="collapse" data-target="#demo">Aplicável ?</button>
	      			<div id="demo" class="collapse">
						<br>
						<div class="row">
							<div class="col-sm-6">
								<label>Proprietário:</label>
								<input type="text" name="p1" class="form-control">
								<label>Endereço Comercial:</label>
								<input type="text" name="p2" class="form-control">
								<label>Fone(s) Comercial:</label>
								<input type="text" name="p3" class="form-control">
							</div>
							<div class="col-sm-6">
								<label>CPF ou CNPJ::</label>
								<input type="text" name="p4" class="form-control">
								<label>UF/Município:</label>
		      					<input type="text" id="city2" class="form-control" placeholder="Digite o nome da cidade">
					      		<select name="p5" multiple class="form-control" id="cidades2">
					      			<?php
					      			foreach ($getCidades as $value) {
					      				echo '<option value="'.$value['id'].'">'.utf8_encode($value['nome']).' - '.$value['uf'].' - '.$value['sigla'].'</option>';
					      			}
					      			?>
							    </select>

								<label>E-mail:</label>
								<input type="text" name="p6" class="form-control">
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
								<input type="text" name="p7" class="form-control">
								<input type="text" name="p8" class="form-control">
								<input type="text" name="p9" class="form-control">
								<input type="text" name="p10" class="form-control">
								<input type="text" name="p11" class="form-control">
								<input type="text" name="p12" class="form-control">
								<input type="text" name="p13" class="form-control">
							</div>
							<div class="col-sm-3">
								<label>Carreta 1º Semi Reboque</label>
								<input type="text" name="p14" class="form-control">
								<input type="text" name="p15" class="form-control">
								<input type="text" name="p16" class="form-control">
								<input type="text" name="p17" class="form-control">
								<input type="text" name="p18" class="form-control">
								<input type="text" name="p19" class="form-control">
								<input type="text" name="p20" class="form-control">
							</div>
							<div class="col-sm-3">
								<label>Carreta 2º Semi Reboque</label>
								<input type="text" name="p21" class="form-control">
								<input type="text" name="p22" class="form-control">
								<input type="text" name="p23" class="form-control">
								<input type="text" name="p24" class="form-control">
								<input type="text" name="p25" class="form-control">
								<input type="text" name="p26" class="form-control">
								<input type="text" name="p27" class="form-control">
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-sm-3">
								<label>Peso máximo permitido <span style="font-size: 10px;">(Veículo e Carga)</span>:</label>
								<input type="text" name="p28" class="form-control">
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
								<input type="text" readonly="" name="p29" class="form-control value">
							</div>
							<div class="col-sm-3">
								<label>Provedor:</label>
								<input type="text" readonly="" name="p30" class="form-control value">
							</div>
						</div>
						<label>Observações:</label>
						<input type="text" name="p31" class="form-control">
						<h3>Estado de Conservação</h3>

						<div class="row">
							<div class="col-sm-3">
								<label class="c">Veículo:</label><br>
								<label class="c">Funilaria:</label><br>
								<label class="c">Mecânica:</label><br>
								<label class="c">Pintura:</label><br>
								<label class="c">Elétrica:</label><br>
								<label class="c">Pneus:</label><br>
								<label class="c">Lonas:</label><br>
								<label class="c">Sistema de Refrigeração:</label><br>
								<label class="c">Assoalho:</label><br>
								<label class="c">Estrutural Abertos:</label><br>
								<label class="c">Baú / Similares:</label>
							</div>
							<div class="col-sm-3">
								<label>Cavalo Mecânico</label>
								<select class="form-control" name="p32">
									<?php
									foreach ($getNav as $n) {
										echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
									}
									?>
								</select>
								<select class="form-control" name="p33">
									<?php
									foreach ($getNav as $n) {
										echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
									}
									?>
								</select>
								<select class="form-control" name="p34">
									<?php
									foreach ($getNav as $n) {
										echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
									}
									?>
								</select>
								<select class="form-control" name="p35">
									<?php
									foreach ($getNav as $n) {
										echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
									}
									?>
								</select>
								<select class="form-control" name="p36">
									<?php
									foreach ($getNav as $n) {
										echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
									}
									?>
								</select>
								<select class="form-control" name="p37">
									<?php
									foreach ($getNav as $n) {
										echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
									}
									?>
								</select>
								<select class="form-control" name="p38">
									<?php
									foreach ($getNav as $n) {
										echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
									}
									?>
								</select>
								<select class="form-control" name="p39">
									<?php
									foreach ($getNav as $n) {
										echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
									}
									?>
								</select>
								<select class="form-control" name="p40">
									<?php
									foreach ($getNav as $n) {
										echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
									}
									?>
								</select>
								<select class="form-control" name="p41">
									<?php
									foreach ($getNav as $n) {
										echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
									}
									?>
								</select>
							</div>
							<div class="col-sm-3">
								<label>Carreta 1º Semi Reboque</label>
								<select class="form-control" name="p42">
									<?php
									foreach ($getNav as $n) {
										echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
									}
									?>
								</select>
								<select class="form-control" name="p43">
									<?php
									foreach ($getNav as $n) {
										echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
									}
									?>
								</select>
								<select class="form-control" name="p44">
									<?php
									foreach ($getNav as $n) {
										echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
									}
									?>
								</select>
								<select class="form-control" name="p45">
									<?php
									foreach ($getNav as $n) {
										echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
									}
									?>
								</select>
								<select class="form-control" name="p46">
									<?php
									foreach ($getNav as $n) {
										echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
									}
									?>
								</select>
								<select class="form-control" name="p47">
									<?php
									foreach ($getNav as $n) {
										echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
									}
									?>
								</select>
								<select class="form-control" name="p48">
									<?php
									foreach ($getNav as $n) {
										echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
									}
									?>
								</select>
								<select class="form-control" name="p49">
									<?php
									foreach ($getNav as $n) {
										echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
									}
									?>
								</select>
								<select class="form-control" name="p50">
									<?php
									foreach ($getNav as $n) {
										echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
									}
									?>
								</select>
								<select class="form-control" name="p51">
									<?php
									foreach ($getNav as $n) {
										echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
									}
									?>
								</select>
							</div>
							<div class="col-sm-3">
								<label>Carreta 2º Semi Reboque</label>
								<select class="form-control" name="p52">
									<?php
									foreach ($getNav as $n) {
										echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
									}
									?>
								</select>
								<select class="form-control" name="p53">
									<?php
									foreach ($getNav as $n) {
										echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
									}
									?>
								</select>
								<select class="form-control" name="p54">
									<?php
									foreach ($getNav as $n) {
										echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
									}
									?>
								</select>
								<select class="form-control" name="p55">
									<?php
									foreach ($getNav as $n) {
										echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
									}
									?>
								</select>
								<select class="form-control" name="p56">
									<?php
									foreach ($getNav as $n) {
										echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
									}
									?>
								</select>
								<select class="form-control" name="p57">
									<?php
									foreach ($getNav as $n) {
										echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
									}
									?>
								</select>
								<select class="form-control" name="p58">
									<?php
									foreach ($getNav as $n) {
										echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
									}
									?>
								</select>
								<select class="form-control" name="p59">
									<?php
									foreach ($getNav as $n) {
										echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
									}
									?>
								</select>
								<select class="form-control" name="p60">
									<?php
									foreach ($getNav as $n) {
										echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
									}
									?>
								</select>
								<select class="form-control" name="p61">
									<?php
									foreach ($getNav as $n) {
										echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
									}
									?>
								</select>
							</div>
						</div>
					</div>
	      					<?php
	      				}
	      			?>

					


					<hr>
				    <div class="row">
		      			<div class="col-sm-10"></div>
		      			<div class="col-sm-2">
							<a href="processo14.php?num_processo=<?=$num_processo; ?>" class="btn btn-danger">Voltar</a>	
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
<?php
require 'header.php';
$sql = new Processos();
$num_processo = addslashes($_GET['num_processo']);
$p = $sql->getProcesso($num_processo);

$nav01 = $sql->nav_processo27_1();
$nav02 = $sql->nav_processo27_2();
$nav03 = $sql->nav_processo27_3();
$nav04 = $sql->nav_processo27_4();
$nav05 = $sql->nav_processo27_5();
$nav06 = $sql->nav_processo27_6();
$nav07 = $sql->nav_processo27_7();
$nav08 = $sql->nav_processo27_8();
$nav09 = $sql->nav_processo27_9();
$nav10 = $sql->nav_processo27_10();
$nav11 = $sql->nav_processo27_11();
$nav12 = $sql->nav_processo27_12();
$nav13 = $sql->nav_processo27_13();
$nav14 = $sql->nav_processo27_14();
$nav15 = $sql->nav_processo27_15();
$nav16 = $sql->nav_processo27_16();
$nav17 = $sql->nav_processo27_17();
$nav18 = $sql->nav_processo27_18();
$nav19 = $sql->nav_processo27_19();

$getDescLocal = $sql->processo_descricao_local($num_processo);
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
	      	<h3>Descrição do Local</h3>
	      	<div class="well">
	      		<form method="POST">
	      			
	      			<?php 
						if (!empty($getDescLocal)) {
					//REGISTRAR
					if (isset($_POST['nav_processo27_1'])) {
						$nav_processo27_1 = addslashes($_POST['nav_processo27_1']);
						$nav_processo27_2 = addslashes($_POST['nav_processo27_2']);
						$nav_processo27_3 = addslashes($_POST['nav_processo27_3']);
						$nav_processo27_4 = addslashes($_POST['nav_processo27_4']);
						$nav_processo27_5 = addslashes($_POST['nav_processo27_5']);
						$nav_processo27_6 = addslashes($_POST['nav_processo27_6']);
						$nav_processo27_7 = addslashes($_POST['nav_processo27_7']);
						$nav_processo27_8 = addslashes($_POST['nav_processo27_8']);
						$nav_processo27_9 = addslashes($_POST['nav_processo27_9']);
						$nav_processo27_10 = addslashes($_POST['nav_processo27_10']);
						$nav_processo27_11 = addslashes($_POST['nav_processo27_11']);
						$nav_processo27_12 = addslashes($_POST['nav_processo27_12']);
						$nav_processo27_13 = addslashes($_POST['nav_processo27_13']);
						$nav_processo27_14 = addslashes($_POST['nav_processo27_14']);
						$nav_processo27_15 = addslashes($_POST['nav_processo27_15']);
						$nav_processo27_16 = addslashes($_POST['nav_processo27_16']);
						$nav_processo27_17 = addslashes($_POST['nav_processo27_17']);
						$nav_processo27_18 = addslashes($_POST['nav_processo27_18']);
						$nav_processo27_19 = addslashes($_POST['nav_processo27_19']);
						$nav_processo27_20 = addslashes($_POST['nav_processo27_20']);
						$nav_processo27_21 = addslashes($_POST['nav_processo27_21']);

						$sql->upDescricaoLocal($num_processo, $nav_processo27_1, $nav_processo27_2, $nav_processo27_3, $nav_processo27_4,$nav_processo27_5, $nav_processo27_6, $nav_processo27_7, $nav_processo27_8, $nav_processo27_9, $nav_processo27_10, $nav_processo27_11, $nav_processo27_12, $nav_processo27_13, $nav_processo27_14, $nav_processo27_15, $nav_processo27_16, $nav_processo27_17, $nav_processo27_18, $nav_processo27_19, $nav_processo27_20, $nav_processo27_21);
						?>
						<script>
							window.location.href = "processo28.php?num_processo=<?=$num_processo; ?>";
						</script>
						<?php
					}
							?>
					<div class="row">
	      				<div class="col-sm-6">
	      					<label>Faixas de Rolamento:</label>
	      					<select name="nav_processo27_1" class="form-control">
	      						<?php 
	      						foreach ($nav01 as $n) {
	      							if ($getDescLocal['nav_processo27_1'] == $n['id']) {
	      								echo '<option selected value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
	      							} else {
	      								echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
	      							}
	      						}
	      						?>
	      					</select>
	      					<label>Faixa(s) Rolamento (Por Sentido):</label>
	      					<select name="nav_processo27_2" class="form-control">
	      						<?php 
	      						foreach ($nav02 as $n) {
	      							if ($getDescLocal['nav_processo27_2'] == $n['id']) {
	      								echo '<option selected value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
	      							} else {
	      								echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
	      							}
	      						}
	      						?>
	      					</select>
	      					<label>Pavimentação:</label>
	      					<select name="nav_processo27_3" class="form-control">
	      						<?php 
	      						foreach ($nav03 as $n) {
	      							if ($getDescLocal['nav_processo27_3'] == $n['id']) {
	      								echo '<option selected value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
	      							} else {
	      								echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
	      							}
	      						}
	      						?>
	      					</select>
	      					<label>Superfície da Pista:</label>
	      					<select name="nav_processo27_4" class="form-control">
	      						<?php 
	      						foreach ($nav04 as $n) {
	      							if ($getDescLocal['nav_processo27_4'] == $n['id']) {
	      								echo '<option selected value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
	      							} else {
	      								echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
	      							}
	      						}
	      						?>
	      					</select>
	      					<label>Edificações Rodoviárias:</label>
	      					<select name="nav_processo27_5" class="form-control">
	      						<?php 
	      						foreach ($nav05 as $n) {
	      							if ($getDescLocal['nav_processo27_5'] == $n['id']) {
	      								echo '<option selected value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
	      							} else {
	      								echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
	      							}
	      						}
	      						?>
	      					</select>
	      					<label>Sinalização Horizontal:</label>
	      					<select name="nav_processo27_6" class="form-control">
	      						<?php 
	      						foreach ($nav06 as $n) {
	      							if ($getDescLocal['nav_processo27_6'] == $n['id']) {
	      								echo '<option selected value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
	      							} else {
	      								echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
	      							}
	      						}
	      						?>
	      					</select>
	      					<label>Visibilidade no local:</label>
	      					<select name="nav_processo27_7" class="form-control">
	      						<?php 
	      						foreach ($nav07 as $n) {
	      							if ($getDescLocal['nav_processo27_7'] == $n['id']) {
	      								echo '<option selected value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
	      							} else {
	      								echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
	      							}
	      						}
	      						?>
	      					</select>
	      				</div>
	      				<div class="col-sm-6">
	      					<label>Status da Pista:</label>
	      					<select name="nav_processo27_8" class="form-control">
	      						<?php 
	      						foreach ($nav08 as $n) {
	      							if ($getDescLocal['nav_processo27_8'] == $n['id']) {
	      								echo '<option selected value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
	      							} else {
	      								echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
	      							}
	      						}
	      						?>
	      					</select>
	      					<label>Avaliação da Pista:</label>
	      					<select name="nav_processo27_9" class="form-control">
	      						<?php 
	      						foreach ($nav09 as $n) {
	      							if ($getDescLocal['nav_processo27_9'] == $n['id']) {
	      								echo '<option selected value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
	      							} else {
	      								echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
	      							}
	      						}
	      						?>
	      					</select>
	      					<label>Acostamento:</label>
	      					<select name="nav_processo27_10" class="form-control">
	      						<?php 
	      						foreach ($nav10 as $n) {
	      							if ($getDescLocal['nav_processo27_10'] == $n['id']) {
	      								echo '<option selected value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
	      							} else {
	      								echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
	      							}
	      						}
	      						?>
	      					</select>
	      					<label>Barreiras Lateral (Defensas Metálicas):</label>
	      					<select name="nav_processo27_11" class="form-control">
	      						<?php 
	      						foreach ($nav11 as $n) {
	      							if ($getDescLocal['nav_processo27_11'] == $n['id']) {
	      								echo '<option selected value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
	      							} else {
	      								echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
	      							}
	      						}
	      						?>
	      					</select>
	      					<label>Controles de Tráfego:</label>
	      					<select name="nav_processo27_12" class="form-control">
	      						<?php 
	      						foreach ($nav12 as $n) {
	      							if ($getDescLocal['nav_processo27_12'] == $n['id']) {
	      								echo '<option selected value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
	      							} else {
	      								echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
	      							}
	      						}
	      						?>
	      					</select>
	      					<label>Sinalização Vertical:</label>
	      					<select name="nav_processo27_13" class="form-control">
	      						<?php 
	      						foreach ($nav13 as $n) {
	      							if ($getDescLocal['nav_processo27_13'] == $n['id']) {
	      								echo '<option selected value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
	      							} else {
	      								echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
	      							}
	      						}
	      						?>
	      					</select>
	      					<label>Tipo e Área:</label>
	      					<select name="nav_processo27_14" class="form-control">
	      						<?php 
	      						foreach ($nav14 as $n) {
	      							if ($getDescLocal['nav_processo27_14'] == $n['id']) {
	      								echo '<option selected value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
	      							} else {
	      								echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
	      							}
	      						}
	      						?>
	      					</select>
	      				</div>
	      			</div>
	      			<hr>
	      			<div class="row">
	      				<div class="col-sm-6">
	      					<label>Culpabilidade Presumida:</label>
	      					<select name="nav_processo27_15" class="form-control">
	      						<?php 
	      						foreach ($nav15 as $n) {
	      							if ($getDescLocal['nav_processo27_15'] == $n['id']) {
	      								echo '<option selected value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
	      							} else {
	      								echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
	      							}
	      						}
	      						?>
	      					</select>
	      					<label>Manobra Perigosa:</label>
	      					<select name="nav_processo27_16" class="form-control">
	      						<?php 
	      						foreach ($nav16 as $n) {
	      							if ($getDescLocal['nav_processo27_16'] == $n['id']) {
	      								echo '<option selected value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
	      							} else {
	      								echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
	      							}
	      						}
	      						?>
	      					</select>
	      				</div>
	      				<div class="col-sm-6">
	      					<label>Falha Humana:</label>
	      					<select name="nav_processo27_17" class="form-control">
	      						<?php 
	      						foreach ($nav17 as $n) {
	      							if ($getDescLocal['nav_processo27_17'] == $n['id']) {
	      								echo '<option selected value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
	      							} else {
	      								echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
	      							}
	      						}
	      						?>
	      					</select>
	      					<label>Incêndio:</label>
	      					<select name="nav_processo27_18" class="form-control">
	      						<?php 
	      						foreach ($nav18 as $n) {
	      							if ($getDescLocal['nav_processo27_18'] == $n['id']) {
	      								echo '<option selected value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
	      							} else {
	      								echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
	      							}
	      						}
	      						?>
	      					</select>
	      				</div>
	      			</div>
	      			<div class="row">
	      				<div class="col-sm-4">
	      					<label>Veículo - Cavalo Mecânico:</label>
	      					<select name="nav_processo27_19" class="form-control">
	      						<?php 
	      						foreach ($nav19 as $n) {
	      							if ($getDescLocal['nav_processo27_19'] == $n['id']) {
	      								echo '<option selected value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
	      							} else {
	      								echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
	      							}
	      						}
	      						?>
	      					</select>
	      				</div>	
	      				<div class="col-sm-4">
	      					<label>1º Semi Reboque:</label>
	      					<select name="nav_processo27_20" class="form-control">
	      						<?php 
	      						foreach ($nav19 as $n) {
	      							if ($getDescLocal['nav_processo27_20'] == $n['id']) {
	      								echo '<option selected value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
	      							} else {
	      								echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
	      							}
	      						}
	      						?>
	      					</select>
	      				</div>
	      				<div class="col-sm-4">
	      					<label>2º Semi Reboque:</label>
	      					<select name="nav_processo27_21" class="form-control">
	      						<?php 
	      						foreach ($nav19 as $n) {
	      							if ($getDescLocal['nav_processo27_21'] == $n['id']) {
	      								echo '<option selected value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
	      							} else {
	      								echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
	      							}
	      						}
	      						?>
	      					</select>
	      				</div>
	      			</div>
							<?php
						} else {
					//REGISTRAR
					if (isset($_POST['nav_processo27_1'])) {
						$nav_processo27_1 = addslashes($_POST['nav_processo27_1']);
						$nav_processo27_2 = addslashes($_POST['nav_processo27_2']);
						$nav_processo27_3 = addslashes($_POST['nav_processo27_3']);
						$nav_processo27_4 = addslashes($_POST['nav_processo27_4']);
						$nav_processo27_5 = addslashes($_POST['nav_processo27_5']);
						$nav_processo27_6 = addslashes($_POST['nav_processo27_6']);
						$nav_processo27_7 = addslashes($_POST['nav_processo27_7']);
						$nav_processo27_8 = addslashes($_POST['nav_processo27_8']);
						$nav_processo27_9 = addslashes($_POST['nav_processo27_9']);
						$nav_processo27_10 = addslashes($_POST['nav_processo27_10']);
						$nav_processo27_11 = addslashes($_POST['nav_processo27_11']);
						$nav_processo27_12 = addslashes($_POST['nav_processo27_12']);
						$nav_processo27_13 = addslashes($_POST['nav_processo27_13']);
						$nav_processo27_14 = addslashes($_POST['nav_processo27_14']);
						$nav_processo27_15 = addslashes($_POST['nav_processo27_15']);
						$nav_processo27_16 = addslashes($_POST['nav_processo27_16']);
						$nav_processo27_17 = addslashes($_POST['nav_processo27_17']);
						$nav_processo27_18 = addslashes($_POST['nav_processo27_18']);
						$nav_processo27_19 = addslashes($_POST['nav_processo27_19']);
						$nav_processo27_20 = addslashes($_POST['nav_processo27_20']);
						$nav_processo27_21 = addslashes($_POST['nav_processo27_21']);

						$sql->setDescricaoLocal($num_processo, $nav_processo27_1, $nav_processo27_2, $nav_processo27_3, $nav_processo27_4,$nav_processo27_5, $nav_processo27_6, $nav_processo27_7, $nav_processo27_8, $nav_processo27_9, $nav_processo27_10, $nav_processo27_11, $nav_processo27_12, $nav_processo27_13, $nav_processo27_14, $nav_processo27_15, $nav_processo27_16, $nav_processo27_17, $nav_processo27_18, $nav_processo27_19, $nav_processo27_20, $nav_processo27_21);
						?>
						<script>
							window.location.href = "processo28.php?num_processo=<?=$num_processo; ?>";
						</script>
						<?php
					}
							?>
					<div class="row">
	      				<div class="col-sm-6">
	      					<label>Faixas de Rolamento:</label>
	      					<select name="nav_processo27_1" class="form-control">
	      						<?php 
	      						foreach ($nav01 as $n) {
	      							echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
	      						}
	      						?>
	      					</select>
	      					<label>Faixa(s) Rolamento (Por Sentido):</label>
	      					<select name="nav_processo27_2" class="form-control">
	      						<?php 
	      						foreach ($nav02 as $n) {
	      							echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
	      						}
	      						?>
	      					</select>
	      					<label>Pavimentação:</label>
	      					<select name="nav_processo27_3" class="form-control">
	      						<?php 
	      						foreach ($nav03 as $n) {
	      							echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
	      						}
	      						?>
	      					</select>
	      					<label>Superfície da Pista:</label>
	      					<select name="nav_processo27_4" class="form-control">
	      						<?php 
	      						foreach ($nav04 as $n) {
	      							echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
	      						}
	      						?>
	      					</select>
	      					<label>Edificações Rodoviárias:</label>
	      					<select name="nav_processo27_5" class="form-control">
	      						<?php 
	      						foreach ($nav05 as $n) {
	      							echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
	      						}
	      						?>
	      					</select>
	      					<label>Sinalização Horizontal:</label>
	      					<select name="nav_processo27_6" class="form-control">
	      						<?php 
	      						foreach ($nav06 as $n) {
	      							echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
	      						}
	      						?>
	      					</select>
	      					<label>Visibilidade no local:</label>
	      					<select name="nav_processo27_7" class="form-control">
	      						<?php 
	      						foreach ($nav07 as $n) {
	      							echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
	      						}
	      						?>
	      					</select>
	      				</div>
	      				<div class="col-sm-6">
	      					<label>Status da Pista:</label>
	      					<select name="nav_processo27_8" class="form-control">
	      						<?php 
	      						foreach ($nav08 as $n) {
	      							echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
	      						}
	      						?>
	      					</select>
	      					<label>Avaliação da Pista:</label>
	      					<select name="nav_processo27_9" class="form-control">
	      						<?php 
	      						foreach ($nav09 as $n) {
	      							echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
	      						}
	      						?>
	      					</select>
	      					<label>Acostamento:</label>
	      					<select name="nav_processo27_10" class="form-control">
	      						<?php 
	      						foreach ($nav10 as $n) {
	      							echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
	      						}
	      						?>
	      					</select>
	      					<label>Barreiras Lateral (Defensas Metálicas):</label>
	      					<select name="nav_processo27_11" class="form-control">
	      						<?php 
	      						foreach ($nav11 as $n) {
	      							echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
	      						}
	      						?>
	      					</select>
	      					<label>Controles de Tráfego:</label>
	      					<select name="nav_processo27_12" class="form-control">
	      						<?php 
	      						foreach ($nav12 as $n) {
	      							echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
	      						}
	      						?>
	      					</select>
	      					<label>Sinalização Vertical:</label>
	      					<select name="nav_processo27_13" class="form-control">
	      						<?php 
	      						foreach ($nav13 as $n) {
	      							echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
	      						}
	      						?>
	      					</select>
	      					<label>Tipo e Área:</label>
	      					<select name="nav_processo27_14" class="form-control">
	      						<?php 
	      						foreach ($nav14 as $n) {
	      							echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
	      						}
	      						?>
	      					</select>
	      				</div>
	      			</div>
	      			<hr>
	      			<div class="row">
	      				<div class="col-sm-6">
	      					<label>Culpabilidade Presumida:</label>
	      					<select name="nav_processo27_15" class="form-control">
	      						<?php 
	      						foreach ($nav15 as $n) {
	      							echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
	      						}
	      						?>
	      					</select>
	      					<label>Manobra Perigosa:</label>
	      					<select name="nav_processo27_16" class="form-control">
	      						<?php 
	      						foreach ($nav16 as $n) {
	      							echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
	      						}
	      						?>
	      					</select>
	      				</div>
	      				<div class="col-sm-6">
	      					<label>Falha Humana:</label>
	      					<select name="nav_processo27_17" class="form-control">
	      						<?php 
	      						foreach ($nav17 as $n) {
	      							echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
	      						}
	      						?>
	      					</select>
	      					<label>Incêndio:</label>
	      					<select name="nav_processo27_18" class="form-control">
	      						<?php 
	      						foreach ($nav18 as $n) {
	      							echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
	      						}
	      						?>
	      					</select>
	      				</div>
	      			</div>
	      			<div class="row">
	      				<div class="col-sm-4">
	      					<label>Veículo - Cavalo Mecânico:</label>
	      					<select name="nav_processo27_19" class="form-control">
	      						<?php 
	      						foreach ($nav19 as $n) {
	      							echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
	      						}
	      						?>
	      					</select>
	      				</div>	
	      				<div class="col-sm-4">
	      					<label>1º Semi Reboque:</label>
	      					<select name="nav_processo27_20" class="form-control">
	      						<?php 
	      						foreach ($nav19 as $n) {
	      							echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
	      						}
	      						?>
	      					</select>
	      				</div>
	      				<div class="col-sm-4">
	      					<label>2º Semi Reboque:</label>
	      					<select name="nav_processo27_21" class="form-control">
	      						<?php 
	      						foreach ($nav19 as $n) {
	      							echo '<option value="'.$n['id'].'">'.utf8_encode($n['nome']).'</option>';
	      						}
	      						?>
	      					</select>
	      				</div>
	      			</div>
							<?php
						}   			
	      			?>

	      			<br>
				    <div class="row">
		      			<div class="col-sm-10"></div>
		      			<div class="col-sm-2">
							<a href="processo26.php?num_processo=<?=$num_processo; ?>" class="btn btn-danger">Voltar</a>	
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
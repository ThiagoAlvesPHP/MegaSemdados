<?php
require 'header.php';
$sql = new Processos();
//SEGURADOS
$getCidades = $sql->getCidades();
$num_processo = addslashes($_GET['num_processo']);
$p = $sql->getProcesso($num_processo);

$dn = $sql->getDanosMerc($num_processo);

$nav_mercadoria = $sql->getMercadoriasP();
$nav_embalagem = $sql->getEmbalagemP();
$nav_medida = $sql->getMedidaP();
$status_merc = $sql->getStatusMerP();
$status_emb = $sql->getStatusEmbP();

$post = filter_input_array(INPUT_POST, FILTER_DEFAULT);
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
	      	<h3>Mercadoria</h3>
	      	<div class="well">
	      		<?php
	      		if (!empty($dn)) {
	      			//UPDATE DE DANOS DE MERCADORIA
	      			if (isset($post['id_tipo_merc'])) {
	      				$post['num_processo'] = $num_processo;
	      				$sql->upDanosMercadoriaP($post);
							?>
						<script>
							window.location.href = "processo12.php?num_processo=<?=$num_processo; ?>";
						</script>
						<?php
	      			}

	      			?>
	      		<form method="POST">
	      			<div class="row">
		      			<div class="col-sm-2">
		      				<label>Tipo:</label><br><br>
		      				<label>Tipo Embalagem :</label>
		      			</div>
		      			<div class="col-sm-5">
							<select name="id_tipo_merc" class="form-control">
								<?php
								foreach ($nav_mercadoria as $m) {
									if ($dn['id_tipo_merc'] == 0) {
										echo '<option value="0">----</option>';
										foreach ($nav_mercadoria as $m) {
											echo '<option value="'.$m['id'].'">'.$m['nome'].'</option>';
										}
									} else {
										if ($m['id'] == $dn['id_tipo_merc']) {
											echo '<option selected value="'.$m['id'].'">'.$m['nome'].'</option>';
										} else {
											echo '<option value="'.$m['id'].'">'.$m['nome'].'</option>';
										}
									}
									
								}
								?>
							</select><br>
							<select name="id_tipo_emb1" class="form-control">
								<?php
								if ($dn['id_tipo_emb1'] == 0) {
									echo '<option value="0">----</option>';
									foreach ($nav_embalagem as $e) {
										echo '<option value="'.$e['id'].'">'.$e['embalagem'].'</option>';
									}
								} else {
									foreach ($nav_embalagem as $e) {
										if ($e['id'] == $dn['id_tipo_emb1']) {
											echo '<option selected value="'.$e['id'].'">'.$e['embalagem'].'</option>';
										} else {
											echo '<option value="'.$e['id'].'">'.$e['embalagem'].'</option>';
										}
										
									}
								}
								
								?>
							</select>
		      			</div>
		      			<div class="col-sm-5">
							<input type="text" name="descricao" value="<?=$dn['descricao']; ?>" class="form-control"><br>
							<select name="id_tipo_emb2" class="form-control">
								<?php
								if ($dn['id_tipo_emb2'] == 0) {
									echo '<option value="0">----</option>';
									foreach ($nav_embalagem as $e) {
										echo '<option value="'.$e['id'].'">'.$e['embalagem'].'</option>';
									}
								} else {
									foreach ($nav_embalagem as $e) {
										if ($e['id'] == $dn['id_tipo_emb2']) {
											echo '<option selected value="'.$e['id'].'">'.$e['embalagem'].'</option>';
										} else {
											echo '<option value="'.$e['id'].'">'.$e['embalagem'].'</option>';
										}
										
									}
								}
								
								?>
							</select>
		      			</div>
		      		</div><br>
		      		<div class="row">
		      			<div class="col-sm-4">
		      				<label>Qtd. de Volumes:</label>
		      				<input type="text" value="<?=$dn['qt_vol']; ?>" name="qt_vol" class="form-control">
		      			</div>
		      			<div class="col-sm-4">
		      				<label>Unidade de Medida:</label>
		      				<select name="id_uni_medida" class="form-control">
								<?php
								if ($dn['id_uni_medida'] == 0) {
									echo '<option value="0">----</option>';
									foreach ($nav_medida as $u) {
										echo '<option value="'.$u['id'].'">'.$u['nome'].'</option>';
									}
								} else {
									foreach ($nav_medida as $u) {
										if ($u['id'] == $dn['id_uni_medida']) {
											echo '<option selected value="'.$u['id'].'">'.$u['nome'].'</option>';
										} else {
											echo '<option value="'.$u['id'].'">'.$u['nome'].'</option>';
										}
										
									}
								}
								
								?>
							</select>
		      			</div>
		      			<div class="col-sm-4">
		      				<label>Peso:</label>
		      				<input type="text" value="<?=$dn['peso']; ?>" name="peso" class="form-control">
		      			</div>
		      		</div>
		      		<h3>Danos Constatados</h3><br>
		      		<div class="row">
		      			<div class="col-sm-2">
		      				<label>Mercadoria:</label><br>
		      			</div>
		      			<div class="col-sm-5">
							<select name="id_status_merc1" class="form-control">
								<?php
								if ($dn['id_status_merc1'] == 0) {
									echo '<option value="0">----</option>';
									foreach ($status_merc as $sm) {
										echo '<option value="'.$sm['id'].'">'.$sm['status'].'</option>';
									}
								} else {
									foreach ($status_merc as $sm) {
										if ($sm['id'] == $dn['id_status_merc1']) {
											echo '<option selected value="'.$sm['id'].'">'.$sm['status'].'</option>';
										} else {
											echo '<option value="'.$sm['id'].'">'.$sm['status'].'</option>';
										}
										
									}
								}
								
								?>
							</select><br>
							<select name="id_status_merc2" class="form-control">
								<?php
								if ($dn['id_status_merc2'] == 0) {
									echo '<option value="0">----</option>';
									foreach ($status_merc as $sm) {
										echo '<option value="'.$sm['id'].'">'.$sm['status'].'</option>';
									}
								} else {
									foreach ($status_merc as $sm) {
										if ($sm['id'] == $dn['id_status_merc2']) {
											echo '<option selected value="'.$sm['id'].'">'.$sm['status'].'</option>';
										} else {
											echo '<option value="'.$sm['id'].'">'.$sm['status'].'</option>';
										}
										
									}
								}
								?>
							</select>
		      			</div>
		      			<div class="col-sm-5">
							<select name="id_status_merc3" class="form-control">
								<?php
								if ($dn['id_status_merc3'] == 0) {
									echo '<option value="0">----</option>';
									foreach ($status_merc as $sm) {
										echo '<option value="'.$sm['id'].'">'.$sm['status'].'</option>';
									}
								} else {
									foreach ($status_merc as $sm) {
										if ($sm['id'] == $dn['id_status_merc3']) {
											echo '<option selected value="'.$sm['id'].'">'.$sm['status'].'</option>';
										} else {
											echo '<option value="'.$sm['id'].'">'.$sm['status'].'</option>';
										}
										
									}
								}
								?>
							</select><br>
							<select name="id_status_merc4" class="form-control">
								<?php
								if ($dn['id_status_merc4'] == 0) {
									echo '<option value="0">----</option>';
									foreach ($status_merc as $sm) {
										echo '<option value="'.$sm['id'].'">'.$sm['status'].'</option>';
									}
								} else {
									foreach ($status_merc as $sm) {
										if ($sm['id'] == $dn['id_status_merc4']) {
											echo '<option selected value="'.$sm['id'].'">'.$sm['status'].'</option>';
										} else {
											echo '<option value="'.$sm['id'].'">'.$sm['status'].'</option>';
										}
										
									}
								}
								?>
							</select>
		      			</div>
		      		</div><br>
		      		<div class="row">
		      			<div class="col-sm-2">
		      				<label>Embalagem:</label><br>
		      			</div>
		      			<div class="col-sm-5">
							<select name="id_status_emb1" class="form-control">
								<?php
								if ($dn['id_status_emb1'] == 0) {
									echo '<option value="0">----</option>';
									foreach ($status_emb as $sm) {
										echo '<option value="'.$sm['id'].'">'.$sm['status'].'</option>';
									}
								} else {
									foreach ($status_emb as $sm) {
										if ($sm['id'] == $dn['id_status_emb1']) {
											echo '<option selected value="'.$sm['id'].'">'.$sm['status'].'</option>';
										} else {
											echo '<option value="'.$sm['id'].'">'.$sm['status'].'</option>';
										}
										
									}
								}
								?>
							</select><br>
							<select name="id_status_emb2" class="form-control">
								<?php
								if ($dn['id_status_emb2'] == 0) {
									echo '<option value="0">----</option>';
									foreach ($status_emb as $sm) {
										echo '<option value="'.$sm['id'].'">'.$sm['status'].'</option>';
									}
								} else {
									foreach ($status_emb as $sm) {
										if ($sm['id'] == $dn['id_status_emb2']) {
											echo '<option selected value="'.$sm['id'].'">'.$sm['status'].'</option>';
										} else {
											echo '<option value="'.$sm['id'].'">'.$sm['status'].'</option>';
										}
										
									}
								}
								?>
							</select>
		      			</div>
		      			<div class="col-sm-5">
							<select name="id_status_emb3" class="form-control">
								<?php
								if ($dn['id_status_emb3'] == 0) {
									echo '<option value="0">----</option>';
									foreach ($status_emb as $sm) {
										echo '<option value="'.$sm['id'].'">'.$sm['status'].'</option>';
									}
								} else {
									foreach ($status_emb as $sm) {
										if ($sm['id'] == $dn['id_status_emb3']) {
											echo '<option selected value="'.$sm['id'].'">'.$sm['status'].'</option>';
										} else {
											echo '<option value="'.$sm['id'].'">'.$sm['status'].'</option>';
										}
										
									}
								}
								?>
							</select><br>
							<select name="id_status_emb4" class="form-control">
								<?php
								if ($dn['id_status_emb4'] == 0) {
									echo '<option value="0">----</option>';
									foreach ($status_emb as $sm) {
										echo '<option value="'.$sm['id'].'">'.$sm['status'].'</option>';
									}
								} else {
									foreach ($status_emb as $sm) {
										if ($sm['id'] == $dn['id_status_emb4']) {
											echo '<option selected value="'.$sm['id'].'">'.$sm['status'].'</option>';
										} else {
											echo '<option value="'.$sm['id'].'">'.$sm['status'].'</option>';
										}
										
									}
								}
								?>
							</select>
		      			</div>
		      		</div>
		      		<br>
		      		<div class="row">
		      			<div class="col-sm-6">
							<label>Nr. ONU:</label>
		      				<input type="text" value="<?=$dn['nr_onu']; ?>" name="nr_onu" class="form-control">
		      				<label>Nr. Risco:</label>
		      				<input type="text" value="<?=$dn['nr_risco']; ?>" name="nr_risco" class="form-control">
		      			</div>
		      			<div class="col-sm-6">
							<label>Classe de Risco:</label>
		      				<input type="text" value="<?=$dn['class_risco']; ?>" name="class_risco" class="form-control">
		      				<label>Classe Embalagem:</label>
		      				<input type="text" value="<?=$dn['class_embalagem']; ?>" name="class_embalagem" class="form-control">
		      			</div>
		      		</div>
	      			<br>
				    <div class="row">
		      			<div class="col-sm-10"></div>
		      			<div class="col-sm-2">
							<a href="processo10.php?num_processo=<?=$num_processo; ?>" class="btn btn-danger">Voltar</a>	
							<button class="btn btn-primary">Proximo</button>	
		      			</div>
		      		</div>
	      		</form>
	      			<?php
	      		} else {
	      			//CADASTRO DE DANOS DE MERCADORIA
	      			if (isset($post['id_tipo_merc'])) {
	      				$post['num_processo'] = $num_processo;
	      				$sql->setDanosMercadoriaP($post);
							?>
						<script>
							window.location.href = "processo12.php?num_processo=<?=$num_processo; ?>";
						</script>
						<?php
	      			}
	      			?>
	      		<form method="POST">
	      			<div class="row">
		      			<div class="col-sm-2">
		      				<label>Tipo:</label><br><br>
		      				<label>Tipo Embalagem :</label>
		      			</div>
		      			<div class="col-sm-5">
							<select name="id_tipo_merc" class="form-control">
								<?php
								echo '<option value="0">----</option>';
								foreach ($nav_mercadoria as $m) {
									echo '<option value="'.$m['id'].'">'.$m['nome'].'</option>';
								}
								?>
							</select><br>
							<select name="id_tipo_emb1" class="form-control">
								<?php
								echo '<option value="0">----</option>';
								foreach ($nav_embalagem as $e) {
									echo '<option value="'.$e['id'].'">'.$e['embalagem'].'</option>';
								}
								?>
							</select>
		      			</div>
		      			<div class="col-sm-5">
							<input type="text" name="descricao" class="form-control"><br>
							<select name="id_tipo_emb2" class="form-control">
								<?php
								echo '<option value="0">----</option>';
								foreach ($nav_embalagem as $e) {
									echo '<option value="'.$e['id'].'">'.$e['embalagem'].'</option>';
								}
								?>
							</select>
		      			</div>
		      		</div><br>
		      		<div class="row">
		      			<div class="col-sm-4">
		      				<label>Qtd. de Volumes:</label>
		      				<input type="text" name="qt_vol" class="form-control">
		      			</div>
		      			<div class="col-sm-4">
		      				<label>Unidade de Medida:</label>
		      				<select name="id_uni_medida" class="form-control">
								<?php
								echo '<option value="0">----</option>';
								foreach ($nav_medida as $u) {
									echo '<option value="'.$u['id'].'">'.$u['nome'].'</option>';
								}
								?>
							</select>
		      			</div>
		      			<div class="col-sm-4">
		      				<label>Peso:</label>
		      				<input type="text" name="peso" class="form-control">
		      			</div>
		      		</div>
		      		<h3>Danos Constatados</h3><br>
		      		<div class="row">
		      			<div class="col-sm-2">
		      				<label>Mercadoria:</label><br>
		      			</div>
		      			<div class="col-sm-5">
							<select name="id_status_merc1" class="form-control">
								<?php
								echo '<option value="0">----</option>';
								foreach ($status_merc as $sm) {
									echo '<option value="'.$sm['id'].'">'.$sm['status'].'</option>';
								}
								?>
							</select><br>
							<select name="id_status_merc2" class="form-control">
								<?php
								echo '<option value="0">----</option>';
								foreach ($status_merc as $sm) {
									echo '<option value="'.$sm['id'].'">'.$sm['status'].'</option>';
								}
								?>
							</select>
		      			</div>
		      			<div class="col-sm-5">
							<select name="id_status_merc3" class="form-control">
								<?php
								echo '<option value="0">----</option>';
								foreach ($status_merc as $sm) {
									echo '<option value="'.$sm['id'].'">'.$sm['status'].'</option>';
								}
								?>
							</select><br>
							<select name="id_status_merc4" class="form-control">
								<?php
								echo '<option value="0">----</option>';
								foreach ($status_merc as $sm) {
									echo '<option value="'.$sm['id'].'">'.$sm['status'].'</option>';
								}
								?>
							</select>
		      			</div>
		      		</div><br>
		      		<div class="row">
		      			<div class="col-sm-2">
		      				<label>Embalagem:</label><br>
		      			</div>
		      			<div class="col-sm-5">
							<select name="id_status_emb1" class="form-control">
								<?php
								echo '<option value="0">----</option>';
								foreach ($status_emb as $sm) {
									echo '<option value="'.$sm['id'].'">'.$sm['status'].'</option>';
								}
								?>
							</select><br>
							<select name="id_status_emb2" class="form-control">
								<?php
								echo '<option value="0">----</option>';
								foreach ($status_emb as $sm) {
									echo '<option value="'.$sm['id'].'">'.$sm['status'].'</option>';
								}
								?>
							</select>
		      			</div>
		      			<div class="col-sm-5">
							<select name="id_status_emb3" class="form-control">
								<?php
								echo '<option value="0">----</option>';
								foreach ($status_emb as $sm) {
									echo '<option value="'.$sm['id'].'">'.$sm['status'].'</option>';
								}
								?>
							</select><br>
							<select name="id_status_emb4" class="form-control">
								<?php
								echo '<option value="0">----</option>';
								foreach ($status_emb as $sm) {
									echo '<option value="'.$sm['id'].'">'.$sm['status'].'</option>';
								}
								?>
							</select>
		      			</div>
		      		</div>
		      		<br>
		      		<div class="row">
		      			<div class="col-sm-6">
							<label>Nr. ONU:</label>
		      				<input type="text" name="nr_onu" class="form-control">
		      				<label>Nr. Risco:</label>
		      				<input type="text" name="nr_risco" class="form-control">
		      			</div>
		      			<div class="col-sm-6">
							<label>Classe de Risco:</label>
		      				<input type="text" name="class_risco" class="form-control">
		      				<label>Classe Embalagem:</label>
		      				<input type="text" name="class_embalagem" class="form-control">
		      			</div>
		      		</div>
	      			<br>
				    <div class="row">
		      			<div class="col-sm-10"></div>
		      			<div class="col-sm-2">
							<a href="processo10.php?num_processo=<?=$num_processo; ?>" class="btn btn-danger">Voltar</a>	
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
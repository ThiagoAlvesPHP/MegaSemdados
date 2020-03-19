<?php
	require 'header.php';
	$sql = new Apolice();
	$sqlP = new Processos();

	$nav_ramo = $sqlP->nav_ramo();
	$getSeguradoID = $sql->getSeguradoID(addslashes($_GET['id']));

	if (isset($_GET['id']) && !empty($_GET['id'])) {
		
		//REGISTRAR APOLICE
		if (!empty($_POST['id_ramo']) && !empty($_POST['num_apolice']) && !empty($_POST['de']) && !empty($_POST['ate'])) {
			$id_juridica = addslashes($_GET['id']);
			$id_ramo = addslashes($_POST['id_ramo']);
			$num_apolice = addslashes($_POST['num_apolice']);
			$de = addslashes($_POST['de']);
			$ate = addslashes($_POST['ate']);

			$sql->setApolice($id_juridica, $id_ramo, $num_apolice, $de, $ate, $id_user);
			?>
			<script>
				alert("Registrado com sucesso!");
				window.location.assign("apoliceGrid.php");
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
				      		Cadastro de Apolice / <a href="apoliceGrid.php">Retornar</a>
				      	</div>
				      	<div class="panel-body">
				      		<form method="POST">
				      			<label>Segurado:</label>
				      			<input class="form-control" readonly="" value="<?=$getSeguradoID['razao_social']; ?>"><br>
				      			<div class="row">
				      				<div class="col-sm-6">
				      					<label><span style="color: red;">*</span> Ramo:</label>
				      					<select required="" name="id_ramo" class="form-control">
				      					<?php
				      					foreach ($nav_ramo as $r) {
				      						echo '<option value="'.$r['id'].'">'.$r['ramo'].'</option>';
				      					}
				      					?>
				      					</select>
				      				</div>	
				      				<div class="col-sm-6">
				      					<label><span style="color: red;">*</span> Número da Apolice:</label>
				      					<input required="" type="text" name="num_apolice" class="form-control">
				      				</div><br>
				      			</div>
				      			<div class="row">
				      				<div class="col-sm-6">
				      					<label><span style="color: red;">*</span> Vigência de:</label>
				      					<input required="" type="date" name="de" class="form-control">
				      				</div>	
				      				<div class="col-sm-6">
				      					<label><span style="color: red;">*</span> Vigência até:</label>
				      					<input required="" type="date" name="ate" class="form-control">
				      				</div><br>
				      			</div><br>
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
		$ap =$sql->getApoliceID(addslashes($_GET['id_apolice']));

		//UPDATE APOLICE
		if (!empty($_POST['id_ramoUP']) && !empty($_POST['num_apoliceUP']) && !empty($_POST['deUP']) && !empty($_POST['ateUP'])) {
			$id = addslashes($_GET['id_apolice']);

			$id_ramo = addslashes($_POST['id_ramoUP']);
			$num_apolice = addslashes($_POST['num_apoliceUP']);
			$de = addslashes($_POST['deUP']);
			$ate = addslashes($_POST['ateUP']);
			$dt_at = date('Y-m-d');
			$status = addslashes($_POST['status']);
			

			$sql->upApolice($id_ramo, $num_apolice, $de, $ate, $id_user, $dt_at, $status, $id);
			?>
			<script>
				alert("Alterado com sucesso!");
				window.location.assign("apoliceGrid.php");
			</script>
			<?php
		}
		?>
		<br>
		<div class="row">
			<div class="col-sm-1"></div>
				<div class="col-sm-10">
					<div class="panel panel-success">
				      	<div class="panel-heading">
				      		Edição de Apolice / <a href="apoliceGrid.php">Retornar</a>
				      	</div>
				      	<div class="panel-body">
				      		<form method="POST">
				      			<label>Segurado:</label>
				      			<input class="form-control" readonly="" value="<?=$ap['razao_social']; ?>"><br>
				      			<div class="row">
				      				<div class="col-sm-6">
				      					<label><span style="color: red;">*</span> Ramo:</label>
				      					<select required="" name="id_ramoUP" class="form-control">
				      					<?php
				      					foreach ($nav_ramo as $r) {
				      						if ($ap['id_ramo'] == $r['id']) {
				      							echo '<option selected value="'.$r['id'].'">'.$r['ramo'].'</option>';
				      						} else {
				      							echo '<option value="'.$r['id'].'">'.$r['ramo'].'</option>';
				      						}
				      					}
				      					?>
				      					</select>
				      				</div>	
				      				<div class="col-sm-6">
				      					<label><span style="color: red;">*</span> Número da Apolice:</label>
				      					<input required="" type="text" value="<?=$ap['num_apolice']; ?>" name="num_apoliceUP" class="form-control">
				      				</div><br>
				      			</div>
				      			<div class="row">
				      				<div class="col-sm-6">
				      					<label><span style="color: red;">*</span> Vigência de:</label>
				      					<input required="" value="<?=$ap['de']; ?>" type="date" name="deUP" class="form-control">
				      					<label>Status</label>
				      					<select name="status" class="form-control">
				      						<?php
				      						if ($ap['status'] == 1) {
				      							echo '<option value="1">Ativo</option>';
				      							echo '<option value="0">Inativo</option>';
				      						} else {
				      							echo '<option value="0">Inativo</option>';
				      							echo '<option value="1">Ativo</option>';
				      						}
				      						?>
				      					</select>
				      				</div>	
				      				<div class="col-sm-6">
				      					<label><span style="color: red;">*</span> Vigência até:</label>
				      					<input required="" value="<?=$ap['ate']; ?>" type="date" name="ateUP" class="form-control">
				      				</div><br>
				      			</div><br>
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
<?php
	require 'header.php';
	$sql = new tipoDoc();
	//CRIANDO PAGINAÇÃO
	$pg = 1;
	if (isset($_GET['p']) && !empty($_GET['p'])) {
	    $pg = addslashes($_GET['p']);
	}
	$limite = 5;
	$p = ($pg - 1) * 5;
	$pastas = $sql->getPastas($p, $limite);

	//DADOS DO USUARIO LOGADO
	$sql2 = new Funcionarios();
	$nivel = $sql2->getFuncionario($id_user);
	//DEFININDO NIVEL DE ACESSO
	if ($nivel['nivel'] <> 2) {
		?>
		<script>
			alert("Você não tem altorização para acessar essa área!");
			window.location.assign("index.php");
		</script>
		<?php
	}

	//REGISTRANDO PASTAS
	if (!empty($_POST['pasta'])) {
		$pasta = addslashes($_POST['pasta']);
		$seguradora = addslashes($_POST['seguradora']);
		$segurado = addslashes($_POST['segurado']);
		$corretora = addslashes($_POST['corretora']);
		$url = 'img/'.$pasta;

		$ver = $sql->setPasta($pasta, $seguradora, $segurado, $corretora, $url);
		if ($ver == true) {
			?>
			<script>
				alert("Registrado com sucesso!");
				window.location.assign("tipoDoc.php");
			</script>
			<?php
		} else {
			?>
			<script>
				alert("Já existe uma pasta com esse nome!");
				window.location.assign("tipoDoc.php");
			</script>
			<?php
		}
	}

	//ALTERARNDO STATUS DA PASTA
	if (isset($_GET['id']) && !empty($_GET['id'])) {
		$id = addslashes($_GET['id']);
		$status = addslashes($_GET['status']);

		$sql->altPastaStatus($status, $id);
		?>
		<script>
			alert("Status Alterado!");
			window.location.assign("tipoDoc.php");
		</script>
		<?php
	}

?>
<br><br><br>
<div class="container">
	<div class="row">
		<div class="col-sm-6">
			<div class="panel panel-primary">
		      <div class="panel-heading">Registro de Pasta</div>
		      <div class="panel-body">
		      	<form method="POST">
		      		<label>Nome da Pasta</label>
		      		<input type="text" name="pasta" class="form-control" placeholder="Exemplo: boletim_ocorrencia - SEM USO DE CARACTERES ESPECIAS">
		      		<br>
		      		<div class="row">
		      			<div class="col-sm-4">
		      				<input type="checkbox" name="seguradora" value="1">
		      				Seguradora
		      			</div>
		      			<div class="col-sm-4">
		      				<input type="checkbox" name="segurado" value="1">
		      				Segurado
		      			</div>
		      			<div class="col-sm-4">
		      				<input type="checkbox" name="corretora" value="1">
		      				Corretora
		      			</div>
		      		</div><br>
		      		<button class="btn btn-primary">Salvar</button>
		      	</form>
		      </div>
		    </div>
		</div>
		<div class="col-sm-6">
			<div class="panel panel-primary">
		      <div class="panel-heading">Ediação de Pastas</div>
		      <div class="panel-body">
		      	<div class="table-responsive">
		      		<table class="table table-hover">
		      			<thead>
		      				<tr>
		      					<th>Pasta</th>
		      					<th>Seguradora</th>
		      					<th>Segurado</th>
		      					<th>Corretora</th>
		      					<th>Status</th>
		      				</tr>
		      			</thead>
		      			<?php
		      			foreach ($pastas as $p) {
		      				?>
		      				<tbody>
		      					<tr>
			      					<td><?=htmlspecialchars($p['pasta']); ?></td>
			      					<td>
			      						<?php
			      						if ($p['seguradora'] == 1) {
			      							echo 'Sim';
			      						} else {
			      							echo 'Não';
			      						}
			      						?>
			      					</td>
			      					<td>
			      						<?php
			      						if ($p['segurado'] == 1) {
			      							echo 'Sim';
			      						} else {
			      							echo 'Não';
			      						}
			      						?>
			      					</td>
			      					<td>
			      						<?php
			      						if ($p['corretora'] == 1) {
			      							echo 'Sim';
			      						} else {
			      							echo 'Não';
			      						}
			      						?>
			      					</td>
			      					<td>
			      						<?php
			      						if ($p['status'] == 1) {
			      							echo '<a href="tipoDoc.php?id='.$p['id'].'&status=0" class="btn btn-success">Ativo</a>';
			      						} else {
			      							echo '<a href="tipoDoc.php?id='.$p['id'].'&status=1" class="btn btn-danger">Inativo</a>';
			      						}
			      						?>
			      					</td>
			      				</tr>
			      			</tbody>
		      				<?php
		      			}
		      			?>
		      		</table>
		      	</div>

		      	<!-- PAGINAÇÃO -->
                <nav aria-label="Navegação de página exemplo">
                  <ul class="pagination">
                    <?php
                        $total = 0;
                        $total += $pastas[0]['count'];
                        $paginas = $total / 5;

                        for ($i=0; $i < $paginas; $i++) {
	                        if (isset($_GET['p']) AND $_GET['p'] == $i+1) {
	                    		echo '
	                                <li class="page-item active">
	                                    <a class="page-link" href="tipoDoc.php?p='.($i+1).'">'.($i+1).'</a>
	                                </li>';
	                    	} else {
	                    		echo '
	                                <li class="page-item">
	                                    <a class="page-link" href="tipoDoc.php?p='.($i+1).'">'.($i+1).'</a>
	                                </li>';
	                    	}
                        }
                    ?>
                  </ul>
                </nav>

		      </div>
		    </div>
		</div>
	</div>
</div>
<?php
	require 'footer.php';
?>
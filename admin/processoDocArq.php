<?php
require 'header.php';
$sql = new Processos();
$num_processo = addslashes($_GET['num_processo']);

$p = $sql->getProcesso($num_processo);

$sql2 = new tipoDoc();
//CRIANDO PAGINAÇÃO
$pg = 1;
if (isset($_GET['p']) && !empty($_GET['p'])) {
    $pg = addslashes($_GET['p']);
}
$limite = 5;
$paginas = ($pg - 1) * 5;
$pastas = $sql2->getPastas($paginas, $limite);
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
	      	<h3>Documentos do Processo</h3>
	      	<div class="well">
	      		<h4>Pastas do Processo:</h4>
	      		<div class="table-responsive">
	      			<table class="table">
	      				<thead style="background: #000; color: #fff;">
					      <tr>
					        <th width="50">Ação</th>
					        <th>Tipo de Documento</th>
					        <th width="50">Seguradora</th>
					        <th width="50">Segurado</th>
					        <th width="50">Corretor</th>
					      </tr>
					    </thead>
					    <?php
		      			foreach ($pastas as $p) {
		      				?>
		      				<tbody>
		      					<tr>
		      						<td>
		      							<a href="processoDocArq.php?num_processo=<?=$num_processo; ?>&id=<?=$p['id']; ?>" class="fa fa-check-circle"></a>
		      						</td>
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
                                    <a class="page-link" href="processoDocArq.php?num_processo='.$num_processo.'&p='.($i+1).'">'.($i+1).'</a>
                                </li>';
                        	} else {
                        		echo '
                                <li class="page-item">
                                    <a class="page-link" href="processoDocArq.php?num_processo='.$num_processo.'&p='.($i+1).'">'.($i+1).'</a>
                                </li>';
                        	}
                            
                        }
                    ?>
                  </ul>
                </nav>

                <?php
                if (isset($_GET['id']) && !empty($_GET['id'])) {
                	$idDoc = addslashes($_GET['id']);
                	$ptID = $sql2->pastaID($idDoc);

                	//REGISTRANDO IMAGEM DE DOCUMENTO EM PROCESSO
                	if (!empty($_FILES['arquivo'])) {
                		//VERIFICANDO SE ARQUIVO E JPG
                		for ($i=0; $i < count($_FILES['arquivo']['tmp_name']); $i++) {

                			//VERIFICANDO SE É ARQUIVO JPEG
                			if ($_FILES['arquivo']['type'][$i] == "image/jpeg") {
                				$largura = 800;
								$altura = 800;
								
								//CAPTURANDO LARGURA E ALTURA ORIGINAL DA IMAGEM
								list($larguraOri, $alturaOri) = getimagesize($_FILES['arquivo']['tmp_name'][$i]);
								$ratio = $larguraOri / $alturaOri;
								
								if ($largura / $altura > $ratio) {
									$largura = $altura * $ratio;
								} else {
									$altura = $largura / $ratio;
								}	

								//CRIAR IMAGEM COM ALTURA E ALTURA
								$imagem_final = imagecreatetruecolor($largura, $altura);
								$imagem_original = imagecreatefromjpeg($_FILES['arquivo']['tmp_name'][$i]);
								imagecopyresampled($imagem_final, $imagem_original, 0, 0, 0, 0, $largura, $altura, $larguraOri, $alturaOri);

								$img = md5($imagem_final.time().rand(0,999)).'.jpeg'; 
								$comentario = $_FILES['arquivo']['name'][$i];

								imagejpeg($imagem_final, $ptID['url'].'/'.$img, 100);
                			}

                			//VERIFICANDO SE ARQUIVO É PDF
		                	if ($_FILES['arquivo']['type'][$i] == 'application/pdf') {
		                		$img = md5($_FILES['arquivo']['name'][$i].time().rand(0,999)).'.pdf';
		            			$comentario = addslashes($_FILES['arquivo']['name'][$i]);
		            			move_uploaded_file($_FILES['arquivo']['tmp_name'][$i], $ptID['url'].'/'.$img);
		                	}
		                	$sql2->setDocProcesso($num_processo, $idDoc, $img, $comentario, $_SESSION['cLogin']);
                		}
	                	?>
						<script>
							window.location.href = "processoDocArq.php?num_processo=<?=$num_processo; ?>&id=<?=$idDoc; ?>";
						</script>
						<?php
                	}
                	//DELETANDO IMAGEM DE DOCUMENTO DE PROCESSO
                	if (isset($_GET['idImg']) && !empty($_GET['idImg'])) {
                		$idImg = addslashes($_GET['idImg']);
                		$arquivo = $sql2->getIMGID($idImg);
                		unlink($ptID['url'].'/'.$arquivo['img']);
                		$sql2->delDocRegProc($idImg);
                		?>
						<script>
							alert("Documento deletado com sucesso!");
							window.location.href = "processoDocArq.php?num_processo=<?=$num_processo; ?>&id=<?=$idDoc; ?>";
						</script>
						<?php
                	}

                	//DOCUMENTOS REGISTRADOS LISTA POR TIPO DE DOC & NUM_PROCESSO
                	$getDocRegProc = $sql2->getDocRegProc($num_processo, $idDoc);
                	?>
                	<h3 style="color: green;"><?=htmlentities($ptID['pasta']); ?></h3>
                	<hr>

                	<div class="row">
                		<div class="col-sm-3">
                			<form method="POST" enctype="multipart/form-data">
		                		<label>Adicionar Arquivo</label>
		                		<input type="file" name="arquivo[]" multiple="" class="form-control"><br>
		                		<button class="btn btn-primary">Salvar</button>
		                	</form>
                		</div>
                		<div class="col-sm-9">
                			<div class="table-responsive">
                				<table class="table table-hover">
                					<thead style="background: #000; color: #fff;">
								      <tr>
								        <th width="50">Ação</th>
								        <th>Documento</th>
								        <th>Comentario</th>
								        <th>Criado em</th>
								        <th>Criado por</th>
								      </tr>
								    </thead>
								    <?php
								    foreach ($getDocRegProc as $a) {
								    	?>
								    	<tbody>
					      					<tr>
					      						<td>
					      							<a href="processoDocArq.php?num_processo=<?=$num_processo; ?>&id=<?=$idDoc; ?>&idImg=<?=$a['id']; ?>" class="fas fa-trash-alt"></a>
					      						</td>
					      						<td>
					      							<?php
					      							$exIMG = explode('.', $a['img']);
					      							if ($exIMG[1] == 'pdf') {
					      								echo '<img src="assets/img/pdf.png" class="img-responsive" width="50" data-toggle="modal" data-target="#'.$a['id'].'">';
					      							} else {
					      								echo '<img width="50" src="'.$a['url'].'/'.$a['img'].'" class="img-responsive" data-toggle="modal" data-target="#'.$a['id'].'">';
					      							}
					      							$cm = explode('.', $a['comentario']);
					      							?>
					      							<div id="<?=$a['id']; ?>" class="modal fade" role="dialog">
													  <div class="modal-dialog">

													    <!-- Modal content-->
													    <div class="modal-content">
													      <div class="modal-header">
													        <button type="button" class="close" data-dismiss="modal">&times;</button>
													        <h4 class="modal-title">Documento - <?=$cm[0]; ?></h4>
													      </div>
													      <div class="modal-body">
													        <?php
													        if ($exIMG[1] == 'pdf') {
							      								echo '<embed width="100%" height="400px" name="plugin" id="plugin" src="'.$a['url'].'/'.$a['img'].'" type="application/pdf" internalinstanceid="18">';
							      							} else {
							      								echo '<img src="'.$a['url'].'/'.$a['img'].'" width="100%" class="img-responsive"">';
							      							}
													        ?>
													      </div>
													      <div class="modal-footer">
													        <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
													      </div>
													    </div>

													  </div>
													</div>
					      						</td>
					      						<td>
					      							<?php
					      							$c = explode('.', $a['comentario']);
					      							echo htmlspecialchars($c[0]);
					      							?>
					      						</td>
					      						<td><?=date('d/m/Y H:i:s', strtotime($a['dt_cadastrado'])); ?></td>
					      						<td><?=htmlentities($a['nome']); ?></td>
					      					</tr>
					      				</tbody>
								    	<?php
								    }
								    ?>
                				</table>
                			</div>
                		</div>
                	</div>
                	<?php
                }
                ?>

                <div class="row">
		  			<div class="col-sm-10"></div>
		  			<div class="col-sm-2">
						<a href="processo31.php?num_processo=<?=$num_processo; ?>" class="btn btn-danger">Voltar</a>	
						<a href="processoHistorico.php?num_processo=<?=$num_processo; ?>" class="btn btn-primary">Proximo</a>
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
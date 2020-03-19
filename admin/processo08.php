<?php
require 'header.php';
$sql = new Processos();
//SEGURADOS
$getCidades = $sql->getCidades();
$num_processo = addslashes($_GET['num_processo']);
$p = $sql->getProcesso($num_processo);


//DELETANDO IMAGEM DE DOCUMENTO DE PROCESSO
if (isset($_GET['idImg']) && !empty($_GET['idImg'])) {
	$idImg = addslashes($_GET['idImg']);
	$arquivo = $sql->getFTPreliminarID($idImg);
	unlink('assets/img/fotos_preliminares/'.$arquivo['img']);
	$sql->delFTpreliminar($idImg);
	?>
	<script>
		alert("Foto deletada com sucesso!");
		window.location.href = "processo08.php?num_processo=<?=$num_processo; ?>";
	</script>
	<?php
}

//CAPTURANDO FOTOS PRELIMINARES REGISTRADAS
$ft = $sql->getFTPreliminar($num_processo);
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
	      	<h3>Fotos Preliminares do Acontecimento</h3>
	      	<div class="well">
	      		<?php
	      		//REGISTRANDO IMAGEM DE DOCUMENTO EM PROCESSO
				if (!empty($_FILES['arquivo'])) {
					//VERIFICANDO SE ARQUIVO E JPG
					if ($_FILES['arquivo']['type'] == 'image/jpeg') {

						$largura = 800;
						$altura = 800;

						//CAPTURANDO LARGURA E ALTURA ORIGINAL DA IMAGEM
						list($larguraOri, $alturaOri) = getimagesize($_FILES['arquivo']['tmp_name']);
						$ratio = $larguraOri / $alturaOri;
						
						if ($largura / $altura > $ratio) {
							$largura = $altura * $ratio;
						} else {
							$altura = $largura / $ratio;
						}

						//CRIAR IMAGEM COM ALTURA E ALTURA
						$imagem_final = imagecreatetruecolor($largura, $altura);
						$imagem_original = imagecreatefromjpeg($_FILES['arquivo']['tmp_name']);
						imagecopyresampled($imagem_final, $imagem_original, 0, 0, 0, 0, $largura, $altura, $larguraOri, $alturaOri);

						$img = md5($_FILES['arquivo']['name'].time().rand(0,999)).'.jpg';
						$texto = addslashes($_FILES['arquivo']['name']);
						$ver = $sql->setFTPremilinar($num_processo, $img, $texto);
						
						if($ver == true){
							imagejpeg($imagem_final, "assets/img/fotos_preliminares/".$img, 100);	
							?>
							<script>
								window.location.href = "processo08.php?num_processo=<?=$num_processo; ?>";
							</script>
							<?php
						} else {
							?>
							<script>
								alert("Já existem 04 fotos preliminares adicionadas neste processo!");
								window.location.href = "processo08.php?num_processo=<?=$num_processo; ?>";
							</script>
							<?php
						}
					}
				}
	      		?>
	      		<form method="POST"  enctype="multipart/form-data">
	      			<label>Adicionar Arquivo</label>
		            <input type="file" name="arquivo" class="form-control"><br>
				    <div class="row">
			      			<div class="col-sm-9"></div>
			      			<div class="col-sm-3">
			      				<button class="btn btn-success">Salvar</button>
								<a href="processo07.php?num_processo=<?=$num_processo; ?>" class="btn btn-danger">Voltar</a>
								<a href="processo09.php?num_processo=<?=$num_processo; ?>" class="btn btn-primary">Proximo</a>	
			      			</div>
			      		</div>
		      	</form>
		      	<hr>
		      	<?php if (!empty($ft)): ?>
		      	<div class="table-responsive">
	            	<table class="table">
	            		<thead>
	            			<tr>
	            				<th width="50">Ação</th>
	            				<th width="500">Foto</th>
	            				<th>Comentário</th>
	            			</tr>
	            		</thead>
	            		<?php
				      	foreach ($ft as $fts) {
				      		?>
				      		<tbody>
		            			<tr>
		            				<td>
		            					<a style="font-size: 30px;" href="processo08.php?num_processo=<?=$num_processo; ?>&idImg=<?=$fts['id']; ?>" class="fas fa-trash-alt"></a>
		            				</td>
		            				<td>
		            					<img src="assets/img/fotos_preliminares/<?=$fts['img']; ?>" width="500" class="img-responsive">
		            				</td>
		            				<td>

										<style type="text/css">
										#divCarregando {
										    position: fixed;
										    top: 200px;
										    left: 70%;
										}
										#divCarregando img{
											width: 120px;
										}
										</style>
		            					<div id="divCarregando" hidden=""> 
										    <img src="assets/img/loader.gif" />
										    Carregando...
										</div>

		            					<textarea name="txt" style="height: 365px;" id="<?=$fts['id']; ?>" name="texto" class="form-control txt"><?=str_replace('.jpg', '', utf8_encode($fts['texto'])); ?></textarea>
		            				</td>
		            			</tr>
		            		</tbody>
				      		<?php
				      	}
				      	?>
	            	</table>
	            </div>
	        	<?php endif; ?>
	      	</div>
	      </div>
	    </div>
	</div>
	<div class="col-sm-1"></div>
</div>

<?php
require 'footer.php';
?>
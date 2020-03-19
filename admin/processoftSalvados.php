<?php
require 'header.php';
$sql = new Processos();
//SEGURADOS
$getCidades = $sql->getCidades();
$num_processo = addslashes($_GET['num_processo']);
$p = $sql->getProcesso($num_processo);

//REGISTRANDO IMAGEM DE DOCUMENTO EM PROCESSO
if (!empty($_FILES['arquivo'])) {
	if (count($_FILES['arquivo']['tmp_name']) > 0) {
		for ($i=0; $i < count($_FILES['arquivo']['tmp_name']); $i++) {
			if ($_FILES['arquivo']['type'][$i] == 'image/jpeg') {
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

				$arquivo = md5($imagem_final.time().rand(0,999)).'.jpeg'; 
				$texto = $_FILES['arquivo']['name'][$i];
				
				imagejpeg($imagem_final, "assets/img/fotos_salvados/".$arquivo, 100);
				
				$sql->setFTSalvados($num_processo, $arquivo, $texto);
				?>
				<script>
				window.location.href = "processoftSalvados.php?num_processo=<?=$num_processo; ?>";
				</script>
				<?php
			}
		}
	}
}

//DELETANDO IMAGEM DE DOCUMENTO DE PROCESSO
if (isset($_GET['idImg']) && !empty($_GET['idImg'])) {
	$idImg = addslashes($_GET['idImg']);
	$arquivo = $sql->getFTSalvadosID($idImg);
	unlink('assets/img/fotos_salvados/'.$arquivo['img']);
	$sql->delFTSalvados($idImg);
	?>
	<script>
		alert("Foto deletada com sucesso!");
		window.location.href = "processoftSalvados.php?num_processo=<?=$num_processo; ?>";
	</script>
	<?php
}

//CAPTURANDO FOTOS PRELIMINARES REGISTRADAS
$ft = $sql->getFTSalvados($num_processo);
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
	      	<h3>Fotos de Operação de Salvados</h3>
	      	<div class="well">
	      		<form method="POST"  enctype="multipart/form-data">
	      			<label>Adicionar Arquivo</label>
		            <input type="file" name="arquivo[]" multiple="" class="form-control"><br>
				    <button class="btn btn-success">Salvar</button>
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
		            					<a style="font-size: 30px;" href="processoftSalvados.php?num_processo=<?=$num_processo; ?>&idImg=<?=$fts['id']; ?>" class="fas fa-trash-alt"></a>
		            				</td>
		            				<td>
		            					<img src="assets/img/fotos_salvados/<?=$fts['img']; ?>" style="height: 365px; width: 500px;" class="img-responsive">
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
		            					<textarea style="height: 365px;" id="<?=$fts['id']; ?>" name="texto" class="form-control txtftSal"><?=str_replace('.jpg', '', $fts['texto']); ?></textarea>
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
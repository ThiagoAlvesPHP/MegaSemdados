<?php
require 'header.php';
$nav = new Navegacao();

if (!empty($_GET['num_processo'])) {
	$ajax = new Ajax();
	$r = new Rdp();

	$dados = $ajax->getProc(addslashes($_GET['num_processo']));

	$post = filter_input_array(INPUT_POST, FILTER_DEFAULT);
	$post['num_processo'] = $_GET['num_processo'];
	$post['num_sinistro'] = $dados['num_sinistro'];
	$post['seguradora'] = $dados['seguradora'];
	$post['segurado'] = $dados['segurado'];
	$post['transportadora'] = $dados['transportadora'];

	//inserir quando 01
	if (!empty($post['quadro'])) {
		$r->setRDP($post);
		echo '<script>alert("Registrado com sucesso!");window.location.href="rdp.php?num_processo='.$_GET['num_processo'].'"</script>';
	}
}

?>
<div class="container-fluid conteudo">	
	<div class="row">
		<div class="col-sm-1"></div>
		<div class="col-sm-10">
		
			<h3>RDP - Recibo Despesas Próprias</h3>
			<hr>

			<div class="well">
				<input class="form-control seach_proc" placeholder="Pesquisar Processo">
				<hr>
				<div class="resposta"></div>
			</div>

			<div class="well">
				<?php if(!empty($_GET['num_processo'])): ?>
					<div class="row">
						<div class="col-sm-6">
							<label>Processo Mega Nrº</label>
							<input type="text" name="" class="form-control" value="<?=$dados['num_processo']; ?>" readonly="">
						</div>
						<div class="col-sm-6">
							<label>Processo Allianz Nrº</label>
							<input type="text" name="" class="form-control" value="<?=$dados['num_sinistro']; ?>" readonly="">
						</div>
					</div>	
					<div class="row">
						<div class="col-sm-4">
							<label>Seguradora:</label>
							<input type="text" name="" class="form-control" value="<?=$dados['seguradora']; ?>" readonly="">
						</div>
						<div class="col-sm-4">
							<label>Segurado:</label>
							<input type="text" name="" class="form-control" value="<?=$dados['segurado']; ?>" readonly="">
						</div>
						<div class="col-sm-4">
							<label>Transportador</label>
							<input type="text" name="" class="form-control" value="<?=$dados['transportadora']; ?>" readonly="">
						</div>
					</div>	

					<hr>
					<!-- QUADRO 01 -->
					<h4>Quadro 01 - <button data-toggle="modal" data-target="#quadro1">+</button></h4>
					<div id="quadro1" class="modal fade" role="dialog">
					  <div class="modal-dialog">
					    <div class="modal-content">
					      <div class="modal-header">
					        <button type="button" class="close" data-dismiss="modal">&times;</button>
					        <h4 class="modal-title">RDP - Quadro 01</h4>
					      </div>
					      <div class="modal-body">
					      	<?php
					      	$select = ['km Ida', 'km Deslocamento Interno', 'km Retorno', 'Refeição', 'Hospedagem', 'Pedágios', 'Xerox', 'Sedex', 'Outros'];
					      	?>
					        <p>
					        	<form method="POST">
					        		<input type="hidden" name="quadro" value="1">
									<select class="form-control" name="type">
										<?php foreach($select as $item): ?>
											<option><?=$item; ?></option>
										<?php endforeach; ?>
									</select>
									<label>Quantidade</label>
									<input type="number" name="qt" min="1" value="1" class="form-control qt_form" required="">
									<label>Descrição</label><input type="text" name="descricao" class="form-control" required="" autocomplete="off">
									<label>Valor Unitario</label><input type="text" name="valor" class="form-control money v_uni" required="" autocomplete="off">
									<label>Total</label><input type="text" name="total" class="money form-control total" required="" readonly="">
									<br>
									<button class="btn btn-success">Salvar</button>
								</form>
					        </p>
					      </div>
					      <div class="modal-footer">
					        <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
					      </div>
					    </div>
					  </div>
					</div>						
					<hr>
					<!-- QUADRO 02 -->
					<h4>Quadro 02 - <button data-toggle="modal" data-target="#quadro2">+</button></h4>

					<div id="quadro2" class="modal fade" role="dialog">
					  <div class="modal-dialog">
					    <div class="modal-content">
					      <div class="modal-header">
					        <button type="button" class="close" data-dismiss="modal">&times;</button>
					        <h4 class="modal-title">RDP - Quadro 2</h4>
					      </div>
					      <div class="modal-body">
					      	<?php
					      	$select = [
					      		'Honorario SOS', 
					      		'Honorario Averiguação Interno', 
					      		'Honorario Limpeza do Local', 
					      		'Certificado de Vistoria'];
					      	?>
					        <p>
					        	<form method="POST">
					        		<input type="hidden" name="quadro" value="2">
									<select class="form-control" name="type">
										<?php foreach($select as $item): ?>
											<option><?=$item; ?></option>
										<?php endforeach; ?>
									</select>
									<label>Quantidade</label>
									<input type="number" name="qt" min="1" value="1" class="form-control qt_form2" required="">
									<label>Descrição</label><input type="text" name="descricao" class="form-control" required="" autocomplete="off">
									<label>Valor Unitario</label><input type="text" name="valor" class="form-control money v_uni2" required="" autocomplete="off">
									<label>Total</label><input type="text" name="total" class="money form-control total2" required="" readonly="">
									<br>
									<button class="btn btn-success">Salvar</button>
								</form>
					        </p>
					      </div>
					      <div class="modal-footer">
					        <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
					      </div>
					    </div>
					  </div>
					</div>
					
				<?php endif; ?>
				<!--	
				<ul>
					<li>Sub Total</li>
					<li>Total Geral</li>
				</ul> -->			
			</div>

		</div>
		<div class="col-sm-1"></div>
	</div>
</div>
<?php require 'footer.php'; ?>
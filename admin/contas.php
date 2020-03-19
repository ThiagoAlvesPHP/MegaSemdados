<?php
require 'header.php';
$nav = new Navegacao();
$contas = new Financeiro();
$form_pag = $nav->getFormPag();

if (!isset($_GET['type']) && empty($_GET['type'])) {
	echo '<script>alert("Tipo de conta não selecionado!");window.location.href = "index.php"</script>';
}

$post = filter_input_array(INPUT_POST, FILTER_DEFAULT);

//REGISTRANDO CONTAS A PAGAR
if (!empty($post)) {
	$post['id_user'] = $_SESSION['cLogin'];
	if ($_GET['type'] == 'receber') {
		$post['type_register'] = 2;
	} else {
		$post['type_register'] = 1;
	}
	
	$contas->setContas($post);
	echo '<script>alert("Registrado com sucesso!");window.location.href=""</script>';
}

?>
<div class="container-fluid conteudo">	
	<div class="row">
		<div class="col-sm-1"></div>
		<div class="col-sm-10">
		<?php if($_GET['type'] == 'pagar'): ?>
			<h3>Contas a Pagar</h3>
			<hr>
			<div class="well">
				<form method="POST">
					<label>Fornecedor</label>
					<input type="text" name="fornecedor" class="form-control">
					<label>Descrição <span class="ob">*</span></label>
					<textarea name="descricao" class="form-control" required=""></textarea>
					<div class="row">
						<div class="col-sm-4">
							<label>Valor <span class="ob">*</span></label>
							<input type="text" name="valor" class="form-control money" required="">
						</div>
						<div class="col-sm-4">
							<label>Forma de Pagamento <span class="ob">*</span></label>
							<select class="form-control" name="form_pag">
								<?php foreach($form_pag as $f): ?>
									<option value="<?=$f['id']; ?>"><?=$f['descricao']; ?></option>
								<?php endforeach; ?>
							</select>	
						</div>
						<div class="col-sm-4">
							<label>Vencimento <span class="ob">*</span></label>
							<input type="date" name="vencimento" class="form-control" required="">
						</div>
					</div>
					<br>
					<button class="btn btn-primary">Registrar</button>
				</form>
			</div>
		<?php else: ?>
			<h3>Contas a Receber</h3>
			<hr>
			<div class="well">
				<form method="POST">
					<label>Fornecedor</label>
					<input type="text" name="fornecedor" class="form-control">
					<label>Descrição <span class="ob">*</span></label>
					<textarea name="descricao" class="form-control" required=""></textarea>
					<div class="row">
						<div class="col-sm-4">
							<label>Valor <span class="ob">*</span></label>
							<input type="text" name="valor" class="form-control money" required="">
						</div>
						<div class="col-sm-4">
							<label>Forma de Pagamento <span class="ob">*</span></label>
							<select class="form-control" name="form_pag">
								<?php foreach($form_pag as $f): ?>
									<option value="<?=$f['id']; ?>"><?=$f['descricao']; ?></option>
								<?php endforeach; ?>
							</select>	
						</div>
						<div class="col-sm-4">
							<label>Vencimento <span class="ob">*</span></label>
							<input type="date" name="vencimento" class="form-control" required="">
						</div>
					</div>
					<br>
					<button class="btn btn-primary">Registrar</button>
				</form>
			</div>
		<?php endif; ?>
		</div>
		<div class="col-sm-1"></div>
	</div>
</div>

<?php require 'footer.php'; ?>


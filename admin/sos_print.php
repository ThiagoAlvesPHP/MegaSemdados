<?php

if (!empty($_GET['num_processo'])) {
	require 'autoload.php';
	$ajax = new Ajax();
	$r = new Rdp();

	$dados = $ajax->getProc(addslashes($_GET['num_processo']));
	//$rdp = $r->getAll(addslashes($_GET['num_processo']));

	$quadro1 = 0;
	$quadro2 = 0;
	$total = 0;
}
?>


<?php if(!empty($_GET['num_processo'])): ?>
	<link rel="icon" href="assets/img/favicon.png" type="image/x-icon"/>
	<style type="text/css">
		.tr td{
			border: solid 0.2px;
		}
	</style>

	<div style="width: 80%; margin: auto;">
		
		<table width="100%">
	    	<tr>
	    		<td><img width="150" src="assets/img/MegaB.png"></td>
	    		<td>
	    			<h2>Despesas SOS Seg.</h2>
					M.R.S Serviços Técnicos de Seguros Ltda<br>
					27.015.698/0001-75
	    		</td>
	    	</tr>
		</table>

		<br><br>

		Processo Mega Nrº: <?=$dados['num_processo']; ?><br>
		Processo Allianz Nrº: <?=utf8_decode($dados['num_sinistro']); ?><br>
		
		Seguradora: <?=utf8_decode($dados['seguradora']); ?><br>
		Segurado: <?=utf8_decode($dados['segurado']); ?><br>
		Transportador: <?=utf8_decode($dados['transportadora']); ?><br><br>
		


		<!-- <table width="100%">
		    <tr>
	            <th>Tipo</th>
	            <th>Quantidade</th>
	            <th>Descriçao</th>
	            <th>Valor</th>
	            <th>Total</th>
	        </tr>
		    <?php foreach ($rdp as $value): ?>
		    <?php 
		    if($value['quadro'] == 1): 
		    $quadro1 += $value['total'];
		    ?>
	    	<tr class="tr">
	    		<td><?=$value['type']; ?></td>
	    		<td><?=$value['qt']; ?></td>
	    		<td><?=$value['descricao']; ?></td>
	    		<td>R$<?=number_format($value['valor'],2,',','.'); ?></td>
	    		<td width="100">R$<?=number_format($value['total'], 2, ',', '.'); ?></td>
	    	</tr>
			<?php endif;?>
		    <?php endforeach; ?>
		</table>

		<table width="100%">
		    <thead>
		        <tr>
		            <th>Sub Total</th>
		            <th width="100">R$<?=number_format($quadro1, 2, ',', '.'); ?></th>
		        </tr>
		    </thead>
		</table> -->

		<hr>

		<!-- <?php
		$total += $quadro1 + $quadro2;
		?>

		<table width="100%" style="font-size: 20px;">
	        <tr>
	            <th>Total Geral</th>
	            <th width="100">R$<?=number_format($total, 2, ',', '.'); ?></th>
	        </tr>
		</table> -->
	</div>
<?php endif; ?>	
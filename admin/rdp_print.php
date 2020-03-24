<?php

if (!empty($_GET['num_processo'])) {
	require 'autoload.php';
	require 'assets/mpdf/autoload.php';
	$ajax = new Ajax();
	$r = new Rdp();

	$dados = $ajax->getProc(addslashes($_GET['num_processo']));
	$rdp = $r->getAll(addslashes($_GET['num_processo']));

	$quadro1 = 0;
	$quadro2 = 0;
	$total = 0;

	ob_start(); 
}
?>


<?php if(!empty($_GET['num_processo'])): ?>

	<style type="text/css">
		.tr td{
			border: solid;
		}
		h2, .container{
			text-align: center;
		}
		img{
			width: 200px;
		}
	</style>
	
	<div class="container">
		<h2>RDP - Recibo Despesas Próprias</h2>
		<img src="assets/img/MegaB.png"><br>
		M.R.S Serviços Técnicos de Seguros Ltda<br>
		27.015.698/0001-75
	</div>
	<br><br>

	Processo Mega Nrº: <?=$dados['num_processo']; ?><br>
	Processo Allianz Nrº: <?=utf8_decode($dados['num_sinistro']); ?><br>
	
	Seguradora: <?=utf8_decode($dados['seguradora']); ?><br>
	Segurado: <?=utf8_decode($dados['segurado']); ?><br>
	Transportador: <?=utf8_decode($dados['transportadora']); ?><br><br>
	


	<table style="width:100%">
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

	<table id="quadro01" class="table table-hover display" style="width:100%">
	    <thead>
	        <tr>
	            <th>Sub Total</th>
	            <th width="100">R$<?=number_format($quadro1, 2, ',', '.'); ?></th>
	        </tr>
	    </thead>
	</table>

	<table style="width:100%">
        <tr>
            <th>Tipo</th>
            <th>Quantidade</th>
            <th>Descriçao</th>
            <th>Valor</th>
            <th>Total</th>
        </tr>
	    <?php foreach ($rdp as $value): ?>
	    <?php 
	    if($value['quadro'] == 2): 
	    $quadro2 += $value['total'];
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

	<table style="width:100%">
	    <thead>
	        <tr>
	            <th>Sub Total</th>
	            <th width="100">R$<?=number_format($quadro2, 2, ',', '.'); ?></th>
	        </tr>
	    </thead>
	</table>

	<hr>

	<?php
	$total += $quadro1 + $quadro2;
	?>

	<table style="width:100%; font-size: 20px;">
        <tr>
            <th>Total Geral</th>
            <th width="100">R$<?=number_format($total, 2, ',', '.'); ?></th>
        </tr>
	</table>
<?php 
$html = ob_get_contents();
ob_end_clean();

$mpdf = new mPDF();
$mpdf->WriteHTML($html);
$mpdf->Output('arquivo.pdf', 'I');
exit;
endif; 
?>	
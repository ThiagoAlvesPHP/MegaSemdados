<?php

if (!empty($_GET['num_processo'])) {
	require 'autoload.php';
	$ajax = new Ajax();
	$r = new Rdp();
	$p = new Processos();

	$getCusto = $p->getCusto($_GET['num_processo']);
	$dados = $ajax->getProc(addslashes($_GET['num_processo']));
	$sos = $r->getSosAll(addslashes($_GET['num_processo']));

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
	    			<h2>Despesas SOS Segurado</h2>
					M.R.S Serviços Técnicos de Seguros Ltda<br>
					27.015.698/0001-75
	    		</td>
	    	</tr>
		</table>

		<br><br>

		Processo Mega Nrº: <?=$dados['num_processo']; ?><br>
		Processo Allianz Nrº: <?=$dados['num_sinistro']; ?><br>
		
		Seguradora: <?=$dados['seguradora']; ?><br>
		Segurado: <?=$dados['segurado']; ?><br>
		Transportador: <?=$dados['transportadora']; ?><br><br>
		
		<style type="text/css">
			.tr td{
				border: solid 0.2px;
			}
		</style>

		<!-- INICIO DE TABELA -->
		<table width="100%">
		    <tr>
	            <th>Data</th>
	            <th>Descrição</th>
	            <th>Valor</th>
	        </tr>
		    <?php 
		    	foreach ($sos as $value): 
		    	$total += $value['valor']; 
		    ?>
		    <tr class="tr">
	    		<td><?=date('d/m/Y', strtotime($value['dt_cadastro'])); ?></td>
	    		<td><?=$value['descricao']; ?></td>
	    		<td>R$<?=number_format($value['valor'],2,',','.'); ?></td>
	    	</tr>
		    <?php endforeach; ?>

		    <!-- tabla 2 -->
		    <?php
				foreach ($getCusto as $dnC):
				$sub = $dnC['valor']*$dnC['qt'];
			?>
			<tbody>
				<tr class="tr">
					<td><?=date('d/m/Y', strtotime($dnC['dt_cadastro'])); ?></td>
					<td>
						<?=htmlspecialchars($dnC['esforco']); ?>
					</td>
					<td>R$<?=number_format($sub, 2, '.','') ?></td>
				</tr>
			</tbody>
				<?php
				$total += $sub;
			endforeach;
			?>

		</table>	
		<!-- FIM DE TABELA -->
		<!-- TOTAL -->
		<table width="100%" style="font-size: 20px;">
		    <tr>
	            <th>Total Geral</th>
	            <th width="100">R$<?=number_format($total, 2, ',', '.'); ?></th>
	        </tr>
		</table>
		<!-- FIM TOTAL -->

	</div>
<?php endif; ?>	
<?php
require 'autoload.php';
$dt = date('Y-m-d');
$dados = (new Dashboard())->getDiarioBordo($dt);
?>
<div class="table-respontive">
<table class="table">
	<tr>
	  <th>Ação:</th>
	  <th>Valor</th>
	  <th>Data</th>
	</tr>
<?php
foreach ($dados as $v): ?>
	<tr>
		<td><a href="diario.php?num_processo=<?=$v['num_processo']; ?>" class="far fa-eye"></a></td>
		<td>R$<?=number_format($v['valor'], 2, '.', ''); ?></td>
		<td><?=date('d/m/Y H:i:s', strtotime($v['dt_hs'])); ?></td>
	</tr>
<?php endforeach; ?>
</table>
</div>
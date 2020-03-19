<?php
require 'autoload.php';
$sql = new Processos();

if (!empty($_POST['seachProcesso'])) {
	$num_processo = addslashes($_POST['seachProcesso']);
	$p = $sql->getProcessosSearchCliente($num_processo);

	header("Content-type:application/json");
	echo json_encode($p);
}
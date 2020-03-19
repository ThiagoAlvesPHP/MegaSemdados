<?php 
require 'autoload.php'; 
$sql = new Processos();
$num_processo = addslashes($_GET['num_processo']);
$id_inventario = addslashes($_GET['id_inventario']);

//SELECIONAR TODOS OS DADOS DO INVENTARIO
$inventario1 = $sql->getInvetario1($id_inventario);
$inventario2 = $sql->getInvetario2($id_inventario);
$inventario3 = $sql->getInvetario3($id_inventario);

$getMedidaP = $sql->getMedidaP();

$dn = $sql->getDanosMerc($num_processo);
$status_merc = $sql->getStatusMerP();
$status_emb = $sql->getStatusEmbP();

//SEGURADORA, SINISTRO, APOLICE, RAMO, MODAL, VALOR MERCADORIA, VALOR EFEITO SEGURO
$p = $sql->getVistoriaCompleto($num_processo);
//NATURZA DO EVENTO
$a = $sql->getCertificadoEvento($num_processo);
//SEGURADO, CNPJ, CONTATO
$segurado = $sql->getSeguradoid($p['id_segurado']);
//CORRETOR, CNPJ, CONTATO
$corretor = $sql->getSeguradoid($p['id_corretora']);
//DADOS DO REMETENTE
$rem = $sql->getRemetente06($num_processo);
//DADOS DO DESTINATARIO
$dest = $sql->getDestinatario06($num_processo);
//PERCURSO DO TRANSPORTE 1
$c1 = $sql->getCidadeID($inventario2['city1']);
//DADOS DO SINISTRO - DADOS DO ACONTECIMENTO
$dbAc = $sql->getDadosAcontecimento($num_processo);
//ACONTECIMENTO
$atividade = $sql->getAtividadesID($dbAc['id_atividade']);
//ATUAÇÃO
$atuacao = $sql->getAtuacaoIDs($dbAc['id_atuacao']);
//LOCAL DE OCORRENCIA
$los = $sql->getCidadeID($dbAc['id_cidade']);

?>

<div style="width: 80%; margin: auto;">
	<div style="width: 100%; height: 50px; text-align: center; background-color: orange; font-size: 20px; border: solid 1px;">
	  <strong>
	    INVENTÁRIO DE SALVADOS N° <?=$inventario1['token']; ?><br>
	    Processo Mega Nr.: <?=str_replace('/', '', $num_processo); ?>
	  </strong>
	</div>
	<br>
	<table width="100%" border="1">
	    <tr>
	    	<td colspan="3"><b>Seguradora:</b> <?=$p['razao_social']; ?></td>
	    </tr>
	    <tr>
	    	<td colspan="3"><b>Segurado:</b> <?=$segurado['razao_social']; ?></td>
	    </tr>
	    <tr>
	      <th>Ramo de Seguro:</th>
	      <th>Modal de Transporte:</th>
	      <th>Natureza:</th>
	    </tr>
	    <tr>
	      <td><?=$p['ramo']; ?></td>
	      <td><?=$p['modal_transport']; ?></td>
	      <td><?=$a['nat_evento']; ?></td>
	    </tr>
	    <tr>
	    	<td colspan="2"><b>Nota(s) Fiscal(ais) N°:</b> <?=$inventario2['v1']; ?></td>
	    	<td><b>Data de Emissão:</b> <?=date('d/m/Y', strtotime($inventario2['v2'])); ?></td>
	    </tr>
	    <tr>
	    	<td colspan="2"><b>DACTE/ CTRC:</b> <?=$inventario2['v3']; ?></td>
	    	<td><b>Data de Emissão:</b> <?=date('d/m/Y', strtotime($inventario2['v4'])); ?></td>
	    </tr>

	    <tr>
	      <td colspan="3"><b>Danos a Mercadoria: </b>
	        <?php
	        foreach ($status_merc as $value) {
	          if ($value['id'] == $dn['id_status_merc1'] OR $value['id'] == $dn['id_status_merc2'] OR $value['id'] == $dn['id_status_merc3'] OR $value['id'] == $dn['id_status_merc4']) {
	            echo utf8_encode($value['status']).', ';
	          }
	        }
	        ?>
	      </td>
	    </tr>
	    <tr>
	      <td colspan="3"><b>Danos a Embalagem: </b>
	        <?php
	        foreach ($status_emb as $value) {
	          if ($value['id'] == $dn['id_status_emb1'] OR $value['id'] == $dn['id_status_emb2'] OR $value['id'] == $dn['id_status_emb3'] OR $value['id'] == $dn['id_status_emb4']) {
	            echo utf8_encode($value['status']).', ';
	          }
	        }
	        ?>
	      </td>
	    </tr>

	    <tr>
	    	<td colspan="2"><b>Local de Armazenagem:</b> <?=$inventario2['v5']; ?></td>
	    	<td><b>Dados da Empresa:</b> <?=$inventario2['v6']; ?></td>
	    </tr>
	    <tr>
	    	<td><b>Endereço:</b> <?=$inventario2['v7']; ?></td>
	    	<td><b>Bairro:</b> <?=$inventario2['v8']; ?></td>
	    	<td><b>CEP:</b> <?=$inventario2['v9']; ?></td>
	    </tr>
	    <tr>
	    	<td colspan="2"><b>UF/Cidade:</b> <?=utf8_encode($c1['sigla']).' / '.$c1['uf'].' / '.$c1['nome']; ?></td>
	    	<td><b>Telefone(s):</b> <?=$inventario2['v11']; ?></td>
	    </tr>
	    <tr>
	    	<td colspan="3"><b>Contato(s):</b> </td>
	    </tr>
	    <tr>
	    	<td><b>Prazo de Armazenamento S/ Custo:</b> <?=$inventario2['v19']; ?> Dias</td>
	    	<td><b>Custo de Armazenagem:</b> R$<?=$inventario2['v14']; ?></td>
	    	<td><b>Período:</b> <?=$inventario2['v15']; ?> Dias</td>
	    </tr>
	    <tr>
	    	<td colspan="3"><b>Adicionais:</b> <?php
	    	if (!empty($inventario2['v16'])) {
	    		echo $inventario2['v16'];
	    	} else {
	    		echo 'Não há';
	    	}
	    	?></td>
	    </tr>
  	</table>
  	<br>
  	<table width="100%" border="1">
  		<tr>
  			<th colspan="8" style="background: #c0c0c0; font-family: verdana;">DESCRIÇÃO DO LOTE</th>
  		</tr>
  		<tr>
  			<th>Nota Fiscal</th>
  			<th>Mercadoria</th>
  			<th>Unid. Medida</th>
  			<th>Qtd.</th>
  			<th>Valor Unitário</th>
  			<th>Total</th>
  			<th>% de Venda</th>
  			<th>Estimativa de Venda</th>
  		</tr>
		<?php
		$t1 = 0;
		$t2 = 0;
		foreach ($inventario3 as $v) {
		$t1 += $v['d7'];
		$t2 += $v['d8'];
		?>
		<tr>
		<td><?=$v['d1']; ?></td>
		<td><?=$v['d2']; ?></td>
		<td>
			<?php
			foreach ($getMedidaP as $m) {
				if ($v['d3'] == $m['id']) {
					echo utf8_encode($m['nome']);
				}
			}
			?>
		</td>
		<td><?=$v['d4']; ?></td>
		<td>R$<?=number_format($v['d5'], 2, ',', '.'); ?></td>
		<td>R$<?=number_format($v['d7'], 2, ',', '.'); ?></td>
		<td><?=$v['d6']; ?>%</td>
		<td>R$<?=number_format($v['d8'], 2, ',', '.'); ?></td>
		</tr>
		<?php
		}
		?>
  		<tr style="background: #c0c0c0; font-family: verdana;">
  			<th colspan="5">TOTAIS</th>
  			<th>R$<?=number_format($t1, 2, ',', '.'); ?></th>
  			<th></th>
  			<th>R$<?=number_format($t2, 2, ',', '.'); ?></th>
  		</tr>
  		<tr>
  			<th colspan="8">VALOR MÉDIO DE MERCADO: R$<?=number_format($t1, 2, ',', '.'); ?></th>
  		</tr>
  		<tr>
  			<th colspan="8">Observações Adicionais:</th>
  		</tr>
  		<tr>
  			<td colspan="8"><?=$inventario2['v18']; ?></td>
  		</tr>
  	</table>
	
	<br><br><br>
	<div style="float: right; text-align: center;">
		<b>____________________________________<br>
		Sandro Tadeu S. Dino<br></b>
		Comissário de Avarias Reg. Nr.1030
	</div>
	<br><br><br>
	<br><br>

	A emissão do presente Inventário de Salvados, não importa por parte da CIA Seguradora em qualquer reconhecimento de direito do Segurado a qualquer indenização, pois este depende das condições da apólice.	

</div>
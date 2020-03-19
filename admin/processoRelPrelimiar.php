<?php 
require 'autoload.php';
//ob_start(); 
$sql = new Processos();
$num_processo = addslashes($_GET['num_processo']);

//SEGURADORA, SINISTRO, APOLICE, RAMO, MODAL, VALOR MERCADORIA, VALOR EFEITO SEGURO
$p = $sql->getVistoriaCompleto($num_processo);
//NATURZA DO EVENTO
$a = $sql->getCertificadoEvento($num_processo);
//SEGURADO, CNPJ, CONTATO
$segurado = $sql->getSeguradoid($p['id_segurado']);
$getContato = $sql->getContatoEmpresaid($p['id_segurado']);

//CORRETOR, CNPJ, CONTATO
$corretor = $sql->getSeguradoid($p['id_corretora']);
$getContatoC = $sql->getContatoEmpresaid($p['id_corretora']);

//TRANSPORTADOR, CNPJ, CONTATO
$transportador = $sql->getTransportadoraID($p['id_transportadora']);
$getContatoT = $sql->getContatoEmpresaid($p['id_transportadora']);

//DADOS DO REMETENTE
$rem = $sql->getRemetente06($num_processo);
//DADOS DO DESTINATARIO
$dest = $sql->getDestinatario06($num_processo);
//PERCURSO DO TRANSPORTE 1
$c1 = $sql->getCidadeID($p['cidade1']);
//PERCURSO DO TRANSPORTE 2
$c2 = $sql->getCidadeID($p['cidade2']);
//DADOS DO SINISTRO - DADOS DO ACONTECIMENTO
$dbAc = $sql->getDadosAcontecimento($num_processo);
//ACONTECIMENTO
$atividade = $sql->getAtividadesID($dbAc['id_atividade']);
//ATUAÇÃO
$atuacao = $sql->getAtuacaoIDs($dbAc['id_atuacao']);
//LOCAL DE OCORRENCIA
$los = $sql->getCidadeID($dbAc['id_cidade']);
//CAPTURANDO FOTOS PRELIMINARES REGISTRADAS
$ft = $sql->getFTPreliminar($num_processo);

//DOCUMENTAÇÃO A MERCADORIA
$getDocMercP = $sql->getDocMercP($num_processo);
$getInforP = $sql->getInforP($num_processo);

//DOCUMENTAÇÃOP DO TRANSPORTE
$getDocForm2 = $sql->getDocForm2($num_processo);
$form1 = $sql->getform1P14($num_processo);
$fretes = $sql->getNavFrete();
//MERCADORIA
$dn = $sql->getDanosMerc($num_processo);
$nav_mercadoria = $sql->getMercadoriasP();
$nav_embalagem = $sql->getEmbalagemP();
$nav_medida = $sql->getMedidaP();
$status_merc = $sql->getStatusMerP();
$status_emb = $sql->getStatusEmbP();
//VEICULO TRANSPORTADOR
$getP15 = $sql->getP15($num_processo);
//MOTORISTA DO VEICULO TRANSPORTADOR
$getP16 = $sql->getP16($num_processo);
$getNav = $sql->nav_processo16();
//DAS PROVIDENCIAS
$getApPv = $sql->getApPv($num_processo);
//ESTIMATIVA DE CUSTO E PREJUIZO
$getPrejCusto = $sql->getPrejCusto($num_processo);
$getCusto = $sql->getCusto($num_processo);
?>
<link rel="icon" href="assets/img/favicon.png" type="image/x-icon"/>

<body bgcolor="#c0c0c0">

<div style="width: 80%; margin: auto; background: #fff;">
  <!-- INICIO -->
<div style="width: 100%; height: 50px; text-align: center; background-color: orange; font-size: 20px; border: solid 1px;">
    <strong>
    AVISO PRELIMINAR DE SINISTRO<br>
    Processo: <?=str_replace('/', '', $num_processo); ?>
    </strong>
</div>


<br>
<div style="width: 100%;">
  <table width="100%" border="1">
    <tr>
      <th>Comunicante:</th>
      <th>Data e Hora do Comunicado:</th>
    </tr>
    <tr>
      <td><?=$p['comunicante']; ?></td>
      <td><?=date('d/m/Y H:i:s', strtotime($p['dt_hs_comunicado'])); ?></td>
    </tr>
  </table>
</div>
<br>
<div style="width: 100%;">
  <table width="100%" border="1">
    <tr>
      <th>Seguradora:</th>
      <th>CNPJ:</th>
      <th>Nr. Sinistro:</th>
      <th>Nr. Apólice Segurado:</th>
    </tr>
    <tr>
      <td><?=$p['razao_social']; ?></td>
      <td><?=$p['cnpj']; ?></td>
      <td><?=$p['num_sinistro']; ?></td>
      <td><?=$p['num_apolice']; ?></td>
    </tr>
    <tr>
      <th>Ramo de Seguro:</th>
      <th>Modal:</th>
      <th>Moeda Segurada:</th>
      <th>Valor:</th>
    </tr>
    <tr>
      <td><?=$p['ramo']; ?></td>
      <td><?=$p['modal_transport']; ?></td>
      <td><?=$p['md']; ?></td>
      <td>R$<?=number_format($p['valor_mercadoria'], 2, ',', '.'); ?></td>
    </tr>
    <tr>
      <th>Natureza do Evento</th>
      <th>Taxa de Conversão:</th>
      <th colspan="2">Valor R$:</th>
    </tr>
    <tr>
      <td>
        <?php
        $get_evento = $sql->getEventosP();
        foreach ($get_evento as $a) {
          if ($dbAc['id_nat_evento'] == $a['id']) {
            echo $a['nat_evento'];
          }
        }
        ?>
      </td>
      <td>*****</td>
      <td colspan="2">*****</td>
    </tr>
  </table>
</div>
<br>
<div style="width: 100%;">
  <table width="100%" border="1">
    <tr>
      <th width="400px;">Segurado</th>
      <th>CNPJ</th>
      <th>Contato</th>
    </tr>
    <tr>
      <td><?=$segurado['razao_social']; ?></td>
      <td><?=$segurado['cnpj']; ?></td>
      <td><?php echo $getContato['nome'].' - '.$getContato['tel01']; ?></td>
    </tr>
  </table>
</div>
<br>
<div style="width: 100%;">
  <table width="100%" border="1">
    <tr>
      <th width="400px;">Transportador</th>
      <th>CNPJ</th>
      <th>Contato</th>
    </tr>
    <tr>
      <td><?=$transportador['razao_social']; ?></td>
      <td><?=$transportador['cnpj']; ?></td>
      <td><?php echo $getContatoT['nome'].' - '.$getContatoT['tel01']; ?></td>
    </tr>
  </table>
</div>
<br>
<div style="width: 100%;">
  <table width="100%" border="1">
    <tr>
      <th width="400px;">Corretor</th>
      <th>CNPJ</th>
      <th>Contato</th>
    </tr>
    <tr>
      <td><?=$corretor['razao_social']; ?></td>
      <td><?=$corretor['cnpj']; ?></td>
      <td><?php echo $getContatoC['nome'].' - '.$getContatoC['tel01']; ?></td>
    </tr>
  </table>
</div>
<br>
<div style="width: 100%;">
  <table width="100%" border="1">
    <tr>
      <th colspan="2" style="text-align: center;">Percurso do Transporte</th>
    </tr>
    <tr>
      <th>UF/Município de Origem</th>
      <th>UF/Município de Destino</th>
    </tr>
    <tr>
      <td><?=utf8_encode($c1['nome']).' - '.$c1['uf'].' - '.$c1['sigla']; ?></td>
      <td><?=utf8_encode($c2['nome']).' - '.$c2['uf'].' - '.$c2['sigla']; ?></td>
    </tr>
  </table>
</div>
<br>
<div style="width: 100%;">
  <table width="100%" border="1">
    <tr>
      <th width="50%" style="text-align: center;">Remetente</th>
      <th style="text-align: center;">Destinatário</th>
    </tr>
    <tr>
      <td><strong>Razão Social: </strong><?=$rem['razao_social']; ?></td>
      <td><strong>Razão Social: </strong><?=$dest['razao_social']; ?></td>
    </tr>
    <tr>
      <td><strong>Endereço: </strong><?=$rem['endereco']; ?></td>
      <td><strong>Endereço: </strong><?=$dest['endereco']; ?></td>
    </tr>
    <tr>
      <td><strong>Responsável(eis): </strong><?=$rem['responsavel']; ?></td>
      <td><strong>Responsável(eis): </strong><?=$dest['responsavel']; ?></td>
    </tr>
    <tr>
      <td><strong>Fone(s): </strong><?=$rem['contato']; ?></td>
      <td><strong>Fone(s): </strong><?=$dest['contato']; ?></td>
    </tr>
    <tr>
      <td><strong>E-mail(s): </strong><?=$rem['email']; ?></td>
      <td><strong>E-mail(s): </strong><?=$dest['email']; ?></td>
    </tr>
    <tr>
      <td><strong>Seguro Próprio: </strong><?php if ($rem['seguro_proprio'] == 0) { echo 'Não'; } else { echo 'Sim'; } ?></td>
      <td><strong>Seguro Próprio: </strong><?php if ($dest['seguro_proprio'] == 0) { echo 'Não'; } else { echo 'Sim'; } ?></td>
    </tr>
  </table>
</div>
<br>
<div style="width: 100%;">
  <table width="100%" border="1">
    <tr>
      <th colspan="3" style="text-align: center;">Sinistro</th>
    </tr>
    <tr>
      <th>UF/Município</th>
      <th>Data e Hora</th>
      <th>Local da Ocorrência / Constatação</th>
    </tr>
    <tr>
      <td><?=utf8_encode($los['nome']).' - '.$los['uf'].' - '.$los['sigla']; ?></td>
      <td><?=date('d/m/Y H:i:s', strtotime($dbAc['dt_hs'])); ?></td>
      <td><?=$dbAc['local_os']; ?></td>
    </tr>
    <tr>
      <th colspan="2">Motorista/Representantes no Local</th>
      <th>Local Preservado</th>
    </tr>
    <tr>
      <td colspan="2"><?php 
      if ($dbAc['pres_representante'] == 0) {
        echo 'Não';
      } else {
        echo 'Sim';
      }
       ?></td>
      <td><?php 
      if ($dbAc['lc_preservado'] == 0) {
        echo 'Não';
      } else {
        echo 'Sim';
      }
      ?></td>
    </tr>

    <tr>
      <th colspan="2">Risco de Saque</th>
      <th>Riscos Ambientais</th>
    </tr>
    <tr>
      <td colspan="2"><?php 
      if ($dbAc['risco_saque'] == 0) {
        echo 'Não';
      } else {
        echo 'Sim';
      }
       ?></td>
      <td><?php 
      if ($dbAc['risco_ambiental'] == 0) {
        echo 'Não';
      } else {
        echo 'Sim';
      }
      ?></td>
    </tr>
  </table>
</div>
<br>
<div style="width: 100%">
  <table width="100%" border="1">
    <tr>
      <th colspan="3" style="text-align: center;">Descrição do Evento</th>
    </tr>
    <tr>
      <td colspan="3"><?=$dbAc['descricao']; ?></td>
    </tr>
  </table>
</div>
<br>
<div style="width: 100%;">
  <table width="100%" border="1">
    <tr>
      <th colspan="5" style="text-align: center;">Documentação</th>
    </tr>
    <tr>
      <th>Da Mercadoria</th>
      <th>Nr. Moeda</th>
      <th>Valor</th>
      <th>Valor Efeito Seguro</th>
      <th>Valor</th>
    </tr>
    <?php
    foreach ($getDocMercP as $value) {
      ?>
    <tr>
      <td><?=utf8_encode($value['nome_cod']); ?></td>
      <td><?php echo $value['num_doc'].' - '.utf8_encode($value['nome']); ?></td>
      <td>R$<?=number_format($value['valor'], 2, ',', '.'); ?></td>
      <td><?=$value['efeito_seguro']; ?></td>
      <td>R$<?=number_format($value['valor_efeito'], 2, ',', '.'); ?></td>
    </tr>
      <?php
    }
    ?>
    <tr>
      <th colspan="5">Obs.:</th>
    </tr>
    <tr>
      <td colspan="5"><?=$getInforP['informacao']; ?></td>
    </tr>

    <tr>
      <th>Do Transporte</th>
      <th>Nr. Moeda</th>
      <th>Valor</th>
      <th>Valor Efeito Seguro</th>
      <th>Valor</th>
    </tr>
    <?php
    foreach ($getDocForm2 as $value) {
      ?>
    <tr>
      <td><?=$value['nome_cod']; ?></td>
      <td><?php echo $value['num_doc'].' - '.utf8_encode($value['nome']); ?></td>
      <td>R$<?=number_format($value['valor'], 2, ',', '.'); ?></td>
      <td><?=$value['efeito_seguro']; ?></td>
      <td>R$<?=number_format($value['valor_efeito'], 2, ',', '.'); ?></td>
    </tr>
      <?php
    }
    ?>
    <tr>
      <th colspan="3">RNTRC:</th>
      <th colspan="2">Modalidade de Frete:</th>
    </tr>
    <tr>
      <td colspan="3"><?=$form1['rntrc']; ?></td>
      <td colspan="2"><?php
      foreach ($fretes as $value) {
        if ($value['id'] == $form1['frete']) {
          echo $value['frete'];
        }
      }

      ?></td>
    </tr>
  </table>
</div>
<br>
<div style="width: 100%;">
  <table width="100%" border="1">
    <tr>
      <th colspan="3" style="text-align: center;">Mercadoria</th>
    </tr>
    <tr>
      <th>Tipo</th>
      <th>Descrição</th>
      <th>Tipo Embalagem</th>
    </tr>
    <tr>
      <td>
        <?php
        foreach ($nav_mercadoria as $m) {
          if ($m['id'] == $dn['id_tipo_merc']) {
            echo utf8_encode($m['nome']);
          }
        }
        ?>
      </td>
      <td><?=$dn['descricao']; ?></td>
      <td>
        <?php
        foreach ($nav_embalagem as $e) {
          if ($e['id'] == $dn['id_tipo_emb1']) {
            echo $e['embalagem'];
          }
        }
        ?>
      </td>
    </tr>
    <tr>
      <th>Qtd. de Volumes</th>
      <th>Unid. Medida:</th>
      <th>Peso:</th>
    </tr>
    <tr>
      <td><?=$dn['qt_vol']; ?></td>
      <td>
        <?php
        foreach ($nav_medida as $u) {
            if ($u['id'] == $dn['id_uni_medida']) {
              echo utf8_encode($u['nome']);
            }            
          }
        ?>
      </td>
      <td><?=$dn['peso']; ?></td>
    </tr>
    <tr>
      <th colspan="3">Danos Constatados</th>
    </tr>
    <tr>
      <td colspan="3"><strong>Mercadoria: </strong>
        <?php
        foreach ($status_merc as $sm) {
            if ($sm['id'] == $dn['id_status_merc1']) {
              echo utf8_encode($sm['status']).', ';
            }
            if ($sm['id'] == $dn['id_status_merc2']) {
              echo utf8_encode($sm['status']).', ';
            }
            if ($sm['id'] == $dn['id_status_merc3']) {
              echo utf8_encode($sm['status']).', ';
            }
            if ($sm['id'] == $dn['id_status_merc4']) {
              echo utf8_encode($sm['status']).', ';
            }
          }
        ?>
      </td>
    </tr>
    <tr>
      <td colspan="3"><strong>Embalagem: </strong>
        <?php
        foreach ($status_emb as $sm) {
            if ($sm['id'] == $dn['id_status_emb1']) {
              echo utf8_encode($sm['status']).', ';
            }
            if ($sm['id'] == $dn['id_status_emb2']) {
              echo utf8_encode($sm['status']).', ';
            }
            if ($sm['id'] == $dn['id_status_emb3']) {
              echo utf8_encode($sm['status']).', ';
            }
            if ($sm['id'] == $dn['id_status_emb4']) {
              echo utf8_encode($sm['status']).', ';
            }
          }
        ?>
      </td>
    </tr>
  </table>
</div>
<br>
<div style="width: 100%;">
  <table width="100%" border="1">
    <tr>
      <th colspan="4" style="text-align: center;">Veículo Transportador</th>
    </tr>
    <tr>
      <th colspan="2">Proprietário:</th>
      <td colspan="2"><?=utf8_encode($getP15['p1']); ?></td>
    </tr>
    <tr>
      <th>Veículo</th>
      <th>Cavalo Mecânico</th>
      <th>Carreta 1º Semirreboque</th>
      <th>Carreta 2º Semirreboque</th>
    </tr>
    <tr>
      <th>Placa:</th>
      <td><?=utf8_encode($getP15['p7']); ?></td>
      <td><?=utf8_encode($getP15['p14']); ?></td>
      <td><?=utf8_encode($getP15['p21']); ?></td>
    </tr>
    <tr>
      <th>Marca:</th>
      <td><?=$getP15['p8']; ?></td>
      <td><?=$getP15['p15']; ?></td>
      <td><?=$getP15['p22']; ?></td>
    </tr>
    <tr>
      <th>Modelo:</th>
      <td><?=$getP15['p9']; ?></td>
      <td><?=$getP15['p16']; ?></td>
      <td><?=$getP15['p23']; ?></td>
    </tr>
    <tr>
      <th colspan="2">Obs.:</th>
      <td colspan="2"><?=$getP15['p31']; ?></td>
    </tr>
  </table>
</div>
<br>
<div style="width: 100%;">
  <table width="100%" border="1">
    <tr>
      <th colspan="4" style="text-align: center;">Dados do Motorista</th>
    </tr>
    <tr>
      <th colspan="2">Vínculo:</th>
      <td colspan="2">
        <?php
        foreach ($getNav as $n) {
          if ($getP16['p1'] == $n['id']) {
            echo utf8_encode($n['nome']);
          }
        }
        ?>
      </td>
    </tr>
    <tr>
      <th colspan="2">Nome:</th>
      <td colspan="2"><?=$getP16['p3']; ?></td>
    </tr>
    <tr>
      <th colspan="4" style="text-align: center;">Dados Pessoais</th>
    </tr>
    <tr>
      <td><strong>RG: </strong><?=$getP16['p12']; ?></td>
      <td><strong>Órgão Emissor: </strong><?=$getP16['p13']; ?></td>
      <td colspan="2"><strong>CPF: </strong><?=$getP16['p14']; ?></td>
    </tr>
    <tr>
      <td><strong>CNH Reg.: </strong><?=$getP16['p15']; ?></td>
      <td><strong>Categoria: </strong><?=$getP16['p16']; ?></td>
      <td colspan="2"><strong>Validade: </strong><?=date('d/m/Y', strtotime($getP16['p17'])); ?></td>
    </tr>
  </table>
</div>
<br>
<div style="width: 100%;">
  <table width="100%" border="1">
    <tr>
      <th style="text-align: center;">Das Providencias</th>
    </tr>
    <tr>
      <td><?=$getApPv['providencias']; ?></td>
    </tr>
  </table>
</div>
<br>
<br>
<br>
<?php 
$total = 0;
?>
<div style="width: 100%;">
  <table width="100%" border="1">
    <tr>
      <th colspan="2" style="text-align: center;">Estimativa de Prejuízo</th>
    </tr>
    <tr>
      <th>DESCRIÇÃO</th>
      <th>TOTAL</th>
    </tr>
    <tr>
      <td>Danos:</td>
      <td>R$<?=number_format($getPrejCusto['danos'], 2, ',', '.'); ?></td>
    </tr>
    <tr>
      <td>Dispersão:</td>
      <td>R$<?=number_format($getPrejCusto['dispersao'], 2, ',', '.'); ?></td>
    </tr>
    <tr>
      <td>Falta/Saque/Roubo:</td>
      <td>R$<?=number_format($getPrejCusto['fsr'], 2, ',', '.'); ?></td>
    </tr>
    <?php 
    $sub1 = $getPrejCusto['danos']+$getPrejCusto['dispersao']+$getPrejCusto['fsr'];
    $total += $sub1;
    ?>
    <tr>
      <th colspan="2" style="text-align: center;">SUBTOTAL R$<?=number_format($sub1, 2, ',', '.'); ?></th>
    </tr>
  </table>
</div>
<div style="width: 100%;">
  <table width="100%" border="1">
    <tr>
      <th colspan="4">Estimativa de Custo (SOS)</th>
    </tr>
    <tr>
      <th>DESCRIÇÃO</th>
      <th>QUANT.</th>
      <th>VALOR</th>
      <th>TOTAL</th>
    </tr>
    <?php
    $sub2 = 0;
    foreach ($getCusto as $value) {
      $sub2 += $value['valor']*$value['qt'];
      ?>
      <tr>
        <td><?=utf8_encode($value['esforco']); ?></td>
        <td><?=$value['qt']; ?></td>
        <td>R$<?=number_format($value['valor'], 2, ',', '.'); ?></td>
        <td>R$<?=number_format($value['valor']*$value['qt'], 2, ',', '.'); ?></td>
      </tr>
      <?php
    }
    ?>
    <tr>
      <th colspan="4" style="text-align: center;">SUBTOTAL R$<?=number_format($sub2, 2, ',', '.'); ?></th>
    </tr>
  </table>
  <?php
  $total += $sub2;
  ?>
</div>
<div style="width: 100%;">
  <table width="100%" border="1">
    <tr>
      <th colspan="6" style="font-size: 20px; text-align: center;">Total de Prejuízo Estimado: R$<?=number_format($total, 2, ',', '.') ?></th>
    </tr>
  </table>
</div>
<br>
<br>
<br>
<br>
<div style="width: 100%;">
  <table width="100%" border="1">
    <tr>
  <?php
  $x = 0;

    foreach ($ft as $fts) {
      $arquivo = 'assets/img/fotos_preliminares/'.$fts['img'];

      $arq = $sql->redimencionarIMG($arquivo); 
      if (file_exists('assets/img/fotos_preliminares/miniaturas/'.$fts['img'])) {
        $mini = 'assets/img/fotos_preliminares/miniaturas/'.$fts['img'];
      } else {
        imagejpeg($arq['img_fim'], 'assets/img/fotos_preliminares/miniaturas/'.$fts['img']);
        $mini = 'assets/img/fotos_preliminares/miniaturas/'.$fts['img'];
      }

      $x++;
      if (($x % 2) != 0) {
        ?>
          <th width="50%">
            <img width="300" height="200" src="<?=$mini; ?>">
            <br>
            <?=$fts['texto']; ?>
          </th>
        <?php
      } else {
        ?>
          <th width="50%">
            <img width="300" height="200" src="<?=$mini; ?>">
            <br>
            <?=$fts['texto']; ?>
          </th>
          </tr>
        <?php
        $x = 0;
      }
    }
  ?>
  </table>
</div>
</div>
</body>
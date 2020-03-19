<?php 
require 'autoload.php';
$sql = new Processos();
$num_processo = addslashes($_GET['num_processo']);

//SEGURADORA, SINISTRO, APOLICE, RAMO, MODAL, VALOR MERCADORIA, VALOR EFEITO SEGURO
$p = $sql->getVistoriaCompleto($num_processo);
//NATURZA DO EVENTO
$a = $sql->getCertificadoEvento($num_processo);
//SEGURADO, CNPJ, CONTATO
$segurado = $sql->getSeguradoid($p['id_segurado']);
//CORRETOR, CNPJ, CONTATO
$corretor = $sql->getSeguradoid($p['id_corretora']);
//TRANSPORTADOR, CNPJ, CONTATO
$transportador = $sql->getTransportadoraID($p['id_transportadora']);
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
//REGISTRO POLICIAL
$getRegPolicial = $sql->getRegPolicial($num_processo);
?>
<link rel="icon" href="assets/img/favicon.png" type="image/x-icon"/>
<!-- INICIO -->
<body bgcolor="#c0c0c0">
  <div style="width: 80%; margin: auto; background: #fff;">

<div style="width: 100%; height: 50px; text-align: center; background-color: #00BFFF; font-size: 20px; border: solid 1px;">
    <strong>
    RELATÓRIO DE SINISTRO DE TRANSPORTE<br>
    Processo: <?=str_replace('/', '', $num_processo); ?>
    </strong>
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
      <td><?=$segurado['tel01']; ?></td>
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
      <td><?=$transportador['tel01']; ?></td>
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
      <td><?=$corretor['tel01']; ?></td>
    </tr>
  </table>
</div>

<?php
if (!empty($c1)) {
?>
<br>
<div style="width: 100%;">
  <table width="100%" border="1">
    <tr>
      <th colspan="2">Percurso do Transporte</th>
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
<?php
}

if (!empty($rem)) {
?>
<br>
<div style="width: 100%;">
  <table width="100%" border="1">
    <tr>
      <th width="50%">Remetente</th>
      <th>Destinatário</th>
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
<?php
}

if (!empty($atividade)) {
?>
<br>
<div style="width: 100%;">
  <table width="100%" border="1">
    <tr>
      <th>Atividade</th>
      <th>Atuação</th>
      <th>Natureza do Evento</th>
    </tr>
    <tr>
      <td><?=$atividade['atividade']; ?></td>
      <td><?=$atuacao['atuacao']; ?></td>
      <td><?php
        $get_evento = $sql->getEventosP();
        foreach ($get_evento as $a) {
          if ($dbAc['id_nat_evento'] == $a['id']) {
            echo $a['nat_evento'];
          }
        }
        ?></td>
    </tr>
    <tr>
      <th>Município</th>
      <th>Data e Hora</th>
      <th>Local da Ocorrência Constatação</th>
    </tr>
    <tr>
      <td><?=utf8_encode($los['nome']).' - '.$los['uf'].' - '.$los['sigla']; ?></td>
      <td><?=date('d/m/Y H:i:s', strtotime($dbAc['dt_hs'])); ?></td>
      <td><?=$dbAc['local_os']; ?></td>
    </tr>
  </table>
</div>
<?php
}

if (!empty($dbAc)) {
?>
<br>
<div style="width: 100%;">
  <table width="100%" border="1">
    <tr>
      <th style="background-color: #7AA6D0;">Descrição do Evento:</th>
    </tr>
    <tr>
      <td><?=$dbAc['descricao']; ?></td>
    </tr>
  </table>
</div>
<?php
}










/*FOTOS GERAIS*/

if (!empty($ft)) {
?>
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
            <img width="250" height="200" src="<?=$mini; ?>"><br>
            <?=$fts['texto']; ?>
          </th>
        <?php
      } else {
        ?>
          <th width="50%">
            <img width="250" height="200" src="<?=$mini; ?>"><br>
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
<?php
}

if (!empty($getRegPolicial)) {
?>
<br>
<div style="width: 100%;">
  <table width="100%" border="1">
    <tr>
      <td><b>Boletim de Ocorrência do Acidente: </b>
        <?php
        if (!empty($getRegPolicial['orgao_acidente'] && !empty($getRegPolicial['num_acidente']))) {
          echo 'Sim';
        } else {
          echo 'Não';
        }
        ?>
      </td>
      <td><b>Órgão: </b><?=$getRegPolicial['orgao_acidente']; ?></td>
      <td><b>Número: </b><?=$getRegPolicial['num_acidente']; ?></td>
    </tr>

    <tr>
      <td><b>Boletim de Ocorrência de Saque: </b>
        <?php
        if (!empty($getRegPolicial['orgao_saque'] && !empty($getRegPolicial['num_saque']))) {
          echo 'Sim';
        } else {
          echo 'Não';
        }
        ?>
      </td>
      <td><b>Órgão: </b><?=$getRegPolicial['orgao_saque']; ?></td>
      <td><b>Número: <b><?=$getRegPolicial['num_saque']; ?></td>
    </tr>

    <tr>
      <td colspan="2"><b>Aberto Inquérito: </b>
        <?php
        if ($getRegPolicial['inquerito'] == 1) {
          echo 'Sim';
        } else {
          echo 'Não';
        }
        ?>
      </td>
      <td><b>Investigação em Andamento: </b>
        <?php
        if ($getRegPolicial['investigacao'] == 1) {
          echo 'Sim';
        } else {
          echo 'Não';
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
      <td><b>Repercussão na Mídia: </b>
        <?php
        if (!empty($getRegPolicial['midia'])) {
          echo 'Sim';
        } else {
          echo 'Não';
        }
        ?><br>
        <b>Observações: </b><?=$getRegPolicial['midia']; ?>
      </td>
    </tr>
  </table>
</div>
<?php
}

$dn = $sql->getDanosMerc($num_processo);
$nav_mercadoria = $sql->getMercadoriasP();
$nav_embalagem = $sql->getEmbalagemP();
$nav_medida = $sql->getMedidaP();
$status_merc = $sql->getStatusMerP();
$status_emb = $sql->getStatusEmbP();

if (!empty($dn)) {
?>
<br>
<div style="width: 100%;">
  <table width="100%" border="1">
    <tr>
      <th colspan="4" style="background-color: #7AA6D0;">Mercadoria</th>
    </tr>
    <tr>
      <td colspan="2"><b>Tipo: </b>
        <?php
        foreach ($nav_mercadoria as $value) {
          if ($value['id'] == $dn['id_tipo_merc']) {
            echo utf8_encode($value['nome']);
          }
        }
        ?>
      </td>
      <td colspan="2"><b>Tipo Embalagem: </b>
        <?php
        foreach ($nav_embalagem as $value) {
          if ($value['id'] == $dn['id_tipo_emb1']) {
            echo utf8_encode($value['embalagem']);
          }
        }
        ?>
      </td>
    </tr>
    <tr>
      <td colspan="2"><b>Qtd. de Volumes: </b><?=$dn['qt_vol']; ?></td>
      <td><b>Unid. Medida: </b>
        <?php
        foreach ($nav_medida as $value) {
          if ($value['id'] == $dn['id_uni_medida']) {
            echo utf8_encode($value['nome']);
          }
        }
        ?>
      </td>
      <td><b>Peso: </b><?=$dn['peso']; ?></td>
    </tr>
    <tr>
      <th colspan="4" style="background-color: #7AA6D0;">Danos Constatados</th>
    </tr>
    <tr>
      <td colspan="4"><b>Mercadoria: </b>
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
      <td colspan="4"><b>Embalagem: </b>
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
      <td><b>Nr. ONU: </b><?=$dn['nr_onu']; ?></td>
      <td><b>Classe de Risco: </b><?=$dn['class_risco']; ?></td>
      <td><b>Nr. Risco: </b><?=$dn['nr_risco']; ?></td>
      <td><b>Classe Embalagem: </b><?=$dn['class_embalagem']; ?></td>
    </tr>
  </table>
</div>
<?php
}
$dnContainer = $sql->getDnContainerP($num_processo);
if (!empty($dnContainer)) {
?>
<br>
<div style="width: 100%;">
  <table width="100%" border="1">
    <tr>
      <th colspan="8" style="background-color: #7AA6D0;">Contêiner</th>
    </tr>
    <tr>
      <th>Armador</th>
      <th>Ano Fabricação</th>
      <th>Tipo / Modelo</th>
      <th>Avarias</th>
      <th>Valor Averbado</th>
      <th>Valor Depreciado</th>
      <th>Valor Reparo</th>
      <th>Lacres</th>
    </tr>
    <?php
    foreach ($dnContainer as $value) {
      ?>
    <tr>
      <td><?=$value['armador']; ?></td>
      <td><?=$value['ano_fabricacao']; ?></td>
      <td><?=$value['modelo']; ?></td>
      <td><?=$value['dano']; ?></td>
      <td>R$<?=number_format($value['valor_averbado'], 2, ',', '.'); ?></td>
      <td>R$<?=number_format($value['valor_depreciado'], 2, ',', '.'); ?></td>
      <td>R$<?=number_format($value['valor_reparo'], 2, ',', '.'); ?></td>
      <td><?=$value['lacres']; ?></td>
    </tr>
      <?php
    }
    ?>
    
    <tr>
      <td colspan="8"><b>Base de Origem: </b></td>
    </tr>
  </table>
</div>
<?php
}
$getDocMercP = $sql->getDocMercP($num_processo);
$getInforP = $sql->getInforP($num_processo);

if (!empty($getDocMercP)) {
?>
<br>
<div style="width: 100%;">
  <table width="100%" border="1">
    <tr>
      <th colspan="5" style="background-color: #7AA6D0;">Documentação</th>
    </tr>
    <tr>
      <th>Da Mercadoria:</th>
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
      <td><?=$value['num_doc'].' - '.$value['nome']; ?></td>
      <td>R$<?=number_format($value['valor'], 2, ',', '.'); ?></td>
      <td><?=$value['efeito_seguro']; ?></td>
      <td>R$<?=number_format($value['valor_efeito'], 2, ',', '.'); ?></td>
    </tr>
      <?php
    }
    ?>
    <tr>
      <td colspan="5"><b>Obs.: </b><?=$getInforP['informacao']; ?></td>
    </tr>
    <?php
    $form1 = $sql->getform1P14($num_processo);
    $fretes = $sql->getNavFrete();
    $getDocForm2 = $sql->getDocForm2($num_processo);
    ?>
    <tr>
      <th>Do Transporte:</th>
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
      <td><?=$value['num_doc'].' - '.$value['nome']; ?></td>
      <td>R$<?=number_format($value['valor'], 2, ',', '.'); ?></td>
      <td><?=$value['efeito_seguro']; ?></td>
      <td>R$<?=number_format($value['valor_efeito'], 2, ',', '.'); ?></td>
    </tr>
      <?php
    }
    ?>
    <tr>
      <td colspan="2"><b>RNTRC: </b><?=$form1['rntrc']; ?></td>
      <td colspan="3"><b>Modalidade de Frete: </b>
        <?php
        foreach ($fretes as $value) {
          if ($value['id'] == $form1['frete']) {
            echo $value['frete'];
          }
        }
        ?>
      </td>
    </tr>
  </table>
</div>
<?php
}
$getNav = $sql->getNavProcesso15();
$getNAv2 = $sql->nav_processo27_10();
$getP15 = $sql->getP15($num_processo);

if (!empty($getP15)) {
?>
<br>
<div style="width: 100%;">
  <table width="100%" border="1">
    <tr>
      <th colspan="4" style="background-color: #7AA6D0;">Veículo Transportador</th>
    </tr>
    <tr>
      <td colspan="2"><b>Proprietário: </b><?=$getP15['p1']; ?></td>
      <td colspan="2"><b>CNPJ / CPF: </b><?=$getP15['p4']; ?></td>
    </tr>
    <tr>
      <td colspan="2"><b>End. Comercial: </b><?=$getP15['p2']; ?></td>
      <td colspan="2"><b>UF/Cidade: </b>
        <?php
        $d  = $sql->getCidadeID($getP15['p5']);
        echo utf8_encode($d['nome']).' - '.$d['uf'].' - '.$d['sigla'];
        ?>
      </td>
    </tr>
    <tr>
      <td colspan="2"><b>Telefone(s): </b><?=$getP15['p3']; ?></td>
      <td colspan="2"><b>E-mail: </b><?=$getP15['p6']; ?></td>
    </tr>
    <tr>
      <th>Veículo:</th>
      <th>Cavalo Mecânico</th>
      <th>Carreta 1º Semirreboque</th>
      <th>Carreta 2º Semirreboque</th>
    </tr>
    <tr>
      <th>Placa:</th>
      <td><?=$getP15['p7']; ?></td>
      <td><?=$getP15['p14']; ?></td>
      <td><?=$getP15['p21']; ?></td>
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
      <th>Cor:</th>
      <td><?=$getP15['p10']; ?></td>
      <td><?=$getP15['p17']; ?></td>
      <td><?=$getP15['p24']; ?></td>
    </tr>
    <tr>
      <th>Ano de Fabricação:</th>
      <td><?=$getP15['p11']; ?></td>
      <td><?=$getP15['p18']; ?></td>
      <td><?=$getP15['p25']; ?></td>
    </tr>
    <tr>
      <th>Cód. Renavam:</th>
      <td><?=$getP15['p12']; ?></td>
      <td><?=$getP15['p19']; ?></td>
      <td><?=$getP15['p26']; ?></td>
    </tr>
    <tr>
      <th>Chassi:</th>
      <td><?=$getP15['p13']; ?></td>
      <td><?=$getP15['p20']; ?></td>
      <td><?=$getP15['p27']; ?></td>
    </tr>
    <tr>
      <td colspan="4"><b>Peso máximo permitido (Veículo e Carga): </b><?=$getP15['p28']; ?></td>
    </tr>
    <tr>
      <td colspan="2"><b>Sistema Rastreamento: </b>
        <?php
        if (!empty($getP15['p29'])) {
          echo 'Sim';
        } else {
          echo 'Não';
        }
        ?>
      </td>
      <td><b>ID Nr.: </b><?=$getP15['p29']; ?></td>
      <td><b>Provedor: </b><?=$getP15['p30']; ?></td>
    </tr>
    <tr>
      <td colspan="4"><b>Observações: </b><?=$getP15['p31']; ?></td>
    </tr>
  </table>
</div>
<div style="width: 100%;">
  <table width="100%" border="1">
    <tr>
      <th>Estado de Conservação:</th>
      <th>Cavalo Mecânico</th>
      <th>Carreta 1º Semirreboque</th>
      <th>Carreta 2º Semirreboque</th>
    </tr>
    <tr>
      <th>Funilaria:</th>
      <td>
        <?php
        foreach ($getNav as $n) {
          if ($getP15['p32'] == $n['id']) {
            echo utf8_encode($n['nome']);
          }
        }
        ?>
      </td>
      <td>
        <?php
        foreach ($getNav as $n) {
          if ($getP15['p42'] == $n['id']) {
            echo utf8_encode($n['nome']);
          }
        }
        ?>
      </td>
      <td>
        <?php
        foreach ($getNav as $n) {
          if ($getP15['p52'] == $n['id']) {
            echo utf8_encode($n['nome']);
          }
        }
        ?>
      </td>
    </tr>
    <tr>
      <th>Mecânica:</th>
      <td>
        <?php
        foreach ($getNav as $n) {
          if ($getP15['p33'] == $n['id']) {
            echo utf8_encode($n['nome']);
          }
        }
        ?>
      </td>
      <td>
        <?php
        foreach ($getNav as $n) {
          if ($getP15['p43'] == $n['id']) {
            echo utf8_encode($n['nome']);
          }
        }
        ?>
      </td>
      <td>
        <?php
        foreach ($getNav as $n) {
          if ($getP15['p53'] == $n['id']) {
            echo utf8_encode($n['nome']);
          }
        }
        ?>
      </td>
    </tr>
    <tr>
      <th>Pintura:</th>
      <td>
        <?php
        foreach ($getNav as $n) {
          if ($getP15['p34'] == $n['id']) {
            echo utf8_encode($n['nome']);
          }
        }
        ?>
      </td>
      <td>
        <?php
        foreach ($getNav as $n) {
          if ($getP15['p44'] == $n['id']) {
            echo utf8_encode($n['nome']);
          }
        }
        ?>
      </td>
      <td>
        <?php
        foreach ($getNav as $n) {
          if ($getP15['p54'] == $n['id']) {
            echo utf8_encode($n['nome']);
          }
        }
        ?>
      </td>
    </tr>
    <tr>
      <th>Elétrica:</th>
      <td>
        <?php
        foreach ($getNav as $n) {
          if ($getP15['p35'] == $n['id']) {
            echo utf8_encode($n['nome']);
          }
        }
        ?>
      </td>
      <td>
        <?php
        foreach ($getNav as $n) {
          if ($getP15['p45'] == $n['id']) {
            echo utf8_encode($n['nome']);
          }
        }
        ?>
      </td>
      <td>
        <?php
        foreach ($getNav as $n) {
          if ($getP15['p55'] == $n['id']) {
            echo utf8_encode($n['nome']);
          }
        }
        ?>
      </td>
    </tr>
    <tr>
      <th>Pneus:</th>
      <td>
        <?php
        foreach ($getNav as $n) {
          if ($getP15['p36'] == $n['id']) {
            echo utf8_encode($n['nome']);
          }
        }
        ?>
      </td>
      <td>
        <?php
        foreach ($getNav as $n) {
          if ($getP15['p46'] == $n['id']) {
            echo utf8_encode($n['nome']);
          }
        }
        ?>
      </td>
      <td>
        <?php
        foreach ($getNav as $n) {
          if ($getP15['p56'] == $n['id']) {
            echo utf8_encode($n['nome']);
          }
        }
        ?>
      </td>
    </tr>
    <tr>
      <th>Lonas:</th>
      <td>
        <?php
        foreach ($getNav as $n) {
          if ($getP15['p37'] == $n['id']) {
            echo utf8_encode($n['nome']);
          }
        }
        ?>
      </td>
      <td>
        <?php
        foreach ($getNav as $n) {
          if ($getP15['p47'] == $n['id']) {
            echo utf8_encode($n['nome']);
          }
        }
        ?>
      </td>
      <td>
        <?php
        foreach ($getNav as $n) {
          if ($getP15['p57'] == $n['id']) {
            echo utf8_encode($n['nome']);
          }
        }
        ?>
      </td>
    </tr>
    <tr>
      <th>Sistema Refrigeração:</th>
      <td>
        <?php
        foreach ($getNav as $n) {
          if ($getP15['p38'] == $n['id']) {
            echo utf8_encode($n['nome']);
          }
        }
        ?>
      </td>
      <td>
        <?php
        foreach ($getNav as $n) {
          if ($getP15['p48'] == $n['id']) {
            echo utf8_encode($n['nome']);
          }
        }
        ?>
      </td>
      <td>
        <?php
        foreach ($getNav as $n) {
          if ($getP15['p58'] == $n['id']) {
            echo utf8_encode($n['nome']);
          }
        }
        ?>
      </td>
    </tr>
    <tr>
      <th>Assoalho:</th>
      <td>
        <?php
        foreach ($getNav as $n) {
          if ($getP15['p39'] == $n['id']) {
            echo utf8_encode($n['nome']);
          }
        }
        ?>
      </td>
      <td>
        <?php
        foreach ($getNav as $n) {
          if ($getP15['p49'] == $n['id']) {
            echo utf8_encode($n['nome']);
          }
        }
        ?>
      </td>
      <td>
        <?php
        foreach ($getNav as $n) {
          if ($getP15['p59'] == $n['id']) {
            echo utf8_encode($n['nome']);
          }
        }
        ?>
      </td>
    </tr>
    <tr>
      <th>Estrutural Abertos:</th>
      <td>
        <?php
        foreach ($getNav as $n) {
          if ($getP15['p40'] == $n['id']) {
            echo utf8_encode($n['nome']);
          }
        }
        ?>
      </td>
      <td>
        <?php
        foreach ($getNav as $n) {
          if ($getP15['p50'] == $n['id']) {
            echo utf8_encode($n['nome']);
          }
        }
        ?>
      </td>
      <td>
        <?php
        foreach ($getNav as $n) {
          if ($getP15['p60'] == $n['id']) {
            echo utf8_encode($n['nome']);
          }
        }
        ?>
      </td>
    </tr>
    <tr>
      <th>Baú / Similares:</th>
      <td>
        <?php
        foreach ($getNav as $n) {
          if ($getP15['p41'] == $n['id']) {
            echo utf8_encode($n['nome']);
          }
        }
        ?>
      </td>
      <td>
        <?php
        foreach ($getNav as $n) {
          if ($getP15['p51'] == $n['id']) {
            echo utf8_encode($n['nome']);
          }
        }
        ?>
      </td>
      <td>
        <?php
        foreach ($getNav as $n) {
          if ($getP15['p61'] == $n['id']) {
            echo utf8_encode($n['nome']);
          }
        }
        ?>
      </td>
    </tr>
  </table>
</div>
<?php
}

$getNAv2 = $sql->nav_processo27_10();
$getP16 = $sql->getP16($num_processo);
$getNav = $sql->nav_processo16();
$getNav3 = $sql->nav_processo16_1();
$getNav4 = $sql->nav_processo16_2();

if (!empty($getP16)) {
?>
<br>
<div style="width: 100%;">
  <table width="100%" border="1">
    <tr>
      <th colspan="3" style="background-color: #7AA6D0;">Motorista do Veículo Transportador</th>
    </tr>
    <tr>
      <td colspan="2"><b>Vínculo: </b>
        <?php
        foreach ($getNav as $n) {
          if ($getP16['p1'] == $n['id']) {
            echo utf8_encode($n['nome']);
          }
        }
        ?>
      </td>
      <td><b>Contato / Fone: </b><?=$getP16['p2'] ?></td>
    </tr>
    <tr>
      <td colspan="2"><b>Nome: </b><?=$getP16['p3'] ?></td>
      <td><b>Tempo de Profissão: </b><?=$getP16['p4'] ?></td>
    </tr>
    <tr>
      <td colspan="2"><b>Endereço Completo: </b><?=$getP16['p5'] ?></td>
      <td><b>UF/Cidade: </b>
        <?php
        $a  = $sql->getCidadeID($getP16['p6']);
        echo utf8_encode($a['nome']).' - '.$a['uf'].' - '.$a['sigla'];
        ?>
      </td>
    </tr>
    <tr>
      <td><b>Estado Civil: </b>
        <?php
        foreach ($getNav4 as $n) {
          if ($getP16['p8'] == $n['id']) {
            echo utf8_encode($n['nome']);
          }
        }
        ?>
      </td>
      <td><b>Data Nascimento: </b><?=date('d/m/Y', strtotime($getP16['p9'])); ?></td>
      <td><b>UF/Cidade Nasc: </b>
      <?php
        $a  = $sql->getCidadeID($getP16['p7']);
        echo utf8_encode($a['nome']).' - '.$a['uf'].' - '.$a['sigla'];
        ?>
      </td>
    </tr>
    <tr>
      <th colspan="3">Filiação:</th>
    </tr>
    <tr>
      <td colspan="2"><b>Pai: </b><?=$getP16['p10']; ?></td>
      <td><b>Mãe: </b><?=$getP16['p11']; ?></td>
    </tr>
    <tr>
      <th colspan="3">Dados Pessoais:</th>
    </tr>
    <tr>
      <td><b>RG: </b><?=$getP16['p12']; ?></td>
      <td><b>Órgão Emissor: </b><?=$getP16['p13']; ?></td>
      <td><b>CPF: </b><?=$getP16['p14']; ?></td>
    </tr>
    <tr>
      <td><b>CNH Reg.: </b><?=$getP16['p15']; ?></td>
      <td><b>Categoria: </b><?=$getP16['p16']; ?></td>
      <td><b>Validade: </b><?=date('d/m/Y', strtotime($getP16['p17'])); ?></td>
    </tr>
    <tr>
      <th colspan="3">No Local do Evento: </th>
    </tr>
    <tr>
      <td colspan="2"><b>Situação após Evento: </b>
        <?php
        foreach ($getNav3 as $n) {
          if ($getP16['p18'] == $n['id']) {
            echo utf8_encode($n['nome']);
          }
        }
        ?>
      </td>
      <td><b>Observações: </b><?=$getP16['p19']; ?></td>
    </tr>
    <tr>
      <td colspan="3"><b>Consulta de Cadastro para Gerenciamento de Riscos: </b>
        <?php
        if (!empty($getP16['p20'])) {
          echo 'Sim - <b>Liberação Nr: </b>'.$getP16['p20'].' - <b>Empresa Responsável: </b>'.$getP16['p21'];
        } else {
          echo 'Não';
        }
        ?>
      </td>
    </tr>
  </table>
</div>
<?php
}

$getP17form1 = $sql->getP17form1($num_processo);
$getP17form2 = $sql->getP17form2($num_processo);
$getNAv2 = $sql->nav_processo27_10();

if (!empty($getP17form1)) {
  ?>
<br>
<div style="width: 100%;">
  <table width="100%" border="1">
    <tr>
      <th colspan="4" style="background-color: #7AA6D0;">Veículo Transbordo</th>
    </tr>
    <tr>
      <td colspan="2"><b>Proprietário: </b><?=$getP17form1['a1']; ?></td>
      <td colspan="2"><b>CNPJ / CPF: </b><?=$getP17form1['a4']; ?></td>
    </tr>
    <tr>
      <td colspan="2"><b>End. Comercial: </b><?=$getP17form1['a2']; ?></td>
      <td colspan="2"><b>UF/Cidade: </b>
        <?php
        $d  = $sql->getCidadeID($getP17form1['a5']);
          
        echo utf8_encode($d['nome']).' - '.$d['uf'].' - '.$d['sigla'];
        ?>
      </td>
    </tr>
    <tr>
      <td colspan="2"><b>Telefone(s): </b><?=$getP17form1['a3']; ?></td>
      <td colspan="2"><b>E-mail: </b><?=$getP17form1['a6']; ?></td>
    </tr>
    <tr>
      <th>Veículo:</th>
      <th>Cavalo Mecânico</th>
      <th>Carreta 1º Semirreboque</th>
      <th>Carreta 2º Semirreboque</th>
    </tr>
    <tr>
      <th>Placa:</th>
      <td><?=$getP17form1['a7']; ?></td>
      <td><?=$getP17form1['a14']; ?></td>
      <td><?=$getP17form1['a21']; ?></td>
    </tr>
    <tr>
      <th>Marca:</th>
      <td><?=$getP17form1['a8']; ?></td>
      <td><?=$getP17form1['a15']; ?></td>
      <td><?=$getP17form1['a22']; ?></td>
    </tr>
    <tr>
      <th>Modelo:</th>
      <td><?=$getP17form1['a9']; ?></td>
      <td><?=$getP17form1['a16']; ?></td>
      <td><?=$getP17form1['a23']; ?></td>
    </tr>
    <tr>
      <th>Cor:</th>
      <td><?=$getP17form1['a10']; ?></td>
      <td><?=$getP17form1['a17']; ?></td>
      <td><?=$getP17form1['a24']; ?></td>
    </tr>
    <tr>
      <th>Ano de Fabricação:</th>
      <td><?=$getP17form1['a11']; ?></td>
      <td><?=$getP17form1['a18']; ?></td>
      <td><?=$getP17form1['a25']; ?></td>
    </tr>
    <tr>
      <th>Cód. Renavam:</th>
      <td><?=$getP17form1['a12']; ?></td>
      <td><?=$getP17form1['a19']; ?></td>
      <td><?=$getP17form1['a26']; ?></td>
    </tr>
    <tr>
      <th>Chassi:</th>
      <td><?=$getP17form1['a13']; ?></td>
      <td><?=$getP17form1['a20']; ?></td>
      <td><?=$getP17form1['a27']; ?></td>
    </tr>
    <tr>
      <td colspan="4"><b>Peso máximo permitido (Veículo e Carga): </b><?=$getP17form1['a28']; ?></td>
    </tr>
    <tr>
      <td colspan="2"><b>Sistema Rastreamento:: </b>
        <?php
        if (!empty($getP17form1['a29'])) {
          echo 'Sim';
        } else {
          echo 'Não';
        }
        ?>
      </td>
      <td><b>ID Nr.: </b><?=$getP17form1['a29']; ?></td>
      <td><b>Provedor: </b><?=$getP17form1['a30']; ?></td>
    </tr>
    <tr>
      <td colspan="4"><b>Observações: </b><?=$getP17form1['a37']; ?></td>
    </tr>
    <tr>
      <td colspan="4"><b>Lacre(s): </b>
        <?=$getP17form1['a31'].', '.$getP17form1['a32'].', '.$getP17form1['a33'].', '.$getP17form1['a34'].', '.$getP17form1['a35'].', '.$getP17form1['a36']; ?>
      </td>
    </tr>
  </table>
</div>
  <?php
}

if (!empty($getP17form2)) {
  ?>
<div style="width: 100%;">
  <table width="100%" border="1">
    <tr>
      <th colspan="4" style="background-color: #7AA6D0;">Veículo Transbordo 2</th>
    </tr>
    <tr>
      <td colspan="2"><b>Proprietário: </b><?=$getP17form2['b1']; ?></td>
      <td colspan="2"><b>CNPJ / CPF: </b><?=$getP17form2['a4']; ?></td>
    </tr>
    <tr>
      <td colspan="2"><b>End. Comercial: </b><?=$getP17form2['a2']; ?></td>
      <td colspan="2"><b>UF/Cidade: </b>
        <?php
        $d  = $sql->getCidadeID($getP17form2['a5']);
          
        echo utf8_encode($d['nome']).' - '.$d['uf'].' - '.$d['sigla'];
        ?>
      </td>
    </tr>
    <tr>
      <td colspan="2"><b>Telefone(s): </b><?=$getP17form2['a3']; ?></td>
      <td colspan="2"><b>E-mail: </b><?=$getP17form2['a6']; ?></td>
    </tr>
    <tr>
      <th>Veículo:</th>
      <th>Cavalo Mecânico</th>
      <th>Carreta 1º Semirreboque</th>
      <th>Carreta 2º Semirreboque</th>
    </tr>
    <tr>
      <th>Placa:</th>
      <td><?=$getP17form2['a7']; ?></td>
      <td><?=$getP17form2['a14']; ?></td>
      <td><?=$getP17form2['a21']; ?></td>
    </tr>
    <tr>
      <th>Marca:</th>
      <td><?=$getP17form2['a8']; ?></td>
      <td><?=$getP17form2['a15']; ?></td>
      <td><?=$getP17form2['a22']; ?></td>
    </tr>
    <tr>
      <th>Modelo:</th>
      <td><?=$getP17form2['a9']; ?></td>
      <td><?=$getP17form2['a16']; ?></td>
      <td><?=$getP17form2['a23']; ?></td>
    </tr>
    <tr>
      <th>Cor:</th>
      <td><?=$getP17form2['a10']; ?></td>
      <td><?=$getP17form2['a17']; ?></td>
      <td><?=$getP17form2['a24']; ?></td>
    </tr>
    <tr>
      <th>Ano de Fabricação:</th>
      <td><?=$getP17form2['a11']; ?></td>
      <td><?=$getP17form2['a18']; ?></td>
      <td><?=$getP17form2['a25']; ?></td>
    </tr>
    <tr>
      <th>Cód. Renavam:</th>
      <td><?=$getP17form2['a12']; ?></td>
      <td><?=$getP17form2['a19']; ?></td>
      <td><?=$getP17form2['a26']; ?></td>
    </tr>
    <tr>
      <th>Chassi:</th>
      <td><?=$getP17form2['a13']; ?></td>
      <td><?=$getP17form2['a20']; ?></td>
      <td><?=$getP17form2['a27']; ?></td>
    </tr>
    <tr>
      <td colspan="4"><b>Peso máximo permitido (Veículo e Carga): </b><?=$getP17form1['a28']; ?></td>
    </tr>
    <tr>
      <td colspan="2"><b>Sistema Rastreamento:: </b>
        <?php
        if (!empty($getP17form2['a29'])) {
          echo 'Sim';
        } else {
          echo 'Não';
        }
        ?>
      </td>
      <td><b>ID Nr.: </b><?=$getP17form2['a29']; ?></td>
      <td><b>Provedor: </b><?=$getP17form2['a30']; ?></td>
    </tr>
    <tr>
      <td colspan="4"><b>Observações: </b><?=$getP17form2['a37']; ?></td>
    </tr>
    <tr>
      <td colspan="4"><b>Lacre(s): </b>
        <?=$getP17form2['a31'].', '.$getP17form2['a32'].', '.$getP17form2['a33'].', '.$getP17form2['a34'].', '.$getP17form2['a35'].', '.$getP17form2['a36']; ?>
      </td>
    </tr>
  </table>
</div>
  <?php
}
?>
<br>
<?php
$getP18form1 = $sql->processo18_form1($num_processo);
$getP18form2 = $sql->processo18_form2($num_processo);

$getNAv2 = $sql->nav_processo27_10();
$getNav = $sql->nav_processo16();
$getNav4 = $sql->nav_processo16_2();

if (!empty($getP18form1)) {
  ?>
<br>
<div style="width: 100%;">
  <table width="100%" border="1">
    <tr>
      <th colspan="3" style="background-color: #7AA6D0;">Motorista do Veículo Transbordo</th>
    </tr>
    <tr>
      <td colspan="2"><b>Vínculo: </b>
        <?php
        foreach ($getNav as $n) {
          if ($getP18form1['p1'] == $n['id']) {
            echo utf8_encode($n['nome']);
          }
        }
        ?>
      </td>
      <td><b>Contato / Fone: </b><?=$getP18form1['p2']; ?></td>
    </tr>
    <tr>
      <td colspan="2"><b>Nome:   </b><?=$getP18form1['p3']; ?></td>
      <td><b>Tempo de Profissão: </b><?=$getP18form1['p4']; ?></td>
    </tr>
    <tr>
      <td colspan="2"><b>Endereço Completo: </b><?=$getP18form1['p5']; ?></td>
      <td><b>UF/ Estado: </b>
        <?php
        $d  = $sql->getCidadeID($getP18form1['p6']);
        echo utf8_encode($d['nome']).' - '.$d['uf'].' - '.$d['sigla'];
        ?>
      </td>
    </tr>
    <tr>
      <td><b>Estado Civil: </b>
        <?php
        foreach ($getNav4 as $n) {
          if ($getP18form1['p8'] == $n['id']) {
            echo utf8_encode($n['nome']);
          }
        }
        ?>
      </td>
      <td><b>Data Nascimento: </b><?=date('d/m/Y', strtotime($getP18form1['p9'])); ?></td>
      <td><b>UF/Cidade: </b>
        <?php
        $d  = $sql->getCidadeID($getP18form1['p7']);
        echo utf8_encode($d['nome']).' - '.$d['uf'].' - '.$d['sigla'];
        ?>
      </td>
    </tr>
    <tr>
      <th colspan="3">Filiação</th>
    </tr>
    <tr>
      <td colspan="2"><b>Pai: </b><?=$getP18form1['p10']; ?></td>
      <td><b>Mãe: </b><?=$getP18form1['p11']; ?></td>
    </tr>
    <tr>
      <th colspan="3">Dados Pessoais</th>
    </tr>
    <tr>
      <td><b>RG: </b><?=$getP18form1['p12']; ?>"</td>
      <td><b>Órgão Emissor: </b><?=$getP18form1['p13']; ?></td>
      <td><b>CPF: </b><?=$getP18form1['p14']; ?></td>
    </tr>
    <tr>
      <td><b>CNH Reg.: </b><?=$getP18form1['p15']; ?></td>
      <td><b>Categoria: </b><?=$getP18form1['p16']; ?></td>
      <td><b>Validade: </b><?=date('d/m/Y', strtotime($getP18form1['p17'])); ?></td>
    </tr>
    <tr>
      <th colspan="3">No Local do Evento</th>
    </tr>
    <tr>
      <td colspan="3"><b>Observações: </b><?=$getP18form1['p18']; ?></td>
    </tr>
    <tr>
      <td colspan="3"><b>Consulta de Cadastro para Gerenciamento de Riscos: </b>
        <?php
        if (!empty($getP18form1['p19'])) {
          echo 'Sim';
        } else {
          echo 'Não';
        }
        ?>
      </td>
    </tr>
    <tr>
      <td><b>Liberação Nr.: </b><?=$getP18form1['p19']; ?></td>
      <td colspan="2"><b>Empresa Responsável: </b><?=$getP18form1['p20']; ?></td>
    </tr>
  </table>
</div>
  <?php
}

if (!empty($getP18form2)) {
  ?>
  <br>
  <div style="width: 100%;">
  <table width="100%" border="1">
    <tr>
      <th colspan="3" style="background-color: #7AA6D0;">Motorista do Veículo Transbordo 2</th>
    </tr>
    <tr>
      <td colspan="2"><b>Vínculo: </b>
        <?php
        foreach ($getNav as $n) {
          if ($getP18form2['a1'] == $n['id']) {
            echo utf8_encode($n['nome']);
          }
        }
        ?>
      </td>
      <td><b>Contato / Fone: </b><?=$getP18form2['p2']; ?></td>
    </tr>
    <tr>
      <td colspan="2"><b>Nome:   </b><?=$getP18form2['p3']; ?></td>
      <td><b>Tempo de Profissão: </b><?=$getP18form2['p4']; ?></td>
    </tr>
    <tr>
      <td colspan="2"><b>Endereço Completo: </b><?=$getP18form2['p5']; ?></td>
      <td><b>UF/ Estado: </b>
        <?php
        $d  = $sql->getCidadeID($getP18form2['p6']);
        echo utf8_encode($d['nome']).' - '.$d['uf'].' - '.$d['sigla'];
        ?>
      </td>
    </tr>
    <tr>
      <td><b>Estado Civil: </b>
        <?php
        foreach ($getNav4 as $n) {
          if ($getP18form2['p8'] == $n['id']) {
            echo utf8_encode($n['nome']);
          }
        }
        ?>
      </td>
      <td><b>Data Nascimento: </b><?=date('d/m/Y', strtotime($getP18form2['p9'])); ?></td>
      <td><b>UF/Cidade: </b>
        <?php
        $d  = $sql->getCidadeID($getP18form2['p7']);
        echo utf8_encode($d['nome']).' - '.$d['uf'].' - '.$d['sigla'];
        ?>
      </td>
    </tr>
    <tr>
      <th colspan="3">Filiação</th>
    </tr>
    <tr>
      <td colspan="2"><b>Pai: </b><?=$getP18form2['p10']; ?></td>
      <td><b>Mãe: </b><?=$getP18form2['p11']; ?></td>
    </tr>
    <tr>
      <th colspan="3">Dados Pessoais</th>
    </tr>
    <tr>
      <td><b>RG: </b><?=$getP18form2['p12']; ?>"</td>
      <td><b>Órgão Emissor: </b><?=$getP18form2['p13']; ?></td>
      <td><b>CPF: </b><?=$getP18form2['p14']; ?></td>
    </tr>
    <tr>
      <td><b>CNH Reg.: </b><?=$getP18form2['p15']; ?></td>
      <td><b>Categoria: </b><?=$getP18form2['p16']; ?></td>
      <td><b>Validade: </b><?=date('d/m/Y', strtotime($getP18form2['p17'])); ?></td>
    </tr>
    <tr>
      <th colspan="3">No Local do Evento</th>
    </tr>
    <tr>
      <td colspan="3"><b>Observações: </b><?=$getP18form2['p18']; ?></td>
    </tr>
    <tr>
      <td colspan="3"><b>Consulta de Cadastro para Gerenciamento de Riscos: </b>
        <?php
        if (!empty($getP18form2['p19'])) {
          echo 'Sim';
        } else {
          echo 'Não';
        }
        ?>
      </td>
    </tr>
    <tr>
      <td><b>Liberação Nr.: </b><?=$getP18form2['p19']; ?></td>
      <td colspan="2"><b>Empresa Responsável: </b><?=$getP18form2['p20']; ?></td>
    </tr>
  </table>
</div>
  <?php
}
?>
<?php
$getStatus = $sql->getStatus();
$getTercForm = $sql->getTercForm($num_processo);

if (!empty($getTercForm)) {
  ?>
<br>
<div style="width: 100%;">
  <table width="100%" border="1">
    <tr>
      <th colspan="3" style="background-color: #7AA6D0;">Terceiro (s)</th>
    </tr>
    <tr>
      <td><b>Envolvimento de Terceiro: </b>
        <?php
          foreach ($getStatus as $s) {
            if ($s['id'] == $getTercForm['terc_env']) {
              echo utf8_encode($s['status']);
            }
          }
          ?>
      </td>
      <td><b>Terceiro Culpado: </b>
        <?php
        foreach ($getStatus as $s) {
          if ($s['id'] == $getTercForm['terc_culp']) {
            echo utf8_encode($s['status']);
          }
        }
        ?>
      </td>
      <td><b>Passível de Ressarcimento: </b>
        <?php
        foreach ($getStatus as $s) {
          if ($s['id'] == $getTercForm['ressarc']) {
            echo utf8_encode($s['status']);
          }
        }
        ?>
      </td>
    </tr>
    <tr>
      <td><b>Declaração do Terceiro: </b>
        <?php
        foreach ($getStatus as $s) {
          if ($s['id'] == $getTercForm['dec_terc']) {
            echo utf8_encode($s['status']);
          }
        }
        ?>
      </td>
      <td><b>Dados do Terceiro: </b>
        <?php
        foreach ($getStatus as $s) {
          if ($s['id'] == $getTercForm['dados_terc']) {
            echo utf8_encode($s['status']);
          }
        }
        ?>
      </td>
      <td><b>Relatório Complementar anexo: </b>
        <?php
        foreach ($getStatus as $s) {
          if ($s['id'] == $getTercForm['rel_compl']) {
            echo utf8_encode($s['status']);
          }
        }
        ?>
      </td>
    </tr>
  </table>
</div>
  <?php
}

$getApPv = $sql->getApPv($num_processo);

if (!empty($getApPv)) {
?>
<br>
<div style="width: 100%;">
  <table width="100%" border="1">
    <tr>
      <th style="background-color: #7AA6D0;">Dos Fatos Apurados:</th>
    </tr>
    <tr>
      <td><?=$getApPv['apurados']; ?></td>
    </tr>
  </table>
</div>
<br>
<div style="width: 100%;">
  <table width="100%" border="1">
    <tr>
      <th style="background-color: #7AA6D0;">Das Providências:</th>
    </tr>
    <tr>
      <td><?=$getApPv['providencias']; ?></td>
    </tr>
  </table>
</div>
<?php
}











/*REPORTAGEM FOTOGRAFICA SOS*/

$getFTreposrtagem = $sql->getFTreposrtagem($num_processo);

if (!empty($getFTreposrtagem)) {
?>
<br>
<div style="width: 100%;">
  <table width="100%" border="1">
    <tr>
      <th style="background-color: #7AA6D0;">Reportagem Fotográfica ( S.O.S ):</th>
    </tr>
  </table>
  <table width="100%" border="1">
    <tr>
    <?php
    $x = 0;
    foreach ($getFTreposrtagem as $fts) {
      $arquivo = 'assets/img/fotos_reportagem/'.$fts['img'];

      $arq = $sql->redimencionarIMG($arquivo); 
      if (file_exists('assets/img/fotos_reportagem/miniaturas/'.$fts['img'])) {
        $mini = 'assets/img/fotos_reportagem/miniaturas/'.$fts['img'];
      } else {
        imagejpeg($arq['img_fim'], 'assets/img/fotos_reportagem/miniaturas/'.$fts['img']);
        $mini = 'assets/img/fotos_reportagem/miniaturas/'.$fts['img'];
      }

      $x++;
      if (($x % 2) != 0) {
        ?>
          <th width="50%">
            <img width="250" height="200" src="<?=$mini; ?>"><br>
            <?=$fts['texto']; ?>
          </th>
        <?php
      } else {
        ?>
          <th width="50%">
            <img width="250" height="200" src="<?=$mini; ?>"><br>
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
<?php
}

$getApPv = $sql->getDetVistoria($num_processo);

if (!empty($getApPv)) {
?>
<br>
<div style="width: 100%;">
  <table width="100%" border="1">
    <tr>
      <th style="background-color: #7AA6D0;">Detalhes da Vistoria:</th>
    </tr>
    <tr>
      <td><?=$getApPv['detalhes']; ?></td>
    </tr>
  </table>
</div>
<?php
}










/*Reportagem Fotográfica ( Vistoria )*/

$getFTvistoria = $sql->getFTvistoria($num_processo);

if (!empty($getFTvistoria)) {
?>
<br>
<div style="width: 100%;">
  <table width="100%" border="1">
    <tr>
      <th style="background-color: #7AA6D0;">Reportagem Fotográfica ( Vistoria ):</th>
    </tr>
  </table>
  <table width="100%" border="1">
    <tr>
    <?php
    $x = 0;
    foreach ($getFTvistoria as $fts) {
      $arquivo = 'assets/img/fotos_vistoria/'.$fts['img'];

      $arq = $sql->redimencionarIMG($arquivo); 
      if (file_exists('assets/img/fotos_vistoria/miniaturas/'.$fts['img'])) {
        $mini = 'assets/img/fotos_vistoria/miniaturas/'.$fts['img'];
      } else {
        imagejpeg($arq['img_fim'], 'assets/img/fotos_vistoria/miniaturas/'.$fts['img']);
        $mini = 'assets/img/fotos_vistoria/miniaturas/'.$fts['img'];
      }

      $x++;
      if (($x % 2) != 0) {
        ?>
          <th width="50%">
            <img width="250" height="200" src="<?=$mini; ?>"><br>
            <?=utf8_encode($fts['texto']); ?>
          </th>
        <?php
      } else {
        ?>
          <th width="50%">
            <img width="250" height="200" src="<?=$mini; ?>"><br>
            <?=utf8_encode($fts['texto']); ?>
          </th>
          </tr>
        <?php
        $x = 0;
      }
    }
  ?>
  </table>
</div>
<?php
}
















$getCidades = $sql->getCidades();
$nav_def_dest = $sql->nav_def_dest();
$nav_motivo_dec = $sql->nav_motivo_dec();
$getDestMerc = $sql->getDestMerc($num_processo);

if (!empty($getDestMerc)) {
?>

<br>
<div style="width: 100%;">
  <table width="100%" border="1">
    <tr>
      <th colspan="2" style="background-color: #7AA6D0;">Definição de Destino:</th>
    </tr>
    <tr>
      <td><b>Definição de Destino: </b>
        <?php
        foreach ($nav_def_dest as $a) {
          if ($getDestMerc['destino'] == $a['id']) {
            echo utf8_encode($a['nome']);
          }
        }
        ?>
      </td>
      <td><b>Motivo da decisão: </b>
        <?php
        foreach ($nav_motivo_dec as $a) {
          if ($getDestMerc['motivo'] == $a['id']) {
            echo utf8_encode($a['nome']);
          }
        }
        ?>
      </td>
    </tr>
    <tr>
      <td><b>Responsável pela decisão: </b><?=$getDestMerc['responsavel']; ?></td>
      <td><b>Representante: </b><?=$getDestMerc['representante']; ?></td>
    </tr>
    <tr>
      <td><b>Fone (s) de Contato: </b><?=$getDestMerc['contato']; ?></td>
      <td><b>E-mail / Contato: </b><?=$getDestMerc['email']; ?></td>
    </tr>
  </table>
</div>
<br>
<div style="width: 100%;">
  <table width="100%" border="1">
    <tr>
      <th colspan="3" style="background-color: #7AA6D0;">Destino da Mercadoria:</th>
    </tr>
    <tr>
      <td colspan="2"><b>Empresa: </b><?=$getDestMerc['empresa']; ?></td>
      <td><b>UF/Cidade: </b>
        <?php
        if (!empty($getDestMerc['cidade'])) {
          $d  = $sql->getCidadeID($getDestMerc['cidade']);
          echo utf8_encode($d['nome']).' - '.$d['uf'].' - '.$d['sigla'];
        }
        ?>
      </td>
    </tr>
    <tr>
      <td><b>Endereço: </b><?=$getDestMerc['endereco']; ?></td>
      <td><b>Bairro: </b><?=$getDestMerc['bairro']; ?></td>
      <td><b>CEP: </b><?=$getDestMerc['cep']; ?></td>
    </tr>
    <tr>
      <td colspan="2"><b>Responsável: </b><?=$getDestMerc['responsavel2']; ?></td>
      <td><b>Telefone(s): </b><?=$getDestMerc['fone']; ?></td>
    </tr>
  </table>
</div>
<?php
}

$getPrejCusto = $sql->getPrejCusto($num_processo);
$nav_esforco = $sql->getNavEsforco();
$getCusto = $sql->getCusto($num_processo);

if (!empty($getPrejCusto)) {
$total = 0;
$sub1 = $getPrejCusto['danos']+$getPrejCusto['dispersao']+$getPrejCusto['fsr'];
$total += $sub1;
?>
<br>
<div style="width: 100%;">
  <table width="100%" border="1">
    <tr>
      <th colspan="2" style="background-color: #7AA6D0;">Prejuízo Apurado:</th>
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
    <tr>
      <th colspan="2" style="background-color: #7AA6D0;">TOTAL R$<?=number_format($sub1, 2, ',', '.'); ?></th>
    </tr>
  </table>
</div>
<hr><br>
<div style="width: 100%;">
  <table width="100%" border="1">
    <tr>
      <th colspan="4" style="background-color: #7AA6D0;">Estimativa de Custo (SOS)</th>
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
      <th colspan="4" style="text-align: center;">TOTAL R$<?=number_format($sub2, 2, ',', '.'); ?></th>
    </tr>
  </table>
  <?php
  $total += $sub2;
  ?>
</div>
<?php
}

$getNavPassagemMot = $sql->getNavPassagemMot();
$getDiagrama = $sql->getDiagrama();
$getStatusConh = $sql->getStatusConhecimento();
$getTacografo = $sql->getStatusTacografo();

$getCausasSinistros = $sql->getCausasSinistros($num_processo);

if (!empty($getCausasSinistros)) {
?>
<br>
<div style="width: 100%;">
  <table width="100%" border="1">
    <tr>
      <th style="background-color: #7AA6D0;">Consequências e Causas do Sinistro</th>
    </tr>
    <tr>
      <td><b>Velocidade Permitida no Local: </b><?=$getCausasSinistros['vel_permitida']; ?></td>
    </tr>
    <tr>
      <td><b>Velocidade apurada no Evento: </b><?=$getCausasSinistros['vel_apurada']; ?></td>
    </tr>
    <tr>
      <td><b>Quantidade de Kms desde última parada: </b><?=$getCausasSinistros['qt_km']; ?></td>
    </tr>
    <tr>
      <td><b>Condutor conhece a rodovia e trecho no Local: </b>
        <?php
        foreach ($getStatusConh as $m) {
          if ($getCausasSinistros['id_status_conhecimento'] == $m['id']) {
            echo utf8_encode($m['nome']);
          }
        }
        ?>
      </td>
    </tr>
    <tr>
      <td><b>Frequência de passagem do motorista pelo local: </b>
        <?php
        foreach ($getNavPassagemMot as $m) {
          if ($getCausasSinistros['id_nav_passagem_mot'] == $m['id']) {
            echo utf8_encode($m['nome']);
          }
        }
        ?>
      </td>
    </tr>
    <tr>
      <td><b>Aparelho de Tacógrafo disponível no veículo: </b>
        <?php
        foreach ($getTacografo as $m) {
          if ($getCausasSinistros['id_status_torografia'] == $m['id']) {
            echo utf8_encode($m['nome']);
          }
        }
        ?>
      </td>
    </tr>
    <tr>
      <td><b>Registro Diagrama Disponível no atendimento: </b>
        <?php
        foreach ($getDiagrama as $m) {
          if ($getCausasSinistros['id_nav_diagrama'] == $m['id']) {
            echo utf8_encode($m['nome']);
          }
        }
        ?>
      </td>
    </tr>
    <tr>
      <td><b>Observações: </b><?=$getCausasSinistros['obs']; ?></td>
    </tr>
  </table>
</div>
<?php
}


$nav01 = $sql->nav_processo27_1();
$nav02 = $sql->nav_processo27_2();
$nav03 = $sql->nav_processo27_3();
$nav04 = $sql->nav_processo27_4();
$nav05 = $sql->nav_processo27_5();
$nav06 = $sql->nav_processo27_6();
$nav07 = $sql->nav_processo27_7();
$nav08 = $sql->nav_processo27_8();
$nav09 = $sql->nav_processo27_9();
$nav10 = $sql->nav_processo27_10();
$nav11 = $sql->nav_processo27_11();
$nav12 = $sql->nav_processo27_12();
$nav13 = $sql->nav_processo27_13();
$nav14 = $sql->nav_processo27_14();
$nav15 = $sql->nav_processo27_15();
$nav16 = $sql->nav_processo27_16();
$nav17 = $sql->nav_processo27_17();
$nav18 = $sql->nav_processo27_18();
$nav19 = $sql->nav_processo27_19();

$getDescLocal = $sql->processo_descricao_local($num_processo);

if (!empty($getDescLocal)) {
?>
<br>
<div style="width: 100%;">
  <table width="100%" border="1">
    <tr>
      <th colspan="2" style="background-color: #7AA6D0;">Descrição do Local:</th>
    </tr>
    <tr>
      <td><b>Faixas de Rolamento: </b>
        <?php 
        foreach ($nav01 as $n) {
          if ($getDescLocal['nav_processo27_1'] == $n['id']) {
            echo utf8_encode($n['nome']);
          }
        }
        ?>
      </td>
      <td><b>Status da Pista: </b>
        <?php 
        foreach ($nav08 as $n) {
          if ($getDescLocal['nav_processo27_8'] == $n['id']) {
            echo utf8_encode($n['nome']);
          }
        }
        ?>
      </td>
    </tr>
    <tr>
      <td><b>Faixa (s) Rolamento (Por Sentido): </b>
        <?php 
        foreach ($nav02 as $n) {
          if ($getDescLocal['nav_processo27_2'] == $n['id']) {
            echo utf8_encode($n['nome']);
          }
        }
        ?>
      </td>
      <td><b>Avaliação da Pista: </b>
        <?php 
        foreach ($nav09 as $n) {
          if ($getDescLocal['nav_processo27_9'] == $n['id']) {
            echo utf8_encode($n['nome']);
          }
        }
        ?>
      </td>
    </tr>
    <tr>
      <td><b>Pavimentação: </b>
        <?php 
        foreach ($nav03 as $n) {
          if ($getDescLocal['nav_processo27_3'] == $n['id']) {
            echo utf8_encode($n['nome']);
          }
        }
        ?>
      </td>
      <td><b>Acostamento: </b>
        <?php 
        foreach ($nav10 as $n) {
          if ($getDescLocal['nav_processo27_10'] == $n['id']) {
            echo utf8_encode($n['nome']);
          }
        }
        ?>
      </td>
    </tr>
    <tr>
      <td><b>Superfície da Pista: </b>
        <?php 
        foreach ($nav04 as $n) {
          if ($getDescLocal['nav_processo27_4'] == $n['id']) {
            echo utf8_encode($n['nome']);
          }
        }
        ?>
      </td>
      <td><b>Barreiras Lateral (Defensas Metálicas): </b>
        <?php 
        foreach ($nav11 as $n) {
          if ($getDescLocal['nav_processo27_11'] == $n['id']) {
            echo utf8_encode($n['nome']);
          }
        }
        ?>
      </td>
    </tr>
    <tr>
      <td><b>Edificações Rodoviárias: </b>
        <?php 
        foreach ($nav05 as $n) {
          if ($getDescLocal['nav_processo27_5'] == $n['id']) {
            echo utf8_encode($n['nome']);
          }
        }
        ?>
      </td>
      <td><b>Controles de Tráfego: </b>
        <?php 
        foreach ($nav12 as $n) {
          if ($getDescLocal['nav_processo27_12'] == $n['id']) {
            echo utf8_encode($n['nome']);
          }
        }
        ?>
      </td>
    </tr>
    <tr>
      <td><b>Sinalização Horizontal: </b>
        <?php 
        foreach ($nav06 as $n) {
          if ($getDescLocal['nav_processo27_6'] == $n['id']) {
            echo utf8_encode($n['nome']);
          }
        }
        ?>
      </td>
      <td><b>Sinalização Vertical: </b>
        <?php 
        foreach ($nav13 as $n) {
          if ($getDescLocal['nav_processo27_13'] == $n['id']) {
            echo utf8_encode($n['nome']);
          }
        }
        ?>
      </td>
    </tr>
    <tr>
      <td><b>Visibilidade no Local: </b>
        <?php 
        foreach ($nav07 as $n) {
          if ($getDescLocal['nav_processo27_7'] == $n['id']) {
            echo utf8_encode($n['nome']);
          }
        }
        ?>
      </td>
      <td><b>Tipo e Área: </b>
        <?php 
        foreach ($nav14 as $n) {
          if ($getDescLocal['nav_processo27_14'] == $n['id']) {
            echo utf8_encode($n['nome']);
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
      <th colspan="2" style="background-color: #7AA6D0;">Culpabilidade:</th>
    </tr>
    <tr>
      <td><b>Presumida: </b>
        <?php 
        foreach ($nav15 as $n) {
          if ($getDescLocal['nav_processo27_15'] == $n['id']) {
            echo utf8_encode($n['nome']);
          }
        }
        ?>
      </td>
      <td><b>Falha Humana: </b>
        <?php 
        foreach ($nav17 as $n) {
          if ($getDescLocal['nav_processo27_17'] == $n['id']) {
            echo utf8_encode($n['nome']);
          }
        }
        ?>
      </td>
    </tr>
    <tr>
      <td><b>Manobra Perigosa: </b>
        <?php 
        foreach ($nav16 as $n) {
          if ($getDescLocal['nav_processo27_16'] == $n['id']) {
            echo utf8_encode($n['nome']);
          }
        }
        ?>
      </td>
      <td><b>Incêndio: </b>
        <?php 
        foreach ($nav18 as $n) {
          if ($getDescLocal['nav_processo27_18'] == $n['id']) {
            echo utf8_encode($n['nome']);
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
      <th colspan="3" style="background-color: #7AA6D0;">Veículo</th>
    </tr>
    <tr>
      <td><b>Cavalo Mecânico: </b>
        <?php 
        foreach ($nav19 as $n) {
          if ($getDescLocal['nav_processo27_19'] == $n['id']) {
            echo utf8_encode($n['nome']);
          }
        }
        ?>
      </td> 
      <td><b>1º Semirreboque: </b>
        <?php 
        foreach ($nav19 as $n) {
          if ($getDescLocal['nav_processo27_20'] == $n['id']) {
            echo utf8_encode($n['nome']);
          }
        }
        ?>
      </td>
      <td><b>2º Semirreboque: </b>
        <?php 
        foreach ($nav19 as $n) {
          if ($getDescLocal['nav_processo27_21'] == $n['id']) {
            echo utf8_encode($n['nome']);
          }
        }
        ?>
      </td>
    </tr>
  </table>
</div>
<?php
}

$docs = $sql->processo_doc_anexos($num_processo);

if (!empty($docs)) {
?>
<br>
<div style="width: 100%;">
  <table width="100%" border="1">
    <tr>
      <th style="background-color: #7AA6D0;">Documentos Anexos / Digitalizados</th>
    </tr>
    <tr>
      <th style="background-color: #7AA6D0;">Mercadoria:</th>
    </tr>
    <tr>
      <td><?=$docs['mercadoria']; ?></td>
    </tr>
    <tr>
      <th style="background-color: #7AA6D0;">Transporte:</th>
    </tr>
    <tr>
      <td><?=$docs['transporte']; ?></td>
    </tr>
    <tr>
      <th style="background-color: #7AA6D0;">Condutor - Veículo Transportador:</th>
    </tr>
    <tr>
      <td><?=$docs['condutor']; ?></td>
    </tr>
    <tr>
      <th style="background-color: #7AA6D0;">Veiculo Transportador Sinistrado:</th>
    </tr>
    <tr>
      <td><?=$docs['veiculo_sinistrado']; ?></td>
    </tr>
    <tr>
      <th style="background-color: #7AA6D0;">Condutor - Veiculo transbordo:</th>
    </tr>
    <tr>
      <td><?=$docs['condutor_transbordo']; ?></td>
    </tr>
    <tr>
      <th style="background-color: #7AA6D0;">Veículo Transbordo:</th>
    </tr>
    <tr>
      <td><?=$docs['veiculo_transbordo']; ?></td>
    </tr>
    <tr>
      <th style="background-color: #7AA6D0;">Outros Documentos Emitidos/Reunidos pelo Vistoriador:</th>
    </tr>
    <tr>
      <td><?=$docs['outros']; ?></td>
    </tr>
  </table>
</div>
<?php
}
?>
</div>
</body>
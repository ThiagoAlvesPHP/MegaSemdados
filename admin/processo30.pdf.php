<?php 
require 'autoload.php'; 
$sql = new Processos();
$num_processo = addslashes($_GET['num_processo']);
$id_vistoria = addslashes($_GET['num_vistoria']);

//SEGURADORA, SINISTRO, APOLICE, RAMO, MODAL, VALOR MERCADORIA, VALOR EFEITO SEGURO
$p = $sql->getVistoriaCompleto($num_processo);
//CERTIFICADO DE VISTORIA
$cert = $sql->getCertificadoVistoriaID($id_vistoria);
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
$table = $sql->getManifesto($num_processo, $id_vistoria);

?>
<div style="width: 80%; margin: auto;">
<!-- INICIO -->
<div style="width: 100%; height: 50px; text-align: center; background-color: #00BFFF; font-size: 20px; border: solid 1px;">
  <strong>
    Certificado de Vistoria Nr.: <?=$cert['token']; ?><br>
    Processo Mega Nr.: <?=str_replace('/', '', $num_processo); ?>
    </strong>
</div>
<br>
<div style="width: 100%;">
  <table width="100%" border="1">
    <tr>
      <th>Seguradora:</th>
      <th>Nr. do Sinistro Cia:</th>
      <th>Apólice Nº:</th>
    </tr>
    <tr>
      <td><?=$p['razao_social']; ?></td>
      <td><?=$p['num_sinistro']; ?></td>
      <td><?=$p['num_apolice']; ?></td>
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
      <th>Valor da Mercadoria:</th>
      <th>Valor p/ Efeito de Seguro:</th>
      <th>Moeda:</th>
    </tr>
    <tr>
      <td>R$<?=number_format($p['valor_mercadoria'], 2, ',', '.'); ?></td>
      <td>R$<?=number_format($p['valor_mercadoria'], 2, ',', '.'); ?></td>
      <td><?=$p['md']; ?></td>
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
<br>
<div style="width: 100%;">
  <table width="100%" border="1">
    <tr>
      <th>Remetente</th>
      <th>Destinatário</th>
    </tr>
    <tr>
      <td><?=$rem['razao_social']; ?></td>
      <td><?=$dest['razao_social']; ?></td>
    </tr>
    <tr>
      <th>Seguro Próprio:</th>
      <th>Seguro Próprio:</th>
    </tr>
    <tr>
      <td><?php if ($rem['seguro_proprio'] == 0) { echo 'Não'; } else { echo 'Sim'; } ?></td>
      <td><?php if ($dest['seguro_proprio'] == 0) { echo 'Não'; } else { echo 'Sim'; } ?></td>
    </tr>
  </table>
</div>
<br>
<div style="width: 100%;">
  <table width="100%" border="1">
    <tr>
      <th colspan="2" style="background: #c0c0c0; font-family: verdana;">Percurso do Transporte</th>
    </tr>
    <tr>
      <th style="text-align: left;">UF/Município de Origem</th>
      <th style="text-align: left;">UF/Município de Destino</th>
    </tr>
    <tr>
      <td><?=$c1['nome'].' - '.$c1['uf'].' - '.$c1['sigla']; ?></td>
      <td><?=$c2['nome'].' - '.$c2['uf'].' - '.$c2['sigla']; ?></td>
    </tr>
  </table>
</div>
<br>
<div style="width: 100%;">
  <table width="100%" border="1">
    <tr>
      <th colspan="3" style="background: #c0c0c0; font-family: verdana;">Dados do Sinistro</th>
    </tr>
    <tr>
      <th style="text-align: left;">Atividade</th>
      <th style="text-align: left;">Atuação</th>
      <th style="text-align: left;">Natureza do Evento</th>
    </tr>
    <tr>
      <td><?=$atividade['atividade']; ?></td>
      <td><?=$atuacao['atuacao']; ?></td>
      <td><?=$a['nat_evento']; ?></td>
    </tr>
    <tr>
      <th style="text-align: left;">Município</th>
      <th style="text-align: left;">Data e Hora</th>
      <th style="text-align: left;">Local da Ocorrência Constatação</th>
    </tr>
    <tr>
      <td><?=$los['nome'].' - '.$los['uf'].' - '.$los['sigla']; ?></td>
      <td><?=date('d/m/Y H:i:s', strtotime($dbAc['dt_hs'])); ?></td>
      <td><?=$dbAc['local_os']; ?></td>
    </tr>
  </table>
</div>

<?php
$dn = $sql->getDanosMerc($num_processo);
$nav_mercadoria = $sql->getMercadoriasP();
$nav_embalagem = $sql->getEmbalagemP();
$nav_medida = $sql->getMedidaP();

if (!empty($dn)) {
?>
<br>
<div style="width: 100%;">
  <table width="100%" border="1">
    <tr>
      <th colspan="2" style="background: #c0c0c0; font-family: verdana;">Descrição da Mercadoria</th>
    </tr>
    <tr>
      <td colspan="2" style="text-align: left;"><b>Mercadoria: </b>
        <?php
        foreach ($nav_mercadoria as $value) {
          if ($value['id'] == $dn['id_tipo_merc']) {
            echo $value['nome'];
          }
        }
        echo ' - '.$dn['descricao'];
        ?>
      </td>
    </tr>
    <tr>
      <td colspan="2" style="text-align: left;"><b>Tipo Embalagem: </b>
        <?php
        foreach ($nav_embalagem as $value) {
          if ($value['id'] == $dn['id_tipo_emb1']) {
            echo $value['embalagem'];
          }
        }
        foreach ($nav_embalagem as $value) {
          if ($value['id'] == $dn['id_tipo_emb2']) {
            echo ' - '.$value['embalagem'];
          }
        }
        ?>
      </td>
    </tr>
  </table>
</div>
<?php
}
$dadosVistoria = $sql->getCertificadoVistoriaID($id_vistoria);
$getMedidaP = $sql->getMedidaP();
$getNavFrete = $sql->getNavFrete();

if (!empty($table) && !empty($dadosVistoria)) {
?>
<div style="width: 100%;">
  <table width="100%" border="1">
    <tr>
      <th style="text-align: left;">Quantidades</th>
      <th style="text-align: left;">Volumes</th>
      <th style="text-align: left;">Unid. Medida</th>
      <th style="text-align: left;">Peso</th>
      <th style="text-align: left;">Frete</th>
    </tr>
    <tr>
      <td>Embarcados</td>
      <td><?=$dadosVistoria['volume1']; ?></td>
      <td>
        <?php
        foreach ($getMedidaP as $m) {
          if ($dadosVistoria['id_uni_medida1'] == $m['id']) {
            echo $m['nome'];
          }
        }
        ?>
      </td>
      <td><?=$dadosVistoria['peso1']; ?></td>
      <td>
        <?php 
        foreach ($getNavFrete as $f) {
          foreach ($table as $value) {
            if ($value['m13'] == $f['id']) {
              echo $f['frete'];
            }
          }
        }
        ?>
      </td>
    </tr>
    <tr>
      <td>Selecionados</td>
      <td><?=$dadosVistoria['volume2']; ?></td>
      <td>
        <?php
        foreach ($getMedidaP as $m) {
          if ($dadosVistoria['id_uni_medida2'] == $m['id']) {
            echo $m['nome'];
          }
        }
        ?>
      </td>
      <td><?=$dadosVistoria['peso2']; ?></td>
      <td></td>
    </tr>
    
    <tr>
      <th style="text-align: left;">Risco/Danos Ambientais:</th>
      <td colspan="4">
        <?php  
        if (!empty($dadosVistoria['risco'])) {
          if($dadosVistoria['risco'] == 1){
          ?>
          Sim
          <?php
          } else {
          ?>
          Não
          <?php
          }
        } else {
        ?>
          Não Informado
        <?php
        }
        ?>
      </td>
    </tr>
  </table>
</div>
<?php
}

$status_merc = $sql->getStatusMerP();
$status_emb = $sql->getStatusEmbP();

if (!empty($dn)) {
?>
<br>
<div style="width: 100%;">
  <table width="100%" border="1">
    <tr>
      <th colspan="2" style="background: #c0c0c0; font-family: verdana;">Danos Constatados</th>
    </tr>
    <tr>
      <td colspan="2"><b>Mercadoria: </b>
        <?php
        foreach ($status_merc as $value) {
          if ($value['id'] == $dn['id_status_merc1'] OR $value['id'] == $dn['id_status_merc2'] OR $value['id'] == $dn['id_status_merc3'] OR $value['id'] == $dn['id_status_merc4']) {
            echo $value['status'].', ';
          }
        }
        ?>
      </td>
    </tr>
    <tr>
      <td colspan="2"><b>Embalagem: </b>
        <?php
        foreach ($status_emb as $value) {
          if ($value['id'] == $dn['id_status_emb1'] OR $value['id'] == $dn['id_status_emb2'] OR $value['id'] == $dn['id_status_emb3'] OR $value['id'] == $dn['id_status_emb4']) {
            echo $value['status'].', ';
          }
        }
        ?>
      </td>
    </tr>
  </table>
</div>
<?php
}

if (!empty($dadosVistoria)) {
?>
<br>
<div style="width: 100%;">
  <table width="100%" border="1">
    <tr>
      <th style="background: #c0c0c0; font-family: verdana;">Apuração de Prejuizo</th>
    </tr>
    <tr>
      <td><?=$dadosVistoria['prejuizo']; ?></td>
    </tr>
  </table>
</div>
<br>
<div style="width: 100%;">
  <table width="100%" border="1">
    <tr>
      <th style="background: #c0c0c0; font-family: verdana;">Salvados</th>
    </tr>
    <tr>
      <td><?=$dadosVistoria['salvado']; ?></td>
    </tr>
  </table>
</div>
<br>
<div style="width: 100%;">
  <table width="100%" border="1">
    <tr>
      <th style="background: #c0c0c0; font-family: verdana;">Documentos Anexos</th>
    </tr>
    <tr>
      <td><?=$dadosVistoria['anexos']; ?></td>
    </tr>
  </table>
</div>




<?php
}









if (!empty($table)) {
$getNFe = $sql->getManifestoNFe($num_processo, $id_vistoria);
$tPrej = 0;
$tNFe = 0;
?>
<!-- <br><br>
<div style="width: 100%;">
  <table width="100%" border="1">
    <tr>
      <th colspan="4" style="background: #c0c0c0; font-family: verdana;">RESUMO DO PREJUÍZO</th>
    </tr>
    <tr>
      <th style="text-align: left;">CTEs/NFEs</th>
      <th style="text-align: left;">Qtd</th>
      <th style="text-align: left;">Total NFEs</th>
      <th style="text-align: left;">Total Prej.</th>
    </tr>
    <?php 
    foreach ($table as $m) {
      $CountNotas = $sql->CountNotas($m['id']);
    ?>
    <tr>
      <td><strong><?=$m['m3']; ?></strong> /<?=$m['m5']; ?></td>
      <td><?php 
      foreach ($CountNotas as $v) {
        if ($v['id_manifesto'] == $m['id']) {
            echo $v['c'];
        }
      }
      ?></td>
      <?php
      foreach ($table as $value) {
        $tNFe += $value['m7'];
      }
      ?>
      <td>R$<?=number_format($tNFe, 2, ',', '.'); ?></td>
      <?php
      foreach ($getNFe as $value) {
        $tPrej += $value['total'];
      }
      ?>
      <td>R$<?=number_format($tPrej, 2, ',', '.'); ?></td>
    </tr>
    <?php
    }
    ?>
    
  </table>
</div> -->
<?php
}
?>


<br><br>

    <?php 
    if (!empty($table)) {
      foreach($table as $value){
    ?>
    <div style="width: 100%;">
      <table width="100%" border="1">
        <tr>
          <th style="background: #c0c0c0; font-family: verdana;">DETALHAMENTO DO PREJUÍZO</th>
        </tr>
      </table>
    </div>

    <div style="width: 100%;">
      <table width="100%" border="1">
        <tr>
          <td><b>MANIFESTO: </b><?=$value['m1']; ?></td>
          <td><b>DATA EMISSÃO: </b><?=date('d/m/Y', strtotime($value['m2'])); ?></td>
          <td><b>DACTE: </b><?=$value['m3']; ?></td>
          <td><b>DATA EMISSÃO: </b><?=date('d/m/Y', strtotime($value['m4'])); ?></td>
        </tr>
      </table>
    </div>

    <div style="width: 100%;">
      <table width="100%" border="1">
        <tr>
          <td><b>NOTA FISCAL: </b><?=$value['m5']; ?></td>
          <td><b>DATA EMISSÃO: </b><?=date('d/m/Y', strtotime($value['m6'])); ?></td>
          <td><b>VALOR TOTAL: </b>R$<?=number_format($value['m7'], 2, ',', '.'); ?></td>
        </tr>
      </table>
    </div>

    <div style="width: 100%;">
      <table width="100%" border="1">
        <tr>
          <th style="text-align: left;">VENC. NF.</th>
          <th style="text-align: left;">VALOR PARC.</th>
        </tr>

        <?php if (!empty($value['m15']) && !empty($value['m16'])): ?>
        <tr>
          <td><?=date('d/m/Y', strtotime($value['m15'])); ?></td>
          <td>R$<?=number_format($value['m16'], 2, ',', '.'); ?></td>
        </tr>
        <?php endif; ?>

        <?php if (!empty($value['m17']) && !empty($value['m18'])): ?>
        <tr>
          <td><?=date('d/m/Y', strtotime($value['m17'])); ?></td>
          <td>R$<?=number_format($value['m18'], 2, ',', '.'); ?></td>
        </tr>
        <?php endif; ?>

        <?php if (!empty($value['m19']) && !empty($value['m20'])): ?>
        <tr>
          <td><?=date('d/m/Y', strtotime($value['m19'])); ?></td>
          <td>R$<?=number_format($value['m20'], 2, ',', '.'); ?></td>
        </tr>
        <?php endif; ?>

        <?php if (!empty($value['m21']) && !empty($value['m22'])): ?>
        <tr>
          <td><?=date('d/m/Y', strtotime($value['m21'])); ?></td>
          <td>R$<?=number_format($value['m22'], 2, ',', '.'); ?></td>
        </tr>
        <?php endif; ?>

        <?php if (!empty($value['m23']) && !empty($value['m24'])): ?>
        <tr>
          <td><?=date('d/m/Y', strtotime($value['m23'])); ?></td>
          <td>R$<?=number_format($value['m24'], 2, ',', '.'); ?></td>
        </tr>
        <?php endif; ?>

        </table>
      </div>

      <div style="width: 100%;">
        <table width="100%" border="1">
        <tr>
          <td><b>REMETENTE: </b><?=$value['m8']; ?></td>
          <td><b>DESTINATARIO: </b><?=$value['m9']; ?></td>
        </tr>
        </table>
      </div>

      <div style="width: 100%;">
        <table width="100%" border="1">
          <tr>
            <th style="text-align: left;">TIPO DE MERCADORIA</th>
            <th style="text-align: left;">VOL. EMBARCADOS</th>
            <th style="text-align: left;">FRETE</th>
            <th style="text-align: left;">VOL. SELECIONADOS</th>
            <th style="text-align: left;">TIPO DE PREJUÍZO</th>
          </tr>
          <tr>
            <td><?=$value['tipo_mercadoria']; ?></td>
            <td><?=$value['m11']; ?></td>
            <td>
              <?php 
              foreach ($getNavFrete as $f) {
                if ($value['m13'] == $f['id']) {
                  echo $f['frete'];
                }
              }
              ?>
            </td>
            <td><?=$value['m12']; ?></td>
            <td><?=$value['prej']; ?></td>
          </tr>
        </table>
      </div>

      <div style="width: 100%;">
        <table width="100%" border="1">
          <tr>
            <th style="text-align: left;">MERCADORIA</th>
            <th style="text-align: left;">QTD.</th>
            <th style="text-align: left;">PESO</th>
            <th style="text-align: left;">VALOR UNIT.</th>
            <th style="text-align: left;">ICMS ST %</th>
            <th style="text-align: left;">IPI %</th>
            <th style="text-align: left;">SUB TOTAL</th>
            <th style="text-align: left;">APROV. SALVADOS</th>
            <th style="text-align: left;">VALOR TOTAL DO PREJUIZO</th>
          </tr>
          <?php
          $tot = 0;
          $valor = 0;
          if (!empty($getNFe)) {
            foreach ($getNFe as $v) {
              $tot += $v['total'];
              if ($value['id'] == $v['id_manifesto']) {
                $valor += $v['total'];
                ?>
                <tr>
                  <td><?=$v['descricao']; ?></td>
                  <td><?=$v['qt']; ?></td>
                  <td><?=$v['peso']; ?></td>
                  <td>R$<?=number_format($v['valor_uni'], 2, ',', '.'); ?></td>
                  <td><?=$v['icms']; ?></td>
                  <td><?=$v['ipi']; ?></td>
                  <td><?php
                  $valor_prej = $v['qt']*$v['valor_uni'];
                  $tx1 = $valor_prej/100 * $v['icms'];
                  $tx2 = $valor_prej/100 * $v['ipi'];

                  $subtotal = $valor_prej+$tx1+$tx2;
                  echo 'R$'.number_format($subtotal, 2, ',', '.');
                  ?></td>
                  <td>R$<?=number_format($v['valor_desc'], 2, ',', '.'); ?></td>
                  <td>R$<?=number_format($v['total'], 2, ',', '.'); ?></td>
                </tr>
                <?php
              }
            }
          }
          ?>
        </table>
      </div>

      <div style="width: 100%;">
        <table width="100%" border="1">
          <tr>
            <th>PREJUÍZO TOTAL: R$<?=number_format($valor, 2, '.', ','); ?></th>
          </tr>
        </table>
      </div>
      <br><br>
      <?php
      }
    }
    ?>

<br>
<div style="width: 100%; background: #00BFFF;">
  <table width="100%" border="1">
    <tr>
      <th style="font-size: 20px;">Prejuízo Apurado: R$ <?=number_format($tot, 2, ',', '.'); ?></th>
    </tr>
  </table>
</div>
<br>
A emissão do presente Certificado de Vistoria, não importa por parte da CIA Seguradora em qualquer reconhecimento de direito do Segurado a qualquer indenização, pois este depende das condições da apólice.
</div>
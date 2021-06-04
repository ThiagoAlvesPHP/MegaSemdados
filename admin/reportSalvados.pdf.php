<?php 
require 'autoload.php';
$sql = new Processos();
$num_processo = addslashes($_GET['num_processo']);
$p = $sql->getProcesso($num_processo);
//CAPTURANDO FOTOS PRELIMINARES REGISTRADAS
$ft = $sql->getFTSalvados($num_processo);
?>
<div style="width: 80%; margin: auto;">
<!-- INICIO -->
<div style="width: 100%; height: 50px; text-align: center; font-size: 20px; border: solid 1px;">
    <strong>
    FOTOS DE SALVADOS DO SINISTRO DE TRANSPORTE<br>
    Processo Mega Nr.: <?=str_replace('/', '', $num_processo); ?>
    </strong>
</div>
<br>
<div style="width: 100%; text-align: center; font-size: 14px; background: #c0c0c0; border: solid 1px;">
    <strong>
    FOTOS DE SALVADOS DO SINISTRO DE TRANSPORTE
    </strong>
</div>
<hr>
<div style="width: 100%;">

  <table width="100%" border="1">
    <tr>
    <?php
    $x = 0;
    foreach ($ft as $fts) {
      $arquivo = 'assets/img/fotos_salvados/'.$fts['img'];

      $arq = $sql->redimencionarIMG($arquivo); 
      if (file_exists('assets/img/fotos_salvados/miniaturas/'.$fts['img'])) {
        $mini = 'assets/img/fotos_salvados/miniaturas/'.$fts['img'];
      } else {
        imagejpeg($arq['img_fim'], 'assets/img/fotos_salvados/miniaturas/'.$fts['img']);
        $mini = 'assets/img/fotos_salvados/miniaturas/'.$fts['img'];
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
</div>
<?php
if (isset($_GET['num_vistoria'])) {
	$manV = $sql->getManifestoIDmanifesto($m['id']);
	?>
<div id="<?=$m['id']; ?>" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Editar Manifesto</h4>
      </div>
      <div class="modal-body">
        <p>
        	<form method="POST">
        		<div class="row">
        			<div class="col-sm-3">
        				<label>Manifesto Nº</label>
        				<input type="text" value="<?=$m['m1']; ?>" name="m1UP" class="form-control">
        			</div>
        			<div class="col-sm-3">
        				<label>Emissão:</label>
        				<input type="date" value="<?=$m['m2']; ?>" name="m2UP" class="form-control">
        			</div>
        			<div class="col-sm-3">
        				<label>CTe Nº</label>
        				<input type="text" value="<?=$m['m3']; ?>" name="m3UP" class="form-control">
        			</div>
        			<div class="col-sm-3">
        				<label>Emissão:</label>
        				<input type="date" value="<?=$m['m4']; ?>" name="m4UP" class="form-control">
        			</div>
        		</div>
        		<br>
        		<div class="row">
        			<div class="col-sm-3">
        				<label>NFe Nº</label>
        				<input type="text" value="<?=$m['m5']; ?>" name="m5UP" class="form-control">
        			</div>
        			<div class="col-sm-3">
        				<label>Emissão:</label>
        				<input type="date" value="<?=$m['m6']; ?>" name="m6UP" class="form-control">
        			</div>
        			<div class="col-sm-3">
        				<label>Valor:</label>
        				<input type="text" value="<?=number_format($m['m7'], 2, '.', ''); ?>" name="m7UP" class="form-control money3">
        			</div>
                    <div class="col-sm-3">
                        <label>Tipo de Mercadoria:</label>
                        <input type="text" name="tipo_mercadoriaUP" value="<?=$m['tipo_mercadoria']; ?>" class="form-control">
                    </div>
        		</div>
        		<br>
        		<div class="row">
        			<div class="col-sm-4">
        				<label>Remetente:</label>
        				<input type="text" value="<?=$m['m8']; ?>" name="m8UP" class="form-control">
        			</div>
        			<div class="col-sm-4">
        				<label>Destinatário:</label>
        				<input type="text" value="<?=$m['m9']; ?>" name="m9UP" class="form-control">
        			</div>
        			<div class="col-sm-4">
        				<label>Mercadoria:</label>
        				<input type="text" value="<?=$m['m10']; ?>" name="m10UP" class="form-control">
        			</div>
        		</div>
        		<br>
        		<div class="row">
        			<div class="col-sm-6">
        				<label>Qtd. Volume:</label>
        				<input type="text" value="<?=$m['m11']; ?>" name="m11UP" class="form-control">
        			</div>
        			<div class="col-sm-6">
        				<label>Qtd. Vol. Resgatado:</label>
        				<input type="text" value="<?=$m['m12']; ?>" name="m12UP" class="form-control">
        			</div>
        		</div>
        		<br>
        		<div class="row">
        			<div class="col-sm-6">
        				<label>Frete:</label>
        				<select name="m13UP" class="form-control">
        					<?php 
        					foreach ($getNavFrete as $f) {
        						if ($m['m13'] == $f['id']) {
        							echo '<option selected value="'.$f['id'].'">'.$f['frete'].'</option>';
        						} else {
        							echo '<option value="'.$f['id'].'">'.$f['frete'].'</option>';
        						}
        					}
        					?>
        				</select>
        			</div>
        			<div class="col-sm-6">
        				<label>Tipo de Prejuízo:</label>
        				<select name="m14UP" class="form-control">
        					<?php 
        					foreach ($getNavPrejuizo as $f) {
        						if ($m['m14'] == $f['id']) {
        							echo '<option selected value="'.$f['id'].'">'.utf8_encode($f['nome']).'</option>';
        						} else {
        							echo '<option value="'.$f['id'].'">'.utf8_encode($f['nome']).'</option>';
        						}
        					}
        					?>
        				</select>
        			</div>
        		</div>
        		<br>
        		<div class="row">
        			<div class="col-sm-6">
        				<label>Valor do Prejuízo:</label>
        				<input type="text" value="<?=number_format($manV['t'], 2, ',', '.'); ?>" class="form-control" readonly="">
        			</div>
        			<div class="col-sm-6">
        				<label>Valor Remanescente do Prejuízo:</label>
        				<input type="text" value="<?=number_format($m['m7']-$manV['t'], 2, ',', '.'); ?>" class="form-control" readonly="">
        			</div>
        		</div>
        		<br>
        		<div class="row">
        			<div class="col-sm-3">
        				<label>DT. Venc. 1:</label>
        				<input type="date" value="<?=$m['m15']; ?>" name="m15UP" class="form-control">
        			</div>
        			<div class="col-sm-3">
        				<label>VL. Venc. 1:</label>
        				<input type="text" value="<?=$m['m16']; ?>" name="m16UP" class="form-control money">
        			</div>
        			<div class="col-sm-3">
        				<label>DT. Venc. 2:</label>
        				<input type="date" value="<?=$m['m17']; ?>" name="m17UP" class="form-control">
        			</div>
        			<div class="col-sm-3">
        				<label>VL. Venc. 2:</label>
        				<input type="text" value="<?=$m['m18']; ?>" name="m18UP" class="form-control money">
        			</div>
        		</div>
        		<br>
        		<div class="row">
        			<div class="col-sm-3">
        				<label>DT. Venc. 3:</label>
        				<input type="date" value="<?=$m['m19']; ?>" name="m19UP" class="form-control">
        			</div>
        			<div class="col-sm-3">
        				<label>VL. Venc. 3:</label>
        				<input type="text" value="<?=$m['m20']; ?>" name="m20UP" class="form-control money">
        			</div>
        			<div class="col-sm-3">
        				<label>DT. Venc. 4:</label>
        				<input type="date" value="<?=$m['m21']; ?>" name="m21UP" class="form-control">
        			</div>
        			<div class="col-sm-3">
        				<label>VL. Venc. 4:</label>
        				<input type="text" value="<?=$m['m22']; ?>" name="m22UP" class="form-control money">
        			</div>
        		</div>
        		<br>
        		<div class="row">
        			<div class="col-sm-6">
        				<label>DT. Venc. 5:</label>
        				<input type="date" value="<?=$m['m23']; ?>" name="m23UP" class="form-control">
        			</div>
        			<div class="col-sm-6">
        				<label>VL. Venc. 5:</label>
        				<input type="text" value="<?=$m['m24']; ?>" name="m24UP" class="form-control money">
        			</div>
        		</div>
        		<input type="text" name="idUP" hidden="" value="<?=$m['id']; ?>">
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
        <button class="btn btn-primary">Salvar</button>
        </form>
      </div>
    </div>
  </div>
</div>
	<?php
}
?>

<?php if (isset($_GET['manifesto'])): $getNFeID = $sql->getNFeID($n['id']); ?>

<div id="<?=$n['id']; ?>" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Editar NFe</h4>
      </div>
      <div class="modal-body">
        <?php
        $valor_prej = 0;
        $valor_prej = $getNFeID['qt']*$getNFeID['valor_uni'];
        $tx1 = $valor_prej/100 * $getNFeID['icms'];
        $tx2 = $valor_prej/100 * $getNFeID['ipi'];
        $valor_prej += $tx1 + $tx2 - $getNFeID['valor_desc'];
        ?>
        <p>
        <form method="POST">
            <label>Descrição da Mercadoria:</label>
                <input type="text" value="<?=$getNFeID['descricao']; ?>" name="descricaoUP" class="form-control">
                <div class="row">
                    <div class="col-sm-6">
                        <label>Quantidade:</label>
                        <input type="text" value="<?=$getNFeID['qt']; ?>" id="qtUP" name="qtUP" class="form-control">
                    </div>
                    <div class="col-sm-6">
                        <label>Peso:</label>
                        <input type="text" value="<?=$getNFeID['peso']; ?>" name="pesoUP" class="form-control money">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <label>Valor Unitário:</label>
                        <input type="text" value="<?=$getNFeID['valor_uni']; ?>" id="valor_uniUP" name="valor_uniUP" class="form-control money4">
                    </div>
                    <div class="col-sm-6">
                        <label>Unidade de Medida:</label>
                        <select name="id_unidadeUP" class="form-control">
                            <?php
                            foreach ($uni as $u) {
                                if ($getNFeID['id_unidade'] == $u['id']) {
                                    echo '<option selected value="'.$u['id'].'">'.utf8_encode($u['nome']).'</option>';
                                } else {
                                    echo '<option value="'.$u['id'].'">'.utf8_encode($u['nome']).'</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <label>ICSM ST.:</label>
                        <input type="text" value="<?=$getNFeID['icms']; ?>" id="icmsUP" name="icmsUP" class="form-control taxas">
                    </div>
                    <div class="col-sm-3">
                        <label>IPI:</label>
                        <input type="text" value="<?=$getNFeID['ipi']; ?>" id="ipiUP" name="ipiUP" class="form-control taxas">
                    </div>
                    <div class="col-sm-3">
                        <label>Valor Desconto:</label>
                        <input type="text" value="<?=number_format($getNFeID['valor_desc'], 2, '.', ''); ?>" id="valor_descUP" name="valor_descUP" class="form-control money3">
                    </div>
                    <div class="col-sm-3">
                        <label>Valor Prejuízo:</label>
                        <input type="text" readonly="" value="<?=number_format($valor_prej, 2, ',', '.'); ?>" id="totalUP" class="form-control money">
                    </div>
                </div>
                <input type="text" name="idUP" hidden="" value="<?=$getNFeID['id']; ?>">
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
        <button class="btn btn-primary">Salvar</button>
        </form>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>
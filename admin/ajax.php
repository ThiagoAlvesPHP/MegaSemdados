<?php
require 'autoload.php';
$sql = new Ajax();

//DEFINIR HORARIO O DIA
if (isset($_POST['value']) && $_POST['value'] == true) {
    $array = array(
        'hora'=>date('H'),
        'minutos'=>date('i'),
        'segundos'=>date('s')
    );

    echo json_encode($array);
}

//BUSCAR MOTORITA
if (isset($_POST['motorista'])) {
    header("Content-type:application/json");
    echo json_encode($sql->getMotorista($_POST['motorista'], $_POST['id_ramo']));
}

//DENIFIR QUEM PODE VISUALIZAR MEUS ARQUIVOS docs.php
if (!empty($_POST['id_doc']) && !empty($_POST['id_func'])) {
    $id_doc = addslashes($_POST['id_doc']);
    $id_para = addslashes($_POST['id_func']);
    
    $sql->setVisDoc($id_doc, $id_para);
}
if (!empty($_POST['id_docDel']) && !empty($_POST['id_funcDel'])) {
    $id_doc = addslashes($_POST['id_docDel']);
    $id_para = addslashes($_POST['id_funcDel']);
    
    $sql->delVisDoc($id_doc, $id_para);
}

//CONSULTA PAGINA pessoaPJGrid.php
if (!empty($_POST['seachPJ'])) {
	$razao_social = addslashes($_POST['seachPJ']);
	$j = $sql->getPJuridicaRS($razao_social);
	
	header("Content-type:application/json");
	echo json_encode($j);
}
//CONSULTA PAGINA pessoaPJGrid.php
if (!empty($_POST['seachPF'])) {
	$seachPF = addslashes($_POST['seachPF']);
	$pf = $sql->getPFisicaAj($seachPF);
	
	header("Content-type:application/json");
	echo json_encode($pf);
}

/*CONSULTA DE APOLICE*/
if(!empty($_POST['seachAp'])){
	$seachAp = addslashes($_POST['seachAp']);

	$apolice = $sql->getApolice($seachAp);
	
	header("Content-type:application/json");
	echo json_encode($apolice);
}

//CONSULTA PAGINA PROCESSO02.PHP
if (!empty($_POST['id_empresa'])) {
	$id = addslashes($_POST['id_empresa']);
	$j = $sql->getApolicID($id);
	
	echo json_encode($j);
}

//CONSULTA PAGINA PROCESSO03.PHP
if (!empty($_POST['id_transportadora'])) {
	$id = addslashes($_POST['id_transportadora']);
	$j = $sql->getTranspID($id);
	
	echo json_encode($j);
}

//CONSULTA PAGINA PROCESSO04.PHP
if (!empty($_POST['id_corretora'])) {
	$id = addslashes($_POST['id_corretora']);
	$j = $sql->getCorretoraID($id);
	
	echo json_encode($j);
}

//CONSULTA PAGINA PROCESSO05.PHP
if (!empty($_POST['city1'])) {
	$city1 = addslashes($_POST['city1']);
	$j = $sql->getCidade($city1);

	header("Content-type:application/json");
	echo json_encode($j);
}

if (!empty($_POST['city2'])) {
	$city2 = addslashes($_POST['city2']);
	$j = $sql->getCidade($city2);

	header("Content-type:application/json");
	echo json_encode($j);
}

if (!empty($_POST['city3'])) {
	$city2 = addslashes($_POST['city3']);
	$j = $sql->getCidade($city2);
	
	header("Content-type:application/json");
	echo json_encode($j);
}
if (!empty($_POST['city4'])) {
	$city2 = addslashes($_POST['city4']);
	$j = $sql->getCidade($city2);
	
	header("Content-type:application/json");
	echo json_encode($j);
}

if (!empty($_POST['txt'])) {
	$texto = addslashes($_POST['txt']);
	$id = addslashes($_POST['id']);

	$sql->setTextoImgPreliminar($id, $texto);
}

if (!empty($_POST['txtP21'])) {
	$texto = addslashes($_POST['txtP21']);
	$id = addslashes($_POST['id']);

	$sql->setTextoReportFT($id, $texto);
}

if (!empty($_POST['txtftSin'])) {
	$texto = addslashes($_POST['txtftSin']);
	$id = addslashes($_POST['id']);

	$sql->setTextoFtSinin($id, $texto);
}

if (!empty($_POST['txtftSal'])) {
	$texto = addslashes($_POST['txtftSal']);
	$id = addslashes($_POST['id']);

	$sql->setTextoFtSal($id, $texto);
}

if (!empty($_POST['txtVist'])) {
	$texto = addslashes($_POST['txtVist']);
	$id = addslashes($_POST['id']);

	$sql->setTextoVist($id, $texto);
}

if (!empty($_POST['mes'])):

	?>
	<div class="table table-responsive">
        <table class="table table-hover" id="resultado">
            <tr>
            <?php
            $x = 0;
            $numero = cal_days_in_month(CAL_GREGORIAN, $_POST['mes'], date('Y'));

            for ($i=1; $i <= $numero; $i++) { 
                $x++;

                $id = 'ag'.$i;
                $v['data'] = date('Y-'.$_POST['mes'].'-'.$i);

                $lem = (new Agenda())->getAgendasData($v['data']);

                if (date('l', strtotime($v['data'])) == 'Monday') {
                    $dia = 'Segunda-Feira';
                }
                elseif (date('l', strtotime($v['data'])) == 'Tuesday') {
                    $dia = 'Terça-Feira';
                }
                elseif (date('l', strtotime($v['data'])) == 'Wednesday') {
                    $dia = 'Quarta-Feira';
                }
                elseif (date('l', strtotime($v['data'])) == 'Thursday') {
                    $dia = 'Quinta-Feira';
                }
                elseif (date('l', strtotime($v['data'])) == 'Friday') {
                    $dia = 'Sexta-Feira';
                }
                elseif (date('l', strtotime($v['data'])) == 'Saturday') {
                    $dia = 'Sábado';
                }
                elseif (date('l', strtotime($v['data'])) == 'Sunday') {
                    $dia = 'Domingo';
                }

                if (($x % 7) != 0) {  
                    echo '<td>';
                    //SE ESTIVER PREENCHIDO
                    if (!empty($lem)) {
                        $data = date('Y-m-d', strtotime($v['data']));

                        if ($data >= date('Y-'.$_POST['mes'].'-d')) {
                            if ($data == date('Y-'.$_POST['mes'].'-d')) {
                                if ($dia == 'Sábado') {
                                    echo '<button title="'.$dia.'" data-toggle="modal" data-target="#'.$id.'" class="btn btn-success btn-block send">'.$i.'<br>'.substr($dia, 0, 4).'</button>';
                                } else {
                                    echo '<button title="'.$dia.'" data-toggle="modal" data-target="#'.$id.'" class="btn btn-success btn-block send">'.$i.'<br>'.substr($dia, 0, 3).'</button>';
                                }
                                
                            } else {
                                if ($dia == 'Sábado') {
                                    echo '<button title="'.$dia.'" data-toggle="modal" data-target="#'.$id.'" class="btn btn-primary btn-block">'.$i.'<br>'.substr($dia, 0, 4).'</button>';
                                } else {
                                    echo '<button title="'.$dia.'" data-toggle="modal" data-target="#'.$id.'" class="btn btn-primary btn-block">'.$i.'<br>'.substr($dia, 0, 3).'</button>';
                                }
                                
                            }
                        } else {
                            if ($dia == 'Sábado') {
                                echo '<button title="'.$dia.'" data-toggle="modal" data-target="#'.$id.'" class="btn btn-danger btn-block">'.$i.'<br>'.substr($dia, 0, 4).'</button>';
                            } else {
                                echo '<button title="'.$dia.'" data-toggle="modal" data-target="#'.$id.'" class="btn btn-danger btn-block">'.$i.'<br>'.substr($dia, 0, 3).'</button>';
                            }
                            
                        }
                    } else {
                        if ($dia == 'Sábado') {
                            echo '<button title="'.$dia.'" data-toggle="modal" data-target="#'.$id.'" class="btn btn-default btn-block">'.$i.'<br>'.substr($dia, 0, 4).'</button>';
                        } else {
                            echo '<button title="'.$dia.'" data-toggle="modal" data-target="#'.$id.'" class="btn btn-default btn-block">'.$i.'<br>'.substr($dia, 0, 3).'</button>';
                        }
                        
                    }

                    ?>
                <!-- MODAL PARA LEMBRETE -->
                <div id="<?=$id; ?>" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">
                                    <?php
                                    $dt = date('Y-'.$_POST['mes'].'-'.$i);
                                    $lembretes = (new Agenda())->getAgendasData($dt);
                                    echo date('d/m/Y', strtotime($dt));
                                    ?>
                                </h4>
                            </div>

                            <div class="modal-body">
                                <p>
                                    <h3>Lembretes do dia</h3>
                                    <?php
                                    foreach ($lembretes as $l) {
                                       echo '<div class="lembretes">'.htmlspecialchars(substr($l['lembrete'], 0, 50)).' - Cadastrado em: '.date('d/m/Y H:i', strtotime($l['dt_cadastro'])).'</div>';
                                    }
                                    ?>
                                </p>
                                <hr>
                                <p>
                                    <form method="POST">
                                      <input type="text" name="data" value="<?=$dt; ?>" hidden="">
                                      <label>Horário</label>
                                      <input type="time" name="hr" class="form-control"><br>
                                      <label>Lembrete</label>
                                      <textarea id="lembrete" name="lembrete" class="form-control"></textarea>
                                      <br>
                                      <button class="btn btn-primary btn-block btn-lg">Salvar</button>
                                    </form>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
    
                <?php

                    echo '</td>';
                } else {
                    echo '<td>';

                    //SE ESTIVER PREENCHIDO
                    if (!empty($lem)) {
                        $data = date('Y-m-d', strtotime($v['data']));

                        if ($data >= date('Y-'.$_POST['mes'].'m-d')) {
                            if ($data == date('Y-'.$_POST['mes'].'-d')) {
                                if ($dia == 'Sábado') {
                                    echo '<button title="'.$dia.'" data-toggle="modal" data-target="#'.$id.'" class="btn btn-success btn-block send">'.$i.'<br>'.substr($dia, 0, 4).'</button>';
                                } else {
                                    echo '<button title="'.$dia.'" data-toggle="modal" data-target="#'.$id.'" class="btn btn-success btn-block send">'.$i.'<br>'.substr($dia, 0, 3).'</button>';
                                }
                                
                            } else {
                                if ($dia == 'Sábado') {
                                    echo '<button title="'.$dia.'" data-toggle="modal" data-target="#'.$id.'" class="btn btn-primary btn-block">'.$i.'<br>'.substr($dia, 0, 4).'</button>';
                                } else {
                                    echo '<button title="'.$dia.'" data-toggle="modal" data-target="#'.$id.'" class="btn btn-primary btn-block">'.$i.'<br>'.substr($dia, 0, 3).'</button>';
                                }
                                
                            }
                        } else {
                            if ($dia == 'Sábado') {
                                echo '<button title="'.$dia.'" data-toggle="modal" data-target="#'.$id.'" class="btn btn-danger btn-block">'.$i.'<br>'.substr($dia, 0, 4).'</button>';
                            } else {
                                echo '<button title="'.$dia.'" data-toggle="modal" data-target="#'.$id.'" class="btn btn-danger btn-block">'.$i.'<br>'.substr($dia, 0, 3).'</button>';
                            }
                            
                        }
                    } else {
                        if ($dia == 'Sábado') {
                            echo '<button title="'.$dia.'" data-toggle="modal" data-target="#'.$id.'" class="btn btn-default btn-block">'.$i.'<br>'.substr($dia, 0, 4).'</button>';
                        } else {
                            echo '<button title="'.$dia.'" data-toggle="modal" data-target="#'.$id.'" class="btn btn-default btn-block">'.$i.'<br>'.substr($dia, 0, 3).'</button>';
                        }
                        
                    }

                    ?>
                <!-- MODAL PARA LEMBRETE -->
                <div id="<?=$id; ?>" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">
                                    <?php
                                    $dt = date('Y-'.$_POST['mes'].'-'.$i);
                                    $lembretes = (new Agenda())->getAgendasData($dt);
                                    echo date('d/m/Y', strtotime($dt));
                                    ?>
                                </h4>
                            </div>

                            <div class="modal-body">
                                <p>
                                    <h3>Lembretes do dia</h3>
                                    <?php
                                    foreach ($lembretes as $l) {
                                       echo '<div class="lembretes">'.htmlspecialchars($l['lembrete']).' - Cadastrado em: '.date('d/m/Y H:i', strtotime($l['dt_cadastro'])).'</div>';
                                    }
                                    ?>
                                </p>
                                <hr>
                                <p>
                                    <form method="POST">
                                      <input type="text" name="data" value="<?=$dt; ?>" hidden="">
                                      <label>Horário</label>
                                      <input type="time" name="hr" class="form-control"><br>
                                      <label>Lembrete</label>
                                      <textarea id="lembrete" name="lembrete" class="form-control"></textarea>
                                      <br>
                                      <button class="btn btn-primary btn-block btn-lg">Salvar</button>
                                    </form>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
    			</td>
    			</tr>
                <?php
                }
                }
            ?>
            </tbody>
        </table>
      </div>
    <?php
endif;

//rdp
if (!empty($_POST['seachProcesso'])) {
    $num_processo = addslashes($_POST['seachProcesso']);
    $p = $sql->getProcessosSearch($num_processo);

    header("Content-type:application/json");
    echo json_encode($p);
}

?>
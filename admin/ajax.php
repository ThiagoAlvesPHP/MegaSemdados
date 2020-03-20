<?php
require 'autoload.php';
$sql = new Ajax();

//datatable registros rdp quadro 1
if (!empty($_POST['quadro1'])) {
    //Receber a requisão da pesquisa 
    $requestData = $_REQUEST;

    $columns = array(
        array(0 => 'id'),
        array(1 => 'type'),
        array(2 => 'qt'),
        array(3 => 'descricao'),
        array(4 => 'valor'),
        array(5 => 'total'),
        array(6 => 'num_processo'),
        array(7 => 'num_sinistro'),
        array(8 => 'seguradora'),
        array(9 => 'segurado'),
        array(10 => 'tranportadora'),
        array(11 => 'usuario'),
        array(12 => 'dt_register')
    );

    //Obtendo registros de número total sem qualquer pesquisa
    $resultado = $sql->getRDP($_POST['quadro1']);
    $qnt_linhas = $sql->getRDPCount($_POST['quadro1']);


    $query = "
            SELECT rdp.*, cad_func.nome FROM rdp 
            INNER JOIN cad_func
            ON rdp.id_user = cad_func.id
            WHERE quadro = :quadro 
            AND 1=1";

    //se estiver preenchido
    if(!empty($requestData['search']['value'])) {  
        $request = $requestData['search']['value'];

        $query .= " AND (id LIKE '".$request."%' ";
        $query .= " OR type LIKE '".$request."%' ";
        $query .= " OR qt LIKE '".$request."%' ";
        $query .= " OR descricao LIKE '".$request."%' ";
        $query .= " OR valor LIKE '".$request."%' ";
        $query .= " OR total LIKE '".$request."%' ";
        $query .= " OR num_processo LIKE '".$request."%' ";
        $query .= " OR num_sinistro LIKE '".$request."%' ";
        $query .= " OR seguradora LIKE '".$request."%' ";
        $query .= " OR segurado LIKE '".$request."%' ";
        $query .= " OR transportadora LIKE '".$request."%' ";
        $query .= " OR id_user LIKE '".$request."%' ";
        $query .= " OR dt_cadastro LIKE '".$request."%') ";
    }
    //Ordenar o resultado
    $query .= " ORDER BY 
                ". implode(' AND ', $columns[$requestData['order'][0]['column']])."   
                ".$requestData['order'][0]['dir']." LIMIT 
                ".$requestData['start']." ,".$requestData['length']."   
    ";

    $totalFiltered = $sql->getRDP2Count($_POST['quadro1'], $query);
    $resultado2 = $sql->getRDP2($_POST['quadro1'], $query);

    // Ler e criar o array de dados
    $dados = array();

    foreach ($resultado2 as $key => $value) {
        $dado = array();
        $dado[] = $value["id"];
        $dado[] = $value["type"];
        $dado[] = $value["qt"];
        $dado[] = $value["descricao"];
        $dado[] = $value["valor"];
        $dado[] = $value["total"];
        $dado[] = $value["num_processo"];
        $dado[] = $value["num_sinistro"];
        $dado[] = $value["seguradora"];
        $dado[] = $value["segurado"];
        $dado[] = $value["transportadora"];
        $dado[] = $value["nome"];
        $dado[] = date('Y-m-d', strtotime($value["dt_cadastro"])); 
        
        $dado[] = '<a class="btn btn-info" href="view.php?id='.$value["id"].'">Ver</a> - <button class="btn btn-danger confirm" value="delete.php?id='.$value["id"].'">Excluir</button>';  
        /*$dado[] = $value["email"];
        $dado[] = '<a class="btn btn-info" href="view.php?id='.$value["id"].'">Ver</a> - <button class="btn btn-danger confirm" value="delete.php?id='.$value["id"].'">Excluir</button>';*/   
        $dados[] = $dado;
    }


    //Cria o array de informações a serem retornadas para o Javascript
    $json_data = array(
        //para cada requisição é enviado um número como parâmetro
        "draw" => intval( $requestData['draw'] ),
        //Quantidade de registros que há no banco de dados
        "recordsTotal" => intval( $qnt_linhas ),  
        //Total de registros quando houver pesquisa
        "recordsFiltered" => intval( $totalFiltered ), 
        //Array de dados completo dos dados retornados da tabela 
        "data" => $dados   
    );

    echo json_encode($json_data);  //enviar dados como formato json
}

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

if (!empty($_POST['seachProcesso'])) {
	$num_processo = addslashes($_POST['seachProcesso']);
	$p = $sql->getProcessosSearch($num_processo);

	header("Content-type:application/json");
	echo json_encode($p);
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

?>
<?php
require 'header.php';
$sql = new Dashboard();
//COUNT PESSOA FISICA
$countFisica = $sql->countFisica();
//COUNT PESSOA JURIDICA
$countJuridica = $sql->countJuridica();
//COUNT FUNCIONARIOS
$countFuncionarios = $sql->countFuncionarios();
//COUNT PROCESSOS
$countProcessos = $sql->countProcessos();

//DIA ATUAL
$ult_acesso = date('Y-m-d');
$acessoDia = $sql->ult_acesso($ult_acesso);

$niverFunc = $sql->getNiverFuncionarios();

//CADASTRO DE LEMBRETES - AGENDA
if (!empty($_POST['lembrete'])) {
    $lembrete = addslashes($_POST['lembrete']);
    $data = date('Y-m-d H:i:s', strtotime($_POST['data'].' '.$_POST['hr']));

    if (date('Y-m-d', strtotime($data)) >= date('Y-m-d')) {
        $sql = (new Agenda())->setAgenda($lembrete, $data);
        echo '<script> alert("Cadastro realizado com sucesso!"); window.location.href = "index.php"; </script>';
    } else {
        echo '<script> alert("Cadastro não realizado - Abaixo da data atual!"); window.location.href = "index.php"; </script>';
    }
}

//DELETANDO AGENDA
if (isset($_GET['agendaDel']) && !empty($_GET['agendaDel'])) {
  $agendaDel = addslashes($_GET['agendaDel']);

  $sql = (new Agenda())->delAgenda($agendaDel);
  echo '<script> alert("Deletado com sucesso!"); window.location.href = "index.php"; </script>';
}

if (date('l') == 'Monday') {
    $hoje = 'Segunda-Feira';
}
elseif (date('l') == 'Tuesday') {
    $hoje = 'Terça-Feira';
}
elseif (date('l') == 'Wednesday') {
    $hoje = 'Quarta-Feira';
}
elseif (date('l') == 'Thursday') {
    $hoje = 'Quinta-Feira';
}
elseif (date('l') == 'Friday') {
    $hoje = 'Sexta-Feira';
}
elseif (date('l') == 'Saturday') {
    $hoje = 'Sábado';
}
elseif (date('l') == 'Sunday') {
    $hoje = 'Domingo';
}

?>
<script type="text/javascript">
    $(function(){
        let value = true;

        var horario = function(){
            $.ajax({
                url:'ajax.php',
                type:'POST',
                dataType:'json',
                data:{value:value},
                success:function(data){
                    let hora = data['hora']+':'+data['minutos']+':'+data['segundos'];

                    $('#horario').html(hora);
                }
            });
        };
        setInterval(horario, 800); 
    });
</script>
<!-- STILE DA AGENDA + CALENDARIO -->
<style type="text/css">
    #lembrete{
        height: 250px;
        background-color: #000;
        color: #fff;
        font-size: 20px;
    }
    .lembretes{
        width: 100%;
        height: 100%;
        background-color: #B0C4DE;
        font-size: 14px;
        margin-top: 5px;
        text-align: center;
        word-wrap: break-word;
    }
    .lembretes:hover{
        background-color: #4682B4;
        color: #fff;
    }
    .th{
        text-align: center;
    }

    .send {
      box-shadow: 0 0 0 0 rgba(69, 152, 27, 0.5);
    }

    .send {
      animation: pulse 1.5s infinite;
    }

    @keyframes pulse {
      0% {
        transform: scale(.9);
      }
      70% {
        transform: scale(1);
        box-shadow: 0 0 0 50px rgba(69, 152, 27, 0);
      }
      100% {
        transform: scale(.9);
        box-shadow: 0 0 0 0 rgba(69, 152, 27, 0);
      }
    }

    .panel, .well, .alert{
        box-shadow: 9px 7px 5px rgba(50, 50, 50, 0.4);
    }
</style>
<a href="" style="text-align: center; font-size: 16px;"></a>
<br><br><br>
<div class="container">

    <h3><i class="fas fa-tachometer-alt"></i> Dashboard</h3>
    <br>

    <div class="row">
        <div class="col-lg-2 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-address-card fa-3x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge" style="font-size: 20px;">
                            	<?=$countFisica['count']; ?>
                            </div>
                            <div>Físicas!</div>
                        </div>
                    </div>
                </div>
                <a href="pessoaPFGrid.php">
                    <div class="panel-footer">
                        <span class="pull-left">Ver detalhes</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-2 col-md-6">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-address-card fa-3x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge" style="font-size: 20px;">
                            	<?=$countJuridica['count']; ?>
                            </div>
                            <div>Juridicas!</div>
                        </div>
                    </div>
                </div>
                <a href="pessoaPJGrid.php">
                    <div class="panel-footer">
                        <span class="pull-left">Ver detalhes</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-2 col-md-6">
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-tasks fa-3x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge" style="font-size: 20px;">
                                <?=$countProcessos['count']; ?>
                            </div>
                            <div>Processos!</div>
                        </div>
                    </div>
                </div>
                <a href="processoGrid.php">
                    <div class="panel-footer">
                        <span class="pull-left">Ver detalhes</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-2 col-md-6">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fas fa-address-book fa-3x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge" style="font-size: 20px;">
                            	<?=$countFuncionarios['count']; ?>
                            </div>
                            <div>Funcionarios</div>
                        </div>
                    </div>
                </div>
                <a href="funcionarioCad.php">
                    <div class="panel-footer">
                        <span class="pull-left">Ver detalhes</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="far fa-clock fa-3x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge" style="font-size: 30px;">
                                <div id="horario"></div>
                            </div>
                            <div><?=$hoje; ?></div>
                        </div>
                    </div>
                </div>
                <a>
                    <div class="panel-footer">
                        <span class="pull-left"><?=date('d/m/Y'); ?></span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <div class="row">

        <?php if(!empty($niverFunc)): ?>
        <div class="col-sm-3">
            <div class="well"> 
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Funcionário</th>
                                <th>Logou</th>
                            </tr>
                        </thead>
                        <?php
                        foreach ($acessoDia as $u) {
                            echo '<tbody>';
                                echo '<tr>';
                                    echo '<td>'.$u['nome'].'</td>';
                                    echo '<td>'.date('d/m/Y - H:i:s', strtotime($u['ult_acesso'])).'</td>';
                                echo '</tr>';
                            echo '</tbody>';
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="well"> 
                <div class="table-responsive">
                    <table class="table">
                        <h4>Funcionários</h4>
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Aniversário</th>
                            </tr>
                        </thead>
                        <?php foreach($niverFunc as $n): ?>
                        <tbody>
                            <tr>
                                <td><?=htmlspecialchars($n['nome']); ?></td>
                                <td><?=date('d/m', strtotime($n['dt_nasc'])); ?></td>
                            </tr>
                        </tbody>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
        <?php else: ?>
        <!-- FUNCIONARIOS LOGADOS -->
        <div class="col-sm-6">
            <div class="well"> 
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Funcionário</th>
                                <th>Logou</th>
                            </tr>
                        </thead>
                        <?php
                        foreach ($acessoDia as $u) {
                            echo '<tbody>';
                                echo '<tr>';
                                    echo '<td>'.$u['nome'].'</td>';
                                    echo '<td>'.date('d/m/Y - H:i:s', strtotime($u['ult_acesso'])).'</td>';
                                echo '</tr>';
                            echo '</tbody>';
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
        <?php endif; ?>
      
      <!-- CALENDARIO E AGENDA PESSOAL -->
      <div class="col-sm-6">
            <div class="well">
                <?php
                $data = date('Y-m');
                if (utf8_decode(strftime("%B", strtotime($data))) == 'mar?o') {
                    echo '<label id="sel">'.strftime("Março de %Y", strtotime($data)).'</label> / Minha Agenda Pessoal';
                } else {
                    echo '<label id="sel">'.ucfirst(strftime("%B de %Y", strtotime($data))).'</label> / Minha Agenda Pessoal';
                }
                ?>
                <div class="row">
                    <div class="col-sm-12">
                        <select class="form-control mes">
                        <option>Selecione um mês</option>
                        <?php
                            $mesAtual = date('Y-m');
                            for ($i=1; $i < 13; $i++) { 
                                $dt = date('Y-'.$i);

                                if ($mesAtual == $dt) {
                                    if (utf8_decode(strftime("%B", strtotime($dt))) == 'mar?o') {
                                        echo '<option selected value="'.$i.'">'.ucfirst(strftime("Março", strtotime($dt))).'</option>';
                                    } else {
                                        echo '<option selected value="'.$i.'">'.ucfirst(strftime("%B", strtotime($dt))).'</option>';
                                    }
                                } else {
                                    if (utf8_decode(strftime("%B", strtotime($dt))) == 'mar?o') {
                                        echo '<option value="'.$i.'">'.ucfirst(strftime("Março", strtotime($dt))).'</option>';
                                    } else {
                                        echo '<option value="'.$i.'">'.ucfirst(strftime("%B", strtotime($dt))).'</option>';
                                    }
                                }
                                
                            }
                        ?>
                        </select>
                    </div>
                </div>

                <div class="table table-responsive">
                <table class="table table-hover" id="resultado">
                    <tr>
                    <?php
                    $x = 0;
                    for ($i=1; $i <= date('t'); $i++) { 
                        $x++;

                        $id = 'ag'.$i;
                        $v['data'] = date('Y-m-').$i;
                        $lem = (new Agenda())->getAgendasData($v['data']);

                        //definindo o dia da semana
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

                                if ($data >= date('Y-m-d')) {
                                    if ($data == date('Y-m-d')) {
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
                        <div id="<?=$id; ?>" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">
                                            <?php
                                            $dt = date('Y-m-').$i;
                                            $lembretes = (new Agenda())->getAgendasData($dt);
                                            echo date('d/m/Y', strtotime($dt));
                                            ?>
                                        </h4>
                                    </div>

                                    <div class="modal-body">
                                        <p>
                                            <div class="table-responsive">
                                              <table class="table table-hover">
                                                <thead>
                                                  <tr>
                                                    <th>Lembrete</th>
                                                    <th>Previsão</th>
                                                    <th>Ação</th>
                                                  </tr>
                                                </thead>
                                              
                                                <?php foreach ($lembretes as $l): ?>
                                                  <tbody>
                                                    <tr>
                                                      <td><?=htmlspecialchars($l['lembrete']); ?></td>
                                                      <td width="80"><?=date('H:i', strtotime($l['data'])); ?></td>  
                                                      <td width="50">
                                                        <a href="?agendaDel=<?=$l['id']; ?>" class="fas fa-trash-alt"></a>
                                                      </td>
                                                    </tr>
                                                  </tbody>
                                                <?php endforeach; ?>
                                            </table>
                                            </div>
                                        </p>
                                        <hr>
                                        <p>
                                            <form method="POST">
                                                <input type="text" name="data" value="<?=$dt; ?>" hidden="">
                                                <label>Horário</label>
                                                <input type="time" name="hr" class="form-control" required=""><br>
                                                <label>Lembrete</label>
                                                <textarea id="lembrete" name="lembrete" class="form-control" required=""></textarea>
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

                                if ($data >= date('Y-m-d')) {
                                    if ($data == date('Y-m-d')) {
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
                        <div id="<?=$id; ?>" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">
                                            <?php
                                            $dt = date('Y-m-').$i;
                                            $lembretes = (new Agenda())->getAgendasData($dt);
                                            echo date('d/m/Y', strtotime($dt));
                                            ?>
                                        </h4>
                                    </div>

                                    <div class="modal-body">
                                        <p>
                                            <div class="table-responsive">
                                              <table class="table table-hover">
                                                <thead>
                                                  <tr>
                                                    <th>Lembrete</th>
                                                    <th>Previsão</th>
                                                    <th>Ação</th>
                                                  </tr>
                                                </thead>
                                              
                                                <?php foreach ($lembretes as $l): ?>
                                                  <tbody>
                                                    <tr>
                                                      <td><?=htmlspecialchars($l['lembrete']); ?></td>
                                                      <td width="80"><?=date('H:i', strtotime($l['data'])); ?></td>  
                                                      <td width="50">
                                                        <a href="?agendaDel=<?=$l['id']; ?>" class="fas fa-trash-alt"></a>
                                                      </td>
                                                    </tr>
                                                  </tbody>
                                                <?php endforeach; ?>
                                            </table>
                                            </div>
                                        </p>
                                        <hr>
                                        <p>
                                            <form method="POST">
                                              <input type="text" name="data" value="<?=$dt; ?>" hidden="">
                                              <label>Horário</label>
                                              <input type="time" name="hr" class="form-control" required=""><br>
                                              <label>Lembrete</label>
                                              <textarea id="lembrete" name="lembrete" class="form-control" required=""></textarea>
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
                            echo '</tr>';
                        }
                        
                        }
                    ?>
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-6">
            <div class="alert alert-info">
                <canvas id="canvas" height="150"></canvas>
            </div>
        </div>
        <div class="col-xs-6">
            <div class="alert alert-danger">
                <canvas id="grafico" height="150"></canvas>
            </div>
        </div>
    </div>
</div>

<?php 
    $jan = $sql->countGraficos(1);
    $fev = $sql->countGraficos(2);
    $mar = $sql->countGraficos(3);
    $abr = $sql->countGraficos(4);
    $mai = $sql->countGraficos(5);
    $jun = $sql->countGraficos(6);
    $jul = $sql->countGraficos(7);
    $ago = $sql->countGraficos(8);
    $set = $sql->countGraficos(9);
    $out = $sql->countGraficos(10);
    $nov = $sql->countGraficos(11);
    $dez = $sql->countGraficos(12);

    $v = '';
?>
<script type="text/javascript">
    var color = Chart.helpers.color;

    //GRAFICO 01
    var barChartData = {
      labels:[
      <?php 
        //PEGA O ULTIMO DIA DO MÊS ATUAL
        $fim = date('t');
        for ($i=1; $i <= $fim; $i++) { 
          echo "'".$i."/".date('m')."',";
        }
      ?>
      ],
      datasets: [{
        label: 'Processos Diários',
        backgroundColor: color(window.chartColors.blue).alpha(0.5).rgbString(),
        borderColor: window.chartColors.blue,
        borderWidth: 1,
        data: [
          <?php
          for ($i=1; $i < 32; $i++) { 
                $v = $sql->countGraficosMensal($i);
                echo $v['c'].',';
            }
          ?>
        ]
      }]
    };

    //GRAFICO 02
    window.onload = function(){

    var ctx = document.getElementById('canvas').getContext('2d');
      window.myBar = new Chart(ctx, {
        type: 'bar',
        data: barChartData,
        options: {
          responsive: true,
          legend: {
            position: 'top',
          },
          title: {
            display: true,
            text: 'Grafico de entrada de processos do mês atual'
          }
        }
      });


    //CRIO UMA VARIAVEL - document.get... PEGA O CANVAS
    var contexto = document.getElementById("grafico").getContext("2d");

    var grafico = new Chart(contexto, {
        //TIPO DE GRAFICO
        type:'line',
        //ABRINDO UM ARRAY
        data: {
            labels: ['Janeiro','Fevereiro','Março','Abril','Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],

            datasets: [{
                label:'Processos Mensais',
                backgroundColor:'#0000FF',
                borderColor:'#0000FF',
                data:[
                <?=$jan['c']; ?>,
                <?=$fev['c']; ?>,
                <?=$mar['c']; ?>,
                <?=$abr['c']; ?>,
                <?=$mai['c']; ?>,
                <?=$jun['c']; ?>,
                <?=$jul['c']; ?>,
                <?=$ago['c']; ?>,
                <?=$set['c']; ?>,
                <?=$out['c']; ?>,
                <?=$nov['c']; ?>,
                <?=$dez['c']; ?>,
                ],
                fill:false
            }],
        },
        options: {
          responsive: true,
          legend: {
            position: 'top',
          },
          title: {
            display: true,
            text: 'Grafico de entrada de processos - <?=date('Y'); ?>'
          }
        }
    });
    }
</script>

<?php
require 'footer.php';
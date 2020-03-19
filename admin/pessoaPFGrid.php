<?php
require 'header.php';
$sql = new Pfisica();

//CRIANDO PAGINAÇÃO
$pg = 1;
if (isset($_GET['p']) && !empty($_GET['p'])) {
    $pg = addslashes($_GET['p']);
}
$limite = 5;
$p = ($pg - 1) * 5;

$dbPF = $sql->getPFisicas($p, $limite);
$delHistorico = $sql->delHistorico();
?>
<div class="container">
	<div class="row">
		<br><br><br>
		<div class="col-sm-12">
			 <h3>Lista de Pessoa Física</h3>
			 <br>
			 <div class="row">
			 	<div class="col-sm-8">
			 	</div>
			 	<div class="col-sm-4">
			 		<div class="row">  
			 			<div class="col-sm-10">
			 				<input id="seachPF" class="form-control" placeholder="Digite um Apelido" autofocus="">
			 			</div>
			 			<div class="col-sm-2">
			 				<a href="pessoaPFGrid.php" class="btn btn-info">
			 					<i class="fas fa-sync-alt"></i>
			 				</a>
			 			</div>
			 		</div>
			 	</div>
			 </div>
			 <br>
			 <div class="table-responsive">
			 	<table class="table table-hover" id="respostaF" style="font-size: 12px;">
				    <thead style="background: #000; color: #fff;">
				      <tr>
				        <th>Ação</th>
				        <th>Empresa</th>
				        <th>Apelido</th>
				        <th>Nome</th>
				        <th>Sobrenome</th>
				        <th>CPF</th>
				        <th>RG</th>
				        <th>Ativo</th>
				        <th>Criado em</th>
				        <th>Criado por</th>
				        <th>Atualizado em</th>
				        <th>Atualizado por</th>
				      </tr>
				    </thead>
				    <?php
				    $total = 0;
				    if (!empty($dbPF)) {
				    	$total += $dbPF[0]['count'];
				    }
                    $paginas = $total / 5;

				    foreach ($dbPF as $value) {
				    	?>
				    	<tbody>
					      <tr>
					        <td>
					        	<a href="pessoaPFForm.php?id_usuario=<?=$value['id']; ?>" class="fa fa-edit" title="Editar dados da Pessoa"></a>
					        	<a href="" title="Historico de Acesso" style="color: green;" class="fas fa-align-justify" data-toggle="modal" data-target="#h<?=$value['id']; ?>"></a>

					        	<div id="h<?=$value['id']; ?>" class="modal fade" role="dialog">
								  <div class="modal-dialog">
								    <div class="modal-content">
								      <div class="modal-header">
								        <button type="button" class="close" data-dismiss="modal">&times;</button>
								        <h4 class="modal-title">
								        	Historico de Acesso - 
								        	<?=$value['apelido']; ?>
								        </h4>
								        <br>
								        Ultimos 7 Dias
								      </div>
								      <div class="modal-body">
								        <div class="table-responsive">
								        	<table class="table table-hover">
								        		<thead>
								        			<tr>
								        				<th>Usuário</th>
								        				<th>Data e Hora</th>
								        			</tr>
								        		</thead>
								        		<?php
								        		$historico = $sql->getHistorico($value['id']);
								        		foreach ($historico as $h):
								        		?>
								        		<tbody>
								        			<tr>
								        				<td><?=$h['apelido']; ?></td>
								        				<td><?=date('d/m/Y H:i:s', strtotime($h['dt_cadastro'])); ?></td>
								        			</tr>
								        		</tbody>
								        		<?php
								        		endforeach;
								        		?>
								        	</table>
								        </div>
								      </div>
								      <div class="modal-footer">
								        <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
								      </div>
								    </div>
								  </div>
								</div>


					        </td>
					        <td><?=htmlspecialchars($value['a']); ?></td>
					        <td><?=htmlspecialchars($value['apelido']); ?></td>
					        <td><?=htmlspecialchars($value['nome']); ?></td>
					        <td><?=htmlspecialchars($value['sobrenome']); ?></td>
					        <td><?=htmlspecialchars($value['cpf']); ?></td>
					        <td><?=htmlspecialchars($value['rg']); ?></td>
					        <td>
					        	<?php 
					        		if ($value['status'] == 1) {
					        			echo 'Sim';
					        		} else {
					        			echo 'Não';
					        		}
					        	?>
					        </td>
					        <td><?=htmlspecialchars(date('d/m/Y H:i:s', strtotime($value['dt_cadastro']))); ?></td>
					        <td>
					        	<?php 
					        	echo htmlspecialchars($value['nm']);
					        	?>
					        </td>
					        <td>
					        	<?php 
					        	if (!empty($value['dt_at'])) {
					        		echo htmlspecialchars(date('d/m/Y', strtotime($value['dt_at'])));
					        	} else {
					        		echo '----';
					        	}
					         
					        ?></td>
					        <td>
					        	<?php
					        		if (!empty($value['id_user_at'])) {
					        			$nome = $sql->getFuncAt($value['id_user_at']);
					        			echo $nome['nome'];
					        		} else {
					        			echo '----';
					        		}
					        	?>
					        </td>
					      </tr>
					    </tbody>
				    	<?php
				    }
				    ?>
				    
				  </table>
			 </div>
			 <!-- PAGINAÇÃO -->
            <nav aria-label="Navegação de página exemplo">
              <ul class="pagination">
                <?php
                    for ($i=0; $i < $paginas; $i++) { 
                    	if (isset($_GET['p']) AND $_GET['p'] == $i+1) {
                    		echo '
                            <li class="page-item active">
                                <a class="page-link" href="pessoaPFGrid.php?p='.($i+1).'">'.($i+1).'</a>
                            </li>';
                    	} else {
                    		echo '
                            <li class="page-item">
                                <a class="page-link" href="pessoaPFGrid.php?p='.($i+1).'">'.($i+1).'</a>
                            </li>';
                    	}
                    }
                ?>
              </ul>
            </nav>
		</div>
	</div>
</div>


<?php
require 'footer.php';
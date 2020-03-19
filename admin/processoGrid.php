<?php
require 'header.php';
$sql = new Processos();
$nat_evento = new Eventos();
$sql2 = new PJuridica();

//CRIANDO PAGINAÇÃO
$pg = 1;
if (isset($_GET['p']) && !empty($_GET['p'])) {
    $pg = addslashes($_GET['p']);
}
$limite = 10;
$p = ($pg - 1) * 10;

$ap = $sql->getProcessos($p, $limite);

?>
<div class="container">
	<div class="row">
		<br><br><br>
		<div class="col-sm-12">
			 <h3>Lista de Processos</h3>
			 <br>
			 <div class="row">
			 	<div class="col-sm-8">
			 		<a href="newProcesso.php" class="btn btn-primary">
					 	<strong>+</strong>
					</a>
			 	</div>
			 	<div class="col-sm-4">
			 		<div class="row">  
			 			<div class="col-sm-10">
			 				<input name="seachProcesso" id="seachProcesso" class="form-control" placeholder="Pesquisar">
			 			</div>
			 			<div class="col-sm-2">
			 				<a href="processoGrid.php" class="btn btn-info">
			 					<i class="fas fa-sync-alt"></i>
			 				</a>
			 			</div>
			 		</div>
			 	</div>
			 </div>
			 <br>
			 <div class="table-responsive">
			 	<table id="resposta" class="table table-hover" style="font-size: 12px;">
				    <thead style="background: #000; color: #fff;">
				      <tr>
				        <th>Ação</th>
				        <th>Nº Processo</th>
				        <th>Natureza Evento</th>
				        <th>Nº Sinistro</th>
				        <th>Nº Apolice</th>
				        <th>Segurado</th>
				        <th>Seguradora</th>
				        <th>Criado em</th>
				        <th>Criado por</th>
				        <!-- <th>Atualizado em</th>
				        <th>Atualizado por</th> -->
				      </tr>
				    </thead>
				    <?php
				    $total = 0;
				    if (!empty($ap)) {
	                    $total += $ap[0]['count'];
				    }
				    $paginas = $total / 10;
                    
				    foreach ($ap as $a) {
				    	?>
				    	<tbody>
					    	<tr>
					    		<td>
					    			<a href="processo.php?num_processo=<?=$a['num_processo']; ?>" class="fa fa-edit" title="Editar Processo"></a>
					    		</td>
					    		<td><?=str_replace('/', '', $a['num_processo']); ?></td>
					    		<td>
					    			<?php
					    			$acontecimento = $sql->getDadosAcontecimento($a['num_processo']);
					    			if (!empty($acontecimento)) {
					    				$nat = $nat_evento->getEvento($acontecimento['id_nat_evento']);
					    				echo $nat['nat_evento'];
					    			} else {
					    				echo '----';
					    			}
					    			
					    			?>
					    		</td>
					    		<td><?=htmlspecialchars($a['num_sinistro']); ?></td>
					    		<td>
					    			<?php 
					    			if (!empty($a['id_apolice'])) {
					    				$ap = $sql->getApolicesID($a['id_apolice']);
					    				echo htmlspecialchars($ap['num_apolice']);
					    			} else {
					    				echo '----';
					    			}
					    			?>
					    		</td>
					    		<td>
					    			<?php
					    			if (!empty($a['id_segurado'])) {
					    				$j = $sql2->getPJuridicaID($a['id_segurado']);
					    				echo htmlspecialchars($j['razao_social']);
					    			} else {
					    				echo '----';
					    			}
					    			
					    			?>
					    		</td>
					    		<td>
					    			<?php
					    			$j = $sql2->getPJuridicaID($a['id_seguradora']);
					    			echo htmlspecialchars($j['razao_social']);
					    			?>
					    		</td>
					    		<td><?=date('d/m/Y H:i:s', strtotime($a['dt_cadastro'])); ?></td>
					    		<td>
					    			<?php
					    			$u = $sql2->getFuncAt($a['id_user']);
					    			echo htmlspecialchars($u['nome']);
					    			?>
					    		</td>
					    		<!-- <td>
					    			<?php
					    			if (!empty($a['dt_at'])) {
					    				echo date('d/m/Y H:i:s', strtotime($a['dt_at']));
					    			} else {
					    				echo '----';
					    			}
					    			?>
					    		</td>
					    		<td>
					    			<?php
					    			if (!empty($a['id_user_at'])) {
					    				$u = $sql2->getFuncAt($a['id_user_at']);
					    				echo htmlspecialchars($u['nome']);
					    			} else {
					    			 	echo '----';
					    			}
					    			?>
					    			
					    		</td> -->
					    	</tr>
					    </tbody>
				    	<?php
				    }
				    ?>
				  </table>
			 </div>
			<!-- PAGINAÇÃO -->
            <!-- <nav aria-label="Navegação de página exemplo">
              <ul class="pagination">
                <?php
                    for ($i=0; $i < $paginas; $i++) { 
                    	if (isset($_GET['p']) AND $_GET['p'] == $i+1) {
                    		echo '
                            <li class="page-item active">
                                <a class="page-link" href="processoGrid.php?p='.($i+1).'">'.($i+1).'</a>
                            </li>';
                    	} else {
                    		echo '
                            <li class="page-item">
                                <a class="page-link" href="processoGrid.php?p='.($i+1).'">'.($i+1).'</a>
                            </li>';
                    	}
                        
                    }
                ?>
              </ul>
            </nav> -->

            <!-- PAGINAÇÃO -->
	        <nav aria-label="Navegação de página exemplo">
	          <ul class="pagination">
	            <?php
	                if ($pg == 1) {
	                    echo '<li class="page-item disabled">
	                      <span class="page-link">Anterior</span>
	                    </li>';
	                    for ($i=0; $i < $paginas; $i++) { 
	                        if ($i < $pg+2) {
	                            echo '
	                            <li class="page-item">
	                                <a class="page-link" href="processoGrid.php?p='.($i+1).'">'.($i+1  ).'</a>
	                            </li>';
	                        }
	                    }
	                    echo '
	                            <li class="page-item">
	                                <a class="page-link">...</a>
	                            </li>';
	                    echo '
	                            <li class="page-item">
	                                <a class="page-link" href="processoGrid.php?p='.($i+1).'">'.($i+1  ).'</a>
	                            </li>';

	                    echo '<li class="page-item"><a class="page-link" href="processoGrid.php?p='.($pg+1).'">Próximo</a></li>';
	                } else {
	                    echo '<li class="page-item"><a class="page-link" href="processoGrid.php?p='.($pg-1).'">Anterior</a></li>';
	                    for ($i=0; $i < $paginas; $i++) {

	                        if ($i < $_GET['p']+2 && $i > $_GET['p']-2) {
	                            echo '
	                            <li class="page-item">
	                                <a class="page-link" href="processoGrid.php?p'.($i+1).'">'.($i+1  ).'</a>
	                            </li>';
	                        }
	                    }
	                    echo '
	                            <li class="page-item">
	                                <a class="page-link">...</a>
	                            </li>';
	                    echo '
	                            <li class="page-item">
	                                <a class="page-link" href="processoGrid.php?p='.($i+1).'">'.($i+1  ).'</a>
	                            </li>';

	                    echo '<li class="page-item"><a class="page-link" href="processoGrid.php?p='.($pg+1).'">Próximo</a></li>';
	                } 
	            ?>
	          </ul>
	        </nav>

		</div>
	</div>
</div>


<?php
require 'footer.php';
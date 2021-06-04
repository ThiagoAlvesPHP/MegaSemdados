<?php
require 'header.php';
$sql = new Apolice();

//CRIANDO PAGINAÇÃO
$pg = 1;
if (isset($_GET['p']) && !empty($_GET['p'])) {
    $pg = addslashes($_GET['p']);
}
$limite = 5;
$p = ($pg - 1) * 5;

$dbPF = $sql->getApolices($p, $limite);

?>
<div class="container">
	<div class="row">
		<br><br><br>
		<div class="col-sm-12">
			 <h3>Apolices</h3>
			 <div class="row">
			 	<div class="col-sm-8">
			 	</div>
			 	<div class="col-sm-4">
			 		<div class="row">  
			 			<div class="col-sm-10">
			 				<input id="seachAp" autofocus="" class="form-control" placeholder="Digite o número da apolice">
			 			</div>
			 			<div class="col-sm-2">
			 				<a href="apoliceGrid.php" class="btn btn-info">
			 					<i class="fas fa-sync-alt"></i>
			 				</a>
			 			</div>
			 		</div>
			 	</div>
			 </div>
			 <br>
			 <div class="table-responsive">
			 	<table class="table table-hover" id="respostaA" style="font-size: 12px;">
				    <thead style="background: #000; color: #fff;">
				      <tr>
				        <th>Ação</th>
				        <th>Empresa</th>
				        <th>CNPJ</th>
				        <th>Ramo</th>
				        <th>Apolice</th>
				        <th>De</th>
				        <th>Até</th>
				        <th>Criado em</th>
				        <th>Criado por</th>
				        <th>Atualizado em</th>
				        <th>Atualizado por</th>
				        <th>Ativo</th>
				      </tr>
				    </thead>
				    <?php
				    $total = 0;
                    $total += $dbPF[0]['count'];
                    $paginas = $total / 5;
                    
				    foreach ($dbPF as $value) {
				    	?>
				    	<tbody>
					      <tr>
					        <td>
					        	<a href="apoliceForm.php?id_apolice=<?=$value['id']; ?>" class="fa fa-edit" title="Editar Apolice"></a>
					        </td>
					        <td><?=htmlspecialchars($value['razao_social']); ?></td>
					        <td><?=htmlspecialchars($value['cnpj']); ?></td>
					        <td><?=htmlspecialchars($value['ramo']); ?></td>
					        <td><?=htmlspecialchars($value['num_apolice']); ?></td>
					        <td><?=htmlspecialchars(date('d/m/Y', strtotime($value['de']))); ?></td>
					        <td><?=htmlspecialchars(date('d/m/Y', strtotime($value['ate']))); ?></td>
					        <td><?=htmlspecialchars(date('d/m/Y H:i:s', strtotime($value['dt_cadastro']))); ?></td>
					        <td><?=htmlspecialchars($value['nome']); ?></td>

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
					        			$nome = $sql->getFuncApol($value['id_user_at']);
					        			echo $nome['nome'];
					        		} else {
					        			echo '----';
					        		}
					        	?>
					        </td>
					        <td>
					        	<?php
					        		if ($value['status'] == 1) {					       echo 'Ativo';
					        		} else {
					        			echo 'Inativo';
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
                                <a class="page-link" href="apoliceGrid.php?p='.($i+1).'">'.($i+1).'</a>
                            </li>';
                    	} else {
                    		echo '
                            <li class="page-item">
                                <a class="page-link" href="apoliceGrid.php?p='.($i+1).'">'.($i+1).'</a>
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
?>
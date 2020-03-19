<?php
require 'header.php';
$sql = new PJuridica();

//CRIANDO PAGINAÇÃO
$pg = 1;
if (isset($_GET['p']) && !empty($_GET['p'])) {
    $pg = addslashes($_GET['p']);
}
$limite = 5;
$p = ($pg - 1) * 5;
$dbPF = $sql->getPJuridica($p, $limite);

?>
<div class="container">
	<div class="row">
		<br><br><br>
		<div class="col-sm-12">
			 <h3>Lista de Pessoa Jurídica</h3>
			 <br>
			 <div class="row">
			 	<div class="col-sm-8">
			 		<a href="pessoaPJForm.php" class="btn btn-primary">
					 	<strong>+</strong>
					</a>
			 	</div>
			 	<div class="col-sm-4">
			 		<div class="row">  
			 			<div class="col-sm-10">
			 				<input id="seachPJ" class="form-control" placeholder="Digite a Razão Social" autofocus="">
			 			</div>
			 			<div class="col-sm-2">
			 				<a href="pessoaPJGrid.php" class="btn btn-info">
			 					<i class="fas fa-sync-alt"></i>
			 				</a>
			 			</div>
			 		</div>
			 	</div>
			 </div>
			 <br>
			 <div class="table-responsive">
			 	<table id="seachPJResultado" class="table table-hover" style="font-size: 12px;">
				    <thead style="background: #000; color: #fff;">
				      <tr>
				        <th>Ação</th>
				        <th>Razão Social</th>
				        <th>CNPJ</th>
				        <th>Ativo</th>
				        <th>Segurado</th>
				        <th>Seguradora</th>
				        <th>Transportadora</th>
				        <th>Corretora</th>
				        <th>Criado em</th>
				        <th>Criado por</th>
				        <th>Atualizado em</th>
				        <th>Atualizado por</th>
				      </tr>
				    </thead>
				    <?php
				    foreach ($dbPF as $value) {
				    	?>
				    	<tbody>
					      <tr>
					        <td>
					        	<a href="pessoaPJForm.php?id=<?=$value['id']; ?>" class="fa fa-edit" title="Editar Dados da Empresa"></a>
					        	<a href="pessoaPFForm.php?id=<?=$value['id']; ?>" class="far fa-address-book" title="Usuários"></a>
					        	<?php 
					        		if ($value['segurado'] == 1 || $value['transportadora'] == 1) {
					        			echo '<a href="apoliceForm.php?id='.$value['id'].'" class="fa fa-book" title="Apolices"></a>';
					        		}
					        	?>
					        	<a href="" class="fas fa-money-bill-alt" title="Conta Bancaria"></a>

					        </td>
					        <td width="150px"><?=htmlspecialchars($value['razao_social']); ?></td>
					        <td><?=htmlspecialchars($value['cnpj']); ?></td>
					        <td>
					        	<?php 
					        		if ($value['status'] == 1) {
					        			echo 'Sim';
					        		} else {
					        			echo 'Não';
					        		}
					        	?>
					        </td>
					        <td>
					        	<?php 
					        		if ($value['segurado'] == 1) {
					        			echo 'Sim';
					        		} else {
					        			echo 'Não';
					        		}
					        	?>
					        </td>
					        <td>
					        	<?php 
					        		if ($value['seguradora'] == 1) {
					        			echo 'Sim';
					        		} else {
					        			echo 'Não';
					        		}
					        	?>
					        </td>
					        <td>
					        	<?php 
					        		if ($value['transportadora'] == 1) {
					        			echo 'Sim';
					        		} else {
					        			echo 'Não';
					        		}
					        	?>
					        </td>
					        <td>
					        	<?php 
					        		if ($value['corretora'] == 1) {
					        			echo 'Sim';
					        		} else {
					        			echo 'Não';
					        		}
					        	?>
					        </td>
					        <td><?=htmlspecialchars(date('d/m/Y H:i:s', strtotime($value['dt_cadastro']))); ?></td>
					        <td><?=htmlspecialchars($value['a']); ?></td>
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
                    $total = 0;
                    $total += $dbPF[0]['count'];
                    $paginas = $total / 5;

                    for ($i=0; $i < $paginas; $i++) { 
                    	if (isset($_GET['p']) AND $_GET['p'] == $i+1) {
                    		echo '
                            <li class="page-item active">
                                <a class="page-link" href="pessoaPJGrid.php?p='.($i+1).'">'.($i+1).'</a>
                            </li>';
                    	} else {
                    		echo '
                            <li class="page-item">
                                <a class="page-link" href="pessoaPJGrid.php?p='.($i+1).'">'.($i+1).'</a>
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
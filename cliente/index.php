<?php
require 'header.php';
$sql = new Processos();
?>
<div class="container">
	<div class="panel panel-primary">
      <div class="panel-heading">
      	<div class="row">  
 			<div class="col-sm-6">
 				<h4>Meus Processos</h4>
 			</div>
 			<div class="col-sm-6">
 				<input id="seachProcesso" class="form-control" placeholder="Número do Processo">
 			</div>
 		</div>
      </div>
      <div class="panel-body">
      	<div class="table-responsive">
      		<table id="resposta" class="table" style="font-size: 12px;">
      			<thead style="background: #000; color: #fff;">
			      <tr>
			        <th>Ação</th>
			        <th width="100">Nº Processo</th>
			        <th>Cia</th>
			        <th>Segurado</th>
			        <th>Transportador</th>
			        <th width="100">Nº Sinistro</th>
			        <th>Apolice</th>
			        <th>Situação</th>
			      </tr>
				</thead>
				<?php
				//ARQUIVOS DA SEGURADORA
				if ($dados['seguradora'] == 1) {
					$id_seguradora = addslashes($dados['id_juridica']);
					$dbProcesso = $sql->processosSeguradora($id_seguradora);

					foreach ($dbProcesso as $v) {
						?>
						<tbody>
							<tr>
								<td>
									<a href="viewProcesso.php?num_processo=<?=$v['num_processo']; ?>" class="fas fa-folder-open"></a>
								</td>
								<td><?=htmlspecialchars(str_replace('/', '', $v['num_processo'])); ?></td>
								<td><?=htmlspecialchars($v['seguradora']); ?></td>
								<td><?=htmlspecialchars($v['segurado']); ?></td>
								<td><?=htmlspecialchars($v['transportadora']); ?></td>
								<td><?=htmlspecialchars($v['num_sinistro']); ?></td>
								<td><?=htmlspecialchars($v['num_apolice']); ?></td>
								<td>
									<?php
									if($v['status'] == 1){echo 'Concluído';} 
									elseif($v['status'] == 2){echo 'Em Andamento';} 
									elseif($v['status'] == 3) {echo 'Pendente';}
									?>
								</td>
							</tr>
						</tbody>
						<?php
					}
				}
				//ARQUIVOS DO CORRETORA
				if ($dados['corretora'] == 1) {
					$id_corretora = addslashes($dados['id_juridica']);
					$dbProcesso = $sql->processosCorretora($id_corretora);

					foreach ($dbProcesso as $v) {
						?>
						<tbody>
							<tr>
								<td>
									<a href="viewProcesso.php?num_processo=<?=$v['num_processo']; ?>" class="fas fa-folder-open"></a>
								</td>
								<td><?=htmlspecialchars(str_replace('/', '', $v['num_processo'])); ?></td>
								<td><?=htmlspecialchars($v['seguradora']); ?></td>
								<td><?=htmlspecialchars($v['segurado']); ?></td>
								<td><?=htmlspecialchars($v['transportadora']); ?></td>
								<td><?=htmlspecialchars($v['num_sinistro']); ?></td>
								<td><?=htmlspecialchars($v['num_apolice']); ?></td>
								<td>
									<?php
									if($v['status'] == 1){echo 'Concluído';} 
									elseif($v['status'] == 2){echo 'Em Andamento';} 
									elseif($v['status'] == 3) {echo 'Pendente';}
									?>
								</td>
							</tr>
						</tbody>
						<?php
					}

				}
				//ARQUIVOS DO SEGURADO
				if ($dados['segurado'] == 1) {
					$id_segurado = addslashes($dados['id_juridica']);
					$dbProcesso = $sql->processosSegurado($id_segurado);

					foreach ($dbProcesso as $v) {
						?>
						<tbody>
							<tr>
								<td>
									<a href="viewProcesso.php?num_processo=<?=$v['num_processo']; ?>" class="fas fa-folder-open"></a>
								</td>
								<td><?=htmlspecialchars(str_replace('/', '', $v['num_processo'])); ?></td>
								<td><?=htmlspecialchars($v['seguradora']); ?></td>
								<td><?=htmlspecialchars($v['segurado']); ?></td>
								<td><?=htmlspecialchars($v['transportadora']); ?></td>
								<td><?=htmlspecialchars($v['num_sinistro']); ?></td>
								<td><?=htmlspecialchars($v['num_apolice']); ?></td>
								<td>
									<?php
									if($v['status'] == 1){echo 'Concluído';} 
									elseif($v['status'] == 2){echo 'Em Andamento';} 
									elseif($v['status'] == 3) {echo 'Pendente';}
									?>
								</td>
							</tr>
						</tbody>
						<?php
					}
				}
				?>
      		</table>
      	</div>
      </div>
    </div>
</div>



<?php
require 'footer.php';
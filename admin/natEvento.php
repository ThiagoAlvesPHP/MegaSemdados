<?php  
require 'header.php';
$sql2 = new Funcionarios();
$nivel = $sql2->getFuncionario($id_user);
if ($nivel['nivel'] <> 2) {
	?>
	<script>
		alert("Você não tem altorização para acessar essa área!");
		window.location.assign("index.php");
	</script>
	<?php
}

$sql = new Eventos();

//CRIANDO PAGINAÇÃO
$pg = 1;
if (isset($_GET['p']) && !empty($_GET['p'])) {
    $pg = addslashes($_GET['p']);
}
$limite = 5;
$p = ($pg - 1) * 5;

$at = $sql->getEventos($p, $limite);
?>
<br><br><br>
<div class="container">
	<div class="row">
		<div class="col-sm-6">
			<div class="panel panel-primary">
			<?php  
			if (isset($_GET['id']) && !empty($_GET['id'])) {
				$getEvento = $sql->getEvento(addslashes($_GET['id']));

				if (!empty($_POST['nat_eventoUP'])) {
					$nat_evento = addslashes($_POST['nat_eventoUP']);
					$sql->upEvento($nat_evento, addslashes($_GET['id']));
					?>
					<script>
						alert("Alterado com sucesso!");
						window.location.assign("natEvento.php");
					</script>
					<?php
				}
				?>
				<div class="panel-heading">
		      	Edição de Moedas
			    </div>
			    <div class="panel-body">
			      	<form method="POST">
			      		<label>Natureza do Evento</label>
			      		<input type="text" value="<?=$getEvento['nat_evento']; ?>" name="nat_eventoUP" class="form-control">
			      		<br>
			      		<a class="btn btn-danger" href="index.php">Voltar</a>
			      		<button class="btn btn-success">Atualizar</button>
			      	</form>
			    </div>
				<?php
			} else {
				if (!empty($_POST['nat_evento'])) {
					$nat_evento = addslashes($_POST['nat_evento']);
					$sql->setEvento($nat_evento);
					?>
					<script>
						alert("Registrado com sucesso!");
						window.location.assign("natEvento.php");
					</script>
					<?php
				}
				?>
				<div class="panel-heading">
		      	Cadastro de Evento
			    </div>
			    <div class="panel-body">
			      	<form method="POST">
			      		<label>Naturezao do Evento</label>
			      		<input type="text" name="nat_evento" class="form-control">
			      		<br>
			      		<a class="btn btn-danger" href="index.php">Voltar</a>
			      		<button class="btn btn-success">Registrar</button>
			      	</form>
			    </div>
				<?php
			}
			?>
		      
		    </div>
		</div>
		<div class="col-sm-6">
			<div class="panel panel-primary">
		      <div class="panel-heading">
		      	Lista de Eventos
		      </div>
		      <div class="panel-body">
		      	<div class="table-responsive">
		      		<table class="table table-hover">
		      			<thead>
		      				<tr>
		      					<th width="50">Ação</th>
		      					<th>Natureza do Evento</th>
		      				</tr>
		      			</thead>
		      			<?php  
		      			foreach ($at as $a) {
		      				?>
		      				<tbody>
			      				<tr>
			      					<td>
			      						<a class="fa fa-edit" href="natEvento.php?id=<?=$a['id']; ?>"></a>
			      					</td>
			      					<td><?=htmlspecialchars($a['nat_evento']); ?></td>
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
                        $total += $at[0]['count'];
                        $paginas = $total / 5;

                        for ($i=0; $i < $paginas; $i++) { 
                        	if (isset($_GET['p']) AND $_GET['p'] == $i+1) {
	                    		echo '
                                <li class="page-item active">
                                    <a class="page-link" href="natEvento.php?p='.($i+1).'">'.($i+1).'</a>
                                </li>';
	                    	} else {
	                    		echo '
                                <li class="page-item">
                                    <a class="page-link" href="natEvento.php?p='.($i+1).'">'.($i+1).'</a>
                                </li>';
	                    	}
                        }
                    ?>
                  </ul>
                </nav>

		      </div>
		    </div>
		</div>
	</div>
</div>

<?php  
require 'footer.php';
?>
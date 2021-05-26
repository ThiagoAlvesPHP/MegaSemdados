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
			 </div>
			 <br>
			 <div class="table-responsive">
			 	<table id="resposta" class="table table-hover" style="font-size: 12px;">
				    <thead style="background: #000; color: #fff;">
				      <tr>
				        <th>Ação</th>
				        <th>Processo</th>
				        <th>Natureza Evento</th>
				        <th>Sinistro</th>
				        <th>Apolice</th>
				        <th>Segurado</th>
				        <th>Seguradora</th>
				        <th>Criado em</th>
				        <th>Criado por</th>
				      </tr>
				    </thead>
				</table>
			 </div>

		</div>
	</div>
</div>

<link rel="stylesheet" href="assets/css/datatable.css">
<script src="assets/js/datatable.js"></script>

<script type="text/javascript">
	//datatable
    $(document).ready(function (){
        var array = [];
        array['grid_processo'] = 'true';

        $('#resposta').DataTable({
            "processing": true,
            "serverSide": true,
            "language": {
                "lengthMenu": "_MENU_ registros por página",
                "zeroRecords": "Nenhum registro encotrado",
                "info": "Mostrando página _PAGE_ de _PAGES_",
                "infoEmpty": "Nenhum registro disponível",
                "infoFiltered": "(Filtrado de _MAX_ registros no total)",
                "sSearch": "Pesquisar",
                "oPaginate": {
                "sNext": "Próximo",
                "sPrevious": "Anterior",
                "sFirst": "Primeiro",
                "sLast": "Último"
                },
            },
            "ajax": {
                "url": "ajax.php",
                "type": "POST",
                "data":array
            }
        });
    });
</script>

<?php
require 'footer.php';
<div class="container-fluid conteudo">	
	<div class="row">
		<div class="col-sm-1"></div>
		<div class="col-sm-10">
		
			<h3>RDP - Recibo Despesas Próprias</h3>
			<hr>

			<div class="well">
				<input class="form-control seach_proc" placeholder="Pesquisar Processo">
				<input type="hidden" name="" class="type" value="<?=$_GET['type']; ?>">
				<hr>
				<div class="resposta"></div>
			</div>

			<div class="well">
				<?php if(!empty($_GET['num_processo'])): ?>

					<script type="text/javascript">
						$(function (){
							$(document).on('click', '.confirm', function(){
								let v = confirm("Tem certeza que deseja excluir?");
								if (v == true) {
									window.location.href = $(this).val();
								}
							})
							
						});
						$(document).ready(function (){
							let quadro1 = '1';
						    $('#quadro01').DataTable({
						        "processing": true,
						        "serverSide": true,
						        "ajax": {
						            "url": "ajax.php",
						            "type": "POST",
						            data:{ quadro1:quadro1 }
						        }
						    });
						});
					</script>


					<!-- INICIO DOS REGISTROS QUADRO 01 -->
					<div class="table table-responsive">
						<table id="quadro01" class="table table-hover display" style="width:100%">
						    <thead>
						        <tr>
						            <th>ID</th>
						            <th>Tipo</th>
						            <th>Quantidade</th>
						            <th>Descriçao</th>
						            <th>Valor</th>
						            <th>Total</th>
						            <th>Nº Processo</th>
						            <th>Nº Sinistro</th>
						            <th>Seguradora</th>
						            <th>Segurado</th>
						            <th>Transportadora</th>
						            <th>Usuário</th>
						            <th>Registrado em</th>
						            <th>Ação</th>
						        </tr>
						    </thead>
						</table>
					</div>
					
				<?php endif; ?>		
			</div>

		</div>
		<div class="col-sm-1"></div>
	</div>
</div>
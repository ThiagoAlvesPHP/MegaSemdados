<style type="text/css">
	
.dropdown-submenu {
    position: relative;
}

.dropdown-submenu>.dropdown-menu {
    top: 0;
    left: 100%;
    margin-top: -6px;
    margin-left: -1px;
    -webkit-border-radius: 0 6px 6px 6px;
    -moz-border-radius: 0 6px 6px;
    border-radius: 0 6px 6px 6px;
}

.dropdown-submenu:hover>.dropdown-menu {
    display: block;
}

.dropdown-submenu>a:after {
    display: block;
    content: " ";
    float: right;
    width: 0;
    height: 0;
    border-color: transparent;
    border-style: solid;
    border-width: 5px 0 5px 5px;
    border-left-color: #ccc;
    margin-top: 5px;
    margin-right: -10px;
}

.dropdown-submenu:hover>a:after {
    border-left-color: #fff;
}

.dropdown-submenu.pull-left {
    float: none;
}

.dropdown-submenu.pull-left>.dropdown-menu {
    left: -100%;
    margin-left: 10px;
    -webkit-border-radius: 6px 0 6px 6px;
    -moz-border-radius: 6px 0 6px 6px;
    border-radius: 6px 0 6px 6px;
}
</style>

<div class="row">
	<div class="col-sm-2">
		<input class="form-control" readonly="" value="Processo: <?=str_replace('/', '', $p['num_processo']); ?>">
	</div>
	<div class="col-sm-4">


		<div class="dropdown" style="float:left; margin-left: 5px;">
            <a id="dLabel" role="button" data-toggle="dropdown" class="btn btn-primary" href="">
                Navegação <span class="caret"></span>
            </a>
    		<ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
    			<li class="dropdown-submenu">
    				<a tabindex="-1" href="#">Aviso Preliminar</a>
    				<ul class="dropdown-menu" style="overflow:auto; height: 300px;">
                        <li><a tabindex="-1" href="processo.php?num_processo=<?=$num_processo; ?>">1 - Dados Inicias do Processo</a></li>
                        <li><a href="processo02.php?num_processo=<?=$num_processo; ?>">2 - Dados da Segurado (+)</a></li>
                        <li><a href="processo03.php?num_processo=<?=$num_processo; ?>">3 - Dados do Transportador (+)</a></li>
                        <li><a href="processo04.php?num_processo=<?=$num_processo; ?>">4 - Dados do Corretor (+)</a></li>
                        <li><a href="processo05.php?num_processo=<?=$num_processo; ?>">5 - Dados do Percurso do Transporte</a></li>
                        <li><a href="processo06.php?num_processo=<?=$num_processo; ?>">6 - Dados do Remetente e Destinátario</a></li>
                        <li><a href="processo07.php?num_processo=<?=$num_processo; ?>">7 - Dados do Acontecimento</a></li>
                        <li><a href="processo08.php?num_processo=<?=$num_processo; ?>">8 - Fotos Preliminares do Acontecimento</a></li>
                        <li><a href="processo11.php?num_processo=<?=$num_processo; ?>">11 - Danos a Mercadoria</a></li>
                        <li><a href="processo13.php?num_processo=<?=$num_processo; ?>">13 - Documentação da Mercadoria (+)</a></li>
                        <li><a href="processo14.php?num_processo=<?=$num_processo; ?>">14 - Documentação do Transporte (+)</a></li>
                        <li><a href="processo15.php?num_processo=<?=$num_processo; ?>">15 - Veículo Transportador</a></li>
                        <li><a href="processo16.php?num_processo=<?=$num_processo; ?>">16 - Motorista do Veículo Transportador</a></li>
                        <li><a href="processo20.php?num_processo=<?=$num_processo; ?>">20 - Dos Fatos Apurados / Das Providências</a></li>
                        <li><a href="processo25.php?num_processo=<?=$num_processo; ?>">25 - Estimativa de Prezuízo e Custo (S.O.S)</a></li>
	                </ul>
    			</li>
    			<li class="divider"></li>
				<li class="dropdown-submenu">
                    <a tabindex="-1" href="#">Relatório Geral</a>
                    <ul class="dropdown-menu" style="overflow:auto; height: 300px;">
                      <li><a tabindex="-1" href="processo.php?num_processo=<?=$num_processo; ?>">1 - Dados Inicias do Processo</a></li>
                      <li><a href="processo02.php?num_processo=<?=$num_processo; ?>">2 - Dados da Segurado (+)</a></li>
                      <li><a href="processo03.php?num_processo=<?=$num_processo; ?>">3 - Dados do Transportador (+)</a></li>
                      <li><a href="processo04.php?num_processo=<?=$num_processo; ?>">4 - Dados do Corretor (+)</a></li>
                      <li><a href="processo05.php?num_processo=<?=$num_processo; ?>">5 - Dados do Percurso do Transporte</a></li>
                      <li><a href="processo06.php?num_processo=<?=$num_processo; ?>">6 - Dados do Remetente e Destinátario</a></li>
                      <li><a href="processo07.php?num_processo=<?=$num_processo; ?>">7 - Dados do Acontecimento</a></li>
                      <li><a href="processo08.php?num_processo=<?=$num_processo; ?>">8 - Fotos Preliminares do Acontecimento</a></li>
                      <li><a href="processo09.php?num_processo=<?=$num_processo; ?>">9 - Registro Policial</a></li>
                      <li><a href="processo10.php?num_processo=<?=$num_processo; ?>">10 - Repercursão na Mídia</a></li>
                      <li><a href="processo11.php?num_processo=<?=$num_processo; ?>">11 - Danos a Mercadoria</a></li>
                      <li><a href="processo12.php?num_processo=<?=$num_processo; ?>">12 - Dados do Container (+)</a></li>
                      <li><a href="processo13.php?num_processo=<?=$num_processo; ?>">13 - Documentação da Mercadoria (+)</a></li>
                      <li><a href="processo14.php?num_processo=<?=$num_processo; ?>">14 - Documentação do Transporte (+)</a></li>
                      <li><a href="processo15.php?num_processo=<?=$num_processo; ?>">15 - Veículo Transportador</a></li>
                      <li><a href="processo16.php?num_processo=<?=$num_processo; ?>">16 - Motorista do Veículo Transportador</a></li>
                      <li><a href="processo17.php?num_processo=<?=$num_processo; ?>">17 - Veículo Transbordo</a></li>
                      <li><a href="processo18.php?num_processo=<?=$num_processo; ?>">18 - Motorista do Veículo Transbordo</a></li>
                      <li><a href="processo19.php?num_processo=<?=$num_processo; ?>">19 - Terceiro Envolvido</a></li>
                      <li><a href="processo20.php?num_processo=<?=$num_processo; ?>">20 - Dos Fatos Apurados / Das Providências</a></li>
                      <li><a href="processo21.php?num_processo=<?=$num_processo; ?>">21 - Reportagem Fotográfica ( S.O.S )</a></li>
                      <li><a href="processo22.php?num_processo=<?=$num_processo; ?>">22 - Detalhes da Vistoria</a></li>
                      <li><a href="processo23.php?num_processo=<?=$num_processo; ?>">23 - Reportagem Fotográfica - Vistoria</a></li>

                      <li><a href="processo24.php?num_processo=<?=$num_processo; ?>">24 - Definição de Destino da Mercadoria</a></li>
                      <li><a href="processo25.php?num_processo=<?=$num_processo; ?>">25 - Estimativa de Prezuízo e Custo (S.O.S)</a></li>
                      <li><a href="processo26.php?num_processo=<?=$num_processo; ?>">26 - Consequências e Causas do Sinistro</a></li>
                      <li><a href="processo27.php?num_processo=<?=$num_processo; ?>">27 - Descrição do Local</a></li>
                      <li><a href="processo28.php?num_processo=<?=$num_processo; ?>">28 - Documentos Anexos / Digitalizados</a></li>
                      <li><a href="processo29.php?num_processo=<?=$num_processo; ?>">29 - Lançamentos (Débitos e Créditos)</a></li>
                      <li><a href="processo30.php?num_processo=<?=$num_processo; ?>">30 - Certificado de Vistoria</a></li>
                      <li><a href="processo31.php?num_processo=<?=$num_processo; ?>">31 - Inventário de Produtos</a></li>
                      <li><a href="processoDocArq.php?num_processo=<?=$num_processo; ?>">32 - Documentos e Arquivos do Processo</a></li>
                      <li><a href="processoHistorico.php?num_processo=<?=$_GET['num_processo']; ?>">33 - Histórico do Processo</a></li>
                    </ul>
                </li>
				        <li class="divider"></li>
				        <li class="dropdown-submenu">
                    <a href="" tabindex="-1">Fotos do Processo</a>
                    <ul class="dropdown-menu">
                      <li><a tabindex="-1" href="processoftSinistro.php?num_processo=<?=$_GET['num_processo']; ?>">Fotos Gerais</a></li>
                      <li><a href="processoftSalvados.php?num_processo=<?=$_GET['num_processo']; ?>">Fotos de Salvados</a></li>
                    </ul>
                </li>
                <li class="divider"></li>
                <li><a href="diario.php?num_processo=<?=$_GET['num_processo']; ?>">Diário de Bordo - Uso Interno</a></li>
            </ul>
        </div>

        <div class="dropdown" style="float:left; margin-left: 5px;">
            <a id="dLabel" role="button" data-toggle="dropdown" class="btn btn-primary" href="">
                Impressão de Documentos <span class="caret"></span>
            </a>
    		<ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
    			<li class="divider"></li>
    			<li><a href="processoRelPrelimiar.php?num_processo=<?=$num_processo; ?>" target="_blank">Aviso Preliminar</a></li>
    			<li class="divider"></li>
			    <li><a href="processoRelGeral.php?num_processo=<?=$num_processo; ?>" target="_blank">Relatório Geral</a></li>
			    <li class="divider"></li>
			    <li><a href="reportFotosGerais.pdf.php?num_processo=<?=$num_processo; ?>" target="_blank">Fotos Gerais</a></li>
			    <li class="divider"></li>
			    <li><a href="reportSalvados.pdf.php?num_processo=<?=$num_processo; ?>" target="_blank">Fotos de Salvados</a></li>
            </ul>
        </div>

	</div>
	<div class="col-sm-3">
		<input class="form-control" readonly="" value="Status: <?php
		if($p['status'] == 1){echo 'Concluído';} 
		elseif($p['status'] == 2){echo 'Em Andamento';} 
		elseif($p['status'] == 3) {echo 'Pendente';}
		?>
		">
	</div>
	<div class="col-sm-3">
		<a class="btn btn-primary" data-toggle="modal" data-target="#status">Definir Status</a>
		<a href="processoHistorico.php?num_processo=<?=$_GET['num_processo']; ?>" class="btn btn-primary">Historico</a>
    <a href="processoDiario.php?num_processo=<?=$_GET['num_processo']; ?>" style="background-color: orange; color: #fff;" class="btn">Diario</a>

    <?php
    if (!empty($_POST['status'])) {
      $status = addslashes($_POST['status']);
      $sql->upStatusProcesso($num_processo, $status);
      ?>
      <script>
        window.location.href = "<?=$url; ?>";
      </script>
      <?php
    }
    ?>

    <!-- Modal -->
    <div id="status" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Definir Status</h4>
          </div>
          <div class="modal-body">
            <p>Evento atual do Processo</p>
            <form method="POST">
              <select name="status" class="form-control">
                <option>Selecione...</option>
                <option value="1">Concluido</option>
                <option value="2">Em Andamento</option>
                <option value="3">Pendente</option>
              </select>
              <br>
              <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
              <button class="btn btn-primary">Salvar</button>
            </form>
          </div>
        </div>
      </div>
    </div>


	</div>
</div>
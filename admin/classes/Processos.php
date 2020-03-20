<?php
date_default_timezone_set('America/Sao_Paulo');
class Processos{
	private $db;

	public function __construct(){
		$file = file_get_contents('classes/config.json');
		$options = json_decode($file, true);

		$config = array();

		$config['db'] = $options['db'];
		$config['host'] = $options['localhost'];
		$config['user'] = $options['user'];
		$config['pass'] = $options['pass'];

		try {
			$this->db = new PDO("mysql:dbname=".$config['db'].";host=".$config['host']."", "".$config['user']."", "".$config['pass']."");
		} catch(PDOException $e) {
			echo "FALHA: ".$e->getMessage();
		}
	}

	public function setRDP($post){
		$post['id_user'] = $_SESSION['cLogin'];

		$fields = [];
        foreach ($post as $key => $value) {
            $fields[] = "$key=:$key";
        }
        $fields = implode(', ', $fields);

		$sql = $this->db->prepare("
			INSERT INTO rdp 
			SET {$fields}
			");

		foreach ($post as $key => $value) {
            $sql->bindValue(":{$key}", $value);
        }
		$sql->execute();
	}

	public function getProcessoRamo($id_ramo){
		$sql = $this->db->prepare("
			SELECT * FROM processos 
			WHERE id_ramo = :id_ramo");
		$sql->bindValue(":id_ramo", $id_ramo);
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}

	public function redimencionarIMG($arquivo){
		$array = array();

		$largura = 500;
		$altura = 500;

		//CAPTURANDO LARGURA E ALTURA ORIGINAL DA IMAGEM
		list($larguraOri, $alturaOri) = getimagesize($arquivo);
		$ratio = $larguraOri / $alturaOri;
		
		if ($largura / $altura > $ratio) {
			$largura = $altura * $ratio;
		} else {
			$altura = $largura / $ratio;
		}
		$array['x'] = $largura;
		$array['y'] = $altura;
		//CRIAR IMAGEM COM ALTURA E ALTURA
		$imagem_final = imagecreatetruecolor($largura, $altura);
		$imagem_original = imagecreatefromjpeg($arquivo);
		imagecopyresampled($imagem_final, $imagem_original, 0, 0, 0, 0, $largura, $altura, $larguraOri, $alturaOri);

		$array['img_fim'] = $imagem_final;
		
		return $array;
	}

	//DIARIO DE BORDO
	public function setDiario($num_processo, $detalhes, $valor, $dt_hs, $id_user){

		$sql = $this->db->prepare("INSERT INTO processo_diario SET 
				num_processo = :num_processo,
				detalhes = :detalhes,
				valor = :valor,
				dt_hs = :dt_hs,
				id_user = :id_user
				");
			$sql->bindValue(":num_processo", $num_processo);
			$sql->bindValue(":detalhes", $detalhes);
			$sql->bindValue(":valor", $valor);
			$sql->bindValue(":dt_hs", $dt_hs);
			$sql->bindValue(":id_user", $id_user);
			$sql->execute();

			return true;
	}
	public function getInvetario1($id_inventario){
		$sql = $this->db->prepare("SELECT processo_inventarios.*, cad_func.nome FROM processo_inventarios INNER JOIN cad_func ON processo_inventarios.id_user = cad_func.id WHERE processo_inventarios.id = :id_inventario");
		$sql->bindValue(":id_inventario", $id_inventario);
		$sql->execute();

		return $sql->fetch(PDO::FETCH_ASSOC);
	}
	public function getInvetario2($id_inventario){
		$sql = $this->db->prepare("SELECT processo_inventarios2.*, cad_func.nome FROM processo_inventarios2 INNER JOIN cad_func ON processo_inventarios2.id_user = cad_func.id WHERE processo_inventarios2.id_inventario = :id_inventario");
		$sql->bindValue(":id_inventario", $id_inventario);
		$sql->execute();

		return $sql->fetch(PDO::FETCH_ASSOC);
	}
	public function getInvetario3($id_inventario){
		$sql = $this->db->prepare("SELECT processo_inventarios_descr.*, cad_func.nome FROM processo_inventarios_descr INNER JOIN cad_func ON processo_inventarios_descr.id_user = cad_func.id WHERE processo_inventarios_descr.id_inventario = :id_inventario");
		$sql->bindValue(":id_inventario", $id_inventario);
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}

	public function getDiario($num_processo){

		$sql = $this->db->prepare("SELECT processo_diario.*, cad_func.nome FROM processo_diario INNER JOIN cad_func ON processo_diario.id_user = cad_func.id WHERE num_processo = :num_processo");
			$sql->bindValue(":num_processo", $num_processo);
			$sql->execute();

			return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	public function delDiario($id){

		$sql = $this->db->prepare("DELETE FROM processo_diario WHERE id = :id");
			$sql->bindValue(":id", $id);
			$sql->execute();

			return true;
	}


	public function getFuncID($id){
		$sql = $this->db->prepare("SELECT * FROM cad_func WHERE id = :id");
		$sql->bindValue(":id", $id);
		$sql->execute();

		return $sql->fetch(PDO::FETCH_ASSOC);
	}
	//SELECIONAR PESSOA JURIDICA SEGURADORA
	public function getProcessos($p, $limite){
		$sql = $this->db->prepare("SELECT processos.*, (select  COUNT(processos.id) from processos) as count FROM processos ORDER BY id DESC LIMIT ".$p.", ".$limite."");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	public function getProcessosUlt(){
		$sql = $this->db->prepare("SELECT processos.num_processo FROM processos ORDER BY id DESC LIMIT 1");
		$sql->execute();

		return $sql->fetch(PDO::FETCH_ASSOC);
	}
	public function nav_tipo_doc(){
		$sql = $this->db->prepare("SELECT * FROM nav_tipo_doc");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	public function getProcesso($num_processo){
		$sql = $this->db->prepare("SELECT processos.*, cad_p_juridica.id, cad_p_juridica.razao_social, cad_p_juridica.cnpj FROM processos INNER JOIN cad_p_juridica ON processos.id_seguradora = cad_p_juridica.id WHERE num_processo = :num_processo");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->execute();

		return $sql->fetch(PDO::FETCH_ASSOC);
	}

	//PDF CERTIFICADO VISTORIA
	public function getVistoriaCompleto($num_processo){
		$sql = $this->db->prepare("SELECT processos.*, cad_p_juridica.id, cad_p_juridica.razao_social, cad_p_juridica.cnpj, cad_apolice.num_apolice, nav_ramo.ramo, nav_moeda.nome as md FROM processos INNER JOIN cad_p_juridica ON processos.id_seguradora = cad_p_juridica.id INNER JOIN cad_apolice ON processos.id_apolice = cad_apolice.id INNER JOIN nav_ramo ON processos.id_ramo = nav_ramo.id INNER JOIN nav_moeda ON processos.moeda = nav_moeda.id WHERE num_processo = :num_processo");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->execute();

		return $sql->fetch(PDO::FETCH_ASSOC);
	}
	public function nav_ramo(){
		$sql = $this->db->prepare("SELECT * FROM nav_ramo");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	public function nav_moeda(){
		$sql = $this->db->prepare("SELECT * FROM nav_moeda");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	//SELECIONAR ESFORCO PAGINA PROCESSO25.PHP
	public function getNavEsforco(){
		$sql = $this->db->prepare("SELECT * FROM nav_esforco");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	public function nav_tipo_doc2(){
		$sql = $this->db->prepare("SELECT * FROM nav_tipo_doc2");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	public function getSeguradoras(){
		$sql = $this->db->prepare("SELECT * FROM cad_p_juridica WHERE seguradora = 1");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	public function getSegurados(){
		$sql = $this->db->prepare("SELECT * FROM cad_p_juridica WHERE segurado = 1");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	public function getSeguradoid($id){
		$sql = $this->db->prepare("SELECT * FROM cad_p_juridica WHERE id = :id");
		$sql->bindValue(":id", $id);
		$sql->execute();

		return $sql->fetch(PDO::FETCH_ASSOC);
	}
	public function getContatoEmpresaid($id){
		$sql = $this->db->prepare("SELECT * FROM cad_p_fisica WHERE id_empresa = :id");
		$sql->bindValue(":id", $id);
		$sql->execute();

		return $sql->fetch(PDO::FETCH_ASSOC);
	}

	public function getApolicesProc(){
		$sql = $this->db->prepare("SELECT * FROM cad_apolice");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	public function getApolicesID($id){
		$sql = $this->db->prepare("SELECT * FROM cad_apolice WHERE id = :id");
		$sql->bindValue(":id", $id);
		$sql->execute();

		return $sql->fetch(PDO::FETCH_ASSOC);
	}
	//SELECIONAR PESSOA JURIDICA SEGURADORA
	public function getTransportadora(){
		$sql = $this->db->prepare("SELECT * FROM cad_p_juridica WHERE transportadora = 1");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	public function getTransportadoraID($id){
		$sql = $this->db->prepare("SELECT * FROM cad_p_juridica WHERE id = :id");
		$sql->bindValue(":id", $id);
		$sql->execute();

		return $sql->fetch(PDO::FETCH_ASSOC);
	}
	//SELECIONAR DEFINIÇÃO DE DESTINO
	public function nav_def_dest(){
		$sql = $this->db->prepare("SELECT * FROM nav_def_dest");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	//SELECIONAR MOTIVO DA DECISÃO
	public function nav_motivo_dec(){
		$sql = $this->db->prepare("SELECT * FROM nav_motivo_dec");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	//SELECIONAR PESSOA JURIDICA SEGURADORA
	public function getCorretora(){
		$sql = $this->db->prepare("SELECT * FROM cad_p_juridica WHERE corretora = 1");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	//SELECIONAR PESSOA JURIDICA SEGURADORA
	public function getCidades(){
		$sql = $this->db->prepare("SELECT pais.sigla, estado.uf, cidade.nome, cidade.id FROM estado INNER JOIN pais ON estado.pais = pais.id INNER JOIN cidade ON cidade.estado = estado.id ORDER BY cidade.nome ASC LIMIT 10");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	//SELECIONAR PESSOA JURIDICA SEGURADORA
	public function getCidadeID($id){
		$sql = $this->db->prepare("SELECT pais.sigla, estado.uf, cidade.nome, cidade.id FROM estado INNER JOIN pais ON estado.pais = pais.id INNER JOIN cidade ON cidade.estado = estado.id WHERE cidade.id = :id");
		$sql->bindValue(":id", $id);
		$sql->execute();

		return $sql->fetch(PDO::FETCH_ASSOC);
	}
	//EXCLUIR EVENTO
	public function delEvento($id){
		$sql = $this->db->prepare("DELETE FROM processo_evento WHERE 
			id = :id
			");
		$sql->bindValue(":id", $id);
		$sql->execute();

		return true;
	}
	//REGISTRAR EVENTO PARA HISTORICO
	public function setEventoProcesso($num_processo, $id_user, $evento){
		$sql = $this->db->prepare("INSERT INTO processo_evento SET 
			num_processo = :num_processo,
			id_user = :id_user,
			evento = :evento
			");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->bindValue(":id_user", $id_user);
		$sql->bindValue(":evento", $evento);
		$sql->execute();

		return true;
	}
	//SELECIONAR PESSOA JURIDICA SEGURADORA
	public function getEventos($num_processo){
		$sql = $this->db->prepare("SELECT processo_evento.*, cad_func.nome FROM processo_evento INNER JOIN cad_func ON processo_evento.id_user = cad_func.id WHERE processo_evento.num_processo = :num_processo");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	//TEXTO DE DIARIO
	public function getDiarioHistorico($num_processo){
		$sql = $this->db->prepare("SELECT processo_not.*, cad_func.nome FROM processo_not INNER JOIN cad_func ON processo_not.id_user = cad_func.id WHERE processo_not.num_processo = :num_processo");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	//REGISTRAR EVENTO EM DIARIO
	public function setDiarioProcesso($num_processo, $id_user, $texto){
		$sql = $this->db->prepare("INSERT INTO processo_not SET 
			num_processo = :num_processo,
			id_user = :id_user,
			texto = :texto
			");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->bindValue(":id_user", $id_user);
		$sql->bindValue(":texto", $texto);
		$sql->execute();

		return true;
	}
	//EXCLUIR EVENTO EM DIARIO
	public function delDiarioProcesso($id){
		$sql = $this->db->prepare("DELETE FROM processo_not WHERE 
			id = :id
			");
		$sql->bindValue(":id", $id);
		$sql->execute();

		return true;
	}
	//REGISTRAR PROCESSO
	public function setProcesso($num_processo, $id_seguradora, $modal_transport, $id_user){
		$sql = $this->db->prepare("INSERT INTO processos SET 
			num_processo = :num_processo,
			id_seguradora = :id_seguradora,
			modal_transport = :modal_transport,
			id_user = :id_user
			");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->bindValue(":id_seguradora", $id_seguradora);
		$sql->bindValue(":modal_transport", $modal_transport);
		$sql->bindValue(":id_user", $id_user);
		$sql->execute();

		return true;
	}
	public function upStatusProcesso($num_processo, $status){

		$sql = $this->db->prepare("UPDATE processos SET 
			status = :status
			WHERE num_processo = :num_processo
			");
		$sql->bindValue(":status", $status);
		$sql->bindValue(":num_processo", $num_processo);
		$sql->execute();

		return true;
	}
	//REGISTRAR PROCESSO PARTE 01
	public function setProcesso01($num_processo, $num_sinistro, $id_ramo, $moeda, $valor_mercadoria, $comunicante, $dt_hs_comunicado){

		$sql = $this->db->prepare("UPDATE processos SET 
				num_sinistro = :num_sinistro,
				id_ramo = :id_ramo,
				moeda = :moeda,
				valor_mercadoria = :valor_mercadoria,
				comunicante = :comunicante,
				dt_hs_comunicado = :dt_hs_comunicado 
				WHERE num_processo = :num_processo
				");
			$sql->bindValue(":num_sinistro", $num_sinistro);
			$sql->bindValue(":id_ramo", $id_ramo);
			$sql->bindValue(":moeda", $moeda);
			$sql->bindValue(":valor_mercadoria", $valor_mercadoria);
			$sql->bindValue(":comunicante", $comunicante);
			$sql->bindValue(":dt_hs_comunicado", $dt_hs_comunicado);
			$sql->bindValue(":num_processo", $num_processo);
			$sql->execute();

			return true;
	}
	//REGISTRAR PROCESSO PARTE 02
	public function setProcesso02($num_processo, $id_segurado, $id_apolice){

		$sql = $this->db->prepare("UPDATE processos SET 
			id_segurado = :id_segurado,
			id_apolice = :id_apolice 
			WHERE num_processo = :num_processo
			");
		$sql->bindValue(":id_segurado", $id_segurado);
		$sql->bindValue(":id_apolice", $id_apolice);
		$sql->bindValue(":num_processo", $num_processo);
		$sql->execute();

		return true;
	}
	//REGISTRAR PROCESSO PARTE 03
	public function setProcesso03($num_processo, $id_transportadora){
		$sql = $this->db->prepare("UPDATE processos SET 
			id_transportadora = :id_transportadora 
			WHERE num_processo = :num_processo
			");
		$sql->bindValue(":id_transportadora", $id_transportadora);
		$sql->bindValue(":num_processo", $num_processo);
		$sql->execute();

		return true;
	}
	//REGISTRAR PROCESSO PARTE 05
	public function setProcesso04($num_processo, $id_corretora){
		$sql = $this->db->prepare("UPDATE processos SET 
			id_corretora = :id_corretora 
			WHERE num_processo = :num_processo
			");
		$sql->bindValue(":id_corretora", $id_corretora);
		$sql->bindValue(":num_processo", $num_processo);
		$sql->execute();

		return true;
	}
	//REGISTRAR PROCESSO PARTE 06
	public function setProcesso05($num_processo, $cidade1, $cidade2){
		$sql = $this->db->prepare("UPDATE processos SET 
			cidade1 = :cidade1,
			cidade2 = :cidade2 
			WHERE num_processo = :num_processo
			");
		$sql->bindValue(":cidade1", $cidade1);
		$sql->bindValue(":cidade2", $cidade2);
		$sql->bindValue(":num_processo", $num_processo);
		$sql->execute();

		return true;
	}
	//BUSCAR REMETENTE NO DB
	public function getRemetente06($num_processo){
		$sql = $this->db->prepare("SELECT * FROM processo_remetente WHERE num_processo = :num_processo");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->execute();

		return $sql->fetch(PDO::FETCH_ASSOC);
	}
	//BUSCAR DESTINATARIO NO DB
	public function getDestinatario06($num_processo){
		$sql = $this->db->prepare("SELECT * FROM processo_destinatario WHERE num_processo = :num_processo");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->execute();

		return $sql->fetch(PDO::FETCH_ASSOC);
	}
	//SETANDO REMETENTE
	public function setRemetente($num_processo, $razao_social, $endereco, $responsavel, $contato, $email, $seguro_proprio){
		$sql = $this->db->prepare("INSERT INTO processo_remetente SET 
			num_processo = :num_processo,
			razao_social = :razao_social,
			endereco = :endereco,
			responsavel = :responsavel,
			contato = :contato,
			email = :email,
			seguro_proprio = :seguro_proprio
			");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->bindValue(":razao_social", $razao_social);
		$sql->bindValue(":endereco", $endereco);
		$sql->bindValue(":responsavel", $responsavel);
		$sql->bindValue(":contato", $contato);
		$sql->bindValue(":email", $email);
		$sql->bindValue(":seguro_proprio", $seguro_proprio);
		$sql->execute();

		return true;
	}
	//SETANDO REMETENTE
	public function setDestinatario($num_processo, $razao_social, $endereco, $responsavel, $contato, $email, $seguro_proprio){
		$sql = $this->db->prepare("INSERT INTO processo_destinatario SET 
			num_processo = :num_processo,
			razao_social = :razao_social,
			endereco = :endereco,
			responsavel = :responsavel,
			contato = :contato,
			email = :email,
			seguro_proprio = :seguro_proprio
			");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->bindValue(":razao_social", $razao_social);
		$sql->bindValue(":endereco", $endereco);
		$sql->bindValue(":responsavel", $responsavel);
		$sql->bindValue(":contato", $contato);
		$sql->bindValue(":email", $email);
		$sql->bindValue(":seguro_proprio", $seguro_proprio);
		$sql->execute();

		return true;
	}
	//UPDATE REMETENTE
	public function upRemetente($num_processo, $razao_social, $endereco, $responsavel, $contato, $email, $seguro_proprio){
		$sql = $this->db->prepare("UPDATE processo_remetente SET 
			razao_social = :razao_social,
			endereco = :endereco,
			responsavel = :responsavel,
			contato = :contato,
			email = :email,
			seguro_proprio = :seguro_proprio WHERE num_processo = :num_processo
			");
		$sql->bindValue(":razao_social", $razao_social);
		$sql->bindValue(":endereco", $endereco);
		$sql->bindValue(":responsavel", $responsavel);
		$sql->bindValue(":contato", $contato);
		$sql->bindValue(":email", $email);
		$sql->bindValue(":seguro_proprio", $seguro_proprio);
		$sql->bindValue(":num_processo", $num_processo);
		$sql->execute();

		return true;
	}
	//SETANDO REMETENTE
	public function upDestinatario($num_processo, $razao_social, $endereco, $responsavel, $contato, $email, $seguro_proprio){
		$sql = $this->db->prepare("UPDATE processo_destinatario SET 
			razao_social = :razao_social,
			endereco = :endereco,
			responsavel = :responsavel,
			contato = :contato,
			email = :email,
			seguro_proprio = :seguro_proprio WHERE num_processo = :num_processo
			");
		$sql->bindValue(":razao_social", $razao_social);
		$sql->bindValue(":endereco", $endereco);
		$sql->bindValue(":responsavel", $responsavel);
		$sql->bindValue(":contato", $contato);
		$sql->bindValue(":email", $email);
		$sql->bindValue(":seguro_proprio", $seguro_proprio);
		$sql->bindValue(":num_processo", $num_processo);
		$sql->execute();

		return true;
	}

	//REGISTRANDO PROCESSO PAGINA 07
	public function getDadosAcontecimento($num_processo){
		$sql = $this->db->prepare("SELECT * FROM processo_dados_acontecimento WHERE num_processo = :num_processo");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->execute();

		return $sql->fetch(PDO::FETCH_ASSOC);
	}
	//GET ATIVIDADES
	public function getAtividadesP(){
		$sql = $this->db->prepare("SELECT * FROM atividades");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	//GET ATIVIDADES
	public function getAtuacaoP(){
		$sql = $this->db->prepare("SELECT * FROM atuacao");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	//GET ATIVIDADES
	public function getEventosP(){
		$sql = $this->db->prepare("SELECT * FROM nat_eventos");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	public function setDadosAcontecimento($num_processo, $id_atividade, $id_atuacao, $id_nat_evento, $id_cidade, $dt_hs, $local_os, $pres_representante, $lc_preservado, $risco_saque, $risco_ambiental, $descricao){
		$sql = $this->db->prepare("INSERT INTO processo_dados_acontecimento SET
			num_processo = :num_processo,
			id_atividade = :id_atividade,
			id_atuacao = :id_atuacao,
			id_nat_evento = :id_nat_evento,
			id_cidade = :id_cidade,
			dt_hs = :dt_hs,
			local_os = :local_os,
			pres_representante = :pres_representante,
			lc_preservado = :lc_preservado,
			risco_saque = :risco_saque,
			risco_ambiental = :risco_ambiental,
			descricao = :descricao
			");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->bindValue(":id_atividade", $id_atividade);
		$sql->bindValue(":id_atuacao", $id_atuacao);
		$sql->bindValue(":id_nat_evento", $id_nat_evento);
		$sql->bindValue(":id_cidade", $id_cidade);
		$sql->bindValue(":dt_hs", $dt_hs);
		$sql->bindValue(":local_os", $local_os);
		$sql->bindValue(":pres_representante", $pres_representante);
		$sql->bindValue(":lc_preservado", $lc_preservado);
		$sql->bindValue(":risco_saque", $risco_saque);
		$sql->bindValue(":risco_ambiental", $risco_ambiental);
		$sql->bindValue(":descricao", $descricao);
		$sql->execute();

		return true;
	}
	public function upDadosAcontecimento($num_processo, $id_atividade, $id_atuacao, $id_nat_evento, $id_cidade, $dt_hs, $local_os, $pres_representante, $lc_preservado, $risco_saque, $risco_ambiental, $descricao){
		$sql = $this->db->prepare("UPDATE processo_dados_acontecimento SET
			id_atividade = :id_atividade,
			id_atuacao = :id_atuacao,
			id_nat_evento = :id_nat_evento,
			id_cidade = :id_cidade,
			dt_hs = :dt_hs,
			local_os = :local_os,
			pres_representante = :pres_representante,
			lc_preservado = :lc_preservado,
			risco_saque = :risco_saque,
			risco_ambiental = :risco_ambiental,
			descricao = :descricao WHERE num_processo = :num_processo");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->bindValue(":id_atividade", $id_atividade);
		$sql->bindValue(":id_atuacao", $id_atuacao);
		$sql->bindValue(":id_nat_evento", $id_nat_evento);
		$sql->bindValue(":id_cidade", $id_cidade);
		$sql->bindValue(":dt_hs", $dt_hs);
		$sql->bindValue(":local_os", $local_os);
		$sql->bindValue(":pres_representante", $pres_representante);
		$sql->bindValue(":lc_preservado", $lc_preservado);
		$sql->bindValue(":risco_saque", $risco_saque);
		$sql->bindValue(":risco_ambiental", $risco_ambiental);
		$sql->bindValue(":descricao", $descricao);
		$sql->execute();

		return true;
	}
	//PROCESSO08.PHP FOTOS PRE LIMINARES
	public function setFTPremilinar($num_processo, $img, $texto){
		$sql = $this->db->prepare("SELECT * FROM processo_img_preliminar WHERE num_processo = :num_processo");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->execute();

		if ($sql->rowCount() <= 3) {
			$sql = $this->db->prepare("INSERT INTO processo_img_preliminar SET 
				num_processo = :num_processo,
				img = :img,
				texto = :texto
				");
			$sql->bindValue(":num_processo", $num_processo);
			$sql->bindValue(":img", $img);
			$sql->bindValue(":texto", $texto);
			$sql->execute();

			return true;
		} else {
			return false;
		}
	}
	//processoftSinistro.php
	public function setFTSinistro($num_processo, $img, $texto){
		$sql = $this->db->prepare("INSERT INTO processo_img_sinistro SET 
				num_processo = :num_processo,
				img = :img,
				texto = :texto
				");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->bindValue(":img", $img);
		$sql->bindValue(":texto", $texto);
		$sql->execute();

		return true;
	}
	public function getFTSinistro($num_processo){
		$sql = $this->db->prepare("SELECT * FROM processo_img_sinistro WHERE num_processo = :num_processo");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	public function delFTSinistro($id){
		$sql = $this->db->prepare("DELETE FROM processo_img_sinistro WHERE id = :id");
		$sql->bindValue(":id", $id);
		$sql->execute();

		return true;
	}
	public function getFTSinistroID($id){
		$sql = $this->db->prepare("SELECT img FROM processo_img_sinistro WHERE id = :id");
		$sql->bindValue(":id", $id);
		$sql->execute();

		return $sql->fetch(PDO::FETCH_ASSOC);
	}

	//processoftSalvados.php
	public function setFTSalvados($num_processo, $img, $texto){
		$sql = $this->db->prepare("INSERT INTO processo_img_salvados SET 
				num_processo = :num_processo,
				img = :img,
				texto = :texto
				");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->bindValue(":img", $img);
		$sql->bindValue(":texto", $texto);
		$sql->execute();

		return true;
	}
	public function getFTSalvadosID($id){
		$sql = $this->db->prepare("SELECT img FROM processo_img_salvados WHERE id = :id");
		$sql->bindValue(":id", $id);
		$sql->execute();

		return $sql->fetch(PDO::FETCH_ASSOC);
	}
	public function getFTSalvados($num_processo){
		$sql = $this->db->prepare("SELECT * FROM processo_img_salvados WHERE num_processo = :num_processo");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	public function delFTSalvados($id){
		$sql = $this->db->prepare("DELETE FROM processo_img_salvados WHERE id = :id");
		$sql->bindValue(":id", $id);
		$sql->execute();

		return true;
	}

	//SELECIONAR IMG DO BANCO DE DADOS
	public function getFTPreliminar($num_processo){
		$sql = $this->db->prepare("
			SELECT processo_img_preliminar.*, 
			(select count(id) from processo_img_preliminar WHERE num_processo = :num_processo) as count 
			FROM processo_img_preliminar 
			WHERE num_processo = :num_processo");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	//SELECIONAR IMG DO BANCO DE DADOS
	public function getFTPreliminarID($id){
		$sql = $this->db->prepare("SELECT img FROM processo_img_preliminar WHERE id = :id");
		$sql->bindValue(":id", $id);
		$sql->execute();

		return $sql->fetch(PDO::FETCH_ASSOC);
	}
	//DELETENADO IMAGEM DE DOCUMENTO EM PROCESSO
	public function delFTpreliminar($id){
		$sql = $this->db->prepare("DELETE FROM processo_img_preliminar WHERE id = :id");
		$sql->bindValue(":id", $id);
		$sql->execute();

		return true;
	}

	//PAGINA PROCESSO09.PHP
	public function getRegPolicial($num_processo){
		$sql = $this->db->prepare("SELECT * FROM processo_reg_policial WHERE num_processo = :num_processo");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->execute();

		return $sql->fetch(PDO::FETCH_ASSOC);
	}
	public function setRegPolicial($num_processo, $orgao_acidente, $num_acidente, $orgao_saque, $num_saque, $inquerito, $investigacao){
		$sql = $this->db->prepare("INSERT INTO processo_reg_policial SET
			num_processo = :num_processo,
			orgao_acidente = :orgao_acidente,
			num_acidente = :num_acidente,
			orgao_saque = :orgao_saque,
			num_saque = :num_saque,
			inquerito = :inquerito,
			investigacao = :investigacao
			");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->bindValue(":orgao_acidente", $orgao_acidente);
		$sql->bindValue(":num_acidente", $num_acidente);
		$sql->bindValue(":orgao_saque", $orgao_saque);
		$sql->bindValue(":num_saque", $num_saque);
		$sql->bindValue(":inquerito", $inquerito);
		$sql->bindValue(":investigacao", $investigacao);
		$sql->execute();

		return true;
	}
	public function upRegPolicial($num_processo, $orgao_acidente, $num_acidente, $orgao_saque, $num_saque, $inquerito, $investigacao){
		$sql = $this->db->prepare("UPDATE processo_reg_policial SET
			orgao_acidente = :orgao_acidente,
			num_acidente = :num_acidente,
			orgao_saque = :orgao_saque,
			num_saque = :num_saque,
			inquerito = :inquerito,
			investigacao = :investigacao WHERE num_processo = :num_processo
			");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->bindValue(":orgao_acidente", $orgao_acidente);
		$sql->bindValue(":num_acidente", $num_acidente);
		$sql->bindValue(":orgao_saque", $orgao_saque);
		$sql->bindValue(":num_saque", $num_saque);
		$sql->bindValue(":inquerito", $inquerito);
		$sql->bindValue(":investigacao", $investigacao);
		$sql->execute();

		return true;
	}
	public function upMidia($num_processo, $midia){
		$sql = $this->db->prepare("UPDATE processo_reg_policial SET
			midia = :midia WHERE num_processo = :num_processo
			");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->bindValue(":midia", $midia);
		$sql->execute();

		return true;
	}

	//PAGINA PROCESSO11.PHP
	public function getDanosMerc($num_processo){
		$sql = $this->db->prepare("SELECT * FROM processo_danos_merc WHERE num_processo = :num_processo");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->execute();

		return $sql->fetch(PDO::FETCH_ASSOC);
	}
	//GET MERCADORIAS
	public function getMercadoriasP(){
		$sql = $this->db->prepare("SELECT * FROM nav_mercadoria");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	//GET EMBALAGENS
	public function getEmbalagemP(){
		$sql = $this->db->prepare("SELECT * FROM nav_embalagem");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	//GET UNIDADES DE MEDIDAS
	public function getMedidaP(){
		$sql = $this->db->prepare("SELECT * FROM nav_unidade");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	//GET STATUS MERCADORIA
	public function getStatusMerP(){
		$sql = $this->db->prepare("SELECT * FROM nav_status_mercadoria");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	//GET STATUS MERCADORIA
	public function getStatus(){
		$sql = $this->db->prepare("SELECT * FROM nav_status");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	//GET STATUS EMBALAGEM
	public function getStatusEmbP(){
		$sql = $this->db->prepare("SELECT * FROM nav_status_embalagem");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	public function setDanosMercadoriaP($num_processo, $id_tipo_merc, $descricao, $id_tipo_emb1, $id_tipo_emb2, $qt_vol, $id_uni_medida, $peso, $id_status_merc1, $id_status_merc2, $id_status_merc3, $id_status_merc4, $id_status_emb1, $id_status_emb2, $id_status_emb3, $id_status_emb4, $nr_onu, $nr_risco, $class_risco, $class_embalagem){
		$sql = $this->db->prepare("INSERT INTO processo_danos_merc SET
			num_processo = :num_processo,
			id_tipo_merc = :id_tipo_merc,
			descricao = :descricao,
			id_tipo_emb1 = :id_tipo_emb1,
			id_tipo_emb2 = :id_tipo_emb2,
			qt_vol = :qt_vol,
			id_uni_medida = :id_uni_medida,
			peso = :peso,
			id_status_merc1 = :id_status_merc1,
			id_status_merc2 = :id_status_merc2,
			id_status_merc3 = :id_status_merc3,
			id_status_merc4 = :id_status_merc1,
			id_status_emb1 = :id_status_emb1,
			id_status_emb2 = :id_status_emb2,
			id_status_emb3 = :id_status_emb3,
			id_status_emb4 = :id_status_emb4,
			nr_onu = :nr_onu,
			nr_risco = :nr_risco,
			class_risco = :class_risco,
			class_embalagem = :class_embalagem
			");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->bindValue(":id_tipo_merc", $id_tipo_merc);
		$sql->bindValue(":descricao", $descricao);
		$sql->bindValue(":id_tipo_emb1", $id_tipo_emb1);
		$sql->bindValue(":id_tipo_emb2", $id_tipo_emb2);
		$sql->bindValue(":qt_vol", $qt_vol);
		$sql->bindValue(":id_uni_medida", $id_uni_medida);
		$sql->bindValue(":peso", $peso);
		$sql->bindValue(":id_status_merc1", $id_status_merc1);
		$sql->bindValue(":id_status_merc2", $id_status_merc2);
		$sql->bindValue(":id_status_merc3", $id_status_merc3);
		$sql->bindValue(":id_status_merc3", $id_status_merc3);
		$sql->bindValue(":id_status_emb1", $id_status_emb1);
		$sql->bindValue(":id_status_emb2", $id_status_emb2);
		$sql->bindValue(":id_status_emb3", $id_status_emb3);
		$sql->bindValue(":id_status_emb4", $id_status_emb4);
		$sql->bindValue(":nr_onu", $nr_onu);
		$sql->bindValue(":nr_risco", $nr_risco);
		$sql->bindValue(":class_risco", $class_risco);
		$sql->bindValue(":class_embalagem", $class_embalagem);
		$sql->execute();

		return true;
	}
	public function upDanosMercadoriaP($num_processo, $id_tipo_merc, $descricao, $id_tipo_emb1, $id_tipo_emb2, $qt_vol, $id_uni_medida, $peso, $id_status_merc1, $id_status_merc2, $id_status_merc3, $id_status_merc4, $id_status_emb1, $id_status_emb2, $id_status_emb3, $id_status_emb4, $nr_onu, $nr_risco, $class_risco, $class_embalagem){
		$sql = $this->db->prepare("UPDATE processo_danos_merc SET
			id_tipo_merc = :id_tipo_merc,
			descricao = :descricao,
			id_tipo_emb1 = :id_tipo_emb1,
			id_tipo_emb2 = :id_tipo_emb2,
			qt_vol = :qt_vol,
			id_uni_medida = :id_uni_medida,
			peso = :peso,
			id_status_merc1 = :id_status_merc1,
			id_status_merc2 = :id_status_merc2,
			id_status_merc3 = :id_status_merc3,
			id_status_merc4 = :id_status_merc4,
			id_status_emb1 = :id_status_emb1,
			id_status_emb2 = :id_status_emb2,
			id_status_emb3 = :id_status_emb3,
			id_status_emb4 = :id_status_emb4,
			nr_onu = :nr_onu,
			nr_risco = :nr_risco,
			class_risco = :class_risco,
			class_embalagem = :class_embalagem WHERE num_processo = :num_processo
			");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->bindValue(":id_tipo_merc", $id_tipo_merc);
		$sql->bindValue(":descricao", $descricao);
		$sql->bindValue(":id_tipo_emb1", $id_tipo_emb1);
		$sql->bindValue(":id_tipo_emb2", $id_tipo_emb2);
		$sql->bindValue(":qt_vol", $qt_vol);
		$sql->bindValue(":id_uni_medida", $id_uni_medida);
		$sql->bindValue(":peso", $peso);
		$sql->bindValue(":id_status_merc1", $id_status_merc1);
		$sql->bindValue(":id_status_merc2", $id_status_merc2);
		$sql->bindValue(":id_status_merc3", $id_status_merc3);
		$sql->bindValue(":id_status_merc4", $id_status_merc4);
		$sql->bindValue(":id_status_emb1", $id_status_emb1);
		$sql->bindValue(":id_status_emb2", $id_status_emb2);
		$sql->bindValue(":id_status_emb3", $id_status_emb3);
		$sql->bindValue(":id_status_emb4", $id_status_emb4);
		$sql->bindValue(":nr_onu", $nr_onu);
		$sql->bindValue(":nr_risco", $nr_risco);
		$sql->bindValue(":class_risco", $class_risco);
		$sql->bindValue(":class_embalagem", $class_embalagem);
		$sql->execute();

		return true;
	}

	//PAGINA PROCESSO12.PHP
	public function setDanosContainerP($num_processo, $num_registro, $armador, $ano_fabricacao, $modelo, $danos, $valor_averbado, $valor_depreciado, $valor_reparo, $lacres){
		$sql = $this->db->prepare("INSERT INTO processo_dados_container SET
			num_processo = :num_processo,
			num_registro = :num_registro,
			armador = :armador,
			ano_fabricacao = :ano_fabricacao,
			modelo = :modelo,
			danos = :danos,
			valor_averbado = :valor_averbado,
			valor_depreciado = :valor_depreciado,
			valor_reparo = :valor_reparo,
			lacres = :lacres
			");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->bindValue(":num_registro", $num_registro);
		$sql->bindValue(":armador", $armador);
		$sql->bindValue(":ano_fabricacao", $ano_fabricacao);
		$sql->bindValue(":modelo", $modelo);
		$sql->bindValue(":danos", $danos);
		$sql->bindValue(":valor_averbado", $valor_averbado);
		$sql->bindValue(":valor_depreciado", $valor_depreciado);
		$sql->bindValue(":valor_reparo", $valor_reparo);
		$sql->bindValue(":lacres", $lacres);
		$sql->execute();

		return true;
	}
	//GET DADOS CONTAINER
	public function getDnContainerP($num_processo){
		$sql = $this->db->prepare("SELECT processo_dados_container.*, nav_avarias.dano FROM processo_dados_container INNER JOIN nav_avarias ON processo_dados_container.danos = nav_avarias.id WHERE num_processo = :num_processo");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	//GET AVARIAS/DANOS
	public function getNavAvarias(){
		$sql = $this->db->prepare("SELECT * FROM nav_avarias");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	//GET TIPO DE FRETE
	public function getNavFrete(){
		$sql = $this->db->prepare("SELECT * FROM nav_frete");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	//GET TIPO PREJUIZO
	public function getNavPrejuizo(){
		$sql = $this->db->prepare("SELECT * FROM nav_tipo_prejuizo");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	//DELET DADOS CONTAINER
	public function delDadosContainerP($id){
		$sql = $this->db->prepare("DELETE FROM processo_dados_container WHERE id = :id");
		$sql->bindValue(":id", $id);
		$sql->execute();

		return true;
	}
	public function upDanosContainerP($id, $num_registro, $armador, $ano_fabricacao, $modelo, $danos, $valor_averbado, $valor_depreciado, $valor_reparo, $lacres){
		$sql = $this->db->prepare("UPDATE processo_dados_container SET
			num_registro = :num_registro,
			armador = :armador,
			ano_fabricacao = :ano_fabricacao,
			modelo = :modelo,
			danos = :danos,
			valor_averbado = :valor_averbado,
			valor_depreciado = :valor_depreciado,
			valor_reparo = :valor_reparo,
			lacres = :lacres WHERE id = :id
			");
		$sql->bindValue(":id", $id);
		$sql->bindValue(":num_registro", $num_registro);
		$sql->bindValue(":armador", $armador);
		$sql->bindValue(":ano_fabricacao", $ano_fabricacao);
		$sql->bindValue(":modelo", $modelo);
		$sql->bindValue(":danos", $danos);
		$sql->bindValue(":valor_averbado", $valor_averbado);
		$sql->bindValue(":valor_depreciado", $valor_depreciado);
		$sql->bindValue(":valor_reparo", $valor_reparo);
		$sql->bindValue(":lacres", $lacres);
		$sql->execute();

		return true;
	}

	//PAGINA PROCESSO13.PHP
	public function setDocMercP($num_processo, $tipo_doc, $num_doc, $id_moeda, $valor, $efeito_seguro, $valor_efeito){
		$sql = $this->db->prepare("INSERT INTO processo_doc_merc SET
			num_processo = :num_processo,
			tipo_doc = :tipo_doc,
			num_doc = :num_doc,
			id_moeda = :id_moeda,
			valor = :valor,
			efeito_seguro = :efeito_seguro,
			valor_efeito = :valor_efeito
			");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->bindValue(":tipo_doc", $tipo_doc);
		$sql->bindValue(":num_doc", $num_doc);
		$sql->bindValue(":id_moeda", $id_moeda);
		$sql->bindValue(":valor", $valor);
		$sql->bindValue(":efeito_seguro", $efeito_seguro);
		$sql->bindValue(":valor_efeito", $valor_efeito);
		$sql->execute();

		return true;
	}
	public function getDocMercP($num_processo){
		$sql = $this->db->prepare("SELECT processo_doc_merc.*, nav_moeda.nome, nav_tipo_doc.tipo_doc as nome_cod FROM processo_doc_merc INNER JOIN nav_moeda ON processo_doc_merc.id_moeda = nav_moeda.id INNER JOIN nav_tipo_doc ON processo_doc_merc.tipo_doc = nav_tipo_doc.id WHERE num_processo = :num_processo");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	public function delDocMercP($id){
		$sql = $this->db->prepare("DELETE FROM processo_doc_merc WHERE id = :id");
		$sql->bindValue(":id", $id);
		$sql->execute();

		return true;
	}
	public function upDocMercP($id, $tipo_doc, $num_doc, $id_moeda, $valor, $efeito_seguro, $valor_efeito){
		$sql = $this->db->prepare("UPDATE processo_doc_merc SET
			tipo_doc = :tipo_doc,
			num_doc = :num_doc,
			id_moeda = :id_moeda,
			valor = :valor,
			efeito_seguro = :efeito_seguro,
			valor_efeito = :valor_efeito WHERE id = :id
			");
		$sql->bindValue(":id", $id);
		$sql->bindValue(":tipo_doc", $tipo_doc);
		$sql->bindValue(":num_doc", $num_doc);
		$sql->bindValue(":id_moeda", $id_moeda);
		$sql->bindValue(":valor", $valor);
		$sql->bindValue(":efeito_seguro", $efeito_seguro);
		$sql->bindValue(":valor_efeito", $valor_efeito);
		$sql->execute();

		return true;
	}
	public function getInforP($num_processo){
		$sql = $this->db->prepare("SELECT * FROM processo_infor_comp WHERE num_processo = :num_processo");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->execute();

		return $sql->fetch(PDO::FETCH_ASSOC);
	}
	public function setInforP($num_processo, $informacao){
		$sql = $this->db->prepare("INSERT INTO processo_infor_comp SET
			num_processo = :num_processo,
			informacao = :informacao
			");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->bindValue(":informacao", $informacao);
		$sql->execute();

		return true;
	}
	public function upInforP($num_processo, $informacao){
		$sql = $this->db->prepare("UPDATE processo_infor_comp SET
			informacao = :informacao WHERE num_processo = :num_processo
			");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->bindValue(":informacao", $informacao);
		$sql->execute();

		return true;
	}

	//PAGINA PROCESSO14.PHP
	public function getform1P14($num_processo){
		$sql = $this->db->prepare("SELECT * FROM processo_doc_trans1 WHERE num_processo = :num_processo");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->execute();

		return $sql->fetch(PDO::FETCH_ASSOC);
	}
	public function setDocForm1($num_processo, $rntrc, $frete){
		$sql = $this->db->prepare("INSERT INTO processo_doc_trans1 SET 
			num_processo = :num_processo,
			rntrc = :rntrc,
			frete = :frete
			");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->bindValue(":rntrc", $rntrc);
		$sql->bindValue(":frete", $frete);
		$sql->execute();

		return true;
	}
	public function upDocForm1($num_processo, $rntrc, $frete){
		$sql = $this->db->prepare("UPDATE processo_doc_trans1 SET 
			rntrc = :rntrc,
			frete = :frete WHERE num_processo = :num_processo
			");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->bindValue(":rntrc", $rntrc);
		$sql->bindValue(":frete", $frete);
		$sql->execute();

		return true;
	}
	public function getDocForm2($num_processo){
		$sql = $this->db->prepare("SELECT processo_doc_trans2.*, nav_moeda.nome, nav_tipo_doc2.tipo_doc as nome_cod FROM processo_doc_trans2 INNER JOIN nav_moeda ON processo_doc_trans2.id_moeda = nav_moeda.id INNER JOIN nav_tipo_doc2 ON processo_doc_trans2.tipo_doc = nav_tipo_doc2.id WHERE num_processo = :num_processo");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	public function setDocForm2($num_processo, $tipo_doc, $num_doc, $id_moeda, $nrtrc, $valor, $efeito_seguro, $valor_efeito){
		$sql = $this->db->prepare("INSERT INTO processo_doc_trans2 SET
			num_processo = :num_processo,
			tipo_doc = :tipo_doc,
			num_doc = :num_doc,
			id_moeda = :id_moeda,
			nrtrc = :nrtrc,
			valor = :valor,
			efeito_seguro = :efeito_seguro,
			valor_efeito = :valor_efeito
			");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->bindValue(":tipo_doc", $tipo_doc);
		$sql->bindValue(":num_doc", $num_doc);
		$sql->bindValue(":id_moeda", $id_moeda);
		$sql->bindValue(":nrtrc", $nrtrc);
		$sql->bindValue(":valor", $valor);
		$sql->bindValue(":efeito_seguro", $efeito_seguro);
		$sql->bindValue(":valor_efeito", $valor_efeito);

		$sql->execute();

		return true;
	}
	public function upDocForm2($id, $tipo_doc, $num_doc, $id_moeda, $nrtrc, $valor, $efeito_seguro, $valor_efeito){
		$sql = $this->db->prepare("UPDATE processo_doc_trans2 SET
			tipo_doc = :tipo_doc,
			num_doc = :num_doc,
			id_moeda = :id_moeda,
			nrtrc = :nrtrc,
			valor = :valor,
			efeito_seguro = :efeito_seguro,
			valor_efeito = :valor_efeito WHERE id = :id
			");
		$sql->bindValue(":id", $id);
		$sql->bindValue(":tipo_doc", $tipo_doc);
		$sql->bindValue(":num_doc", $num_doc);
		$sql->bindValue(":id_moeda", $id_moeda);
		$sql->bindValue(":nrtrc", $nrtrc);
		$sql->bindValue(":valor", $valor);
		$sql->bindValue(":efeito_seguro", $efeito_seguro);
		$sql->bindValue(":valor_efeito", $valor_efeito);
		$sql->execute();

		return true;
	}
	public function delDocForm2($id){
		$sql = $this->db->prepare("DELETE FROM processo_doc_trans2 WHERE id = :id");
		$sql->bindValue(":id", $id);
		$sql->execute();

		return true;
	}

	//PAGINA PROCESSO15.PHP
	public function getNavProcesso15(){
		$sql = $this->db->prepare("SELECT * FROM nav_processo15");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	public function getP15($num_processo){
		$sql = $this->db->prepare("SELECT * FROM processo15 WHERE num_processo = :num_processo");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->execute();

		return $sql->fetch(PDO::FETCH_ASSOC);
	}
	public function setProcesso15($num_processo, $post){
		$fields = implode(', ', array_keys($post));
		$keys = ':' . implode(', :', array_keys($post));
		$sql = $this->db->prepare("INSERT INTO processo15 
			(num_processo, {$fields}) VALUES (:num_processo, {$keys})");

		$sql->bindValue(":num_processo", $num_processo);
		foreach ($post as $key => $value) {
            $sql->bindValue(":{$key}", $value);
        }
		
		$sql->execute();

		return true;
	}
	public function upProcesso15($num_processo, $post){
		$fields = [];
        foreach ($post as $key => $value) {
            $fields[] = "$key=:$key";
        }
        $fields = implode(', ', $fields);
		$sql = $this->db->prepare("UPDATE processo15 SET {$fields} WHERE num_processo = :num_processo");

		$sql->bindValue(":num_processo", $num_processo);
		foreach ($post as $key => $value) {
            $sql->bindValue(":{$key}", $value);
        }
		$sql->execute();

		return true;
	}
	//PAGINA PROCESSO16.PHP
	public function getP16($num_processo){
		$sql = $this->db->prepare("SELECT * FROM processo16 WHERE num_processo = :num_processo");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->execute();

		return $sql->fetch(PDO::FETCH_ASSOC);
	}
	public function setProcesso16($num_processo, $post){
		$fields = implode(', ', array_keys($post));
		$keys = ':' . implode(', :', array_keys($post));
		$sql = $this->db->prepare("INSERT INTO processo16 
			(num_processo, {$fields}) VALUES (:num_processo, {$keys})");

		$sql->bindValue(":num_processo", $num_processo);
		foreach ($post as $key => $value) {
            $sql->bindValue(":{$key}", $value);
        }
		
		$sql->execute();

		return true;
	}
	public function nav_processo16(){
		$sql = $this->db->prepare("SELECT * FROM nav_processo16");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	public function nav_processo16_1(){
		$sql = $this->db->prepare("SELECT * FROM nav_processo16_1");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	public function nav_processo16_2(){
		$sql = $this->db->prepare("SELECT * FROM nav_processo16_2");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}

	//PAGINA PROCESSO17.PHP
	public function getP17form1($num_processo){
		$sql = $this->db->prepare("SELECT * FROM processo_17_form1 WHERE num_processo = :num_processo");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->execute();

		return $sql->fetch(PDO::FETCH_ASSOC);
	}
	public function setP17form1($num_processo, $post){
		$fields = implode(', ', array_keys($post));
		$keys = ':' . implode(', :', array_keys($post));
		$sql = $this->db->prepare("INSERT INTO processo_17_form1 
			(num_processo, {$fields}) VALUES (:num_processo, {$keys})");

		$sql->bindValue(":num_processo", $num_processo);
		foreach ($post as $key => $value) {
            $sql->bindValue(":{$key}", $value);
        }
		
		$sql->execute();

		return true;
	}
	public function upP17form1($num_processo, $post){
		$fields = [];
        foreach ($post as $key => $value) {
            $fields[] = "$key=:$key";
        }
        $fields = implode(', ', $fields);
		$sql = $this->db->prepare("UPDATE processo_17_form1 SET {$fields} WHERE num_processo = :num_processo");

		$sql->bindValue(":num_processo", $num_processo);
		foreach ($post as $key => $value) {
            $sql->bindValue(":{$key}", $value);
        }
		$sql->execute();

		return true;
	}
	public function getP17form2($num_processo){
		$sql = $this->db->prepare("SELECT * FROM processo_17_form2 WHERE num_processo = :num_processo");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->execute();

		return $sql->fetch(PDO::FETCH_ASSOC);
	}
	public function setP17form2($num_processo, $post){
		$fields = implode(', ', array_keys($post));
		$keys = ':' . implode(', :', array_keys($post));
		$sql = $this->db->prepare("INSERT INTO processo_17_form2 
			(num_processo, {$fields}) VALUES (:num_processo, {$keys})");

		$sql->bindValue(":num_processo", $num_processo);
		foreach ($post as $key => $value) {
            $sql->bindValue(":{$key}", $value);
        }
		
		$sql->execute();

		return true;
	}
	public function upP17form2($num_processo, $post){
		$fields = [];
        foreach ($post as $key => $value) {
            $fields[] = "$key=:$key";
        }
        $fields = implode(', ', $fields);
		$sql = $this->db->prepare("UPDATE processo_17_form2 SET {$fields} WHERE num_processo = :num_processo");

		$sql->bindValue(":num_processo", $num_processo);
		foreach ($post as $key => $value) {
            $sql->bindValue(":{$key}", $value);
        }
		$sql->execute();

		return true;
	}

	//PAGINA PROCESSO18.PHP
	public function processo18_form1($num_processo){
		$sql = $this->db->prepare("SELECT * FROM processo18_form1 WHERE num_processo = :num_processo");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->execute();

		return $sql->fetch(PDO::FETCH_ASSOC);
	}
	public function processo18_form2($num_processo){
		$sql = $this->db->prepare("SELECT * FROM processo18_form2 WHERE num_processo = :num_processo");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->execute();

		return $sql->fetch(PDO::FETCH_ASSOC);
	}
	public function setProcesso18($num_processo, $post){
		$fields = implode(', ', array_keys($post));
		$keys = ':' . implode(', :', array_keys($post));
		$sql = $this->db->prepare("INSERT INTO processo18_form1 
			(num_processo, {$fields}) VALUES (:num_processo, {$keys})");

		$sql->bindValue(":num_processo", $num_processo);
		foreach ($post as $key => $value) {
            $sql->bindValue(":{$key}", $value);
        }
		
		$sql->execute();

		return true;
	}
	public function upProcesso18($num_processo, $post){
		$fields = [];
        foreach ($post as $key => $value) {
            $fields[] = "$key=:$key";
        }
        $fields = implode(', ', $fields);
		$sql = $this->db->prepare("UPDATE processo18_form1 SET {$fields} WHERE num_processo = :num_processo");

		$sql->bindValue(":num_processo", $num_processo);
		foreach ($post as $key => $value) {
            $sql->bindValue(":{$key}", $value);
        }
		$sql->execute();

		return true;
	}
	public function upProcesso18form2($num_processo, $post){
		$fields = [];
        foreach ($post as $key => $value) {
            $fields[] = "$key=:$key";
        }
        $fields = implode(', ', $fields);
		$sql = $this->db->prepare("UPDATE processo18_form2 SET {$fields} WHERE num_processo = :num_processo");

		$sql->bindValue(":num_processo", $num_processo);
		foreach ($post as $key => $value) {
            $sql->bindValue(":{$key}", $value);
        }
		$sql->execute();

		return true;
	}
	public function setProcesso18form2($num_processo, $post){
		$fields = implode(', ', array_keys($post));
		$keys = ':' . implode(', :', array_keys($post));
		$sql = $this->db->prepare("INSERT INTO processo18_form2 
			(num_processo, {$fields}) VALUES (:num_processo, {$keys})");

		$sql->bindValue(":num_processo", $num_processo);
		foreach ($post as $key => $value) {
            $sql->bindValue(":{$key}", $value);
        }
		
		$sql->execute();

		return true;
	}

	//PAGINA PROCESSO19.PHP
	public function getTercForm($num_processo){
		$sql = $this->db->prepare("SELECT * FROM processo_terc_env WHERE num_processo = :num_processo");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->execute();

		return $sql->fetch(PDO::FETCH_ASSOC);
	}
	public function setTercEnvolvido($num_processo, $terc_env, $dec_terc, $terc_culp, $dados_terc, $ressarc, $rel_compl){
		$sql = $this->db->prepare("INSERT INTO processo_terc_env SET
			num_processo = :num_processo,
			terc_env = :terc_env,
			dec_terc = :dec_terc,
			terc_culp = :terc_culp,
			dados_terc = :dados_terc,
			ressarc = :ressarc,
			rel_compl = :rel_compl
			");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->bindValue(":terc_env", $terc_env);
		$sql->bindValue(":dec_terc", $dec_terc);
		$sql->bindValue(":terc_culp", $terc_culp);
		$sql->bindValue(":dados_terc", $dados_terc);
		$sql->bindValue(":ressarc", $ressarc);
		$sql->bindValue(":rel_compl", $rel_compl);
		$sql->execute();

		return true;
	}
	public function upTercEnvolvido($num_processo, $terc_env, $dec_terc, $terc_culp, $dados_terc, $ressarc, $rel_compl){
		$sql = $this->db->prepare("UPDATE processo_terc_env SET
			terc_env = :terc_env,
			dec_terc = :dec_terc,
			terc_culp = :terc_culp,
			dados_terc = :dados_terc,
			ressarc = :ressarc,
			rel_compl = :rel_compl WHERE num_processo = :num_processo
			");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->bindValue(":terc_env", $terc_env);
		$sql->bindValue(":dec_terc", $dec_terc);
		$sql->bindValue(":terc_culp", $terc_culp);
		$sql->bindValue(":dados_terc", $dados_terc);
		$sql->bindValue(":ressarc", $ressarc);
		$sql->bindValue(":rel_compl", $rel_compl);
		$sql->execute();

		return true;
	}
	public function upProcesso16($num_processo, $post){
		$fields = [];
        foreach ($post as $key => $value) {
            $fields[] = "$key=:$key";
        }
        $fields = implode(', ', $fields);
		$sql = $this->db->prepare("UPDATE processo16 SET {$fields} WHERE num_processo = :num_processo");

		$sql->bindValue(":num_processo", $num_processo);
		foreach ($post as $key => $value) {
            $sql->bindValue(":{$key}", $value);
        }
		$sql->execute();

		return true;
	}

	//PAGINA PROCESSO20.PHP
	public function getApPv($num_processo){
		$sql = $this->db->prepare("SELECT * FROM processo_apur_provi WHERE num_processo = :num_processo");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->execute();

		return $sql->fetch(PDO::FETCH_ASSOC);
	}
	public function setApProv($num_processo, $apurados, $providencias){
		$sql = $this->db->prepare("INSERT INTO processo_apur_provi SET 
			num_processo = :num_processo,
			apurados = :apurados,
			providencias = :providencias
			");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->bindValue(":apurados", $apurados);
		$sql->bindValue(":providencias", $providencias);
		$sql->execute();

		return true;
	}
	public function upApProv($num_processo, $apurados, $providencias){
		$sql = $this->db->prepare("UPDATE processo_apur_provi SET 
			apurados = :apurados,
			providencias = :providencias WHERE num_processo = :num_processo
			");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->bindValue(":apurados", $apurados);
		$sql->bindValue(":providencias", $providencias);
		$sql->execute();

		return true;
	}

	//PROCESSO PAGINA21.PHP
	public function getFTreposrtagem($num_processo){
		$sql = $this->db->prepare("SELECT * FROM processo_report_ft WHERE num_processo = :num_processo ORDER BY id ASC");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	public function setFTreportagem($num_processo, $img, $texto){
		$sql = $this->db->prepare("INSERT INTO processo_report_ft SET 
			num_processo = :num_processo,
			img = :img,
			texto = :texto
			");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->bindValue(":img", $img);
		$sql->bindValue(":texto", $texto);
		$sql->execute();

		return true;
	}
	//SELECIONAR IMG DO BANCO DE DADOS
	public function getFTreportagem($id){
		$sql = $this->db->prepare("SELECT img FROM processo_report_ft WHERE id = :id");
		$sql->bindValue(":id", $id);
		$sql->execute();

		return $sql->fetch(PDO::FETCH_ASSOC);
	}
	//DELETENADO IMAGEM DE DOCUMENTO EM PROCESSO
	public function delFTreportagem($id){
		$sql = $this->db->prepare("DELETE FROM processo_report_ft WHERE id = :id");
		$sql->bindValue(":id", $id);
		$sql->execute();

		return true;
	}

	//PAGINA PROCESSO22.PHP
	public function getDetVistoria($num_processo){
		$sql = $this->db->prepare("SELECT * FROM processo_det_vistoria WHERE num_processo = :num_processo");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->execute();

		return $sql->fetch(PDO::FETCH_ASSOC);
	}
	public function setDetVistoria($num_processo, $detalhes){
		$sql = $this->db->prepare("INSERT INTO processo_det_vistoria SET 
			num_processo = :num_processo,
			detalhes = :detalhes
			");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->bindValue(":detalhes", $detalhes);
		$sql->execute();

		return true;
	}
	public function upDetVistoria($num_processo, $detalhes){
		$sql = $this->db->prepare("UPDATE processo_det_vistoria SET 
			detalhes = :detalhes WHERE num_processo = :num_processo
			");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->bindValue(":detalhes", $detalhes);
		$sql->execute();

		return true;
	}

	//PROCESSO PAGINA23.PHP
	public function getFTvistoria($num_processo){
		$sql = $this->db->prepare("SELECT * FROM processo_vistoria_img WHERE num_processo = :num_processo ORDER BY id ASC");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	public function setFTvistoria($num_processo, $img, $texto){
		$sql = $this->db->prepare("INSERT INTO processo_vistoria_img SET 
			num_processo = :num_processo,
			img = :img,
			texto = :texto
			");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->bindValue(":img", $img);
		$sql->bindValue(":texto", $texto);
		$sql->execute();

		return true;
	}
	public function getFTvistoriaID($id){
		$sql = $this->db->prepare("SELECT img FROM processo_vistoria_img WHERE id = :id");
		$sql->bindValue(":id", $id);
		$sql->execute();

		return $sql->fetch(PDO::FETCH_ASSOC);
	}
	public function delFTvistoria($id){
		$sql = $this->db->prepare("DELETE FROM processo_vistoria_img WHERE id = :id");
		$sql->bindValue(":id", $id);
		$sql->execute();

		return true;
	}

	//PROCESSO PAGINA24.PHP
	public function getDestMerc($num_processo){
		$sql = $this->db->prepare("SELECT * FROM processo_dest_merc WHERE num_processo = :num_processo");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->execute();

		return $sql->fetch(PDO::FETCH_ASSOC);
	}
	public function setDestMerc($num_processo, $destino, $responsavel, $contato, $motivo, $representante, $email, $empresa, $endereco, $bairro, $cep, $cidade, $responsavel2, $fone){
		$sql = $this->db->prepare("INSERT INTO processo_dest_merc SET
			num_processo = :num_processo,
			destino = :destino,
			responsavel = :responsavel,
			contato = :contato,
			motivo = :motivo,
			representante = :representante,
			email = :email,
			empresa = :empresa,
			endereco = :endereco,
			bairro = :bairro,
			cep = :cep,
			cidade = :cidade,
			responsavel2 = :responsavel2,
			fone = :fone
			");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->bindValue(":destino", $destino);
		$sql->bindValue(":responsavel", $responsavel);
		$sql->bindValue(":contato", $contato);
		$sql->bindValue(":motivo", $motivo);
		$sql->bindValue(":representante", $representante);
		$sql->bindValue(":email", $email);
		$sql->bindValue(":empresa", $empresa);
		$sql->bindValue(":endereco", $endereco);
		$sql->bindValue(":bairro", $bairro);
		$sql->bindValue(":cep", $cep);
		$sql->bindValue(":cidade", $cidade);
		$sql->bindValue(":responsavel2", $responsavel2);
		$sql->bindValue(":fone", $fone);
		$sql->execute();

		return true;
	}
	public function upDestMerc($num_processo, $destino, $responsavel, $contato, $motivo, $representante, $email, $empresa, $endereco, $bairro, $cep, $cidade, $responsavel2, $fone){
		$sql = $this->db->prepare("UPDATE processo_dest_merc SET 
			destino = :destino,
			responsavel = :responsavel,
			contato = :contato,
			motivo = :motivo,
			representante = :representante,
			email = :email,
			empresa = :empresa,
			endereco = :endereco,
			bairro = :bairro,
			cep = :cep,
			cidade = :cidade,
			responsavel2 = :responsavel2,
			fone = :fone WHERE num_processo =:num_processo
			");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->bindValue(":destino", $destino);
		$sql->bindValue(":responsavel", $responsavel);
		$sql->bindValue(":contato", $contato);
		$sql->bindValue(":motivo", $motivo);
		$sql->bindValue(":representante", $representante);
		$sql->bindValue(":email", $email);
		$sql->bindValue(":empresa", $empresa);
		$sql->bindValue(":endereco", $endereco);
		$sql->bindValue(":bairro", $bairro);
		$sql->bindValue(":cep", $cep);
		$sql->bindValue(":cidade", $cidade);
		$sql->bindValue(":responsavel2", $responsavel2);
		$sql->bindValue(":fone", $fone);
		$sql->execute();

		return true;
	}

	//PROCESSO PAGINA25.PHP
	public function getPrejCusto($num_processo){
		$sql = $this->db->prepare("SELECT * FROM processo_prej_custo WHERE num_processo = :num_processo");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->execute();

		return $sql->fetch(PDO::FETCH_ASSOC);
	}
	public function setPrejCusto($num_processo, $danos, $dispersao, $fsr){
		$sql = $this->db->prepare("INSERT INTO processo_prej_custo SET
			num_processo = :num_processo,
			danos = :danos,
			dispersao = :dispersao,
			fsr = :fsr
			");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->bindValue(":danos", $danos);
		$sql->bindValue(":dispersao", $dispersao);
		$sql->bindValue(":fsr", $fsr);
		$sql->execute();

		return true;
	}
	public function upPrejCusto($num_processo, $danos, $dispersao, $fsr){
		$sql = $this->db->prepare("UPDATE processo_prej_custo SET
			danos = :danos,
			dispersao = :dispersao,
			fsr = :fsr WHERE num_processo = :num_processo
			");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->bindValue(":danos", $danos);
		$sql->bindValue(":dispersao", $dispersao);
		$sql->bindValue(":fsr", $fsr);
		$sql->execute();

		return true;
	}
	public function setCusto($num_processo, $id_esforco, $qt, $valor, $id_user){
		$sql = $this->db->prepare("INSERT INTO processo_prej_custo2 SET
			num_processo = :num_processo,
			id_esforco = :id_esforco,
			qt = :qt,
			valor = :valor,
			id_user = :id_user
			");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->bindValue(":id_esforco", $id_esforco);
		$sql->bindValue(":qt", $qt);
		$sql->bindValue(":valor", $valor);
		$sql->bindValue(":id_user", $id_user);
		$sql->execute();

		return true;
	}
	public function getCusto($num_processo){
		$sql = $this->db->prepare("SELECT processo_prej_custo2.*, cad_func.nome, nav_esforco.nome as esforco FROM processo_prej_custo2 INNER JOIN cad_func ON processo_prej_custo2.id_user = cad_func.id INNER JOIN nav_esforco ON processo_prej_custo2.id_esforco = nav_esforco.id WHERE num_processo = :num_processo ORDER BY processo_prej_custo2.id DESC");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	public function delCusto($id){
		$sql = $this->db->prepare("DELETE FROM processo_prej_custo2 WHERE id = :id");
		$sql->bindValue(":id", $id);
		$sql->execute();

		return true;
	}
	public function upCusto($id, $id_esforco, $qt, $valor, $id_user){
		$sql = $this->db->prepare("UPDATE processo_prej_custo2 SET
			id_esforco = :id_esforco,
			qt = :qt,
			valor = :valor,
			id_user = :id_user WHERE id = :id
			");
		$sql->bindValue(":id", $id);
		$sql->bindValue(":id_esforco", $id_esforco);
		$sql->bindValue(":qt", $qt);
		$sql->bindValue(":valor", $valor);
		$sql->bindValue(":id_user", $id_user);
		$sql->execute();

		return true;
	}

	//PAGINA PROCESSO26.PHP
	public function getNavPassagemMot(){
		$sql = $this->db->prepare("SELECT * FROM nav_passagem_mot");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	public function getDiagrama(){
		$sql = $this->db->prepare("SELECT * FROM nav_diagrama");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	public function getStatusConhecimento(){
		$sql = $this->db->prepare("SELECT * FROM nav_status_conhecimento");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	public function getStatusTacografo(){
		$sql = $this->db->prepare("SELECT * FROM nav_status_tacografo");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	public function getCausasSinistros($num_processo){
		$sql = $this->db->prepare("SELECT * FROM processo_causas_sinistro WHERE num_processo = :num_processo");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->execute();

		return $sql->fetch(PDO::FETCH_ASSOC);
	}
	public function setCausaSinistro($num_processo, $vel_permitida, $qt_km, $id_nav_passagem_mot, $id_nav_diagrama, $vel_apurada, $id_status_conhecimento, $id_status_torografia, $obs){
		$sql = $this->db->prepare("INSERT INTO processo_causas_sinistro SET
			num_processo = :num_processo,
			vel_permitida = :vel_permitida,
			qt_km = :qt_km,
			id_nav_passagem_mot = :id_nav_passagem_mot,
			id_nav_diagrama = :id_nav_diagrama,
			vel_apurada = :vel_apurada,
			id_status_conhecimento = :id_status_conhecimento,
			id_status_torografia = :id_status_torografia,
			obs = :obs
			");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->bindValue(":vel_permitida", $vel_permitida);
		$sql->bindValue(":qt_km", $qt_km);
		$sql->bindValue(":id_nav_passagem_mot", $id_nav_passagem_mot);
		$sql->bindValue(":id_nav_diagrama", $id_nav_diagrama);
		$sql->bindValue(":vel_apurada", $vel_apurada);
		$sql->bindValue(":id_status_conhecimento", $id_status_conhecimento);
		$sql->bindValue(":id_status_torografia", $id_status_torografia);
		$sql->bindValue(":obs", $obs);
		$sql->execute();

		return true;
	}
	public function upCausaSinistro($num_processo, $vel_permitida, $qt_km, $id_nav_passagem_mot, $id_nav_diagrama, $vel_apurada, $id_status_conhecimento, $id_status_torografia, $obs){
		$sql = $this->db->prepare("UPDATE processo_causas_sinistro SET
			vel_permitida = :vel_permitida,
			qt_km = :qt_km,
			id_nav_passagem_mot = :id_nav_passagem_mot,
			id_nav_diagrama = :id_nav_diagrama,
			vel_apurada = :vel_apurada,
			id_status_conhecimento = :id_status_conhecimento,
			id_status_torografia = :id_status_torografia,
			obs = :obs WHERE num_processo = :num_processo
			");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->bindValue(":vel_permitida", $vel_permitida);
		$sql->bindValue(":qt_km", $qt_km);
		$sql->bindValue(":id_nav_passagem_mot", $id_nav_passagem_mot);
		$sql->bindValue(":id_nav_diagrama", $id_nav_diagrama);
		$sql->bindValue(":vel_apurada", $vel_apurada);
		$sql->bindValue(":id_status_conhecimento", $id_status_conhecimento);
		$sql->bindValue(":id_status_torografia", $id_status_torografia);
		$sql->bindValue(":obs", $obs);
		$sql->execute();

		return true;
	}

	//PAGINA PROCESSO27.PHP
	public function nav_processo27_1(){
		$sql = $this->db->prepare("SELECT * FROM nav_processo27_1");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	public function nav_processo27_2(){
		$sql = $this->db->prepare("SELECT * FROM nav_processo27_2");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	public function nav_processo27_3(){
		$sql = $this->db->prepare("SELECT * FROM nav_processo27_3");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	public function nav_processo27_4(){
		$sql = $this->db->prepare("SELECT * FROM nav_processo27_4");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	public function nav_processo27_5(){
		$sql = $this->db->prepare("SELECT * FROM nav_processo27_5");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	public function nav_processo27_6(){
		$sql = $this->db->prepare("SELECT * FROM nav_processo27_6");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	public function nav_processo27_7(){
		$sql = $this->db->prepare("SELECT * FROM nav_processo27_7");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	public function nav_processo27_8(){
		$sql = $this->db->prepare("SELECT * FROM nav_processo27_8");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	public function nav_processo27_9(){
		$sql = $this->db->prepare("SELECT * FROM nav_processo27_9");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	public function nav_processo27_10(){
		$sql = $this->db->prepare("SELECT * FROM nav_processo27_10");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	public function nav_processo27_11(){
		$sql = $this->db->prepare("SELECT * FROM nav_processo27_11");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	public function nav_processo27_12(){
		$sql = $this->db->prepare("SELECT * FROM nav_processo27_12");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	public function nav_processo27_13(){
		$sql = $this->db->prepare("SELECT * FROM nav_processo27_13");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	public function nav_processo27_14(){
		$sql = $this->db->prepare("SELECT * FROM nav_processo27_14");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	public function nav_processo27_15(){
		$sql = $this->db->prepare("SELECT * FROM nav_processo27_15");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	public function nav_processo27_16(){
		$sql = $this->db->prepare("SELECT * FROM nav_processo27_16");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	public function nav_processo27_17(){
		$sql = $this->db->prepare("SELECT * FROM nav_processo27_17");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	public function nav_processo27_18(){
		$sql = $this->db->prepare("SELECT * FROM nav_processo27_18");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	public function nav_processo27_19(){
		$sql = $this->db->prepare("SELECT * FROM nav_processo27_19");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	public function processo_descricao_local($num_processo){
		$sql = $this->db->prepare("SELECT * FROM processo_descricao_local WHERE num_processo = :num_processo");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->execute();

		return $sql->fetch(PDO::FETCH_ASSOC);
	}
	public function setDescricaoLocal($num_processo, $nav_processo27_1, $nav_processo27_2, $nav_processo27_3, $nav_processo27_4,$nav_processo27_5, $nav_processo27_6, $nav_processo27_7, $nav_processo27_8, $nav_processo27_9, $nav_processo27_10, $nav_processo27_11, $nav_processo27_12, $nav_processo27_13, $nav_processo27_14, $nav_processo27_15, $nav_processo27_16, $nav_processo27_17, $nav_processo27_18, $nav_processo27_19, $nav_processo27_20, $nav_processo27_21){
		$sql = $this->db->prepare("INSERT INTO processo_descricao_local SET
			num_processo = :num_processo,
			nav_processo27_1 = :nav_processo27_1,
			nav_processo27_2 = :nav_processo27_2,
			nav_processo27_3 = :nav_processo27_3,
			nav_processo27_4 = :nav_processo27_4,
			nav_processo27_5 = :nav_processo27_5,
			nav_processo27_6 = :nav_processo27_6,
			nav_processo27_7 = :nav_processo27_8,
			nav_processo27_8 = :nav_processo27_8,
			nav_processo27_9 = :nav_processo27_9,
			nav_processo27_10 = :nav_processo27_10,
			nav_processo27_11 = :nav_processo27_11,
			nav_processo27_12 = :nav_processo27_12,
			nav_processo27_13 = :nav_processo27_13,
			nav_processo27_14 = :nav_processo27_14,
			nav_processo27_15 = :nav_processo27_15,
			nav_processo27_16 = :nav_processo27_16,
			nav_processo27_17 = :nav_processo27_17,
			nav_processo27_18 = :nav_processo27_18,
			nav_processo27_19 = :nav_processo27_19,
			nav_processo27_20 = :nav_processo27_20,
			nav_processo27_21 = :nav_processo27_21
			");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->bindValue(":nav_processo27_1", $nav_processo27_1);
		$sql->bindValue(":nav_processo27_2", $nav_processo27_2);
		$sql->bindValue(":nav_processo27_3", $nav_processo27_3);
		$sql->bindValue(":nav_processo27_4", $nav_processo27_4);
		$sql->bindValue(":nav_processo27_5", $nav_processo27_5);
		$sql->bindValue(":nav_processo27_6", $nav_processo27_6);
		$sql->bindValue(":nav_processo27_7", $nav_processo27_7);
		$sql->bindValue(":nav_processo27_8", $nav_processo27_8);
		$sql->bindValue(":nav_processo27_9", $nav_processo27_9);
		$sql->bindValue(":nav_processo27_10", $nav_processo27_10);
		$sql->bindValue(":nav_processo27_11", $nav_processo27_11);
		$sql->bindValue(":nav_processo27_12", $nav_processo27_12);
		$sql->bindValue(":nav_processo27_13", $nav_processo27_13);
		$sql->bindValue(":nav_processo27_14", $nav_processo27_14);
		$sql->bindValue(":nav_processo27_15", $nav_processo27_15);
		$sql->bindValue(":nav_processo27_16", $nav_processo27_16);
		$sql->bindValue(":nav_processo27_17", $nav_processo27_17);
		$sql->bindValue(":nav_processo27_18", $nav_processo27_18);
		$sql->bindValue(":nav_processo27_19", $nav_processo27_19);
		$sql->bindValue(":nav_processo27_20", $nav_processo27_20);
		$sql->bindValue(":nav_processo27_21", $nav_processo27_21);
		
		$sql->execute();

		return true;
	}
	public function upDescricaoLocal($num_processo, $nav_processo27_1, $nav_processo27_2, $nav_processo27_3, $nav_processo27_4,$nav_processo27_5, $nav_processo27_6, $nav_processo27_7, $nav_processo27_8, $nav_processo27_9, $nav_processo27_10, $nav_processo27_11, $nav_processo27_12, $nav_processo27_13, $nav_processo27_14, $nav_processo27_15, $nav_processo27_16, $nav_processo27_17, $nav_processo27_18, $nav_processo27_19, $nav_processo27_20, $nav_processo27_21){
		$sql = $this->db->prepare("UPDATE processo_descricao_local SET
			nav_processo27_1 = :nav_processo27_1,
			nav_processo27_2 = :nav_processo27_2,
			nav_processo27_3 = :nav_processo27_3,
			nav_processo27_4 = :nav_processo27_4,
			nav_processo27_5 = :nav_processo27_5,
			nav_processo27_6 = :nav_processo27_6,
			nav_processo27_7 = :nav_processo27_7,
			nav_processo27_8 = :nav_processo27_8,
			nav_processo27_9 = :nav_processo27_9,
			nav_processo27_10 = :nav_processo27_10,
			nav_processo27_11 = :nav_processo27_11,
			nav_processo27_12 = :nav_processo27_12,
			nav_processo27_13 = :nav_processo27_13,
			nav_processo27_14 = :nav_processo27_14,
			nav_processo27_15 = :nav_processo27_15,
			nav_processo27_16 = :nav_processo27_16,
			nav_processo27_17 = :nav_processo27_17,
			nav_processo27_18 = :nav_processo27_18,
			nav_processo27_19 = :nav_processo27_19,
			nav_processo27_20 = :nav_processo27_20,
			nav_processo27_21 = :nav_processo27_21 WHERE num_processo = :num_processo
			");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->bindValue(":nav_processo27_1", $nav_processo27_1);
		$sql->bindValue(":nav_processo27_2", $nav_processo27_2);
		$sql->bindValue(":nav_processo27_3", $nav_processo27_3);
		$sql->bindValue(":nav_processo27_4", $nav_processo27_4);
		$sql->bindValue(":nav_processo27_5", $nav_processo27_5);
		$sql->bindValue(":nav_processo27_6", $nav_processo27_6);
		$sql->bindValue(":nav_processo27_7", $nav_processo27_7);
		$sql->bindValue(":nav_processo27_8", $nav_processo27_8);
		$sql->bindValue(":nav_processo27_9", $nav_processo27_9);
		$sql->bindValue(":nav_processo27_10", $nav_processo27_10);
		$sql->bindValue(":nav_processo27_11", $nav_processo27_11);
		$sql->bindValue(":nav_processo27_12", $nav_processo27_12);
		$sql->bindValue(":nav_processo27_13", $nav_processo27_13);
		$sql->bindValue(":nav_processo27_14", $nav_processo27_14);
		$sql->bindValue(":nav_processo27_15", $nav_processo27_15);
		$sql->bindValue(":nav_processo27_16", $nav_processo27_16);
		$sql->bindValue(":nav_processo27_17", $nav_processo27_17);
		$sql->bindValue(":nav_processo27_18", $nav_processo27_18);
		$sql->bindValue(":nav_processo27_19", $nav_processo27_19);
		$sql->bindValue(":nav_processo27_20", $nav_processo27_20);
		$sql->bindValue(":nav_processo27_21", $nav_processo27_21);
		
		$sql->execute();

		return true;
	}

	//PROCESSO PAGINA28.PHP
	public function processo_doc_anexos($num_processo){
		$sql = $this->db->prepare("SELECT * FROM processo_doc_anexos WHERE num_processo = :num_processo");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->execute();

		return $sql->fetch(PDO::FETCH_ASSOC);
	}
	public function setDocsAnexos($num_processo, $mercadoria, $transporte, $condutor, $veiculo_sinistrado, $condutor_transbordo, $veiculo_transbordo, $outros){
		$sql = $this->db->prepare("INSERT INTO processo_doc_anexos SET
			num_processo = :num_processo,
			mercadoria = :mercadoria,
			transporte = :transporte,
			condutor = :condutor,
			veiculo_sinistrado = :veiculo_sinistrado,
			condutor_transbordo = :condutor_transbordo,
			veiculo_transbordo = :veiculo_transbordo,
			outros = :outros
			");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->bindValue(":mercadoria", $mercadoria);
		$sql->bindValue(":transporte", $transporte);
		$sql->bindValue(":condutor", $condutor);
		$sql->bindValue(":veiculo_sinistrado", $veiculo_sinistrado);
		$sql->bindValue(":condutor_transbordo", $condutor_transbordo);
		$sql->bindValue(":veiculo_transbordo", $veiculo_transbordo);
		$sql->bindValue(":outros", $outros);
		$sql->execute();

		return true;
	}
	public function upDocsAnexos($num_processo, $mercadoria, $transporte, $condutor, $veiculo_sinistrado, $condutor_transbordo, $veiculo_transbordo, $outros){
		$sql = $this->db->prepare("UPDATE processo_doc_anexos SET
			mercadoria = :mercadoria,
			transporte = :transporte,
			condutor = :condutor,
			veiculo_sinistrado = :veiculo_sinistrado,
			condutor_transbordo = :condutor_transbordo,
			veiculo_transbordo = :veiculo_transbordo,
			outros = :outros WHERE num_processo = :num_processo
			");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->bindValue(":mercadoria", $mercadoria);
		$sql->bindValue(":transporte", $transporte);
		$sql->bindValue(":condutor", $condutor);
		$sql->bindValue(":veiculo_sinistrado", $veiculo_sinistrado);
		$sql->bindValue(":condutor_transbordo", $condutor_transbordo);
		$sql->bindValue(":veiculo_transbordo", $veiculo_transbordo);
		$sql->bindValue(":outros", $outros);
		$sql->execute();

		return true;
	}

	//PAGINA PROCESSO29.PHP
	public function setLancamentos($num_processo, $operacao, $atividade1, $atividade2, $valor_receber, $valor_pagar, $dt_pagamento, $id_user){
		$sql = $this->db->prepare("INSERT INTO processo_lancamentos SET
			num_processo = :num_processo,
			operacao = :operacao,
			atividade1 = :atividade1,
			atividade2 = :atividade2,
			valor_receber = :valor_receber,
			valor_pagar = :valor_pagar,
			dt_pagamento = :dt_pagamento,
			id_user = :id_user
			");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->bindValue(":operacao", $operacao);
		$sql->bindValue(":atividade1", $atividade1);
		$sql->bindValue(":atividade2", $atividade2);
		$sql->bindValue(":valor_receber", $valor_receber);
		$sql->bindValue(":valor_pagar", $valor_pagar);
		$sql->bindValue(":dt_pagamento", $dt_pagamento);
		$sql->bindValue(":id_user", $id_user);
		$sql->execute();

		return true;
	}
	public function upLancamentos($id, $operacao, $atividade1, $atividade2, $valor_receber, $valor_pagar, $dt_pagamento, $id_user){
		$sql = $this->db->prepare("UPDATE processo_lancamentos SET
			operacao = :operacao,
			atividade1 = :atividade1,
			atividade2 = :atividade2,
			valor_receber = :valor_receber,
			valor_pagar = :valor_pagar,
			dt_pagamento = :dt_pagamento,
			id_user = :id_user WHERE id = :id
			");
		$sql->bindValue(":id", $id);
		$sql->bindValue(":operacao", $operacao);
		$sql->bindValue(":atividade1", $atividade1);
		$sql->bindValue(":atividade2", $atividade2);
		$sql->bindValue(":valor_receber", $valor_receber);
		$sql->bindValue(":valor_pagar", $valor_pagar);
		$sql->bindValue(":dt_pagamento", $dt_pagamento);
		$sql->bindValue(":id_user", $id_user);
		$sql->execute();

		return true;
	}
	public function nav_lancamento(){
		$sql = $this->db->prepare("SELECT * FROM nav_lancamento");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	public function nav_atividade(){
		$sql = $this->db->prepare("SELECT * FROM nav_atividade");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	public function getLancamentos($num_processo){
		$sql = $this->db->prepare("SELECT processo_lancamentos.*, nav_lancamento.nome as n, nav_atividade.nome as name, cad_func.nome as func FROM processo_lancamentos INNER JOIN nav_lancamento ON processo_lancamentos.operacao = nav_lancamento.id INNER JOIN nav_atividade ON processo_lancamentos.atividade1 = nav_atividade.id INNER JOIN cad_func ON processo_lancamentos.id_user = cad_func.id WHERE processo_lancamentos.num_processo = :num_processo ORDER BY processo_lancamentos.id DESC");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	public function delLancamento($id){
		$sql = $this->db->prepare("DELETE FROM processo_lancamentos WHERE id = :id");
		$sql->bindValue(":id", $id);
		$sql->execute();

		return true;
	}

	//CERTIFICADO DE VISTORIA PAGINA PROCESSO30.PHP
	public function setCertificadoVistoria($num_processo, $token, $id_user){
		$sql = $this->db->prepare("INSERT INTO processo_certificado_vist SET
			num_processo = :num_processo,
			token = :token,
			id_user = :id_user
			");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->bindValue(":token", $token);
		$sql->bindValue(":id_user", $id_user);
		$sql->execute();

		return true;
	}

	//CERTIFICADO DE VISTORIA PDF
	public function getCertificadoVistoria($num_processo){
		$sql = $this->db->prepare("SELECT processo_certificado_vist.*, cad_func.nome FROM processo_certificado_vist INNER JOIN cad_func ON processo_certificado_vist.id_user = cad_func.id WHERE 
			num_processo = :num_processo ORDER BY processo_certificado_vist.id DESC
			");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}

	public function getCertificadoVistoriaID($id){
		$sql = $this->db->prepare("SELECT processo_certificado_vist.*, cad_func.nome FROM processo_certificado_vist INNER JOIN cad_func ON processo_certificado_vist.id_user = cad_func.id WHERE processo_certificado_vist.id = :id");
		$sql->bindValue(":id", $id);
		$sql->execute();

		return $sql->fetch(PDO::FETCH_ASSOC);
	}
	public function getAtividadesID($id){
		$sql = $this->db->prepare("SELECT * FROM atividades WHERE id = :id");
		$sql->bindValue(":id", $id);
		$sql->execute();

		return $sql->fetch(PDO::FETCH_ASSOC);
	}
	public function getAtuacaoIDs($id){
		$sql = $this->db->prepare("SELECT * FROM atuacao WHERE id = :id");
		$sql->bindValue(":id", $id);
		$sql->execute();

		return $sql->fetch(PDO::FETCH_ASSOC);
	}
	public function getCertificadoEvento($num_processo){
		$sql = $this->db->prepare("SELECT processo_dados_acontecimento.*, nat_eventos.nat_evento FROM processo_dados_acontecimento INNER JOIN nat_eventos ON processo_dados_acontecimento.id_nat_evento = nat_eventos.id WHERE num_processo = :num_processo");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->execute();

		return $sql->fetch(PDO::FETCH_ASSOC);
	}
	public function getDBDanosMerc($num_processo){
		$sql = $this->db->prepare("SELECT * FROM processo_danos_merc WHERE num_processo = :num_processo");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->execute();

		return $sql->fetch(PDO::FETCH_ASSOC);
	}

	public function upVistoria($post, $id){
		$sql = $this->db->prepare("
			UPDATE processo_certificado_vist SET 
			volume1 = :volume1,
			id_uni_medida1 = :id_uni_medida1,
			peso1 = :peso1,
			volume2 = :volume2,
			id_uni_medida2 = :id_uni_medida2,
			peso2 = :peso2,
			risco = :risco,
			prejuizo = :prejuizo,
			salvado = :salvado,
			anexos = :anexos 
			WHERE id = :id"
		);

		foreach ($post as $key => $value) {
            $sql->bindValue(":{$key}", $value);
        }
		$sql->bindValue(":id", $id);
		$sql->execute();

		return true;
	}


	public function setManifesto($num_processo, $id_vistoria, $post, $id_user, $valor){

		$sql = $this->db->prepare("SELECT SUM(m7) as m7 FROM processo_manifesto 
			WHERE num_processo = :num_processo");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->execute();
		$v = $sql->fetch(PDO::FETCH_ASSOC);

		if ($v['m7']+$post['m7'] <= $valor) {

			$fields = [];
	        foreach ($post as $key => $value) {
	            $fields[] = "$key=:$key";
	        }

	        $fields = implode(', ', $fields);
			$sql = $this->db->prepare("
				INSERT INTO processo_manifesto SET 
				num_processo = :num_processo, 
				id_vistoria = :id_vistoria,
				{$fields},
				id_user = :id_user");

			$sql->bindValue(":num_processo", $num_processo);
			$sql->bindValue(":id_vistoria", $id_vistoria);
			foreach ($post as $key => $value) {
	            $sql->bindValue(":{$key}", $value);
	        }
	        $sql->bindValue(":id_user", $id_user);
			$sql->execute();

			return true;
		} else {
			return false;
		}
	}
	public function upManifesto($num_processo, $post, $valor){
		$sql = $this->db->prepare("SELECT SUM(m7) as m7 FROM processo_manifesto 
			WHERE num_processo = :num_processo AND id <> :id");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->bindValue(":id", $post['idUP']);
		$sql->execute();
		$v = $sql->fetch(PDO::FETCH_ASSOC);

		if (number_format($v['m7']+$post['m7UP'], 2, '.', '') <= number_format($valor, 2, '.', '')) {
			$sql = $this->db->prepare("
				UPDATE processo_manifesto SET
				m1 = :m1, m2 = :m2, m3 = :m3,
				m4 = :m4, m5 = :m5, m6 = :m6,
				m7 = :m7, tipo_mercadoria = :tipo_mercadoria, m8 = :m8, m9 = :m9,
				m10 = :m10, m11 = :m11, m12 = :m12,
				m13 = :m13, m14 = :m14, m15 = :m15,
				m16 = :m16, m17 = :m17, m18 = :m18,
				m19 = :m19, m20 = :m20, m21 = :m21,
				m22 = :m22, m23 = :m23, m24 = :m24 
				WHERE id = :id
				");
			foreach ($post as $key => $value) {
				$key = substr($key,0, -2);
	            $sql->bindValue(":{$key}", $value);
	        }
			$sql->execute();

			return true;
		} else {
			return false;
		}
	}
	public function getManifestoIDmanifesto($id_manifesto){
		$sql = $this->db->prepare("SELECT SUM(total) as t FROM processo_manifesto_nfe WHERE id_manifesto = :id_manifesto");
		$sql->bindValue(":id_manifesto", $id_manifesto);
		$sql->execute();

		return $sql->fetch(PDO::FETCH_ASSOC);
	}
	public function getManifestoID($id){
		$sql = $this->db->prepare("SELECT * FROM processo_manifesto WHERE 
			id = :id");
		$sql->bindValue(":id", $id);
		$sql->execute();

		return $sql->fetch(PDO::FETCH_ASSOC);
	}
	public function getManifestoNFe($num_processo, $id_vistoria){
		$sql = $this->db->prepare("
			SELECT * FROM processo_manifesto_nfe 
			WHERE num_processo = :num_processo 
			AND id_vistoria = :id_vistoria");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->bindValue(":id_vistoria", $id_vistoria);
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	public function getManifestoNFeIDmanifesto($id_manifesto){
		$sql = $this->db->prepare("SELECT processo_manifesto_nfe.*, nav_unidade.nome, cad_func.nome as func FROM processo_manifesto_nfe INNER JOIN nav_unidade ON processo_manifesto_nfe.id_unidade = nav_unidade.id INNER JOIN cad_func ON processo_manifesto_nfe.id_user = cad_func.id WHERE 
			id_manifesto = :id_manifesto");
		$sql->bindValue(":id_manifesto", $id_manifesto);
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	public function getNFeID($id){
		$sql = $this->db->prepare("SELECT processo_manifesto_nfe.*, nav_unidade.nome, cad_func.nome as func FROM processo_manifesto_nfe INNER JOIN nav_unidade ON processo_manifesto_nfe.id_unidade = nav_unidade.id INNER JOIN cad_func ON processo_manifesto_nfe.id_user = cad_func.id WHERE 
			processo_manifesto_nfe.id = :id");
		$sql->bindValue(":id", $id);
		$sql->execute();

		return $sql->fetch(PDO::FETCH_ASSOC);
	}
	public function getManifesto($num_processo, $id_vistoria){
		$sql = $this->db->prepare("SELECT processo_manifesto.*, nav_tipo_prejuizo.nome as prej, cad_func.nome as func FROM processo_manifesto INNER JOIN nav_tipo_prejuizo ON processo_manifesto.m14 = nav_tipo_prejuizo.id INNER JOIN cad_func ON processo_manifesto.id_user = cad_func.id WHERE 
			num_processo = :num_processo AND id_vistoria = :id_vistoria
			");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->bindValue(":id_vistoria", $id_vistoria);
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}

	public function CountNotas($id_manifesto){
		$sql = $this->db->prepare("SELECT count(id) as c, id_manifesto FROM processo_manifesto_nfe WHERE id_manifesto=:id_manifesto");
		$sql->bindValue(":id_manifesto", $id_manifesto);
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	public function getManifestosP($num_processo){
		$sql = $this->db->prepare("SELECT processo_manifesto.m7 as valor FROM processo_manifesto WHERE num_processo = :num_processo");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	public function delNFe($id){
		$sql = $this->db->prepare("DELETE FROM processo_manifesto_nfe WHERE id = :id");
		$sql->bindValue(":id", $id);
		$sql->execute();

		return true;
	}
	public function setNFe($num_processo, $id_vistoria, $id_manifesto, $post, $id_user){
		$fields = [];
        foreach ($post as $key => $value) {
            $fields[] = "$key=:$key";
        }

        $fields = implode(', ', $fields);
		$sql = $this->db->prepare("
			INSERT INTO processo_manifesto_nfe SET 
			num_processo = :num_processo, 
			id_vistoria = :id_vistoria, 
			id_manifesto = :id_manifesto,
			{$fields},
			id_user = :id_user");

		$sql->bindValue(":num_processo", $num_processo);
		$sql->bindValue(":id_vistoria", $id_vistoria);
		$sql->bindValue(":id_manifesto", $id_manifesto);
		foreach ($post as $key => $value) {
            $sql->bindValue(":{$key}", $value);
        }
        $sql->bindValue(":id_user", $id_user);
		$sql->execute();

		return true;
	}
	public function upNFe($post){

		$sql = $this->db->prepare("
			UPDATE processo_manifesto_nfe SET 
			descricao = :descricao,
			qt = :qt,
			peso = :peso,
			valor_uni = :valor_uni,
			id_unidade = :id_unidade,
			icms = :icms,
			ipi = :ipi,
			valor_desc = :valor_desc,
			total = :total
			WHERE id = :id"
		);

		foreach ($post as $key => $value) {
			$key = substr($key,0, -2);
            $sql->bindValue(":{$key}", $value);
        }
		$sql->execute();

		return true;
	}

	public function delManifestoNFe($id){
		$sql = $this->db->prepare("DELETE FROM processo_manifesto_nfe WHERE id_manifesto = :id");
		$sql->bindValue(":id", $id);
		$sql->execute();

		$sql = $this->db->prepare("DELETE FROM processo_manifesto WHERE id = :id");
		$sql->bindValue(":id", $id);
		$sql->execute();

		return true;
	}

	//PAGINA PROCESSO31.PHP
	public function seInventario($num_processo, $token, $id_user){
		$sql = $this->db->prepare("INSERT INTO processo_inventarios SET
			num_processo = :num_processo,
			token = :token,
			id_user = :id_user
			");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->bindValue(":token", $token);
		$sql->bindValue(":id_user", $id_user);
		$sql->execute();

		return true;
	}
	public function getInventario($num_processo){
		$sql = $this->db->prepare("SELECT processo_inventarios.*, cad_func.nome FROM processo_inventarios INNER JOIN cad_func ON processo_inventarios.id_user = cad_func.id WHERE 
			num_processo = :num_processo ORDER BY processo_inventarios.id DESC
			");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	public function getInventarioID($id){
		$sql = $this->db->prepare("SELECT processo_inventarios.*, cad_func.nome FROM processo_inventarios INNER JOIN cad_func ON processo_inventarios.id_user = cad_func.id WHERE processo_inventarios.id = :id ORDER BY processo_inventarios.id DESC
			");
		$sql->bindValue(":id", $id);
		$sql->execute();

		return $sql->fetch(PDO::FETCH_ASSOC);
	}
	public function getInventario2ID($id_inventario){
		$sql = $this->db->prepare("SELECT processo_inventarios2.*, cad_func.nome FROM processo_inventarios2 INNER JOIN cad_func ON processo_inventarios2.id_user = cad_func.id WHERE processo_inventarios2.id_inventario = :id_inventario
			");
		$sql->bindValue(":id_inventario", $id_inventario);
		$sql->execute();

		return $sql->fetch(PDO::FETCH_ASSOC);
	}
	public function setInventario2($num_processo, $id_inventario, $v1, $v2, $v3, $v4, $v5, $v6, $v7, $v8, $v9, $city1, $v11, $v12, $v13, $v14, $v15, $v16, $v17, $v18, $v19, $id_user){
		$sql = $this->db->prepare("INSERT INTO processo_inventarios2 SET
			num_processo = :num_processo,
			id_inventario = :id_inventario,
			v1 = :v1,
			v2 = :v2,
			v3 = :v3,
			v4 = :v4,
			v5 = :v5,
			v6 = :v6,
			v7 = :v7,
			v8 = :v8,
			v9 = :v9,
			city1 = :city1,
			v11 = :v11,
			v12 = :v12,
			v13 = :v13,
			v14 = :v14,
			v15 = :v15,
			v16 = :v16,
			v17 = :v17,
			v18 = :v18,
			v19 = :v19,
			id_user = :id_user
			");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->bindValue(":id_inventario", $id_inventario);
		$sql->bindValue(":v1", $v1);
		$sql->bindValue(":v2", $v2);
		$sql->bindValue(":v3", $v3);
		$sql->bindValue(":v4", $v4);
		$sql->bindValue(":v5", $v5);
		$sql->bindValue(":v6", $v6);
		$sql->bindValue(":v7", $v7);
		$sql->bindValue(":v8", $v8);
		$sql->bindValue(":v9", $v9);
		$sql->bindValue(":city1", $city1);
		$sql->bindValue(":v11", $v11);
		$sql->bindValue(":v12", $v12);
		$sql->bindValue(":v13", $v13);
		$sql->bindValue(":v14", $v14);
		$sql->bindValue(":v15", $v15);
		$sql->bindValue(":v16", $v16);
		$sql->bindValue(":v17", $v17);
		$sql->bindValue(":v18", $v18);
		$sql->bindValue(":v19", $v19);
		$sql->bindValue(":id_user", $id_user);
		$sql->execute();

		return true;
	}
	public function upInventario2($num_processo, $id_inventario, $v1, $v2, $v3, $v4, $v5, $v6, $v7, $v8, $v9, $city1, $v11, $v12, $v13, $v14, $v15, $v16, $v17, $v18, $v19){
		$sql = $this->db->prepare("UPDATE processo_inventarios2 SET
			v1 = :v1,
			v2 = :v2,
			v3 = :v3,
			v4 = :v4,
			v5 = :v5,
			v6 = :v6,
			v7 = :v7,
			v8 = :v8,
			v9 = :v9,
			city1 = :city1,
			v11 = :v11,
			v12 = :v12,
			v13 = :v13,
			v14 = :v14,
			v15 = :v15,
			v16 = :v16,
			v17 = :v17,
			v18 = :v18,
			v19 = :v19 WHERE 
			num_processo = :num_processo AND 
			id_inventario = :id_inventario
			");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->bindValue(":id_inventario", $id_inventario);
		$sql->bindValue(":v1", $v1);
		$sql->bindValue(":v2", $v2);
		$sql->bindValue(":v3", $v3);
		$sql->bindValue(":v4", $v4);
		$sql->bindValue(":v5", $v5);
		$sql->bindValue(":v6", $v6);
		$sql->bindValue(":v7", $v7);
		$sql->bindValue(":v8", $v8);
		$sql->bindValue(":v9", $v9);
		$sql->bindValue(":city1", $city1);
		$sql->bindValue(":v11", $v11);
		$sql->bindValue(":v12", $v12);
		$sql->bindValue(":v13", $v13);
		$sql->bindValue(":v14", $v14);
		$sql->bindValue(":v15", $v15);
		$sql->bindValue(":v16", $v16);
		$sql->bindValue(":v17", $v17);
		$sql->bindValue(":v18", $v18);
		$sql->bindValue(":v19", $v19);
		$sql->execute();

		return true;
	}
	public function setInventario3($num_processo, $id_inventario, $d1, $d2, $d3, $d4, $d5, $d6, $d7, $d8, $id_user){
		$sql = $this->db->prepare("INSERT INTO processo_inventarios_descr SET
			num_processo = :num_processo,
			id_inventario = :id_inventario,
			d1 = :d1,
			d2 = :d2,
			d3 = :d3,
			d4 = :d4,
			d5 = :d5,
			d6 = :d6,
			d7 = :d7,
			d8 = :d8,
			id_user = :id_user
			");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->bindValue(":id_inventario", $id_inventario);
		$sql->bindValue(":d1", $d1);
		$sql->bindValue(":d2", $d2);
		$sql->bindValue(":d3", $d3);
		$sql->bindValue(":d4", $d4);
		$sql->bindValue(":d5", $d5);
		$sql->bindValue(":d6", $d6);
		$sql->bindValue(":d7", $d7);
		$sql->bindValue(":d8", $d8);
		$sql->bindValue(":id_user", $id_user);
		$sql->execute();

		return true;
	}
	public function upInventario3($id, $d1, $d2, $d3, $d4, $d5, $d6, $d7, $d8){
		$sql = $this->db->prepare("UPDATE processo_inventarios_descr SET
			d1 = :d1,
			d2 = :d2,
			d3 = :d3,
			d4 = :d4,
			d5 = :d5,
			d6 = :d6,
			d7 = :d7,
			d8 = :d8 WHERE id = :id");
		$sql->bindValue(":d1", $d1);
		$sql->bindValue(":d2", $d2);
		$sql->bindValue(":d3", $d3);
		$sql->bindValue(":d4", $d4);
		$sql->bindValue(":d5", $d5);
		$sql->bindValue(":d6", $d6);
		$sql->bindValue(":d7", $d7);
		$sql->bindValue(":d8", $d8);
		$sql->bindValue(":id", $id);
		$sql->execute();

		return true;
	}
	public function getInventario3($id_inventario){
		$sql = $this->db->prepare("SELECT processo_inventarios_descr.*, cad_func.nome, nav_unidade.nome as uni FROM processo_inventarios_descr INNER JOIN cad_func ON processo_inventarios_descr.id_user = cad_func.id INNER JOIN nav_unidade ON processo_inventarios_descr.d3 = nav_unidade.id WHERE processo_inventarios_descr.id_inventario = :id_inventario
			");
		$sql->bindValue(":id_inventario", $id_inventario);
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	public function delInventario3($id){
		$sql = $this->db->prepare("DELETE FROM processo_inventarios_descr WHERE id = :id");
		$sql->bindValue(":id", $id);
		$sql->execute();

		return true;
	}


}
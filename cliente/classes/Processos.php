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
	//PROCESSOS ID SEGURADO
	public function processosSeguradora($id_seguradora){
		$sql = $this->db->prepare("SELECT processos.num_processo, processos.num_sinistro, processos.status, e.razao_social as seguradora, x.razao_social as transportadora, s.razao_social as segurado, cad_apolice.num_apolice FROM processos INNER JOIN cad_p_juridica e ON processos.id_seguradora = e.id INNER JOIN cad_p_juridica x on processos.id_transportadora = x.id INNER JOIN cad_apolice ON cad_apolice.id = processos.id_apolice INNER JOIN cad_p_juridica s ON processos.id_segurado = s.id WHERE processos.id_seguradora = :id_seguradora ORDER BY processos.id DESC");
		$sql->bindValue(":id_seguradora", $id_seguradora);
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);	
	}
	//PROCESSOS ID SEGURADO
	public function processosSegurado($id_segurado){
		$sql = $this->db->prepare("SELECT processos.num_processo, processos.num_sinistro, processos.status, e.razao_social as seguradora, x.razao_social as transportadora, s.razao_social as segurado, cad_apolice.num_apolice FROM processos INNER JOIN cad_p_juridica e ON processos.id_seguradora = e.id INNER JOIN cad_p_juridica x on processos.id_transportadora = x.id INNER JOIN cad_apolice ON cad_apolice.id = processos.id_apolice INNER JOIN cad_p_juridica s ON processos.id_segurado = s.id WHERE processos.id_segurado = :id_segurado  ORDER BY processos.id DESC");
		$sql->bindValue(":id_segurado", $id_segurado);
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);	
	}
	
	//PROCESSOS ID SEGURADO
	public function processosCorretora($id_corretora){
		$sql = $this->db->prepare("SELECT processos.num_processo, processos.num_sinistro, processos.status, e.razao_social as seguradora, x.razao_social as transportadora, s.razao_social as segurado, cad_apolice.num_apolice FROM processos INNER JOIN cad_p_juridica e ON processos.id_seguradora = e.id INNER JOIN cad_p_juridica x on processos.id_transportadora = x.id INNER JOIN cad_apolice ON cad_apolice.id = processos.id_apolice INNER JOIN cad_p_juridica s ON processos.id_segurado = s.id WHERE processos.id_corretora = :id_corretora  ORDER BY processos.id DESC");
		$sql->bindValue(":id_corretora", $id_corretora);
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);	
	}

	//PROCESSO POR NUM_PROCESSO
	public function ProcessoNum_Processo($num_processo){
		$sql = $this->db->prepare("SELECT processos.*, e.razao_social as seguradora, s.razao_social as segurado, c.cnpj as cnpj1, cn.cnpj as cnpj2, cad_apolice.num_apolice, nav_ramo.ramo, nav_moeda.moeda, processo_dados_acontecimento.id_nat_evento FROM processos INNER JOIN cad_p_juridica e ON processos.id_seguradora = e.id INNER JOIN cad_apolice ON cad_apolice.id = processos.id_apolice INNER JOIN cad_p_juridica s ON processos.id_segurado = s.id INNER JOIN cad_p_juridica c ON processos.id_seguradora = c.id INNER JOIN cad_p_juridica cn ON processos.id_segurado = cn.id INNER JOIN nav_ramo ON processos.id_ramo = nav_ramo.id INNER JOIN nav_moeda ON processos.moeda = nav_moeda.id INNER JOIN processo_dados_acontecimento ON processos.num_processo = processo_dados_acontecimento.num_processo WHERE processos.num_processo = :num_processo");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->execute();

		return $sql->fetch(PDO::FETCH_ASSOC);
	}
	//NATUREZA DO EVENTO
	public function natEventoID($id){
		$sql = $this->db->prepare("SELECT * FROM nat_eventos WHERE id = :id");
		$sql->bindValue(":id", $id);
		$sql->execute();

		return $sql->fetch(PDO::FETCH_ASSOC);
	}
	//PASTAS REGISTRADAS
	public function getPtDocCliente($num_processo){
		$sql = $this->db->prepare("SELECT processos.id_seguradora, processos.id_segurado, processos.id_corretora, doc_processo.tipo_doc, doc_processo.img, doc_processo.comentario, doc_processo.id as id_img, tipos_doc.pasta, tipos_doc.seguradora, tipos_doc.segurado, tipos_doc.corretora, tipos_doc.id as id_tpDoc, tipos_doc.url FROM processos INNER JOIN doc_processo ON processos.num_processo = doc_processo.num_processo INNER JOIN tipos_doc ON tipos_doc.id = doc_processo.tipo_doc WHERE processos.num_processo = :num_processo");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	//BUSCANDO IMAGENS SELECIONADAS
	public function getImg($id){
		$sql = $this->db->prepare("SELECT doc_processo.img, tipos_doc.url FROM doc_processo INNER JOIN tipos_doc ON doc_processo.tipo_doc = tipos_doc.id WHERE doc_processo.id = :id");
		$sql->bindValue(":id", $id);
		$sql->execute();

		return $sql->fetch(PDO::FETCH_ASSOC);
	}
	//QUAL EMPRESA O USUARIO REPRESENTA
	public function getEmpresaID($id){
		$sql = $this->db->prepare("SELECT * FROM cad_p_juridica WHERE id = :id");
		$sql->bindValue(":id", $id);
		$sql->execute();

		return $sql->fetch(PDO::FETCH_ASSOC);
	}
	//HISTORICO
	public function getEvento($num_processo){
		$sql = $this->db->prepare("SELECT * FROM processo_evento WHERE num_processo = :num_processo ORDER BY id DESC");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}

	public function getProcessosSearchCliente($num_processo){
		$sql = $this->db->prepare("SELECT * FROM processos WHERE num_processo LIKE :num_processo '%'");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}

	public function getClienteId($id){
		$sql = $this->db->prepare("SELECT email FROM cad_p_fisica WHERE id = :id");
		$sql->bindValue(":id", $id);
		$sql->execute();

		return $sql->fetch(PDO::FETCH_ASSOC);
	}
}
<?php
date_default_timezone_set('America/Sao_Paulo');
class tipoDoc{
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
	//REGISTRANDO PASTAS
	public function setPasta($pasta, $seguradora, $segurado, $corretora, $url){
		$sql = $this->db->prepare("SELECT * FROM tipos_doc WHERE pasta = :pasta");
		$sql->bindValue(":pasta", $pasta);
		$sql->execute();

		if ($sql->rowCount() == 0) {
			$sql = $this->db->prepare("INSERT INTO tipos_doc SET 
				pasta = :pasta,
				seguradora = :seguradora,
				segurado = :segurado,
				corretora = :corretora,
				url = :url
				");
			$sql->bindValue(":pasta", $pasta);
			$sql->bindValue(":seguradora", $seguradora);
			$sql->bindValue(":segurado", $segurado);
			$sql->bindValue(":corretora", $corretora);
			$sql->bindValue(":url", $url);
			$sql->execute();
			//CRIANDO PASTA EM DIRETORIO
			mkdir($url, 0700);

			return true;
		} else {
			return false;
		}
	}
	//SELECIONANDO PASTAS
	public function getPastas($p, $limite){
		$sql = $this->db->prepare("SELECT *, (select COUNT(id) FROM tipos_doc) as count FROM tipos_doc LIMIT ".$p.", ".$limite."");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}

	//ALTERAÇÃO DE STATUS DE PASTAS
	public function altPastaStatus($status, $id){
		$sql = $this->db->prepare("UPDATE tipos_doc SET 
			status = :status WHERE id = :id");
		$sql->bindValue(":status", $status);
		$sql->bindValue(":id", $id);
		$sql->execute();

		return true;
	}
	//SELECIONAR PASTA POR ID
	public function pastaID($id){
		$sql = $this->db->prepare("SELECT * FROM tipos_doc WHERE id = :id");
		$sql->bindValue(":id", $id);
		$sql->execute();

		return $sql->fetch(PDO::FETCH_ASSOC);
	}

	//SALVAR ARQUIVO POR PROCESSO
	public function setDocProcesso($num_processo, $tipo_doc, $img, $comentario, $id_user){
		$sql = $this->db->prepare("INSERT INTO doc_processo SET 
			num_processo = :num_processo,
			tipo_doc = :tipo_doc,
			img = :img,
			comentario = :comentario,
			id_user = :id_user
			");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->bindValue(":tipo_doc", $tipo_doc);
		$sql->bindValue(":img", $img);
		$sql->bindValue(":comentario", $comentario);
		$sql->bindValue(":id_user", $id_user);
		$sql->execute();

		return true;
	}
	//SELECIONANDO DOCUMENTOS REGISTRADOS LISTA POR TIPO DE DOC & NUM_PROCESSO
	public function getDocRegProc($num_processo, $tipo_doc){
		$sql = $this->db->prepare("SELECT doc_processo.*, cad_func.nome, tipos_doc.url FROM doc_processo INNER JOIN cad_func ON doc_processo.id_user = cad_func.id INNER JOIN tipos_doc ON doc_processo.tipo_doc = tipos_doc.id WHERE doc_processo.num_processo = :num_processo AND doc_processo.tipo_doc = :tipo_doc");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->bindValue(":tipo_doc", $tipo_doc);
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	//DELETENADO IMAGEM DE DOCUMENTO EM PROCESSO
	public function delDocRegProc($id){
		$sql = $this->db->prepare("DELETE FROM doc_processo WHERE id = :id");
		$sql->bindValue(":id", $id);
		$sql->execute();

		return true;
	}
	//SELECIONAR IMG DO BANCO DE DADOS
	public function getIMGID($id){
		$sql = $this->db->prepare("SELECT img FROM doc_processo WHERE id = :id");
		$sql->bindValue(":id", $id);
		$sql->execute();

		return $sql->fetch(PDO::FETCH_ASSOC);
	}	
}
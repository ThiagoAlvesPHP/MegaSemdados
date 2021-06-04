<?php
date_default_timezone_set('America/Sao_Paulo');
class Usuario{
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
	public function getUsuarios(){
		$sql = $this->db->prepare("SELECT cad_usuarios.*, cad_func.nome FROM cad_usuarios INNER JOIN cad_func ON cad_usuarios.id_user = cad_func.id");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}

	//INSERIR DOCUMENTOS
	public function setDocs($titulo, $arquivo){

		$sql = $this->db->prepare("
			INSERT INTO cad_docs 
			SET titulo = :titulo,
			arquivo = :arquivo,
			id_user = :id_user");
		$sql->bindValue(':titulo', $titulo);
		$sql->bindValue(':arquivo', $arquivo);
		$sql->bindValue(':id_user', $_SESSION['cLogin']);
		$sql->execute();

		return true;
	}	

	public function getDocs(){
		$sql = $this->db->prepare("
			SELECT cad_docs.*, cad_func.nome 
			FROM cad_docs INNER JOIN cad_func 
			ON cad_docs.id_user = cad_func.id
			WHERE cad_docs.id_user = :id_user");
		$sql->bindValue(':id_user', $_SESSION['cLogin']);
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}

	public function getDocsLiberados($id_doc, $id_para){
		$sql = $this->db->prepare("
			SELECT * FROM cad_docs_liberados
			WHERE id_doc = :id_doc 
			AND id_de = :id_de
			AND id_para = :id_para");
		$sql->bindValue(':id_doc', $id_doc);
		$sql->bindValue(':id_de', $_SESSION['cLogin']);
		$sql->bindValue(':id_para', $id_para);
		$sql->execute();

		if ($sql->rowCount() > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function getDocsRecebidos(){
		$sql = $this->db->prepare("
			SELECT 
			cad_docs_liberados.*, 
			cad_docs.titulo, 
			cad_docs.arquivo,
			cad_func.nome 
			FROM cad_docs_liberados 
			INNER JOIN cad_docs 
			ON cad_docs_liberados.id_doc = cad_docs.id
			INNER JOIN cad_func 
			ON cad_docs_liberados.id_de = cad_func.id
			WHERE id_para = :id_para
			ORDER BY cad_docs_liberados.dt_cadastro DESC");
		$sql->bindValue(':id_para', $_SESSION['cLogin']);
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public function delDoc($id){
		$sql = $this->db->prepare("
			DELETE FROM cad_docs 
			WHERE id = :id
			AND id_user = :id_user");
		$sql->bindValue(':id', $id);
		$sql->bindValue(':id_user', $_SESSION['cLogin']);
		$sql->execute();

		return true;
	}
	public function delDocLiberados($id_doc){
		$sql = $this->db->prepare("
			DELETE FROM cad_docs_liberados 
			WHERE id_doc = :id_doc");
		$sql->bindValue(':id_doc', $id_doc);
		$sql->execute();

		return true;
	}
}
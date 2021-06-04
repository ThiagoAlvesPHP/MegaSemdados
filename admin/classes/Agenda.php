<?php
date_default_timezone_set('America/Sao_Paulo');
class Agenda{
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

	//INSERIR AGENDA
	public function setAgenda($lembrete, $data){		
		$sql = $this->db->prepare("
			INSERT INTO cad_agenda 
			SET lembrete = :lembrete,
			data = :data, 
			id_user = :id_user");
		$sql->bindValue(':lembrete', $lembrete);
		$sql->bindValue(':data', $data);
		$sql->bindValue(':id_user', $_SESSION['cLogin']);
		$sql->execute();

		return true;
	}

	//DELETANDO AGENDA
	public function delAgenda($id){
		$sql = $this->db->prepare("
			DELETE FROM cad_agenda 
			WHERE id = :id");
		$sql->bindValue(':id', $id);
		$sql->execute();

		return true;
	}
	
	//GET AGENDA POR DATA E ID DO USUARIO
	public function getAgendasData($data){
		$sql = $this->db->prepare('
			SELECT * FROM cad_agenda 
			WHERE DATE(data) = :data 
			AND id_user = :id_user');
		$sql->bindValue(':data', $data);
		$sql->bindValue(':id_user', $_SESSION['cLogin']);
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}

	//GET AGENDA POR DATA E ID DO USUARIO
	public function getAgendasDataCron(){
		$sql = $this->db->prepare('
			SELECT 
			cad_agenda.*,
			cad_func.nome,
			cad_func.email,
			cad_func.ult_acesso 
			FROM cad_agenda 
			INNER JOIN cad_func
			ON cad_agenda.id_user = cad_func.id
			WHERE DATE(data) = :data');
		$sql->bindValue(':data', date('Y-m-d'));
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
}
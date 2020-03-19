<?php
date_default_timezone_set('America/Sao_Paulo');
class Eventos{
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
	//SET ATIDADES
	public function setEvento($nat_evento){
		$sql = $this->db->prepare("INSERT INTO nat_eventos SET 
			nat_evento = :nat_evento
			");
		$sql->bindValue(":nat_evento", $nat_evento);
		$sql->execute();

		return true;
	}
	//GET ATIVIDADES
	public function getEventos($p, $limite){
		$sql = $this->db->prepare("SELECT *, (select COUNT(id) FROM tipos_doc) as count FROM nat_eventos LIMIT ".$p.", ".$limite."");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	//GET ATIVIDADE POR ID
	public function getEvento($id){
		$sql = $this->db->prepare("SELECT * FROM nat_eventos WHERE id = :id");
		$sql->bindValue(":id", $id);
		$sql->execute();

		return $sql->fetch(PDO::FETCH_ASSOC);
	}
	//UPDATE ATIDADES
	public function upEvento($nat_evento, $id){
		$sql = $this->db->prepare("UPDATE nat_eventos SET 
			nat_evento = :nat_evento WHERE id = :id");
		$sql->bindValue(":nat_evento", $nat_evento);
		$sql->bindValue(":id", $id);
		$sql->execute();

		return true;
	}
}
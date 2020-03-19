<?php
date_default_timezone_set('America/Sao_Paulo');
class Ramos{
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
	public function setRamo($ramo){
		$sql = $this->db->prepare("INSERT INTO nav_ramo SET 
			ramo = :ramo
			");
		$sql->bindValue(":ramo", $ramo);
		$sql->execute();

		return true;
	}
	//GET ATIVIDADES
	public function getRamos(){
		$sql = $this->db->prepare("SELECT * FROM nav_ramo");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	//GET ATIVIDADE POR ID
	public function getRamo($id){
		$sql = $this->db->prepare("SELECT * FROM nav_ramo WHERE id = :id");
		$sql->bindValue(":id", $id);
		$sql->execute();

		return $sql->fetch(PDO::FETCH_ASSOC);
	}
	//UPDATE ATIDADES
	public function upRamo($ramo, $id){
		$sql = $this->db->prepare("UPDATE nav_ramo SET 
			ramo = :ramo WHERE id = :id");
		$sql->bindValue(":ramo", $ramo);
		$sql->bindValue(":id", $id);
		$sql->execute();

		return true;
	}
}
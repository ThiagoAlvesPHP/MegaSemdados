<?php
date_default_timezone_set('America/Sao_Paulo');
class Atividades{
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
	public function setAtididade($atividade){
		$sql = $this->db->prepare("INSERT INTO atividades SET 
			atividade = :atividade");
		$sql->bindValue(":atividade", $atividade);
		$sql->execute();

		return true;
	}
	//GET ATIVIDADES
	public function getAtividades(){
		$sql = $this->db->prepare("SELECT * FROM atividades");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	//GET ATIVIDADE POR ID
	public function getAtividade($id){
		$sql = $this->db->prepare("SELECT * FROM atividades WHERE id = :id");
		$sql->bindValue(":id", $id);
		$sql->execute();

		return $sql->fetch(PDO::FETCH_ASSOC);
	}
	//UPDATE ATIDADES
	public function upAtididade($atividade, $id){
		$sql = $this->db->prepare("UPDATE atividades SET 
			atividade = :atividade WHERE id = :id");
		$sql->bindValue(":atividade", $atividade);
		$sql->bindValue(":id", $id);
		$sql->execute();

		return true;
	}
}
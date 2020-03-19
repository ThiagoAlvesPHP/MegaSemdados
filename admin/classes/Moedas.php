<?php
date_default_timezone_set('America/Sao_Paulo');
class Moedas{
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
	public function setMoeda($moeda, $nome){
		$sql = $this->db->prepare("INSERT INTO nav_moeda SET 
			moeda = :moeda,
			nome = :nome
			");
		$sql->bindValue(":moeda", $moeda);
		$sql->bindValue(":nome", $nome);
		$sql->execute();

		return true;
	}
	//GET ATIVIDADES
	public function getMoedas(){
		$sql = $this->db->prepare("SELECT * FROM nav_moeda");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	//GET ATIVIDADE POR ID
	public function getMoeda($id){
		$sql = $this->db->prepare("SELECT * FROM nav_moeda WHERE id = :id");
		$sql->bindValue(":id", $id);
		$sql->execute();

		return $sql->fetch(PDO::FETCH_ASSOC);
	}
	//UPDATE ATIDADES
	public function upMoeda($moeda, $nome, $id){
		$sql = $this->db->prepare("UPDATE nav_moeda SET 
			moeda = :moeda, nome = :nome WHERE id = :id");
		$sql->bindValue(":moeda", $moeda);
		$sql->bindValue(":nome", $nome);
		$sql->bindValue(":id", $id);
		$sql->execute();

		return true;
	}
}
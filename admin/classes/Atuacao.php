<?php
date_default_timezone_set('America/Sao_Paulo');
class Atuacao{
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
	public function setAtuacao($atuacao){
		$sql = $this->db->prepare("INSERT INTO atuacao SET 
			atuacao = :atuacao
			");
		$sql->bindValue(":atuacao", $atuacao);
		$sql->execute();

		return true;
	}
	//GET ATIVIDADES
	public function getAtuacao(){
		$sql = $this->db->prepare("SELECT * FROM atuacao");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	//GET ATIVIDADE POR ID
	public function getAtuacaoID($id){
		$sql = $this->db->prepare("SELECT * FROM atuacao WHERE id = :id");
		$sql->bindValue(":id", $id);
		$sql->execute();

		return $sql->fetch(PDO::FETCH_ASSOC);
	}
	//UPDATE ATIDADES
	public function upAtuacao($atuacao, $id){
		$sql = $this->db->prepare("UPDATE atuacao SET 
			atuacao = :atuacao WHERE id = :id");
		$sql->bindValue(":atuacao", $atuacao);
		$sql->bindValue(":id", $id);
		$sql->execute();

		return true;
	}
}
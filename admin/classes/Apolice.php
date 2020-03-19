<?php
date_default_timezone_set('America/Sao_Paulo');
class Apolice{
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
	//GET SEGURADO POR ID
	public function getSeguradoID($id){
		$sql = $this->db->prepare("SELECT * FROM cad_p_juridica WHERE id = :id");
		$sql->bindValue(":id", $id);
		$sql->execute();

		return $sql->fetch(PDO::FETCH_ASSOC);
	}
	//SET APOLICE
	public function setApolice($id_juridica, $id_ramo, $num_apolice, $de, $ate, $id_user){
		$sql = $this->db->prepare("INSERT INTO cad_apolice SET 
			id_juridica = :id_juridica,
			id_ramo = :id_ramo,
			num_apolice = :num_apolice,
			de = :de,
			ate = :ate,
			id_user = :id_user
			");
		$sql->bindValue(":id_juridica", $id_juridica);
		$sql->bindValue(":id_ramo", $id_ramo);
		$sql->bindValue(":num_apolice", $num_apolice);
		$sql->bindValue(":de", $de);
		$sql->bindValue(":ate", $ate);
		$sql->bindValue(":id_user", $id_user);
		$sql->execute();

		return true;
	}	
	//GET APOLICES GRID
	public function getApolices($p, $limite){
		$sql = $this->db->prepare("SELECT cad_apolice.*, cad_p_juridica.razao_social, cad_p_juridica.cnpj, cad_func.nome, nav_ramo.ramo, (select  COUNT(cad_apolice.id) from cad_apolice) as count FROM cad_apolice INNER JOIN cad_p_juridica ON cad_apolice.id_juridica = cad_p_juridica.id INNER JOIN cad_func ON cad_apolice.id_user = cad_func.id INNER JOIN nav_ramo ON cad_apolice.id_ramo = nav_ramo.id LIMIT ".$p.", ".$limite."");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	//GET APOLICES GRID
	public function getApoliceID($id){
		$sql = $this->db->prepare("SELECT cad_apolice.*, cad_p_juridica.razao_social, cad_p_juridica.cnpj, cad_func.nome, nav_ramo.ramo FROM cad_apolice INNER JOIN cad_p_juridica ON cad_apolice.id_juridica = cad_p_juridica.id INNER JOIN cad_func ON cad_apolice.id_user = cad_func.id INNER JOIN nav_ramo ON cad_apolice.id_ramo = nav_ramo.id WHERE cad_apolice.id = :id");
		$sql->bindValue(":id", $id);
		$sql->execute();

		return $sql->fetch(PDO::FETCH_ASSOC);
	}
	//UPDATE APOLICE
	public function upApolice($id_ramo, $num_apolice, $de, $ate, $id_user_at, $dt_at, $status, $id){
		$sql = $this->db->prepare("UPDATE cad_apolice SET 
			id_ramo = :id_ramo,
			num_apolice = :num_apolice,
			de = :de,
			ate = :ate,
			id_user_at = :id_user_at,
			dt_at = :dt_at,
			status = :status 
			WHERE id = :id
			");
		$sql->bindValue(":id_ramo", $id_ramo);
		$sql->bindValue(":num_apolice", $num_apolice);
		$sql->bindValue(":de", $de);
		$sql->bindValue(":ate", $ate);
		$sql->bindValue(":id_user_at", $id_user_at);
		$sql->bindValue(":dt_at", $dt_at);
		$sql->bindValue(":status", $status);
		$sql->bindValue(":id", $id);
		$sql->execute();

		return true;
	}
	public function getFuncApol($id){
		$sql = $this->db->prepare("SELECT * FROM cad_func WHERE id = :id");
		$sql->bindValue(":id", $id);
		$sql->execute();

		return $sql->fetch(PDO::FETCH_ASSOC);
	}
}
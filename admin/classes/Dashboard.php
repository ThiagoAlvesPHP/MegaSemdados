<?php
date_default_timezone_set('America/Sao_Paulo');
class Dashboard{
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
	//COUNT PESSOA FISICA
	public function countFisica(){
		$sql = $this->db->prepare("SELECT COUNT(id) as count FROM cad_p_fisica");
		$sql->execute();

		return $sql->fetch(PDO::FETCH_ASSOC);
	}
	//COUNT PESSOA JURIDICA
	public function countJuridica(){
		$sql = $this->db->prepare("SELECT COUNT(id) as count FROM cad_p_juridica");
		$sql->execute();

		return $sql->fetch(PDO::FETCH_ASSOC);
	}
	//COUNT FUNCIONARIOS
	public function countFuncionarios(){
		$sql = $this->db->prepare("SELECT COUNT(id) as count FROM cad_func");
		$sql->execute();

		return $sql->fetch(PDO::FETCH_ASSOC);
	}
	//COUNT FUNCIONARIOS
	public function countProcessos(){
		$sql = $this->db->prepare("SELECT COUNT(id) as count FROM processos");
		$sql->execute();

		return $sql->fetch(PDO::FETCH_ASSOC);
	}

	//COUNT FUNCIONARIOS
	public function ult_acesso($ult_acesso){
		$sql = $this->db->prepare("SELECT * FROM cad_func WHERE DATE(ult_acesso) = :ult_acesso ORDER BY ult_acesso DESC");
		$sql->bindValue(":ult_acesso", $ult_acesso);
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}

	//COUNT DIARIO DE BORDO
	public function countDiarioBordo($dt){
		$sql = $this->db->prepare("SELECT COUNT(id) as count FROM processo_diario WHERE DATE(dt_hs) = :dt");
		$sql->bindValue(":dt", $dt);
		$sql->execute();

		return $sql->fetch(PDO::FETCH_ASSOC);
	}
	public function getDiarioBordo($dt){
		$sql = $this->db->prepare("SELECT * FROM processo_diario WHERE DATE(dt_hs) = :dt");
		$sql->bindValue(":dt", $dt);
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}

	public function countGraficos($m){
		$sql = $this->db->prepare("SELECT COUNT(id) as c FROM processos WHERE YEAR(dt_cadastro) = YEAR(NOW()) AND MONTH(dt_cadastro) = :m");
		$sql->bindValue(":m", $m);
		$sql->execute();

		return $sql->fetch(PDO::FETCH_ASSOC);
	}
	public function countGraficosMensal($d){
		$sql = $this->db->prepare("SELECT COUNT(id) as c FROM processos WHERE YEAR(dt_cadastro) = YEAR(NOW()) AND MONTH(dt_cadastro) = MONTH(NOW()) AND DAY(dt_cadastro) = :d");
		$sql->bindValue(":d", $d);
		$sql->execute();

		return $sql->fetch(PDO::FETCH_ASSOC);
	}

	public function getNiverFuncionarios(){
		$sql = $this->db->prepare("
			SELECT nome, dt_nasc 
			FROM cad_func
			WHERE MONTH(dt_nasc) = :mes");
		$sql->bindValue(":mes", date('m'));
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}

}
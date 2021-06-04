<?php
date_default_timezone_set('America/Sao_Paulo');
class Funcionarios{
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
	public function getFunc(){
		$sql = $this->db->prepare("SELECT * FROM cad_func ORDER BY nome ASC");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	public function getFuncionario($id){
		$sql = $this->db->prepare("SELECT * FROM cad_func WHERE id = :id");
		$sql->bindValue(":id", $id);
		$sql->execute();

		return $sql->fetch(PDO::FETCH_ASSOC);
	}
	public function upFunc($nome, $cpf, $rg, $dt_nasc, $email, $nivel, $status, $id){
		$sql = $this->db->prepare("UPDATE cad_func SET 
			nome = :nome,
			cpf = :cpf,
			rg = :rg,
			dt_nasc = :dt_nasc,
			email = :email,
			nivel = :nivel,
			status = :status WHERE 
			id = :id
			");
		$sql->bindValue(":nome", $nome);
		$sql->bindValue(":cpf", $cpf);
		$sql->bindValue(":rg", $rg);
		$sql->bindValue(":dt_nasc", $dt_nasc);
		$sql->bindValue(":email", $email);
		$sql->bindValue(":nivel", $nivel);
		$sql->bindValue(":status", $status);
		$sql->bindValue(":id", $id);
		$sql->execute();

		return true;
	}
	public function upPassFun($senha, $id){
		$sql = $this->db->prepare("UPDATE cad_func SET senha = :senha WHERE id = :id");
		$sql->bindValue(":senha", md5($senha));
		$sql->bindValue(":id", $id);
		$sql->execute();

		return true;
	}
}
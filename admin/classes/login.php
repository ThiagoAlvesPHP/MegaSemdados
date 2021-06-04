<?php
date_default_timezone_set('America/Sao_Paulo');
class login{
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
	//LOGAR
	public function logar($login, $senha){
		$dados = array();

		$sql = $this->db->prepare("SELECT id FROM cad_func WHERE 
			login = :login AND senha = :senha AND status = 1");
		$sql->bindValue(":login", $login);
		$sql->bindValue(":senha", md5($senha));
		$sql->execute();

		if ($sql->rowCount() > 0) {
			$dados = $sql->fetch(PDO::FETCH_ASSOC);
			$_SESSION['cLogin'] = $dados['id'];
			
			$ult_acesso = date('Y-m-d H:i:s');
			$sql = $this->db->prepare("UPDATE cad_func SET ult_acesso = :ult_acesso WHERE id = :id");
			$sql->bindValue(":ult_acesso", $ult_acesso);
			$sql->bindValue(":id", $_SESSION['cLogin']);
			$sql->execute();
			
			return true;
		} else {
			return false;
		}	
	}
}
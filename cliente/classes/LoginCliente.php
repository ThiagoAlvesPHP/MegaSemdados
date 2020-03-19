<?php
date_default_timezone_set('America/Sao_Paulo');
class LoginCliente{
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
	public function logarCliente($email, $senha){
		$dados = array();

		$sql = $this->db->prepare("SELECT id FROM cad_p_fisica WHERE 
			email = :email AND senha = :senha AND status = 1");
		$sql->bindValue(":email", $email);
		$sql->bindValue(":senha", md5($senha));
		$sql->execute();

		if ($sql->rowCount() > 0) {
			$dados = $sql->fetch(PDO::FETCH_ASSOC);
			$_SESSION['cLoginCliente'] = $dados['id'];

			$sql = $this->db->prepare("
				INSERT INTO historico_acesso_clientes 
				SET id_user = :id_user");
			$sql->bindValue(':id_user', $dados['id']);
			$sql->execute();

			return true;
		} else {
			return false;
		}	
	}
}
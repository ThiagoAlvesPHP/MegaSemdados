<?php
date_default_timezone_set('America/Sao_Paulo');
class Cliente{
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
	public function cliente($id){
		$sql = $this->db->prepare("SELECT cad_p_fisica.*, cad_p_juridica.id as id_juridica, cad_p_juridica.razao_social, cad_p_juridica.segurado, cad_p_juridica.seguradora, cad_p_juridica.corretora FROM cad_p_fisica INNER JOIN cad_p_juridica ON cad_p_fisica.id_empresa = cad_p_juridica.id WHERE cad_p_fisica.id = :id");
		$sql->bindValue(":id", $id);
		$sql->execute();

		return $sql->fetch(PDO::FETCH_ASSOC);	
	}
	public function upPassCliente($senha, $id){
		$sql = $this->db->prepare("UPDATE cad_p_fisica SET senha = :senha WHERE id = :id");
		$sql->bindValue(":senha", md5($senha));
		$sql->bindValue(":id", $id);
		$sql->execute();

		return true;
	}
}
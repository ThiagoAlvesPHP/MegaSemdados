<?php
date_default_timezone_set('America/Sao_Paulo');
class Financeiro{
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
	public function setContas($post){
		$fields = [];
        foreach ($post as $key => $value) {
            $fields[] = "$key=:$key";
        }
        $fields = implode(', ', $fields);

		$sql = $this->db->prepare("
			INSERT INTO cad_contas 
			SET {$fields}
			");

		foreach ($post as $key => $value) {
            $sql->bindValue(":{$key}", $value);
        }
		$sql->execute();

		return true;
	}
	public function getContas($type_register, $mes = '', $ano = ''){
		echo "<br><br><br>";
		if (empty($mes)) {
			$mes = date('m');
			$ano = date('Y');
		}
		$sql = $this->db->prepare("
			SELECT * FROM cad_contas 
			WHERE type_register = :type_register
			AND MONTH(vencimento) = :mes
			AND YEAR(vencimento) = :ano
			");
		
		$sql->bindValue(":type_register", $type_register);
		$sql->bindValue(":mes", $mes);
		$sql->bindValue(":ano", $ano);
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}

	public function delConta($id){	
		$sql = $this->db->prepare("
			DELETE FROM cad_contas WHERE id = :id
			");
		
		$sql->bindValue(":id", $id);
		$sql->execute();

		return true;
	}
}
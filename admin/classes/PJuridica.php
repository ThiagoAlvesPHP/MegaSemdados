<?php
date_default_timezone_set('America/Sao_Paulo');
class PJuridica{
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
	public function getPJuridica($p, $limite){
		$sql = $this->db->prepare("SELECT cad_p_juridica.*, cad_func.nome as a, (select  COUNT(cad_p_juridica.id) from cad_p_juridica) as count FROM cad_p_juridica INNER JOIN cad_func ON cad_p_juridica.id_user = cad_func.id ORDER BY cad_p_juridica.razao_social ASC LIMIT ".$p.", ".$limite."");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	public function getFuncAt($id){
		$sql = $this->db->prepare("SELECT * FROM cad_func WHERE id = :id");
		$sql->bindValue(":id", $id);
		$sql->execute();

		return $sql->fetch(PDO::FETCH_ASSOC);
	}
	//DADOS DE PESSOA FISICA - PAGINA pessoaPFForm.php
	public function getPJuridicaID($id){
		$sql = $this->db->prepare("SELECT * FROM cad_p_juridica WHERE id = :id");
		$sql->bindValue(":id", $id);
		$sql->execute();

		return $sql->fetch(PDO::FETCH_ASSOC);
	}
	public function upPJForm($post){
		$fields = [];
        foreach ($post as $key => $value) {
            $fields[] = "$key=:$key";
        }
        $fields = implode(', ', $fields);
		$sql = $this->db->prepare("UPDATE cad_p_juridica SET {$fields} WHERE id = {$post['id']}");

		foreach ($post as $key => $value) {
            $sql->bindValue(":{$key}", $value);
        }
		$sql->execute();
	}
}
<?php
date_default_timezone_set('America/Sao_Paulo');
class Rdp{
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

	//buscar rdp por num_processo
	public function getAll($num_processo){	
		$array = array();

		$sql = $this->db->prepare("
			SELECT 
			rdp.*, cad_func.nome 
			FROM rdp 
			INNER JOIN cad_func
			ON rdp.id_user = cad_func.id
			WHERE rdp.num_processo = :num_processo");
		$sql->bindValue(':num_processo', $num_processo);
		$sql->execute();

		if ($sql->rowCount() > 0) {
			$array = $sql->fetchAll(PDO::FETCH_ASSOC);
		}

		return $array;
	}
	//inseriri rdp
	public function setRDP($post){
		$post['id_user'] = $_SESSION['cLogin'];

		$fields = [];
        foreach ($post as $key => $value) {
            $fields[] = "$key=:$key";
        }
        $fields = implode(', ', $fields);

		$sql = $this->db->prepare("
			INSERT INTO rdp 
			SET {$fields}
			");

		foreach ($post as $key => $value) {
            $sql->bindValue(":{$key}", $value);
        }
		$sql->execute();
	}
	//deletar rdp
	public function delRDP($id){
		$sql = $this->db->prepare("
			DELETE FROM rdp 
			WHERE id = :id
			");
		$sql->bindValue(":id", $id);
		$sql->execute();
	}
	//atualizar rdp
	public function upRDP($post){
		$fields = [];
        foreach ($post as $key => $value) {
            $fields[] = "$key=:$key";
        }
        $fields = implode(', ', $fields);

		$sql = $this->db->prepare("
			UPDATE rdp 
			SET {$fields}
			WHERE id = :id
			");

		$sql->bindValue(":id", $post['id']);
		foreach ($post as $key => $value) {
            $sql->bindValue(":{$key}", $value);
        }
		$sql->execute();
	}

	//inserir despesas sos
	public function setSOS($post){
		$post['id_user'] = $_SESSION['cLogin'];

		$fields = [];
        foreach ($post as $key => $value) {
            $fields[] = "$key=:$key";
        }
        $fields = implode(', ', $fields);

		$sql = $this->db->prepare("
			INSERT INTO despesas_sos 
			SET {$fields}
			");

		foreach ($post as $key => $value) {
            $sql->bindValue(":{$key}", $value);
        }
		$sql->execute();
	}
	//buscar rdp por num_processo
	public function getSosAll($num_processo){	
		$array = array();

		$sql = $this->db->prepare("
			SELECT 
			despesas_sos.*, 
			cad_func.nome 
			FROM despesas_sos 
			INNER JOIN cad_func
			ON despesas_sos.id_user = cad_func.id
			WHERE despesas_sos.num_processo = :num_processo
			ORDER BY despesas_sos.dt_cadastro ASC");
		$sql->bindValue(':num_processo', $num_processo);
		$sql->execute();

		if ($sql->rowCount() > 0) {
			$array = $sql->fetchAll(PDO::FETCH_ASSOC);
		}

		return $array;
	}
	//deletar rdp
	public function delSOS($id){
		$sql = $this->db->prepare("
			DELETE FROM despesas_sos 
			WHERE id = :id
			");
		$sql->bindValue(":id", $id);
		$sql->execute();
	}
	//atualizar sos
	public function upSOS($post){
		$fields = [];
        foreach ($post as $key => $value) {
            $fields[] = "$key=:$key";
        }
        $fields = implode(', ', $fields);

		$sql = $this->db->prepare("
			UPDATE despesas_sos 
			SET {$fields}
			WHERE id = :id
			");

		$sql->bindValue(":id", $post['id']);
		foreach ($post as $key => $value) {
            $sql->bindValue(":{$key}", $value);
        }
		$sql->execute();
	}
}
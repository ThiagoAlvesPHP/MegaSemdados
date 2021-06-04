<?php
date_default_timezone_set('America/Sao_Paulo');
class Cadastros{
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
	//CADASTRO DE PESSOA FISICA
	public function setPFForm($id_empresa, $apelido, $nome, $sobrenome, $email, $senha, $cpf, $rg, $org_em, $dt_emissao, $sexo, $dt_nac, $tel01, $tel02, $outras, $status, $id_user){
		$sql = $this->db->prepare("SELECT * FROM cad_p_fisica WHERE email = :email");
		$sql->bindValue(":email", $email);
		$sql->execute();

		if ($sql->rowCount() == 0) {
			$sql = $this->db->prepare("INSERT INTO cad_p_fisica SET 
				id_empresa = :id_empresa,
				apelido = :apelido, 
				nome = :nome,
				sobrenome = :sobrenome, 
				email = :email,
				senha = :senha,
				cpf = :cpf, 
				rg = :rg, 
				org_em = :org_em,
				dt_emissao = :dt_emissao, 
				sexo = :sexo,
				dt_nac = :dt_nac, 
				tel01 = :tel01, 
				tel02 = :tel02,
				outras = :outras,
				status = :status, 
				id_user = :id_user
				");
			$sql->bindValue(":id_empresa", $id_empresa);
			$sql->bindValue(":apelido", $apelido);
			$sql->bindValue(":nome", $nome);
			$sql->bindValue(":sobrenome", $sobrenome);
			$sql->bindValue(":email", $email);
			$sql->bindValue(":senha", md5($senha));
			$sql->bindValue(":cpf", $cpf);
			$sql->bindValue(":rg", $rg);
			$sql->bindValue(":org_em", $org_em);
			$sql->bindValue(":dt_emissao", $dt_emissao);
			$sql->bindValue(":sexo", $sexo);
			$sql->bindValue(":dt_nac", $dt_nac);
			$sql->bindValue(":tel01", $tel01);
			$sql->bindValue(":tel02", $tel02);
			$sql->bindValue(":outras", $outras);
			$sql->bindValue(":status", $status);
			$sql->bindValue(":id_user", $id_user);
			$sql->execute();

			return true;
		} else {
			return false;
		}
	}
	//CADASTRO DE PESSOA JURIDICA
	public function setPJForm($post){
		$fields = [];
        foreach ($post as $key => $value) {
            $fields[] = "$key=:$key";
        }
        $fields = implode(', ', $fields);
		$sql = $this->db->prepare("INSERT INTO cad_p_juridica SET {$fields}");

		foreach ($post as $key => $value) {
            $sql->bindValue(":{$key}", strtoupper($value));
        }
		$sql->execute();		
	}
	//SET DE FUNCIONARIOS
	public function setFuncionario($nome, $cpf, $rg, $dt_nasc, $email, $login, $senha, $nivel){
		$sql = $this->db->prepare("SELECT * FROM cad_func WHERE login = :login OR cpf = :cpf");
		$sql->bindValue(":login", $login);
		$sql->bindValue(":cpf", $cpf);
		$sql->execute();
		if ($sql->rowCount() == 0) {
			$sql = $this->db->prepare("INSERT INTO cad_func SET 
				nome = :nome,
				cpf = :cpf,
				rg = :rg,
				dt_nasc = :dt_nasc,
				email = :email,
				login = :login,
				senha = :senha,
				nivel = :nivel
				");
			$sql->bindValue(":nome", $nome);
			$sql->bindValue(":cpf", $cpf);
			$sql->bindValue(":rg", $rg);
			$sql->bindValue(":dt_nasc", $dt_nasc);
			$sql->bindValue(":email", $email);
			$sql->bindValue(":login", $login);
			$sql->bindValue(":senha", md5($senha));
			$sql->bindValue(":nivel", $nivel);
			$sql->execute();

			return true;
		} else {
			return false;
		}
	}
}
<?php
date_default_timezone_set('America/Sao_Paulo');
class Pfisica{
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
	public function getPFisicas($p, $limite){
		$sql = $this->db->prepare("SELECT cad_p_fisica.*, cad_func.nome as nm, cad_p_juridica.razao_social as a, (select  COUNT(cad_p_fisica.id) from cad_p_fisica) as count FROM cad_p_fisica INNER JOIN cad_func ON cad_p_fisica.id_user = cad_func.id INNER JOIN cad_p_juridica ON cad_p_fisica.id_empresa = cad_p_juridica.id LIMIT ".$p.", ".$limite."");
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
	public function getPFisica($id){
		$sql = $this->db->prepare("SELECT * FROM cad_p_fisica WHERE id = :id");
		$sql->bindValue(":id", $id);
		$sql->execute();

		return $sql->fetch(PDO::FETCH_ASSOC);
	}
	public function upPFForm($apelido, $nome, $sobrenome, $email, $cpf, $rg, $org_em, $dt_emissao, $sexo, $dt_nac, $tel01, $tel02, $outras, $status, $id_user_at, $dt_at, $id){
		$sql = $this->db->prepare("UPDATE cad_p_fisica SET 
			apelido = :apelido, 
			nome = :nome,
			sobrenome = :sobrenome, 
			email = :email,
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
			id_user_at = :id_user_at,
			dt_at = :dt_at WHERE id = :id
			");
		$sql->bindValue(":apelido", $apelido);
		$sql->bindValue(":nome", $nome);
		$sql->bindValue(":sobrenome", $sobrenome);
		$sql->bindValue(":email", $email);
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
		$sql->bindValue(":id_user_at", $id_user_at);
		$sql->bindValue(":dt_at", $dt_at);
		$sql->bindValue(":id", $id);
		$sql->execute();

		return true;
	}
	public function upPFFormPass($senha, $id){
		$sql = $this->db->prepare("UPDATE cad_p_fisica SET 
			senha = :senha WHERE id = :id");
		$sql->bindValue(":senha", md5($senha));
		$sql->bindValue(":id", $id);
		$sql->execute();

		return true;
	}

	//DADOS DE PESSOA FISICA - PAGINA pessoaPFForm.php
	public function getPFisicasEmpresa($id_empresa){
		$sql = $this->db->prepare("SELECT cad_p_fisica.*, cad_p_juridica.razao_social FROM cad_p_fisica INNER JOIN cad_p_juridica ON cad_p_fisica.id_empresa = cad_p_juridica.id WHERE id_empresa = :id_empresa");
		$sql->bindValue(":id_empresa", $id_empresa);
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}

	public function getHistorico($id_user){
		$sql = $this->db->prepare("
			SELECT 
			cad_p_fisica.apelido, 
			cad_p_juridica.razao_social,
			historico_acesso_clientes.dt_cadastro 
			FROM cad_p_fisica INNER JOIN cad_p_juridica 
			ON cad_p_fisica.id_empresa = cad_p_juridica.id 
			INNER JOIN historico_acesso_clientes 
			ON historico_acesso_clientes.id_user = cad_p_fisica.id
			WHERE historico_acesso_clientes.id_user = :id_user");
		$sql->bindValue(":id_user", $id_user);
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}

	public function delHistorico(){
		$data = date('Y-m-d',strtotime("-7 day"));

		$sql = $this->db->prepare("
			DELETE FROM historico_acesso_clientes 
			WHERE dt_cadastro < :data");
		$sql->bindValue(":data", $data);
		$sql->execute();

		return true;
	}
}
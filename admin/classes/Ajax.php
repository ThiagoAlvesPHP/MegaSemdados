<?php
date_default_timezone_set('America/Sao_Paulo');
class Ajax{
	private $db;
	public function __construct(){
		$optionss = [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"];
		$file = file_get_contents('classes/config.json');
		$options = json_decode($file, true);
		$config = array();
		$config['db'] = $options['db'];
		$config['host'] = $options['localhost'];
		$config['user'] = $options['user'];
		$config['pass'] = $options['pass'];
		try {
			$this->db = new PDO("mysql:dbname=".$config['db'].";host=".$config['host']."", "".$config['user']."", "".$config['pass']."", $optionss);
		} catch(PDOException $e) {
			echo "FALHA: ".$e->getMessage();
		}
	}

	public function getAllSearch($sql){
		$sql = $this->db->prepare($sql);
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	//count processos
	public function countProcessos(){
		$sql = $this->db->query("SELECT COUNT(*) as c FROM processos");

		return $sql->fetch(PDO::FETCH_ASSOC);
	}

	//consultar motorista
	public function getMotorista($motorista, $id_ramo){
		$array = array();
		$sql = $this->db->prepare("
			SELECT 
			processos.num_processo, 
			nav_ramo.ramo,
			processo16.p3, 
			processo16.p4,
            processo16.p15, 
            processo16.p16, 
            processo16.p17,
            processo16.p9 as dt_nascimento,
			processo15.p7 as placa1, 
			processo15.p9,
            processo15.p11 as ano1,
            processo15.p14 as placa2,
            processo15.p18 as ano2,
            processo15.p21 as placa3,
            processo15.p25 as ano3,
            processo_dados_acontecimento.id_cidade,
            processo_dados_acontecimento.id_nat_evento,
            processo_dados_acontecimento.dt_hs
			FROM 
			processos INNER JOIN nav_ramo
			ON processos.id_ramo = nav_ramo.id
			INNER JOIN processo15 
			ON processos.num_processo = processo15.num_processo
			INNER JOIN processo16
			ON processos.num_processo = processo16.num_processo
            INNER JOIN processo_dados_acontecimento
            ON processos.num_processo = processo_dados_acontecimento.num_processo
		   	WHERE processos.id_ramo = :id_ramo
           	AND processo16.p3 LIKE '%' :motorista '%'
			");
		$sql->bindValue(":motorista", $motorista);
		$sql->bindValue(":id_ramo", $id_ramo);
		$sql->execute();

		if ($sql->rowCount() > 0) {
			$array = $sql->fetchAll(PDO::FETCH_ASSOC);

			foreach ($array as $key => $value) {

				$array[$key]['nat_evento'] = $this->getAuxiliarGetMotorista($value['id_nat_evento']);

				$array[$key]['segurado'] = $this->getAuxiliarGetMotorista2($value['num_processo']);

				$array[$key]['cidade'] = $this->geAuxiliarCidade($value['id_cidade']);

				$array[$key]['num_sinistro'] = $this->getAuxiliarSinistro($value['num_processo']);
			}
		}

		return $array;
	}

	public function getAuxiliarGetMotorista($id){
		$nat = '';
		$sql = $this->db->prepare("
			SELECT nat_evento 
			FROM nat_eventos 
			WHERE id = :id");
		$sql->bindValue(':id', $id);
		$sql->execute();

		if ($sql->rowCount() > 0) {
			$array = $sql->fetch(PDO::FETCH_ASSOC);

			return $array;
		}
	}
	public function getAuxiliarGetMotorista2($num_processo){
		$sql = $this->db->prepare("
			SELECT 
			cad_p_juridica.razao_social
			FROM processos 
			INNER JOIN cad_p_juridica 
			ON processos.id_segurado = cad_p_juridica.id 
			WHERE processos.num_processo = :num_processo");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->execute();

		$dados = $sql->fetch(PDO::FETCH_ASSOC);

		return $dados['razao_social'];
	}
	public function geAuxiliarCidade($id_cidade){
		$sql = $this->db->prepare("
			SELECT 
			estado.uf, 
			cidade.nome 
			FROM estado
			INNER JOIN cidade ON cidade.estado = estado.id 
			WHERE cidade.id = :id_cidade");
		$sql->bindValue(":id_cidade", $id_cidade);
		$sql->execute();

		return $sql->fetch(PDO::FETCH_ASSOC);
	}
	public function getAuxiliarSinistro($num_processo){
		$sql = $this->db->prepare("
			SELECT 
			num_sinistro 
			FROM processos 
			WHERE num_processo = :num_processo");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->execute();

		return $sql->fetch(PDO::FETCH_ASSOC);
	}

	//GET APOLICE POR ID
	public function getApolicID($id){
		$sql = $this->db->prepare("
			SELECT cad_apolice.*, 
			(SELECT cad_p_juridica.cnpj FROM cad_p_juridica WHERE cad_p_juridica.id = :id) as cnpj 
			FROM cad_apolice 
			WHERE 
			cad_apolice.id_juridica = :id
			AND 
			cad_apolice.status = 1");
		$sql->bindValue(":id", $id);
		$sql->execute();
		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
	//GET TRANSPORTADORA POR ID
	public function getTranspID($id){
		$sql = $this->db->prepare("SELECT cnpj FROM cad_p_juridica WHERE id = :id");
		$sql->bindValue(":id", $id);
		$sql->execute();
		return $sql->fetch(PDO::FETCH_ASSOC);
	}
	//GET TRANSPORTADORA POR ID
	public function getCorretoraID($id){
		$sql = $this->db->prepare("SELECT cnpj FROM cad_p_juridica WHERE id = :id");
		$sql->bindValue(":id", $id);
		$sql->execute();
		return $sql->fetch(PDO::FETCH_ASSOC);
	}
	//GET CIDADE POR NOME
	public function getCidade($nome){
		$sql = $this->db->prepare("SELECT pais.sigla, estado.uf, cidade.nome, cidade.id FROM cidade INNER JOIN estado ON cidade.estado = estado.id INNER JOIN pais ON estado.pais = pais.id WHERE cidade.nome LIKE :nome '%'");
		$sql->bindValue(":nome", $nome);
		$sql->execute();
		return $sql->fetchAll(PDO::FETCH_ASSOC);	
	}
	//JURIDICA POR RAZÃO SOCIAL
	public function getPJuridicaRS($razao_social){
		$sql = $this->db->prepare("SELECT cad_p_juridica.*, cad_func.nome FROM cad_p_juridica INNER JOIN cad_func ON cad_p_juridica.id_user = cad_func.id WHERE razao_social LIKE :razao_social '%'");
		$sql->bindValue(":razao_social", $razao_social);
		$sql->execute();
		return $sql->fetchAll(PDO::FETCH_ASSOC);	
	}
	//FISICA POR RAZÃO SOCIAL
	public function getPFisicaAj($apelido){
		$sql = $this->db->prepare("SELECT cad_p_fisica.*, cad_p_juridica.razao_social, cad_func.nome as n FROM cad_p_fisica INNER JOIN cad_p_juridica ON cad_p_fisica.id_empresa = cad_p_juridica.id INNER JOIN cad_func ON cad_p_fisica.id_user = cad_func.id WHERE apelido LIKE :apelido '%'");
		$sql->bindValue(":apelido", $apelido);
		$sql->execute();
		return $sql->fetchAll(PDO::FETCH_ASSOC);	
	}
	//APOLICE
	public function getApolice($num_processo){
		$sql = $this->db->prepare("
			SELECT 
			cad_apolice.*, 
			cad_p_juridica.razao_social, 
			cad_p_juridica.cnpj, 
			cad_func.nome FROM cad_apolice INNER JOIN cad_p_juridica ON cad_apolice.id_juridica = cad_p_juridica.id INNER JOIN cad_func ON cad_apolice.id_user = cad_func.id WHERE cad_apolice.num_apolice LIKE :num_processo '%'");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->execute();
		return $sql->fetchAll(PDO::FETCH_ASSOC);	
	}
	//consultando processo via like
	public function getProcessosSearch($num_processo){
		$array = array();

		$sql = $this->db->prepare("
			SELECT * FROM processos 
			WHERE num_processo 
			LIKE :num_processo '%'");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->execute();

		if ($sql->rowCount() > 0) {
			$array = $sql->fetchAll(PDO::FETCH_ASSOC);
			foreach ($array as $key => $value) {
				$array[$key]['seguradora'] = $this->getPFisica($value['id_seguradora']);
				$array[$key]['segurado'] = $this->getPFisica($value['id_segurado']);
				$array[$key]['transportadora'] = $this->getPFisica($value['id_transportadora']);
			}
		}
		return $array;
	}
	public function getProc($num_processo){
		$array = array();

		$sql = $this->db->prepare("
			SELECT * FROM processos 
			WHERE num_processo 
			LIKE :num_processo");
		$sql->bindValue(":num_processo", $num_processo);
		$sql->execute();

		if ($sql->rowCount() > 0) {
			$array = $sql->fetch(PDO::FETCH_ASSOC);
			$array['seguradora'] = $this->getPFisica($array['id_seguradora']);
			$array['segurado'] = $this->getPFisica($array['id_segurado']);
			$array['transportadora'] = $this->getPFisica($array['id_transportadora']);
		}
		return $array;
	}
	public function getPFisica($id){
		$sql = $this->db->prepare("
			SELECT razao_social FROM cad_p_juridica 
			WHERE id = :id");
		$sql->bindValue(":id", $id);
		$sql->execute();
		$razao_social = $sql->fetch(PDO::FETCH_ASSOC);
		return $razao_social['razao_social'];
	}

	public function setTextoImgPreliminar($id, $texto){
		$sql = $this->db->prepare("UPDATE processo_img_preliminar SET texto = :texto WHERE id = :id");
		$sql->bindValue(":texto", $texto);
		$sql->bindValue(":id", $id);
		$sql->execute();
		die(json_encode(true));
	}
	public function setTextoReportFT($id, $texto){
		$sql = $this->db->prepare("UPDATE processo_report_ft SET texto = :texto WHERE id = :id");
		$sql->bindValue(":texto", $texto);
		$sql->bindValue(":id", $id);
		$sql->execute();
		die(json_encode(true));
	}
	public function setTextoFtSinin($id, $texto){
		$sql = $this->db->prepare("UPDATE processo_img_sinistro SET texto = :texto WHERE id = :id");
		$sql->bindValue(":texto", $texto);
		$sql->bindValue(":id", $id);
		$sql->execute();
		die(json_encode(true));
	}
	public function setTextoFtSal($id, $texto){
		$sql = $this->db->prepare("UPDATE processo_img_salvados SET texto = :texto WHERE id = :id");
		$sql->bindValue(":texto", $texto);
		$sql->bindValue(":id", $id);
		$sql->execute();
		die(json_encode(true));
	}
	public function setTextoVist($id, $texto){
		$sql = $this->db->prepare("UPDATE processo_vistoria_img SET texto = :texto WHERE id = :id");
		$sql->bindValue(":texto", $texto);
		$sql->bindValue(":id", $id);
		$sql->execute();
		die(json_encode(true));
	}
	public function setVisDoc($id_doc, $id_para){
		$sql = $this->db->prepare("
			INSERT INTO cad_docs_liberados
			SET id_doc = :id_doc, 
			id_de = :id_de,
			id_para = :id_para");
		$sql->bindValue(':id_doc', $id_doc);
		$sql->bindValue(':id_de', $_SESSION['cLogin']);
		$sql->bindValue(':id_para', $id_para);
		$sql->execute();
		return true;
	}
	public function delVisDoc($id_doc, $id_para){
		$sql = $this->db->prepare("
			DELETE FROM cad_docs_liberados
			WHERE id_doc = :id_doc
			AND id_de = :id_de
			AND id_para = :id_para");
		$sql->bindValue(':id_doc', $id_doc);
		$sql->bindValue(':id_de', $_SESSION['cLogin']);
		$sql->bindValue(':id_para', $id_para);
		$sql->execute();
		return true;
	}
}
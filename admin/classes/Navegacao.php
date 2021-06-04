<?php
date_default_timezone_set('America/Sao_Paulo');
class Navegacao{
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

	//ATUALIZAR MENU1
	public function navMercadoriaUp($nome, $id){
		$sql = $this->db->prepare("UPDATE nav_mercadoria SET nome=:nome WHERE id=:id");
		$sql->bindValue(":nome", $nome);
		$sql->bindValue(":id", $id);
		$sql->execute();

		return true;
	}
	//ATUALIZAR MENU2
	public function navEmbalagemUp($embalagem, $id){
		$sql = $this->db->prepare("UPDATE nav_embalagem SET embalagem=:embalagem WHERE id=:id");
		$sql->bindValue(":embalagem", $embalagem);
		$sql->bindValue(":id", $id);
		$sql->execute();

		return true;
	}
	//ATUALIZAR MENU3
	public function navUnidadeUp($nome, $id){
		$sql = $this->db->prepare("UPDATE nav_unidade SET nome=:nome WHERE id=:id");
		$sql->bindValue(":nome", $nome);
		$sql->bindValue(":id", $id);
		$sql->execute();

		return true;
	}
	//ATUALIZAR MENU4
	public function navStatusMercUp($status, $id){
		$sql = $this->db->prepare("UPDATE nav_status_mercadoria SET status=:status WHERE id=:id");
		$sql->bindValue(":status", $status);
		$sql->bindValue(":id", $id);
		$sql->execute();

		return true;
	}
	//ATUALIZAR MENU5
	public function navStatusEmbUp($status, $id){
		$sql = $this->db->prepare("UPDATE nav_status_embalagem SET status=:status WHERE id=:id");
		$sql->bindValue(":status", $status);
		$sql->bindValue(":id", $id);
		$sql->execute();

		return true;
	}

	//REGISTRAR MENU1
	public function setMercadoria($nome){
		$sql = $this->db->prepare("INSERT INTO nav_mercadoria SET nome=:nome");
		$sql->bindValue(":nome", $nome);
		$sql->execute();

		return true;
	}
	//REGISTRAR MENU2
	public function setEmbalagem($embalagem){
		$sql = $this->db->prepare("INSERT INTO nav_embalagem SET embalagem=:embalagem");
		$sql->bindValue(":embalagem", $embalagem);
		$sql->execute();

		return true;
	}
	//REGISTRAR MENU3
	public function setUnidade($nome){
		$sql = $this->db->prepare("INSERT INTO nav_unidade SET nome=:nome");
		$sql->bindValue(":nome", $nome);
		$sql->execute();

		return true;
	}
	//REGISTRAR MENU4
	public function setStatusMerc($status){
		$sql = $this->db->prepare("INSERT INTO nav_status_mercadoria SET status=:status");
		$sql->bindValue(":status", $status);
		$sql->execute();

		return true;
	}
	//REGISTRAR MENU5
	public function setStatusEmb($status){
		$sql = $this->db->prepare("INSERT INTO nav_status_embalagem SET status=:status");
		$sql->bindValue(":status", $status);
		$sql->execute();

		return true;
	}
	
	//ATUALIZAR MENU1 - PAGINA nav_12_13_14.php
	public function navAvariasUp($dano, $id){
		$sql = $this->db->prepare("UPDATE nav_avarias SET dano=:dano WHERE id=:id");
		$sql->bindValue(":dano", $dano);
		$sql->bindValue(":id", $id);
		$sql->execute();

		return true;
	}
	//ATUALIZAR MENU3 - PAGINA nav_12_13_14.php
	public function navTipoDoc1sUp($tipo_doc, $id){
		$sql = $this->db->prepare("UPDATE nav_tipo_doc SET tipo_doc=:tipo_doc WHERE id=:id");
		$sql->bindValue(":tipo_doc", $tipo_doc);
		$sql->bindValue(":id", $id);
		$sql->execute();

		return true;
	}
	//ATUALIZAR MENU4 - PAGINA nav_12_13_14.php
	public function navFretesUp($frete, $id){
		$sql = $this->db->prepare("UPDATE nav_frete SET frete=:frete WHERE id=:id");
		$sql->bindValue(":frete", $frete);
		$sql->bindValue(":id", $id);
		$sql->execute();

		return true;
	}
	//ATUALIZAR MENU5 - PAGINA nav_12_13_14.php
	public function navTipoDoc2sUp($tipo_doc, $id){
		$sql = $this->db->prepare("UPDATE nav_tipo_doc2 SET tipo_doc=:tipo_doc WHERE id=:id");
		$sql->bindValue(":tipo_doc", $tipo_doc);
		$sql->bindValue(":id", $id);
		$sql->execute();

		return true;
	}

	//REGISTRAR MENU1 - PAGINA nav_12_13_14.php
	public function setAvarias($dano){
		$sql = $this->db->prepare("INSERT INTO nav_avarias SET dano=:dano");
		$sql->bindValue(":dano", $dano);
		$sql->execute();

		return true;
	}
	//REGISTRAR MENU3 - PAGINA nav_12_13_14.php
	public function setTipoDoc01($tipo_doc){
		$sql = $this->db->prepare("INSERT INTO nav_tipo_doc SET tipo_doc=:tipo_doc");
		$sql->bindValue(":tipo_doc", $tipo_doc);
		$sql->execute();

		return true;
	}
	//REGISTRAR MENU2 - PAGINA nav_12_13_14.php
	public function setFrete($frete){
		$sql = $this->db->prepare("INSERT INTO nav_frete SET frete=:frete");
		$sql->bindValue(":frete", $frete);
		$sql->execute();

		return true;
	}
	//REGISTRAR MENU2 - PAGINA nav_12_13_14.php
	public function setTipoDoc02($tipo_doc){
		$sql = $this->db->prepare("INSERT INTO nav_tipo_doc2 SET tipo_doc=:tipo_doc");
		$sql->bindValue(":tipo_doc", $tipo_doc);
		$sql->execute();

		return true;
	}

	public function getFormPag(){
		$sql = $this->db->prepare("SELECT * FROM nav_forma_pag");
		$sql->execute();

		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}
}
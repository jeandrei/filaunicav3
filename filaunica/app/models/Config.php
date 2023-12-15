<?php
	class Config {
		private $db;

		public function __construct(){				
			$this->db = new Database;
		}

		//RETORNA TODAS AS CONFIGURAÇÕES
		public function getConfg() {
			$this->db->query('SELECT * FROM config'); 
			$result = $this->db->resultSet();
			if($this->db->rowCount() > 0){
				return $result;
			} else {
				return false;
			}
		} 

		//RETORNA SE PERMITE CADASTRO DUPLICADO
		public function getPermiteDuplicado() {
			$this->db->query("SELECT * FROM config WHERE descricao = 'permiteCadDuplicado'");  
			$row = $this->db->single();
			if($this->db->rowCount() > 0){
				return $row->valor;
			} else {
				return false;
			}
		} 

		//Atualiza a configuração de permitir ou não cadastros duplicados na fila
		public function atualizaConfigCad($situacao){  					
			if($situacao === 'true')          {
				$sql = "UPDATE config SET valor = 'sim' WHERE descricao = 'permiteCadDuplicado'";
			} else {
				$sql = "UPDATE config SET valor = 'nao' WHERE descricao = 'permiteCadDuplicado'";
			}									
			$this->db->query($sql);   				
			if($this->db->execute()){
				return true;
			} else {
				return false;
			}
		}
			
	}//fim da classe
    
?>
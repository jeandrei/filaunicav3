<?php
	class Bairro {
		private $db;

		public function __construct(){
			//inicia a classe Database
			$this->db = new Database;
		}        
		
		//Retorna um bairro a partir do id
		public function getBairroByid($id){
			$this->db->query('SELECT * FROM bairro WHERE id = :id');				
			$this->db->bind(':id', $id);
			$row = $this->db->single();				
			if($this->db->rowCount() > 0){
				return $row;
			} else {
				return false;
			}
		} 
		
		//Retorna todos os bairros cadastrados
		public function getBairros(){
			$this->db->query('SELECT * FROM bairro'); 
			$result = $this->db->resultSet();				
			if($this->db->rowCount() > 0){
				return $result;
			} else {
				return false;
			}
		}

	}//fim da classe   
?>
<?php
	class Usuarioescola {
		private $db;

		public function __construct(){				
			$this->db = new Database;
		}

		// Find userescola by id
		public function getuserescolaById($id){
			$this->db->query('SELECT * FROM userescola WHERE id = :id'); 
			$this->db->bind(':id', $id);
			$result = $this->db->single();					
			if($this->db->rowCount() > 0){
				return $result;
			} else {
				return false;
			}
		}

		//Retorna o id do usuário da tabela userescola
		public function getUserId($id){				
			$this->db->query('SELECT userid FROM userescola WHERE id = :id');
			$this->db->bind(':id', $id);
			$row = $this->db->single();		
			if($this->db->rowCount() > 0){
				return $row->userid;
			} else {
				return false;
			}
		}	

		// Register User
		public function register($data){                              
			$this->db->query('INSERT INTO userescola (userid, escolaid) VALUES (:userid, :escolaid)');			
			$this->db->bind(':userid',$data['user']->id);
			$this->db->bind(':escolaid',$data['escolaid']);  
			if($this->db->execute()){
				return  $this->db->lastId;
			} else {
				return false;
			}
		}

		//Remove um usuário da tabela userescola
		public function delete($id){   
			$this->db->query('DELETE FROM userescola WHERE id = :id');
			// Bind value
			$this->db->bind(':id', $id);

			$row = $this->db->execute();

			// Check row
			if($this->db->rowCount() > 0){
					return true;
			} else {
					return false;
			}
		}

		//Retorna as escolas do usuário
		public function getEscolasDoUsuario($userId){            
			$this->db->query('SELECT 
															es.nome as nome, 
															es.id as escolaid,
															ue.userid as userid,
															ue.id as id 
												FROM 
															escola es, 
															userescola ue 
												WHERE 
															es.id = ue.escolaid 
												AND 
															ue.userid = :userId;
											');  
			$this->db->bind(':userId', $userId); 
			$result = $this->db->resultSet();			
			if($this->db->rowCount() > 0){
					return $result;
			} else {
					return false;
			}
		}

		//Retorna se o usuário já está vinculado em uma escola
		public function verificaEscolaVinculada($escolaId,$userId){ 				
			$this->db->query('SELECT * FROM userescola WHERE userid = :userid AND escolaid = :escolaid');
			$this->db->bind(':userid', $userId);
			$this->db->bind(':escolaid', $escolaId);			
			$row = $this->db->single();	
			if($this->db->rowCount() > 0){                
				return true;
			} else {                
				return false;
			}
		}
				
	}// fim da classe
?>
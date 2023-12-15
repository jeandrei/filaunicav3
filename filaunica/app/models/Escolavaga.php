<?php
	class Escolavaga {
		private $db;

		public function __construct(){					
			$this->db = new Database;
		}
		
		//Retorna as vagas de uma escola
		public function escolaVagasModel($escola_id){
			$this->db->query('SELECT * FROM escola_vagas WHERE escola_id = :escola_id'); 
			$this->db->bind(':escola_id', $escola_id);
			$result = $this->db->resultSet();
			if($this->db->rowCount() > 0){
				return $result;
			} else {
				return false;
			}
		}

		//Retorna se existe ou não vaga em uma etapa em uma escola
		public function existeEscolaVaga($escola_id, $etapa_id){
			$this->db->query('SELECT * FROM escola_vagas WHERE escola_id = :escola_id AND etapa_id = :etapa_id');
			$this->db->bind(':escola_id', $escola_id);
			$this->db->bind(':etapa_id', $etapa_id);
			$result = $this->db->single();
			if($this->db->rowCount() > 0){
				return true;
			} else {
				return false;
			}
		}

		// Registra Escolavaga
		public function register($escola_id,$etapa_id,$matutino,$vespertino,$integral){  
			if($this->existeEscolaVaga($escola_id, $etapa_id)){
				//UPDATE
				$this->db->query('UPDATE escola_vagas SET matutino = :matutino, vespertino = :vespertino, integral = :integral WHERE etapa_id = :etapa_id AND escola_id = :escola_id');
			} else {
				//REGISTER
				$this->db->query('INSERT INTO escola_vagas (etapa_id, escola_id, matutino, vespertino, integral) VALUES (:etapa_id, :escola_id, :matutino, :vespertino, :integral)');
			}	
			$this->db->bind(':etapa_id',$etapa_id);
			$this->db->bind(':escola_id',$escola_id);
			$this->db->bind(':matutino',$matutino);                          
			$this->db->bind(':vespertino',$vespertino);  
			$this->db->bind(':integral',$integral);			
			if($this->db->execute()){
				return $this->db->lastId;
			} else {
				return false;
			}
		}

		//Retorna as vagas de uma escola
		public function getEscolaVagas($escola_id){  
			$this->db->query('SELECT 
															e.id,
															e.descricao,
															(SELECT matutino FROM escola_vagas ev WHERE ev.etapa_id  = e.id  AND ev.escola_id = :escola_id) AS matutino,
															(SELECT vespertino FROM escola_vagas ev WHERE ev.etapa_id  = e.id  AND ev.escola_id = :escola_id) AS vespertino,
															(SELECT integral FROM escola_vagas ev WHERE ev.etapa_id  = e.id  AND ev.escola_id = :escola_id) AS integral
											FROM 
													etapa e'
											); 
			$this->db->bind(':escola_id', $escola_id);
			$result = $this->db->resultSet();			
			if($this->db->rowCount() > 0){
				return $result;
			} else {
				return false;
			}   
		}

		//Retorna as vagas de uma escola/etapa
		public function getEscolaVagasEtapa($escola_id, $etapa_id){  
			$this->db->query('SELECT * FROM escola_vagas WHERE escola_id = :escola_id AND etapa_id = :etapa_id');  
			$this->db->bind(':escola_id', $escola_id);
			$this->db->bind(':etapa_id', $etapa_id);
			$result = $this->db->single(); 				
			if($this->db->rowCount() > 0){
				return $result;
			} else {
				return false;
			}
		}

		//Atualiza a tabela as vagas de uma escola/etapa e turno
		public function atualizaVaga($escola_id, $etapa_id, $turno){ 
			$this->db->query('UPDATE escola_vagas SET '.$turno.' = '.$turno.' -1 WHERE etapa_id = :etapa_id AND escola_id = :escola_id');    
			$this->db->bind(':etapa_id',$etapa_id);
			$this->db->bind(':escola_id',$escola_id); 
			if($this->db->execute()){
				return true;
			} else {
				return false;
			}
		}
			
	}//fim da classe
    
?>
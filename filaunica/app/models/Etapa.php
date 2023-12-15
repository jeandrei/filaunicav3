<?php
	class Etapa {
		private $db;

		public function __construct(){				
			$this->db = new Database;
		}

		// Registra Etapa
		public function register($data){  
			$this->db->query('INSERT INTO etapa (data_ini, data_fin, descricao) VALUES (:data_ini, :data_fin, :descricao)');				
			$this->db->bind(':data_ini',$data['data_ini']);
			$this->db->bind(':data_fin',$data['data_fin']);
			$this->db->bind(':descricao',$data['descricao']);  			
			if($this->db->execute()){
				return $this->db->lastId;
			} else {
				return false;
			}
		}

		// Update Etapa
		public function update($data){                      
			$this->db->query('UPDATE etapa SET data_ini = :data_ini, data_fin = :data_fin, descricao = :descricao WHERE id = :id');				
			$this->db->bind(':id',$data['id']);
			$this->db->bind(':data_ini',$data['data_ini']);            
			$this->db->bind(':data_fin',$data['data_fin']);
			$this->db->bind(':descricao',$data['descricao']);				
			if($this->db->execute()){
				return true;
			} else {
				return false;
			}
		}

		public function deletaTodosEscolaVagaEtapa($etapa_id){
			$this->db->query('DELETE FROM escola_vagas WHERE etapa_id = :etapa_id');			
			$this->db->bind(':etapa_id', $etapa_id);					
			if($this->db->execute()){
				return true;
			} else {
				return false;
			}
		}

		// Deleta etapa por id
		public function delEtapaByid($id){                       
			//remove todas as vagas da etapa
			$this->deletaTodosEscolaVagaEtapa($id);
			$this->db->query('DELETE FROM etapa WHERE id = :id');			
			$this->db->bind(':id', $id);				
			if($this->db->execute()){
				return true;
			} else {
				return false;
			}
		}

		// RETORNA A DESCRIÇÃO DE UMA ETAPA A PARTIR DE UM ID
		public function getDescricaoEtapa($id) {
			$this->db->query("SELECT descricao FROM etapa WHERE id = :id");
			$this->db->bind(':id', $id);    
			$row = $this->db->single(); 
			if($this->db->rowCount() > 0){
				return $row;
			} else {
				return false;
			} 
		}        

		// RETORNA O ID DE UMA ETAPA A PARTIR DA DATA DE NASCIMENTO
		public function getEtapaId($nasc) {  			
			$this->db->query("SELECT * FROM etapa WHERE :nasc>=data_ini AND :nasc<=data_fin");
			$this->db->bind(':nasc',$nasc);                  
			$etapa =$this->db->single();  
			if($this->db->rowCount() > 0){
				return $etapa->id;
			} else {
				return false;
			}
		}

		// RETORNA A DESCRIÇÃO DE UMA ETAPA A PARTIRA DE UMA DATA
		public function getEtapaDescricao($nasc) {
			if(!$this->getEtapaId($nasc)){
				return false;
			} else {
				$etapa_id = $this->getEtapaId($nasc);
			}			
			$this->db->query("SELECT descricao from etapa WHERE id = :id");
			$this->db->bind(':id', $etapa_id); 
			$row = $this->db->single();             
			if(!empty($row->descricao)){
				return $row->descricao;
			}
			else {
				return false;
			}		
		}
			
		// RETORNA TODAS AS ETAPAS
		public function getEtapas() {
			$this->db->query("SELECT * FROM etapa ORDER BY descricao");
			$result = $this->db->resultSet();  
			foreach ($result as $row) {
				$etapas[] = array(
						'id' => $row->id,
						'data_ini' => $row->data_ini,
						'data_fin' => $row->data_fin,
						'descricao' => $row->descricao
				);
			}
			return $etapas;
		} 
			
		//Retorna todas as etapas
		public function getAllEtapas(){
			$this->db->query('SELECT * FROM etapa');
			$result = $this->db->resultSet();  		
			if($this->db->rowCount() > 0){
					return $result;
			} else {
					return false;
			}
		}

		// RETORNA A ETAPA A PARTIR DE UMA DATA DE NASCIMENTO
		public function getEtapa($nasc) {
			//SE QUISER VERIFICAR SE TEM NO MÍNIMO 4 MESES HABILITE ESSAS LINHAS COMENTADAS
			$this->db->query("SELECT TIMESTAMPDIFF(MONTH, :datanasc, NOW()) AS meses");
			$this->db->bind(':datanasc',$nasc); 
			$num_meses = $this->db->single();  
			if($num_meses->meses<4){        
				return false;
			}		
			//pega o id da etapa
			$this->db->query("SELECT * FROM etapa WHERE :nasc>=data_ini AND :nasc<=data_fin");
			$this->db->bind(':nasc',$nasc);                  
			$etapa =$this->db->single();  
			if($this->db->rowCount() > 0){
				return $etapa->id;
			}
			else{
				return false;
			}		
		}
		
		// Busca etapa por id
		public function getEtapaByid($id){
			$this->db->query('SELECT * FROM etapa WHERE id = :id');			
			$this->db->bind(':id', $id);
			$row = $this->db->single();			
			if($this->db->rowCount() > 0){
				return $row;
			} else {
				return false;
			}
		}  
			
		// VERIFICA SE JÁ EXISTE ALGUM REGISTRO NA FILA COM ESTA ETAPA
		// NÃO PODE REMOVER ETAPA COM REGISTROS NA FILA
		public function etapaRegFila($id){
			$this->db->query('SELECT * FROM fila WHERE nascimento BETWEEN (SELECT data_ini FROM etapa WHERE id = :id) AND (SELECT data_fin FROM etapa WHERE id = :id)');
			$this->db->bind(':id', $id);			
			$row = $this->db->single();
			if($this->db->rowCount() > 0){
					return $row;
			} else {
					return false;
			}
		}

		// VERIFICA SE JÁ NÃO EXISTE UMA ETAPA COM PERÍODO CADASTRADO
		// VERIFICA SE EXISTE ELGUMA ETAPA A QUAL CONFLITA COM A NOVA ETAPA
		// EXEMPLO SE TENHO UM PERÍODO DE 01/01/2020 ATÉ 03/03/2020 NÃO POSSO PERMITIR CADASTRAR UMA NOVA
		// ETAPA COM DATA ENTRE ESSE PERÍODO EXEMPLO COM DATA INICIAL EM 02/02/2020 NÃO PODE DEIXAR
		public function verificaEtapaPeriodo($dataini,$datafin){ 
			$this->db->query('SELECT * 
																FROM 
																	etapa 
																WHERE 
																	(:dataini BETWEEN etapa.data_ini AND etapa.data_fin) 
																OR
																	(:datafin BETWEEN etapa.data_ini AND etapa.data_fin)'
												);
			$this->db->bind(':dataini', $dataini);
			$this->db->bind(':datafin', $datafin); 
			$row = $this->db->single();
			if($this->db->rowCount() > 0){
				return $row;
			} else {
				return false;
			}
		}

		// VERIFICA SE A DATA INICIAL PASSADA ESTÁ ENTRE ALGUMA DATA DE INICIO E FIM DE TODAS AS ETAPAS
		public function etapaDataIni($dataini,$datafin){
			// pego todas as etapas
			$etapas = $this->getEtapas();           
			$this->db->query('SELECT * FROM etapa WHERE data_ini BETWEEN :dataini AND :datafin');
			$this->db->bind(':dataini', $dataini);
			$this->db->bind(':datafin', $datafin);              
			$result = $this->db->resultSet();		
			if($this->db->rowCount() > 0){
				return $result;
			} else {
				return false;
			}
		}

			// VERIFICA SE A DATA FINAL PASSADA ESTÁ ENTRE ALGUMA DATA DE INICIO E FIM DE TODAS AS ETAPAS
			public function etapaDataFin($dataini,$datafin){
				// pego todas as etapas
				$etapas = $this->getEtapas();           
				$this->db->query('SELECT * FROM etapa WHERE data_fin BETWEEN :dataini AND :datafin');
				$this->db->bind(':dataini', $dataini);
				$this->db->bind(':datafin', $datafin);              
				$result = $this->db->resultSet();  				
				if($this->db->rowCount() > 0){
					return $result;
				} else {
					return false;
				}
			}

	}//etapa
    
?>
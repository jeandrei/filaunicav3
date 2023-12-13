<?php
//aula 31 do curso
    class Situacao {
        private $db;

        public function __construct(){
            //inicia a classe Database
            $this->db = new Database;
        }

        // Registra Situação
        public function register($data){                  
            $this->db->query('INSERT INTO situacao (descricao, cor, ativonafila) VALUES (:descricao, :cor, :ativonafila)');
            // Bind values
            $this->db->bind(':descricao',$data['descricao']);
            $this->db->bind(':cor',$data['cor']);
            $this->db->bind(':ativonafila',$data['ativo']);            

            // Execute
            if($this->db->execute()){
								return $this->db->lastId;
            } else {
                return false;
            }
        }

        // Update Situacao
        public function update($data){                      
            $this->db->query('UPDATE situacao SET descricao = :descricao, cor = :cor, ativonafila = :ativonafila WHERE id = :id');
            // Bind values
            $this->db->bind(':id',$data['id']);
            $this->db->bind(':descricao',$data['descricao']);   
            $this->db->bind(':ativonafila',$data['ativo']);         
            $this->db->bind(':cor',$data['cor']);            

            // Execute
            if($this->db->execute()){
                return true;
            } else {
                return false;
            }
        }

        public function getIdSituacaoArquivado(){
            $this->db->query("SELECT id FROM situacao WHERE descricao = 'Arquivado'");
            $situacaoArquivado = $this->db->single();
            if($this->db->rowCount() > 0){
                return $situacaoArquivado->id;
            } else {
                return false;
            }
        }

        public function criaSituacaoArquivado(){
            $this->db->query("INSERT INTO situacao (descricao, cor) VALUES ('Arquivado', '#898c8a')");
            // Execute
            if($this->db->execute()){                
                return $this->db->lastId; 
            } else {
                return false;
            }
        }
       
        public function arquivaProtocolos($situacaoId){
            //pega a o id da situação arquivado
            $situacaoArquivadoId = $this->getIdSituacaoArquivado();
            //se não tem a situação arquivado crio ela e retorno o id
            if(!$situacaoArquivadoId){
              $situacaoArquivadoId = $this->criaSituacaoArquivado();
            } 
            
            $sql = "UPDATE fila SET situacao_id = $situacaoArquivadoId WHERE situacao_id = :situacao_id";
            $this->db->query($sql);            
            $this->db->bind(':situacao_id',$situacaoId);  
            
            if($this->db->execute()){
                return true; 
            } else {
                return false;
            }
        }        

        // Deleta situacao por id
        public function delete($id){                      
            //não permito a exclusão da situação Arquivado
            if($this->getDescricaoSituacaoById($id) == 'Arquivado'){
                return false;
            }
            
            //se não conseguir arquivar os protocolos retorno falso
            if(!$this->arquivaProtocolos($id)){
                return false;
            }
           
            //caso não seja a situação arquivado e tenha arquivado todos os protocolos eu removo a situação
            $this->db->query('DELETE FROM situacao WHERE id = :id');
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
            

        // RETORNA A SITUAÇÃO POR ID
        public function getDescricaoSituacaoById($id) {  
            //pega o id da etapa
            $this->db->query("SELECT * FROM situacao WHERE id = :id");
            $this->db->bind(':id',$id);                  
            $situacao =$this->db->single();  
            if(!empty($situacao->id)){
                return $situacao->descricao;
            }
            else{
                return false;
            }
        
        }

        // RETORNA A SITUAÇÃO POR ID
        public function getCorSituacaoById($id) {  
            //pega o id da etapa
            $this->db->query("SELECT * FROM situacao WHERE id = :id");
            $this->db->bind(':id',$id);                  
            $situacao =$this->db->single();  
            if(!empty($situacao->id)){
                return $situacao->cor;
            }
            else{
                return false;
            }       
        }

        //Traz todas as situações da tabela situacao
        public function getSituacoes(){
            $this->db->query('SELECT * FROM situacao ORDER BY ativonafila DESC,descricao  ASC');          
           
            $result = $this->db->resultSet();  

            // Check row
            if($this->db->rowCount() > 0){
                return $result ;
            } else {
                return false;
            }
        }

        //Traz a situação pelo id
        public function getSituacaoByid($id){
            $this->db->query('SELECT * FROM situacao WHERE id = :id');          
            $this->db->bind(':id',$id);  
            $situacao =$this->db->single();  

            // Check row
            if($this->db->rowCount() > 0){
                return $situacao;
            } else {
                return false;
            }
        }
    
    }


    



       
?>
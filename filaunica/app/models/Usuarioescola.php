<?php
//aula 31 do curso
    class Usuarioescola {
        private $db;

        public function __construct(){
            //inicia a classe Database
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

        // Register User
        public function register($data){                              
            $this->db->query('INSERT INTO userescola (userid, escolaid) VALUES (:userid, :escolaid)');
            // Bind values
            $this->db->bind(':userid',$data['user']->id);
            $this->db->bind(':escolaid',$data['escolaid']);            

            // Execute
            if($this->db->execute()){
								return  $this->db->lastId;
            } else {
                return false;
            }
        }

         // Update User
         public function update($data){
            $this->db->query('UPDATE users SET name = :name, password = :password, type =:type WHERE email = :email');
            // Bind values
            $this->db->bind(':email',$data['email']);
            $this->db->bind(':name',$data['name']);            
            $this->db->bind(':password',$data['password']);
            $this->db->bind(':type',$data['type']);

            // Execute
            if($this->db->execute()){
                return true;
            } else {
                return false;
            }
        }

        // 2 Login User                
        public function login($email, $password){
            $this->db->query('SELECT * FROM users WHERE email = :email');
            $this->db->bind(':email', $email);

            $row = $this->db->single();

            $hashed_password = $row->password;
            // password_verify — Verifica se um password corresponde com um hash criptografado
            // Logo para verificar não precisa descriptografar 
            // aqui $password vem do formulário ou seja digitado pelo usuário  
            // e $hashed_password vem da consulta do banco e está criptografado
            if(password_verify($password, $hashed_password)){
                return $row;
            } else {
                return false;
            }
        } 
              

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

            // Check row
            if($this->db->rowCount() > 0){
                return $result;
            } else {
                return false;
            }
        }


        public function getAllEscolas(){            
            $this->db->query('SELECT 
                                    es.nome as nome, 
                                    es.id as escolaid
                              FROM 
                                    escola es                               
                            '); 
            
            $result = $this->db->resultSet();

            // Check row
            if($this->db->rowCount() > 0){
                return $result;
            } else {
                return false;
            }
        }


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

        public function getUserId($id){
            
            $this->db->query('SELECT userid FROM userescola WHERE id = :id');
            $this->db->bind(':id', $id);

            $row = $this->db->single();

            // Check row
            if($this->db->rowCount() > 0){
                return $row->userid;
            } else {
                return false;
            }

        }

        public function verificaEscolaVinculada($escolaId,$userId){ 
            
            $this->db->query('SELECT * FROM userescola WHERE userid = :userid AND escolaid = :escolaid');
            $this->db->bind(':userid', $userId);
            $this->db->bind(':escolaid', $escolaId);
            
            $row = $this->db->single();
            
            // Check row
            if($this->db->rowCount() > 0){                
                return true;
            } else {                
                return false;
            }

        }

    }
?>
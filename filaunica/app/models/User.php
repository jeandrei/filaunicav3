<?php
//aula 31 do curso
    class User {
        private $db;

        public function __construct(){
            //inicia a classe Database
            $this->db = new Database;
        }

        // Register User
        public function register($data){            
           
            $this->db->query('INSERT INTO users (name, email, password, type) VALUES (:name, :email, :password, :type)');
            // Bind values
            $this->db->bind(':name',$data['name']);
            $this->db->bind(':email',$data['email']);
            $this->db->bind(':password',$data['password']);
            $this->db->bind(':type',$data['type']);

            // Execute
            if($this->db->execute()){
                return true;
            } else {
                return false;
            }
        }

         // Update User
         public function update($data){
            //se não for um usuário sec eu removo todos os vinculos com escola do usuário
            if($data['type'] <> 'sec'){               
                if($this->temUsuarioEscola($data['id'])){
                    $this->deleteescolasusuario($data['id']);
                }               
            }
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

      
        public function deleteescolasusuario($userId){
            $this->db->query('DELETE FROM userescola WHERE userid = :userId');
            // Bind value
            $this->db->bind(':userId', $userId);

            $row = $this->db->execute();

            // Check row
            if($this->db->rowCount() > 0){
                return true;
            } else {
                return false;
            }
        }

        public function temUsuarioEscola($userId){
            $this->db->query('SELECT * FROM userescola WHERE userid = :userid');
            // Bind value
            $this->db->bind(':userid', $userId);

            $row = $this->db->single();

            // Check row
            if($this->db->rowCount() > 0){
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

        // Find user by email
        public function findUserByEmail($email){
            $this->db->query('SELECT * FROM users WHERE email = :email');
            // Bind value
            $this->db->bind(':email', $email);

            $row = $this->db->single();

            // Check row
            if($this->db->rowCount() > 0){
                return true;
            } else {
                return false;
            }
        }

         // Find user by email
         public function delUserByid($id){
            // se tem usuarioescola vinculado ao usuário excluo tudo primeiro             
            if($this->temUsuarioEscola($id)){
                $this->deleteescolasusuario($id);
            }               
            
            $this->db->query('DELETE FROM users WHERE id = :id');
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

        

        // Find user by email
        public function getUsers(){
            $this->db->query('SELECT * FROM users');            

            $result = $this->db->resultSet();

            // Check row
            if($this->db->rowCount() > 0){
                return $result;
            } else {
                return false;
            }
        }

         // Find user by email
         public function getUserById($id_user){
            $this->db->query('SELECT id,name,email,type,created_at FROM users WHERE id = :id');      
            
            $this->db->bind(':id', $id_user);

            $result = $this->db->single();

            // Check row
            if($this->db->rowCount() > 0){
                return $result;
            } else {
                return false;
            }
        }


        // Verifica se tem ao menos um usuário admin no banco
        public function existeUserAdmin(){
            $this->db->query("SELECT COUNT(id) as qtd FROM users WHERE type = 'admin'");            

            $result = $this->db->single();

            // Check row
            if($this->db->rowCount() > 0){
                return $result->qtd;
            } else {
                return false;
            }
        }


        public function getUserType($id_user){

            $this->db->query("SELECT role.description as type FROM role,userrole WHERE role.id = userrole.roleid AND userrole.userid = :id_user");

            $this->db->bind(':id_user', $id_user);            

            $result = $this->db->single();

            // Check row
            if($this->db->rowCount() > 0){
                return $result->type;
            } else {
                return false;
            }
            
        }

        public function getUsersPag($page,$options){ 
            $sql = "SELECT id,name,email,type FROM users WHERE 1";    
            
    
            
             if(!empty($options['named_params'][':name'])){
                $sql .= " AND name LIKE '%" . $options['named_params'][':name']."%'";
            } 

            if(!empty($options['named_params'][':type'])){
                $sql .= " AND type = '" . $options['named_params'][':type']."'";
            }     
           


            $sql .= ' ORDER BY users.name ASC ';  
                 
    
            //TENTA EXECUTAR A PAGINAÇÃO 
            try
            {
                $this->pag = new Pagination($page,$sql, $options);  
            }
            catch(paginationException $e)
            {
                echo $e;
                exit();
            }       
            
            //EXECUTA A PAGINAÇÃO
            $this->pag->execute();
            //RETORNA A PAGINAÇÃO
            return $this->pag;      
            
        } 

    }
?>
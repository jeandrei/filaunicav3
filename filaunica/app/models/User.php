<?php
	class User {
		private $db;

		public function __construct(){				
			$this->db = new Database;
		}

		//Registra um usuário
		public function register($data){              
			$this->db->query('INSERT INTO users (name, email, password, type) VALUES (:name, :email, :password, :type)');			
			$this->db->bind(':name',$data['name']);
			$this->db->bind(':email',$data['email']);
			$this->db->bind(':password',$data['password']);
			$this->db->bind(':type',$data['type']);			
			if($this->db->execute()){
				return $this->db->lastId;
			} else {
				return false;
			}
		}

		//Atualiza um usuário
		public function update($data){
			//se não for um usuário sec eu removo todos os vinculos com escola do usuário
			if($data['type'] <> 'sec'){               
				if($this->temUsuarioEscola($data['id'])){
					$this->deleteescolasusuario($data['id']);
				}               
			}
			$this->db->query('UPDATE users SET name = :name, password = :password, type =:type WHERE email = :email');			
			$this->db->bind(':email',$data['email']);
			$this->db->bind(':name',$data['name']);            
			$this->db->bind(':password',$data['password']);
			$this->db->bind(':type',$data['type']);			
			if($this->db->execute()){
				return true;
			} else {
				return false;
			}
		}

		//Deleta um usuário da tabela userescola
		public function deleteescolasusuario($userId){           
			$this->db->query('DELETE FROM userescola WHERE userid = :userId');				
			$this->db->bind(':userId', $userId);
			$this->db->execute();				
			if($this->db->rowCount() > 0){
				return true;
			} else {
				return false;
			}
		}

		//Verifica se um usuário já tem registro na tabela userescola
		public function temUsuarioEscola($userId){
			$this->db->query('SELECT * FROM userescola WHERE userid = :userid');			
			$this->db->bind(':userid', $userId);
			$this->db->single();
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

		//Encontra um usuário a partir do email
		public function findUserByEmail($email){
			$this->db->query('SELECT * FROM users WHERE email = :email');				
			$this->db->bind(':email', $email);
			$this->db->single();				
			if($this->db->rowCount() > 0){
					return true;
			} else {
					return false;
			}
		}

		//Delete um usuário
		public function delUserByid($id){                     
			// se tem usuarioescola vinculado ao usuário excluo tudo primeiro             
			if($this->temUsuarioEscola($id)){
					$this->deleteescolasusuario($id);
			}   
			$this->db->query('DELETE FROM users WHERE id = :id');				
			$this->db->bind(':id', $id);
			$this->db->execute();				
			if($this->db->rowCount() > 0){
				return true;
			} else {
				return false;
			}
		}		

		//Retorna todos os usuários
		public function getUsers(){
			$this->db->query('SELECT * FROM users');  
			$result = $this->db->resultSet();
			if($this->db->rowCount() > 0){
				return $result;
			} else {
				return false;
			}
		}

		//Retorna um usuário a partir do id
		public function getUserById($id_user){
			$this->db->query('SELECT id,name,email,type,created_at FROM users WHERE id = :id'); 
			$this->db->bind(':id', $id_user);
			$result = $this->db->single();
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
			if($this->db->rowCount() > 0){
				return $result->qtd;
			} else {
				return false;
			}
		}

		//Retorna o tipo do usuário
		public function getUserType($id_user){
			$this->db->query("SELECT role.description as type FROM role,userrole WHERE role.id = userrole.roleid AND userrole.userid = :id_user");
			$this->db->bind(':id_user', $id_user);  
			$result = $this->db->single();
			if($this->db->rowCount() > 0){
				return $result->type;
			} else {
				return false;
			}				
		}

		//Retorna os dados para a paginação
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
			try	{
				$this->pag = new Pagination($page,$sql, $options);  
			} catch(paginationException $e)	{
					echo $e;
					exit();
			}  
			//EXECUTA A PAGINAÇÃO
			$this->pag->execute();
			//RETORNA A PAGINAÇÃO
			return $this->pag;     
		} 

	}//fim da classe
?>
<?php
    class Users extends Controller{
			public function __construct(){
					//vai procurar na pasta model um arquivo chamado User.php e incluir
					$this->userModel = $this->model('User');
					$this->usuarioEscolaModel = $this->model('Usuarioescola');
			}

			public function index() {

				if((!isAdmin())){ 
						flash('message', 'Você ser um administrador para ter acesso a esta página!', 'error'); 
						redirect('pages/sistem');
						die();
				}  					
					
				if(isset($_GET['page']))  
				{  
						$page = $_GET['page'];  
				}  
				else  
				{  
						$page = 1;  
				}  

				/*inicialização dos dados da paginação */
				if(!isset($_GET['name'])){$_GET['name'] = '';}
				if(!isset($_GET['type'])){$_GET['type'] = '';}  


				$options = array(
					'results_per_page' => 10,
					'url' => URLROOT . '/users/index.php?page=*VAR*&name=' . $_GET['name'] .'&type='. $_GET['type'],
					'using_bound_params' => true,
					'named_params' => array(
															':name' => $_GET['name'],
															':type' => $_GET['type']                         
															)     
				);

				$pagination = $this->userModel->getUsersPag($page,$options); 

				if($pagination->success == true){ 
					$results = $pagination->resultset->fetchAll(); 
					if(!empty($results)){
							foreach($results as $row){
									$results[] = [
											'id'   => $row['id'],
											'name' => ($row['name'])
															? $row['name']
															: '',
											'email' => ($row['email'])
															? $row['email']
															: '',
											'type' => ($row['type'])
															? $row['type']
															: ''
									];
							}
					}
									
				} else {
						$results = false;
				}

				$data = [
						'pagination' => isset($pagination)
														? $pagination
														: '',
						'results' => isset($results)
														? $results
														: '',
						'nav' => 'Cadastros\\Usuários\\'
				];
					
				$this->view('users/index', $data);				
			}

			public function new(){                
					
				if((!isLoggedIn())){ 
						flash('message', 'Você deve efetuar o login para ter acesso a esta página', 'error'); 
						redirect('users/login');
						die();
					} else if ((!isAdmin())){                
						flash('message', 'Você não tem permissão de acesso a esta página', 'error'); 
						redirect('pages/sistem');
						die();
					}  

				// Check for POST            
				if($_SERVER['REQUEST_METHOD'] == 'POST'){ 
					$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);						
					$data = [
							'name' => isset($_POST['name'])
													? trim($_POST['name'])
													: '',
							'email' => isset($_POST['email'])
													? trim($_POST['email'])
													: '',                   
							'password' => isset($_POST['password'])
													? trim($_POST['password'])
													: '',
							'confirm_password' => isset($_POST['confirm_password'])
													? trim($_POST['confirm_password'])
													: '',
							'type' => isset($_POST['type'])
													? $_POST['type']
													: '',
							'name_err' => '',
							'email_err' => '',
							'password_err' => '',
							'confirm_password_err' => '',
							'type_err' => '',
							'nav' => 'Cadastros\\Usuários\\Adicionar Usuário\\'
					];   

					// Validate Email
					if(empty($data['email'])){
						$data['email_err'] = 'Por favor informe seu email';
					} else {
						// Check email userModel foi instansiado na construct
						if($this->userModel->findUserByEmail($data['email'])){
							$data['email_err'] = 'Email já existente'; 
						}
					}

					// Validate Name
					if(empty($data['name'])){
						$data['name_err'] = 'Por favor informe seu nome';
					}

					// Validate Password
					if(empty($data['password'])){
						$data['password_err'] = 'Por favor informe a senha';
					} elseif (strlen($data['password']) < 6){
						$data['password_err'] = 'Senha deve ter no mínimo 6 caracteres';
					}

					// Validate Confirm Password
					if(empty($data['confirm_password'])){
						$data['confirm_password_err'] = 'Por favor confirme a senha';
					} else {
						if($data['password'] != $data['confirm_password']){
							$data['confirm_password_err'] = 'Senha e confirmação de senha diferentes';    
						}
					}

					if(!isset($data['type'])){
						$data['type_err'] = 'Por favor informe um tipo para o usuário';
					}
						
					// Make sure errors are empty
					if(                    
							empty($data['email_err']) &&
							empty($data['name_err']) && 
							empty($data['password_err']) &&
							empty($data['type_err']) &&
							empty($data['confirm_password_err']) 

					){	
							// Hash Password criptografa o password
							$data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
							try {     
								if($lastId = $this->userModel->register($data)){
									flash('message', 'Cadastro realizado com sucesso!','success'); 
									redirect('users/userlist');
									die();
								} else {                        
									throw new Exception('Ops! Algo deu errado ao tentar gravar os dados!');
								}
							} catch (Exception $e) {                         
								$erro = 'Erro: '.  $e->getMessage();                      
								flash('message', $erro,'error');
								$data['password'] = $data['confirm_password'];
								$this->view('users/newuser',$data);
								die();
							} 
					} else {
						// Load the view with errors                     
						$this->view('users/newuser', $data);
					}               
				} else { 
					$data = [
							'name' => '',
							'email' => '',
							'type' => '',
							'type_err' => '',
							'password' => '',
							'confirm_password' => '',
							'name_err' => '',
							'email_err' => '',
							'password_err' => '',
							'confirm_password_err' => '',
							'erro' => '',
							'nav' => 'Cadastros\\Usuários\\Adicionar Usuário\\'
					];
					if(!isAdmin()){
						redirect('index');
					} else {
						// Load view
						$this->view('users/newuser', $data);
					}
				} 
			}

      
		


			public function edit($id){             
					
				if((!isLoggedIn())){ 
					flash('message', 'Você deve efetuar o login para ter acesso a esta página', 'error'); 
					redirect('users/login');
					die();
				} else if ((!isAdmin())){                
					flash('message', 'Você não tem permissão de acesso a esta página', 'error'); 
					redirect('pages/sistem');
					die();
				}  

				if(!is_numeric($id)){
					$erro = 'ID Inválido!'; 
				} else if (!$user = $this->userModel->getUserByid($id)){
					$erro = 'ID inexistente';
				} else {
					$erro = '';
				}   
				
				if($erro){
					flash('message', $erro, 'error');                        
					redirect('users/index');
					die();
				}      

					          
				if($_SERVER['REQUEST_METHOD'] == 'POST'){ 
					$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
					$data = [
						'id' => $id,
						'name' => isset($_POST['name'])
												? trim($_POST['name'])
												: '',
						'email' => isset($_POST['email'])
												? trim($_POST['email'])
												: '',                   
						'password' => isset($_POST['password'])
												? trim($_POST['password'])
												: '',
						'confirm_password' => isset($_POST['confirm_password'])
												? trim($_POST['confirm_password'])
												: '',
						'type' => isset($_POST['type'])
												? $_POST['type']
												: '',
						'typedb' => ($this->userModel->getUserById($id)->type)
												? $this->userModel->getUserById($id)->type
												: '',
						'name_err' => '',
						'email_err' => '',
						'password_err' => '',
						'confirm_password_err' => '',
						'type_err' => '',
						'nav' => 'Cadastros\\Usuários\\Editar Usuário\\'
					];                 

					// Validate Name
					if(empty($data['name'])){
						$data['name_err'] = 'Por favor informe seu nome';
					}

					// Validate Password
					if(empty($data['password'])){
						$data['password_err'] = 'Por favor informe a senha';
					} elseif (strlen($data['password']) < 6){
						$data['password_err'] = 'Senha deve ter no mínimo 6 caracteres';
					}

					// Validate Confirm Password
					if(empty($data['confirm_password'])){
						$data['confirm_password_err'] = 'Por favor confirme a senha';
					} else {
						if($data['password'] != $data['confirm_password']){
							$data['confirm_password_err'] = 'Senha e confirmação de senha diferentes';    
						}
					}

					if(!isset($data['type'])){
						$data['type_err'] = 'Por favor informe um tipo para o usuário';
					}

					if($data['type'] <> 'sec'){
						if(!isset($_POST['confirma'])){
							if($this->usuarioEscolaModel->getEscolasDoUsuario($id)){
									$data['alerta'] = 'Este usuário possui vinculos com escolas e a atualização para um tipo diferente requer a remoção dos vinculos.';                        
							} 
						}
					} else {
						$data['alerta'] = '';
					}							
					
					if(   
							empty($data['name_err']) && 
							empty($data['password_err']) &&
							empty($data['type_err']) &&
							empty($data['confirm_password_err']) &&
							empty($data['alerta'])                 
					){								
							// Hash Password criptografa o password
							$data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

							// Register User                      
							if($this->userModel->update($data)){
								// Cria a menságem antes de chamar o view va para 
								// views/users/login a segunda parte da menságem                        
								flash('message', 'Usuário atualizado com sucesso!','success');
								redirect('users/userlist');
								die();
							} else {
									die('Ops! Algo deu errado.');
							}    
								
					} else {
						// Load the view with errors
						$this->view('users/edituser', $data);
					}              
											
				} else {
					// get exiting user from the model
					$user = $this->userModel->getUserByid($id);

					if(!isAdmin()){
							redirect('index');
					}

					$data = [
						'id' => $id,
						'name' => $user->name,
						'email' => $user->email,                                      
						'type' => $user->type,
						'typedb' => $this->userModel->getUserById($id)->type,
						'alerta' => '',
						'name_err' => '',
						'email_err' => '',
						'password_err' => '',
						'confirm_password_err' => '',
						'type_err' => '',
						'nav' => 'Cadastros\\Usuários\\Editar Usuário\\'
					];
					if(!isAdmin()){
						redirect('index');
					} else {
					// Load view
						$this->view('users/edituser', $data);
					}
				} 
			}

			public function delete($id){              
					
				if((!isLoggedIn())){ 
					flash('message', 'Você deve efetuar o login para ter acesso a esta página', 'error'); 
					redirect('users/login');
					die();
				} else if ((!isAdmin())){                
					flash('message', 'Você não tem permissão de acesso a esta página', 'error'); 
					redirect('pages/sistem');
					die();
				}  
					
				//se não for um id válido
				if(!is_numeric($id)){
						$erro = 'ID Inválido!'; 
				// se no id não existir
				} else if (!$user = $this->userModel->getUserById($id)){
						$erro = 'ID inexistente';
				//se o usuário estiver tentando excluir seu próprio registro
				} else if($_SESSION[DB_NAME . '_user_id'] == $id){            
						$erro = 'Você não pode excluir seu próprio usuário!';            
				//não precisaria dessa linha mas é garantia que pelo menos um usuário administrador fique no bd
				} else if ($user->type == 'admin'){ 
						$qtdAdmins = $this->userModel->existeUserAdmin();
						if($qtdAdmins < 2){
								$erro = 'Existe apenas um administrador cadastrado! Cadastre um novo administrador para ralizar esta exclusão.';
						} 
				} else {
						$erro = '';
				} 

				if($erro !== ''){
					flash('message', $erro , 'error'); 									   
					redirect('users/index');
					die();
				}   
					
				//esse $_POST['delete'] vem lá do view('confirma');
				if(isset($_POST['delete'])){  	
					try {                    
						if($this->userModel->delUserByid($id)){
							flash('message', 'Registro excluido com sucesso!', 'success'); 
							redirect('users/index');
						} else {
							throw new Exception('Ops! Algo deu errado ao tentar excluir os dados!');
						}
					} catch (Exception $e) {
						$erro = 'Erro: '.  $e->getMessage();
						flash('message', $erro,'error');
						redirect('users/index');
					}                
				} else {					
					$data = [
						'user' => $user,
						'nav' => 'Cadastros\\Usuários\\Remover Usuário\\'
					];
					$this->view('users/confirma',$data);
					exit();
				}                 
			}       
            

			public function login(){ 
				if($_SERVER['REQUEST_METHOD'] == 'POST'){
					$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
					$data = [                    
							'email' => isset($_POST['email'])
															? trim($_POST['email'])
															: '',
							'password' => isset($_POST['password'])
															? trim($_POST['password'])
															: '',  
							'email_err' => '',
							'password_err' => ''
							
					];      

					// Validate Email
					if(empty($data['email'])){
						$data['email_err'] = 'Por favor informe seu email';
					} else {
						// Check for user/email
						if(!$this->userModel->findUserByEmail($data['email'])){
							$data['email_err'] = 'Usuário não encontrado';
						} 
					} 

					// Validate Password
					if(empty($data['password'])){
						$data['password_err'] = 'Por favor informe sua senha';
					}    									
					
					if(                    
							empty($data['email_err']) &&                     
							empty($data['password_err'])                     
						){
							//Validate
							// 1 Check and set loged in user
							// 2 models/User login();
							$loggedInUser = $this->userModel->login($data['email'], $data['password']);							
							if($loggedInUser){
								// Create Session 
								// função no final desse arquivo
								$this->createUserSession($loggedInUser);
							} else {
								$data['password_err'] = 'Senha incorreta';
								$this->view('users/login', $data);
							}
						} else {
							// Load the view with errors
							$this->view('users/login', $data);
						}  					
				} else {
					// Init data
					$data = [
							'name' => '',
							'email' => '',
							'password' => '',
							'confirm_password' => '',
							'name_err' => '',
							'email_err' => '',
							'password_err' => '',
							'confirm_password_err' => ''
					];                
					// Load view
					$this->view('users/login', $data);
				}
			}

			public function createUserSession($user){
				// $user->id vem do model na função login() retorna a row com todos os campos
				// da consulta na tabela users
				$_SESSION[DB_NAME . '_user_id'] = $user->id;
				$_SESSION[DB_NAME . '_user_email'] = $user->email;
				$_SESSION[DB_NAME . '_user_name'] = $user->name;
				$_SESSION[DB_NAME . '_user_type'] = $user->type;        
				redirect('pages/sistem');			
			}

			public function logout(){
				unset($_SESSION[DB_NAME . '_user_id']);
				unset($_SESSION[DB_NAME . '_user_email']);
				unset($_SESSION[DB_NAME . '_user_name']);
				unset($_SESSION[DB_NAME . '_user_type']);
				session_destroy();
				redirect('pages/login'); 
			}    

			public function getType($id){
					$userType = $this->userModel->getUserType($id);
					return $userType;
			}
}   
?>
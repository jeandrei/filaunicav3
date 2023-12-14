<?php
    class Usuarioescolas extends Controller{
			public function __construct(){
				if((!isLoggedIn())){ 
						flash('message', 'Você deve efetuar o login para ter acesso a esta página', 'error'); 
						redirect('users/login');
						die();
				} else if ((!isAdmin())){                
						flash('message', 'Você não tem permissão de acesso a esta página', 'error'); 
						redirect('pages/sistem'); 
						die();
				} 
				//vai procurar na pasta model um arquivo chamado User.php e incluir
				$this->usuarioEscolaModel = $this->model('Usuarioescola');
				$this->escolaModel = $this->model('Escola');
				$this->userModel = $this->model('User');
			}

			//Carrega o usuário e suas escolas registradas para dar acesso ao cadastro de vagas tabela userescola
			public function index($id) { 
			
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

				$data = [
						'escolasusuario' => ($this->usuarioEscolaModel->getEscolasDoUsuario($id))
														? $this->usuarioEscolaModel->getEscolasDoUsuario($id)
														: '',
						'user' => ($this->userModel->getUserById($id))
														? $this->userModel->getUserById($id)
														: '',
						'nav' => 'Cadastros\\Usuários\\Editar Usuário\\Vincular Escola\\'
				];
				$this->view('usuarioescolas/index', $data);
			}

			//Vincula um usuário a uma escola na tabela userescola
			public function new($id){
				
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
							'user' => ($this->userModel->getUserById($id))
													? $this->userModel->getUserById($id)
													: '',
							'escolas' => ($this->escolaModel->getEscolas())
													? $this->escolaModel->getEscolas()
													: '',
							'escolaid' => isset($_POST['escolaid'])
													? trim($_POST['escolaid'])
													: '',                    
							'userid_err' => '',
							'escolaid_err' => '',
							'nav' => 'Cadastros\\Usuários\\Editar Usuário\\Vincular Escola\\Adicionar'
					];     

					// Valida escolaid
					if((!isset($data['escolaid'])) || ($data['escolaid'] == '') || ($data['escolaid'] == 'NULL')){
						$data['escolaid_err'] = 'Por favor informe a escola a ser vinculada';
					}

					if($this->usuarioEscolaModel->verificaEscolaVinculada($data['escolaid'], $id)){
						$data['escolaid_err'] = 'Escola já vinculada ao usuário';
					} 
						
					if(  
						empty($data['escolaid_err']) 
					){ 
						if($data['user']->type == 'sec'){
							try {     
								if($lastId = $this->usuarioEscolaModel->register($data)){
									flash('message', 'Cadastro realizado com sucesso!','success'); 
									redirect('usuarioescolas/' . $id);
									die();
								} else {                        
									throw new Exception('Ops! Algo deu errado ao tentar gravar os dados!');
								}
							} catch (Exception $e) {                         
								$erro = 'Erro: '.  $e->getMessage();                      
								flash('message', $erro,'error');                                
								redirect('usuarioescolas/' . $id);
								die();
							}  
						} else {
							die('Só é permitido vincular escolas a usuários do tipo sec');
						}  
					} else {							                  
						$this->view('usuarioescolas/new', $data);
					}  				
				} else {  
					$data = [
						'user' => ($this->userModel->getUserById($id))
												? $this->userModel->getUserById($id)
												: '',
						'escolas' => ($this->escolaModel->getEscolas())
												? $this->escolaModel->getEscolas()
												: '',
						'escolaid' => isset($_POST['escolaid'])
						? trim($_POST['escolaid'])
						: '',    
						'name' => '',
						'email' => '',
						'type' => '',
						'password' => '',
						'confirm_password' => '',
						'name_err' => '',
						'email_err' => '',
						'password_err' => '',
						'confirm_password_err' => '',
						'escolaid_err' => '',
						'erro' => '',
						'nav' => 'Cadastros\\Usuários\\Editar Usuário\\Vincular Escola\\Adicionar'
					];
					// Load view
					$this->view('usuarioescolas/new', $data); 
				} 
			}
        
			//Remove um registro da tabela userescola
			public function delete($id){ 

				if(!is_numeric($id)){
					$erro = 'ID Inválido!'; 
				} else if (!$userEscola = $this->usuarioEscolaModel->getuserescolaById($id)){
					$erro = 'ID inexistente';
				} else {
					$erro = '';
				}   
				
				if($erro){
					flash('message', $erro, 'error');                        
					redirect('users/index');
					die();
				}  
				$userid = $this->usuarioEscolaModel->getUserId($id);				
				try {                    
					if($this->usuarioEscolaModel->delete($id)){
						flash('message', 'Registro excluido com sucesso!', 'success'); 
						redirect('usuarioescolas/'.$userid );
					} else {
						throw new Exception('Ops! Algo deu errado ao tentar excluir os dados!');
					}
				} catch (Exception $e) {
					$erro = 'Erro: '.  $e->getMessage();
					flash('message', $erro,'error');
					redirect('usuarioescolas/'.$userid);
				} 							
			}    

}   
?>
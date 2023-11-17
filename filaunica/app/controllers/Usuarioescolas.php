<?php
    class Usuarioescolas extends Controller{
        public function __construct(){
            //vai procurar na pasta model um arquivo chamado User.php e incluir
            $this->usuarioEscolaModel = $this->model('Usuarioescola');
            $this->escolaModel = $this->model('Escola');
            $this->userModel = $this->model('User');
        }

        public function index($id) {
            
            if((!isAdmin()) && (!isSec())){ 
                flash('message', 'Você ser tem permissão para acessar esta página!', 'error'); 
                redirect('pages/sistem');
                die();
            }   

            $data['escolasusuario'] = $this->usuarioEscolaModel->getEscolasDoUsuario($id);
            $data['user'] = $this->userModel->getUserById($id);
            $this->view('usuarioescolas/index', $data);            
           
        }

        public function new($id){                
           
            if((!isLoggedIn())){ 
                flash('message', 'Você deve efetuar o login para ter acesso a esta página', 'error'); 
                redirect('users/login');
                die();
              } else if ((!isAdmin()) && (!isSec())){              
                flash('message', 'Você não tem permissão de acesso a esta página', 'error'); 
                redirect('pages/sistem');
                die();
              }  
              
            // Check for POST            
            if($_SERVER['REQUEST_METHOD'] == 'POST'){                
               
                // Process form

                // Sanitize POST data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                
                 

                //init data
                $data = [
                    'user' => $this->userModel->getUserById($id),
                    'escolas' => $this->escolaModel->getEscolas(),
                    'escolaid' => trim($_POST['escolaid']),                    
                    'userid_err' => '',
                    'escolaid_err' => ''
                ];          
                   

                // Valida escolaid
                if((!isset($data['escolaid'])) || ($data['escolaid'] == '') || ($data['escolaid'] == 'NULL')){
                    $data['escolaid_err'] = 'Por favor informe a escola a ser vinculada';
                }

                if($this->usuarioEscolaModel->verificaEscolaVinculada($data['escolaid'], $id)){
                    $data['escolaid_err'] = 'Escola já vinculada ao usuário';
                } 
               

                // Make sure errors are empty
                if(  
                    empty($data['escolaid_err']) 
                    ){ 
                        if($data['user']->type == 'sec'){
                            // Register userescola
                            if($this->usuarioEscolaModel->register($data)){
                                // Cria a menságem antes de chamar o view va para 
                                // views/users/login a segunda parte da menságem
                                flash('message', 'Escola vinculada com sucesso!','success');                        
                                redirect('usuarioescolas/'.$id);
                            } else {
                                die('Ops! Algo deu errado.');
                            }
                        } else {
                            die('Só é permitido vincular escolas a usuários do tipo sec');
                        }
                      
                    } else {
                      // Load the view with errors                     
                      $this->view('usuarioescolas/new', $data);
                    }               

            
            } else {   
                // Init data
                $data = [
                    'user' => $this->userModel->getUserById($id),
                    'escolas' => $this->escolaModel->getEscolas(),
                    'name' => '',
                    'email' => '',
                    'type' => '',
                    'password' => '',
                    'confirm_password' => '',
                    'name_err' => '',
                    'email_err' => '',
                    'password_err' => '',
                    'confirm_password_err' => '',
                    'erro' => ''
                ];
                if(!isAdmin()){
                    redirect('index');
                } else {
                     // Load view
                    $this->view('usuarioescolas/new', $data);
                }
               
                
            } 
        }

       
        

        public function delete($id){              
            
            if((!isLoggedIn())){ 
                flash('message', 'Você deve efetuar o login para ter acesso a esta página', 'error'); 
                redirect('users/login');
                die();
              } else if ((!isAdmin()) && (!isUser())){                
                flash('message', 'Você não tem permissão de acesso a esta página', 'error'); 
                redirect('pages/sistem');
                die();
              }                 
                              
              //pego o id do usuário
              $userid = $this->usuarioEscolaModel->getUserId($id);
              
               try {                    
                   if($this->usuarioEscolaModel->delete($id)){
                       flash('message', 'Registro excluido com sucesso!', 'success'); 
                       redirect('usuarioescolas/index/'.$userid );
                   } else {
                       throw new Exception('Ops! Algo deu errado ao tentar excluir os dados!');
                   }
               } catch (Exception $e) {
                   $erro = 'Erro: '.  $e->getMessage();
                   flash('message', $erro,'error');
                   $this->view('usuarioescolas/index');
               }                
                          
       }    

}   
?>
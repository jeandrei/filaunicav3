<?php
    class Configs extends Controller{
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

            // 1 Chama o model
            $this->configModel = $this->model('Config');
        }

        // INDEX PÁGINA INICIAL LANDING PAGE
        public function index(){ 

            $data = [
            'title' => 'Configurações',
            'description'=> 'Configurações da fila única'
            ];

            $this->view('configs/index', $data);
        }  
        
        public function configCad(){

            $data = [
                'title' => 'Configurações',
                'description'=> 'Configurações de cadastro',
                'permiteCadDuplicado' => $this->configModel->getPermiteDuplicado()
            ];    
               
            $this->view('configs/configCad', $data);
        }

        public function atualizConfigCad(){  
           try{
                if($this->configModel->atualizaConfigCad($_POST['situacao'])){  
                    $json_ret = array(
                                        'classe'=>'success', 
                                        'message'=>'Dados gravados com sucesso',
                                        'error'=>false
                                    );                     
                    
                    echo json_encode($json_ret); 
                } else {                        
                    throw new Exception('Erro ao gravar os dados!');  
                }        
            } catch (Exception $e) {
                $json_ret = array(
                        'classe'=>'error', 
                        'message'=>$e->getMessage(),
                        'error'=>true
                        );                     
                echo json_encode($json_ret); 
            }
        }   
}
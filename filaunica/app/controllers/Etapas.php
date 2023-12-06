<?php
    class Etapas extends Controller{
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
            $this->etapaModel = $this->model('Etapa');
        }

        public function index() { 

            if($data['etapas'] = $this->etapaModel->getAllEtapas()){                
                $this->view('etapas/index', $data);
            } else {                                 
                $this->view('etapas/index');
            }   
        }

        public function new(){   
           
            // Check for POST            
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
               
                // Process form

                // Sanitize POST data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);    


                //init data
                $data = [
                    'data_ini' => trim($_POST['data_ini']),
                    'data_fin' => trim($_POST['data_fin']),
                    'descricao' => trim($_POST['descricao']),                    
                    'data_ini_err' => '',
                    'data_fin_err' => '',
                    'descricao_err' => ''
                ];                

                

                // Valida data Inicial
                if(empty($data['data_ini'])){
                    $data['data_ini_err'] = 'Por favor informe a data inicial';
                } 

                // Valida data Inicial
                if(empty($data['data_fin'])){
                    $data['data_fin_err'] = 'Por favor informe a data final';
                } 

                // Valida descrição
                if(empty($data['descricao'])){
                    $data['descricao_err'] = 'Por favor informe a descrição da etapa';
                } 
               
                if($this->etapaModel->verificaEtapaPeriodo($data['data_ini'],$data['data_fin'])){
                    $data['erro'] = 'Existem etapas cadastradas que conflitam com este período';                    
                }
               /*  
                if($this->etapaModel->etapaDataFin($data['data_ini'],$data['data_fin'])){
                    $data['erro'] = 'Existem etapas cadastradas que conflitam com este período';                    
                }
*/
                
                // Make sure errors are empty
                if(                    
                    empty($data['data_ini_err']) &&
                    empty($data['data_fin_err']) && 
                    empty($data['descricao_err']) &&                     
                    empty($data['erro'])
                    ){
                      //Validated
                     

                      // Register User
                      if($this->etapaModel->register($data)){
                        // Cria a menságem antes de chamar o view va para 
                        // views/users/login a segunda parte da menságem
                        flash('message', 'Etapa registrada com sucesso!','success');                        
                        redirect('etapas/index');
                      } else {
                          die('Ops! Algo deu errado.');
                      }
                      

                      
                    } else {
                      // Load the view with errors
                      if(!empty($data['erro'])){
                      flash('message', $data['erro'], 'error');
                      }
                      $this->view('etapas/newetapa', $data);
                    }               

            
            } else {

                // Init data
                $data = [
                    'data_ini' => '',
                    'data_fin' => '',
                    'descricao' => '',
                    'data_ini_err' => '',
                    'data_fin_err' => '',
                    'erro' => '',
                    'descricao_err' => ''                    
                ];
                // Load view
                $this->view('etapas/newetapa', $data);
            } 
        }

       
        public function edit($id){           
            
            // Check for POST            
            if($_SERVER['REQUEST_METHOD'] == 'POST'){  
                            
               
                // Process form

                // Sanitize POST data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                
                if (isset($_POST['type']) && ($_POST['type'] == 1)){
                    $type = 'admin';
                } else {
                    $type = 'user';
                }
                
                //init data
                $data = [
                    'id' => $id,
                    'data_ini' => trim($_POST['data_ini']),
                    'data_fin' => trim($_POST['data_fin']),
                    'descricao' => trim($_POST['descricao']),                    
                    'data_ini_err' => '',
                    'data_fin_err' => '',
                    'descricao_err' => ''
                ];                

                

                // Valida data Inicial
                if(empty($data['data_ini'])){
                    $data['data_ini_err'] = 'Por favor informe a data inicial';
                } 

                // Valida data Inicial
                if(empty($data['data_fin'])){
                    $data['data_fin_err'] = 'Por favor informe a data final';
                } 

                // Valida descrição
                if(empty($data['descricao'])){
                    $data['descricao_err'] = 'Por favor informe a descrição da etapa';
                } 
               
                if($etapa_conflict = $this->etapaModel->verificaEtapaPeriodo($data['data_ini'],$data['data_fin'])){
                    // se o período que estou editando está dentro do período atual de uma etapa
                    // então tenho que permitir a atualização logo não atribuo valor a $data['erro']                    
                    if($id != $etapa_conflict->id){
                        $data['erro'] = 'Existem etapas cadastradas que conflitam com este período '; 
                    }                 
                }
                 
                
                // Make sure errors are empty
                if(                    
                    empty($data['data_ini_err']) &&
                    empty($data['data_fin_err']) && 
                    empty($data['descricao_err']) &&
                    empty($data['erro']) 
                    ){
                      //Validated
                     

                      // Update User
                      if($this->etapaModel->update($data)){                         
                        // views/users/login a segunda parte da menságem                       
                        flash('message', 'Etapa atualizada com sucesso!','success');                        
                        redirect('etapas/index');
                      } else {
                          die('Ops! Algo deu errado.');
                      }
                      

                      
                    } else {
                      // Load the view with errors
                      if(!empty($data['erro'])){
                      flash('message', $data['erro'], 'error');
                      }
                      $this->view('etapas/editetapa', $data);
                    }               

            
            } else {
                // get exiting user from the model
                $etapa = $this->etapaModel->getEtapaByid($id);              
               

                $data = [
                    'id' => $id,
                    'data_ini' => $etapa->data_ini,
                    'data_fin' => $etapa->data_fin,                                      
                    'descricao' => $etapa->descricao                  
                ];
                // Load view
                $this->view('etapas/editetapa', $data);
            } 
        }


        public function delete($id){ 

             //VALIDAÇÃO DO ID
             if(!is_numeric($id)){
                $erro = 'ID Inválido!'; 
            } else if (!$data['etapa'] = $this->etapaModel->getEtapaById($id)){
                $erro = 'ID inexistente';
            } else {
                $erro = '';
            }   
            
             //esse $_POST['delete'] vem lá do view('confirma');
            if(isset($_POST['delete'])){
                
                if($erro){
                    flash('message', $erro , 'error'); 
                    $data['etapas'] = $this->etapaModel->getAllEtapas();   
                    $this->view('etapas/index',$data);
                    die();
                }                   

                try {                    
                    if($this->etapaModel->delEtapaByid($id)){
                        flash('message', 'Registro excluido com sucesso!', 'success'); 
                        redirect('etapas/index');
                    } else {
                        throw new Exception('Ops! Algo deu errado ao tentar excluir os dados!');
                    }
                } catch (Exception $e) {
                    $erro = 'Erro: '.  $e->getMessage();
                    flash('message', $erro,'error');
                    $this->view('etapas/index');
                }                
           } else {  
            //se existe protocolos na fila dessa etapa aviso o usuário        
            if($this->etapaModel->etapaRegFila($id)){
                $data['alerta'] = 'Alerta.: Existem registros na fila vinculados a esta etapa!';                   
            } else {
                $data['alerta'] = '';
            }      
                
            $this->view('etapas/confirma',$data);
            exit();
           }                 
        }
}   
?>
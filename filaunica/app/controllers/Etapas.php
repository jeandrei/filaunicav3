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
            if($etapas = $this->etapaModel->getAllEtapas()){      
                $data = [
                    'etapas' => isset($etapas)
                                ? $etapas
                                : ''
                ];       
                $this->view('etapas/index', $data);
            } else {                                 
                $this->view('etapas/index');
            }   
        }

        public function new(){                          
            if($_SERVER['REQUEST_METHOD'] == 'POST'){               
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING); 
               
                $data = [
                    'data_ini' => isset(($_POST['data_ini']))
                                    ? trim($_POST['data_ini'])
                                    : '',
                    'data_fin' => isset($_POST['data_fin'])
                                    ? trim($_POST['data_fin'])
                                    : '',
                    'descricao' => isset($_POST['descricao'])
                                    ?trim($_POST['descricao'])
                                    : '',                    
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
                    $erro = 'Existem etapas cadastradas que conflitam com este período';                    
                }               
                
                // Make sure errors are empty
                if(                    
                    empty($data['data_ini_err']) &&
                    empty($data['data_fin_err']) && 
                    empty($data['descricao_err']) &&                     
                    empty($erro)
                    ){ 
                        try {  
                            if($lastId = $this->etapaModel->register($data)){
                                flash('message', 'Cadastro realizado com sucesso!','success'); 
                                redirect('etapas/index');
                                die();
                            } else {                        
                                throw new Exception('Ops! Algo deu errado ao tentar gravar os dados!');
                            }
                        } catch (Exception $e) {                         
                            $erro = 'Erro: '.  $e->getMessage();                      
                            flash('message', $erro,'error');
                            $this->view('etapas/newetapa', $data);
                            die();
                        }                  
                    } else {                      
                      if(!empty($erro)){
                        flash('message', $erro, 'error');
                        $this->view('etapas/newetapa', $data);
                      } else {
                        redirect('etapas/index');
                      }
                      
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
            
            if(!is_numeric($id)){
                die('Erro ao recuperar o id! Tente novamente');
            }             
                      
            if($_SERVER['REQUEST_METHOD'] == 'POST'){      
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);                 
                $data = [
                    'id' => $id,
                    'data_ini' => isset(($_POST['data_ini']))
                                    ? trim($_POST['data_ini'])
                                    : '',
                    'data_fin' => isset($_POST['data_fin'])
                                    ? trim($_POST['data_fin'])
                                    : '',
                    'descricao' => isset($_POST['descricao'])
                                    ?trim($_POST['descricao'])
                                    : '',                    
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
                       $erro = 'Existem etapas cadastradas que conflitam com este período '; 
                    }                 
                }

                if(                    
                    empty($data['data_ini_err']) &&
                    empty($data['data_fin_err']) && 
                    empty($data['descricao_err']) &&
                    empty($erro) 
                    ){
                        try {  
                            if($this->etapaModel->update($data)){
                                flash('message', 'Cadastro atualizado com sucesso!','success'); 
                                redirect('etapas/index');
                                die();
                            } else {                        
                                throw new Exception('Ops! Algo deu errado ao tentar atualizar os dados!');
                            }
                        } catch (Exception $e) {                         
                            $erro = 'Erro: '.  $e->getMessage();                      
                            flash('message', $erro, 'error');
                            $this->view('etapas/editetapa', $data);
                            die();
                        }                          
                    } else {                      
                        if(!empty($erro)){                              
                            flash('message', $erro, 'error');
                            $this->view('etapas/editetapa', $data);
                            die();
                        }
                        else {
                            redirect('etapas/index');  
                        }                      
                    }       
            } else {
                // get exiting user from the model
                if($etapa = $this->etapaModel->getEtapaByid($id)){
                    $data = [
                        'id' => $id,
                        'data_ini' => isset($etapa->data_ini)
                                        ? $etapa->data_ini
                                        : '',
                        'data_fin' => isset($etapa->data_fin)
                                        ? $etapa->data_fin
                                        : '',                                      
                        'descricao' => isset($etapa->descricao)
                                        ? $etapa->descricao
                                        : ''
                    ];
                } else {
                    $data = '';
                }                    
                $this->view('etapas/editetapa', $data);
            } 
        }


        public function delete($id){              
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
                    if(!$data['etapas'] = $this->etapaModel->getAllEtapas()){
                        $data['etapas'] = '';
                    }
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
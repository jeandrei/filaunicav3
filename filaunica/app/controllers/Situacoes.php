<?php
    class Situacoes extends Controller{
        public function __construct(){
            //vai procurar na pasta model um arquivo chamado User.php e incluir
            $this->situacaoModel = $this->model('Situacao');
        }

        public function index() {

            if((!isLoggedIn())){ 
                flash('message', 'Você deve efetuar o login para ter acesso a esta página', 'error'); 
                redirect('users/login');
                die();
            } else if ((!isAdmin())){                
                flash('message', 'Você não tem permissão de acesso a esta página', 'error'); 
                redirect('pages/sistem'); 
                die();
            }   
           
            $situacoes = $this->situacaoModel->getSituacoes();

            foreach($situacoes as $row){
                $data[] = array(
                  'id' => $row->id,
                  'descricao' => $row->descricao, 
                  'ativo' => $row->ativonafila == 1 ? 'SIM' : 'NÃO',
                  'cor' => $row->cor
                );       
            } 

            $this->view('situacoes/index', $data);
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
                // Process form
                
                // Sanitize POST data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);    


                //init data
                $data = [
                    'descricao' => trim($_POST['descricao']),
                    'ativo' => trim($_POST['ativo']),
                    'cor' => trim($_POST['cor']),                    
                    'descricao_err' => '',
                    'ativo_err' => '',
                    'cor_err' => ''
                ];                

                

                // Valida Situação
                if(empty($data['descricao'])){
                    $data['descricao_err'] = 'Por favor informe a Situação';
                } 

                // Valida se é ativo ou não na fila               
                if((($data['ativo'])=="") || ($data['ativo'] <> '0') && ($data['ativo'] <> '1')){
                    $data['ativo_err'] = 'Por favor informe se fica ativo na fila';
                } 

                // Valida cor
                if(empty($data['cor'])){
                    $data['cor_err'] = 'Por favor informe uma cor';
                } 
                              
                
                // Make sure errors are empty
                if(                    
                    empty($data['descricao_err']) &&
                    empty($data['ativo_err']) && 
                    empty($data['cor_err'])
                    ){
                      
                        try {
                                if($this->situacaoModel->register($data)){
                                    flash('message', 'Cadastro realizado com sucesso!','success');                     
                                    $this->view('situacoes/new');
                                } else {
                                    throw new Exception('Ops! Algo deu errado ao tentar gravar os dados!');
                                }
        
                            } catch (Exception $e) {
                                $erro = 'Erro: '.  $e->getMessage();
                                flash('message', $erro,'error');
                                $this->view('situacoes/new');
                            }                  
                        } else {
                            //Validação falhou
                            flash('message', 'Erro ao efetuar o cadastro, verifique os dados informados!','error');                     
                            $this->view('situacoes/new',$data);
                        }     

                } else {

                    if(!isAdmin()){
                        redirect('index');
                    } 

                    unset($data);                  
                    $this->view('situacoes/new', $data);
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

            // Check for POST            
            if($_SERVER['REQUEST_METHOD'] == 'POST'){             
                // Process form
                
                // Sanitize POST data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);    


                //init data
                $data = [
                    'id' => $id,
                    'descricao' => trim($_POST['descricao']),
                    'ativo' => trim($_POST['ativo']),
                    'cor' => trim($_POST['cor']),                    
                    'descricao_err' => '',
                    'ativo_err' => '',
                    'cor_err' => ''
                ];                

                

                // Valida Situação
                if(empty($data['descricao'])){
                    $data['descricao_err'] = 'Por favor informe a Situação';
                } 

                // Valida se é ativo ou não na fila               
                if((($data['ativo'])=="") || ($data['ativo'] <> '0') && ($data['ativo'] <> '1')){
                    $data['ativo_err'] = 'Por favor informe se fica ativo na fila';
                } 

                // Valida cor
                if(empty($data['cor'])){
                    $data['cor_err'] = 'Por favor informe uma cor';
                } 
                              
                
                // Make sure errors are empty
                if(                    
                    empty($data['descricao_err']) &&
                    empty($data['ativo_err']) && 
                    empty($data['cor_err'])
                    ){
                      
                        try {
                                if($this->situacaoModel->update($data)){                                    
                                    flash('message', 'Cadastro atualizado com sucesso!');                     
                                    $this->view('situacoes/edit',$data);
                                } else {
                                    throw new Exception('Ops! Algo deu errado ao tentar atualizar os dados!');
                                }
        
                            } catch (Exception $e) {
                                $erro = 'Erro: '.  $e->getMessage();
                                flash('message', $erro,'error');
                                $this->view('situacoes/edit');
                            }                  
                        } else {
                            //Validação falhou
                            flash('message', 'Erro ao tentar atualizar o cadastro, verifique os dados informados!','error');                     
                            $this->view('situacoes/edit',$data);
                        }
            
            } else {
                // get exiting user from the model
                $situacao = $this->situacaoModel->getSituacaoByid($id);

                if(!isAdmin()){
                    redirect('userlist');
                }
               

                $data = [
                    'id' => $id,
                    'descricao' => $situacao->descricao,
                    'ativo' => $situacao->ativonafila,                                      
                    'cor' => $situacao->cor                  
                ];
                // Load view
                $this->view('situacoes/edit', $data);
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
           
            //VALIDAÇÃO DO ID
            if(!is_numeric($id)){
               $erro = 'ID Inválido!'; 
            } else if (!$data = $this->situacaoModel->getSituacaoById($id)){
                $erro = 'ID inexistente';
            }

            if($erro){
                flash('message', $erro , 'alert alert-danger'); 
                $this->view('situacoes/index');
                exit();
            }  
            
            //esse $_POST['delete'] vem lá do view('confirma');
            if(isset($_POST['delete'])){                
                try {
                    if($this->situacaoModel->delete($id)){
                        flash('message', 'Registro excluido com sucesso!', 'success'); 
                        redirect('situacoes/index');
                    } else {
                        throw new Exception('Ops! Algo deu errado ao tentar excluir os dados!');
                    }
                } catch (Exception $e) {
                    $erro = 'Erro: '.  $e->getMessage();
                    flash('message', $erro,'error');
                    $this->view('situacoes/index');
                }                
           } else {              
            $this->view('situacoes/confirma',$data);
            exit();
           }  

        }

}   
?>
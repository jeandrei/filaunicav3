<?php
    class Situacoes extends Controller{
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
            $this->situacaoModel = $this->model('Situacao');
        }

        public function index() {            
           
            $situacoes = $this->situacaoModel->getSituacoes();

            foreach($situacoes as $row){
                $results[] = array(
                  'id' => $row->id,
                  'descricao' => isset($row->descricao)
                                ? $row->descricao
                                : '', 
                  'ativo' => $row->ativonafila == 1 
                                ? 'SIM' 
                                : 'NÃO',
                  'cor' => isset($row->cor)
                                ? $row->cor
                                : ''
                );       
            } 

            $data = [
                'results' => $results,
                'nav' => 'Cadastros\\Situações\\'
            ];

            $this->view('situacoes/index', $data);
        }
        
        

        public function new(){                         
            if($_SERVER['REQUEST_METHOD'] == 'POST'){   
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);  
                $data = [
                    'descricao' => isset($_POST['descricao'])
                                    ? trim($_POST['descricao'])
                                    : '',
                    'ativo' => isset($_POST['ativo'])
                                    ? trim($_POST['ativo'])
                                    : '',
                    'cor' => isset(($_POST['cor']))
                                    ? trim($_POST['cor'])
                                    : '',
                    'descricao_err' => '',
                    'ativo_err' => '',
                    'cor_err' => '',
                    'nav' => 'Cadastros\\Situações\\Adicionar Situação\\'
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
                                    redirect('situacoes/index');
                                } else {
                                    throw new Exception('Ops! Algo deu errado ao tentar gravar os dados!');
                                }
        
                            } catch (Exception $e) {
                                $erro = 'Erro: '.  $e->getMessage();
                                flash('message', $erro,'error');
                                $this->view('situacoes/new', $data);
                            }                  
                        } else {
                            //Validação falhou
                            flash('message', 'Erro ao efetuar o cadastro, verifique os dados informados!','error');                            
                            $this->view('situacoes/new',$data);
                        }     

                } else {  
                     $data = [
                        'descricao' => '',
                        'ativo' => '',
                        'cor' => '',                    
                        'descricao_err' => '',
                        'ativo_err' => '',
                        'cor_err' => '',
                        'nav' => 'Cadastros\\Situações\\Adicionar Situação\\'
                    ]; 
                    $this->view('situacoes/new', $data);
                } 
        }



        public function edit($id){                      
            if($_SERVER['REQUEST_METHOD'] == 'POST'){  
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING); 
                $data = [
                    'id' => $id,
                    'descricao' => trim($_POST['descricao']),
                    'ativo' => trim($_POST['ativo']),
                    'cor' => trim($_POST['cor']),                    
                    'descricao_err' => '',
                    'ativo_err' => '',
                    'cor_err' => '',
                    'nav' => 'Cadastros\\Situações\\Editar Situação\\'
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
                                    flash('message', 'Cadastro atualizado com sucesso!','success');             
                                    redirect('situacoes/index');
                                    die();
                                } else {
                                    throw new Exception('Ops! Algo deu errado ao tentar atualizar os dados!');
                                }
        
                            } catch (Exception $e) {
                                $erro = 'Erro: '.  $e->getMessage();
                                flash('message', $erro,'error');
                                $this->view('situacoes/edit', $data);
                            }                  
                        } else {
                            //Validação falhou
                            flash('message', 'Erro ao tentar atualizar o cadastro, verifique os dados informados!','error');                     
                            $this->view('situacoes/edit',$data);
                        }
            
            } else { 
                if($situacao = $this->situacaoModel->getSituacaoByid($id)){
                    $data = [
                        'id' => $id,
                        'descricao' => $situacao->descricao,
                        'ativo' => $situacao->ativonafila,  
                        'cor' => $situacao->cor,                          
                        'descricao_err' => '',
                        'ativo_err' => '',
                        'cor_err' => '',
                        'nav' => 'Cadastros\\Situações\\Editar Situação\\'
                    ];    
                } else {
                    $situacao = 'null' ;
                }                
                $this->view('situacoes/edit', $data);
            } 
        }

        public function delete($id){
                       
            //VALIDAÇÃO DO ID
            if(!is_numeric($id)){
               $erro = 'ID Inválido!'; 
            } else if (!$situacao = $this->situacaoModel->getSituacaoById($id)){
                $erro = 'ID inexistente';
            } else {
                $erro = '';
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
                    redirect('situacoes/index');
                }                
           } else {   
            
            $data = [
                'situacao' => $situacao,
                'nav' => 'Cadastros\\Situações\\Remover Situação'
            ];
            $this->view('situacoes/confirma',$data);
            exit();
           }  

        }

}   
?>
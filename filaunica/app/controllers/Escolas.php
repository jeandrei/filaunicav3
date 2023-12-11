<?php
    class Escolas extends Controller{
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
            $this->escolaModel = $this->model('Escola');
            $this->bairroModel = $this->model('Bairro');
        }

        public function index() {             
            if($escolas = $this->escolaModel->getEscolas()){
                foreach($escolas as $row){                    
                    $results[] = [
                        'id' => $row->id,
                        'nome' => ($row->nome)
                                    ? $row->nome
                                    : '',
                        'bairro_id' => ($row->bairro_id)
                                    ? $row->bairro_id
                                    : '',
                        'bairro' => isset($this->bairroModel->getBairroById($row->bairro_id)->nome)
                                    ? $this->bairroModel->getBairroById($row->bairro_id)->nome
                                    : '',
                        'logradouro' => isset($row->logradouro)
                                    ? $row->logradouro
                                    : '',                    
                        'numero' => ($row->numero) 
                                    ? $row->numero 
                                    : '',
                        'emAtividade' => ($row->emAtividade == 1) 
                                    ? 'Sim' 
                                    : 'Não'                        
                    ];       
                } 
                $data = [
                    'results' => $results,
                    'nav' => 'Cadastros\\Unidades\\'
                ];           
                $this->view('escolas/index', $data);
            } else {                                 
                $this->view('escolas/index');
            }   
        }

        public function new(){  
            if($_SERVER['REQUEST_METHOD'] == 'POST'){               
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING); 
                $data = [
                    'nome' => isset($_POST['nome'])
                                ? trim($_POST['nome'])
                                : '',
                    'bairro_id' => isset($_POST['bairro_id'])
                                ?  $_POST['bairro_id']
                                : '',
                    'logradouro' => isset($_POST['logradouro'])
                                ? trim($_POST['logradouro'])
                                : '',                    
                    'numero' => isset($_POST['numero']) 
                                ? trim($_POST['numero']) 
                                : '',
                    'emAtividade' => isset($_POST['emAtividade'])
                                ? trim($_POST['emAtividade'])
                                : '',
                    'bairros' => ($this->bairroModel->getBairros())
                                ? $this->bairroModel->getBairros()
                                : '',
                    'nome_err' => '',
                    'bairro_id_err' => '',
                    'logradouro_err' => '',                   
                    'emAtividade_err' => '',
                    'numero_err' => '',
                    'nav' => 'Cadastros\\Unidades\\Registrar uma unidade\\'
                ];                   

                // Valida nome
                if(empty($data['nome'])){
                    $data['nome_err'] = 'Por favor informe o nome da escola';
                } 

                // Valida logradouro
                if(empty($data['logradouro'])){
                    $data['logradouro_err'] = 'Por favor informe o logradouro';
                } 

                // Valida bairro
                if((empty($data['bairro_id'])) || ($data['bairro_id'] == 'NULL')){                    
                    $data['bairro_id_err'] = 'Por favor informe o bairro';
                }                  

                 // Valida emAtividade
                 if((($data['emAtividade'])=="") || ($data['emAtividade'] <> '0') && ($data['emAtividade'] <> '1')){
                    $data['emAtividade_err'] = 'Por favor informe se deseja manter a escola disponível para inscrições';
                }   
                
                if(                    
                    empty($data['nome_err']) &&
                    empty($data['logradouro_err']) && 
                    empty($data['bairro_id_err']) &&  
                    empty($data['emAtividade_err'])
                    ){
                        try {                                                 
                        
                            if($lastId = $this->escolaModel->register($data)){
                                flash('message', 'Cadastro realizado com sucesso!','success'); 
                                redirect('escolas/index');
                                die();
                            } else {                        
                                throw new Exception('Ops! Algo deu errado ao tentar gravar os dados!');
                            }

                        } catch (Exception $e) {                         
                            $erro = 'Erro: '.  $e->getMessage();                      
                            flash('message', $erro,'error');
                            $this->view('escolas/new',$data);
                            die();
                        }   
                    } else {
                      if(!empty($data['erro'])){
                      flash('message', $data['erro'], 'error');
                      }
                      $this->view('escolas/new', $data);
                    } 
            
            } else {                
                $data = [
                    'nome' => '',
                    'bairro_id' => '',
                    'bairros' => $this->bairroModel->getBairros(),
                    'logradouro' => '',
                    'numero' => '',
                    'emAtividade' => '',
                    'nome_err' => '',
                    'bairro_id_err' => '',
                    'logradouro_err' => '',                   
                    'emAtividade_err' => '',
                    'numero_err' => '',
                    'nav' => 'Cadastros\\Unidades\\Registrar uma unidade\\'                    
                ];               
                $this->view('escolas/new', $data);
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
                    'nome' => isset($_POST['nome'])
                                ? trim($_POST['nome'])
                                : '',
                    'bairro_id' => isset($_POST['bairro_id'])
                                ? $_POST['bairro_id']
                                : '',
                    'bairros' => ($this->bairroModel->getBairros())
                                ? $this->bairroModel->getBairros()
                                : '',
                    'logradouro' => isset($_POST['logradouro'])
                                ? trim($_POST['logradouro'])
                                : '',  
                    'numero' => isset($_POST['numero']) 
                                ? trim($_POST['numero']) 
                                : '',
                    'emAtividade' => isset($_POST['emAtividade'])
                                ? trim($_POST['emAtividade'])
                                : '',
                    'nome_err' => '',
                    'numero_err' => '',
                    'bairro_id_err' => '',
                    'logradouro_err' => '',                    
                    'emAtividade_err' => '',
                    'nav' => 'Cadastros\\Unidades\\Atualizar uma unidade\\'                       
                ];    

                // Valida nome
                if(empty($data['nome'])){
                    $data['nome_err'] = 'Por favor informe o nome da escola';
                } 

                // Valida logradouro
                if(empty($data['logradouro'])){
                    $data['logradouro_err'] = 'Por favor informe o logradouro';
                } 

                // Valida bairro
                if((empty($data['bairro_id'])) || ($data['bairro_id'] == 'NULL')){                    
                    $data['bairro_id_err'] = 'Por favor informe o bairro';
                }                  

                // Valida emAtividade
                if((($data['emAtividade'])=="") || ($data['emAtividade'] <> '0') && ($data['emAtividade'] <> '1')){
                $data['emAtividade_err'] = 'Por favor informe se deseja manter a escola disponível para inscrições';
                }        
                
                if(                    
                    empty($data['nome_err']) &&
                    empty($data['logradouro_err']) && 
                    empty($data['bairro_id_err']) && 
                    empty($data['emAtividade_err'])
                ){
                    try {                                                 
                    
                        if($this->escolaModel->update($data)){
                            flash('message', 'Cadastro atualizado com sucesso!','success'); 
                            redirect('escolas/index');
                            die();
                        } else {                        
                            throw new Exception('Ops! Algo deu errado ao tentar atualizar os dados!');
                        }

                    } catch (Exception $e) {                         
                        $erro = 'Erro: '.  $e->getMessage();                      
                        flash('message', $erro,'error');
                        $this->view('escolas/edit',$data);
                        die();
                    }                      
                } else {
                    // Load the view with errors
                    if(!empty($data['erro'])){
                    flash('message', $data['erro'], 'error');
                    }
                    $this->view('escolas/edit', $data);
                }              
            } else {  
                if($escola = $this->escolaModel->getEscolaByid($id)){
                    $data = [
                        'id' => $id,
                        'nome' => isset($escola->nome)
                                    ? $escola->nome
                                    : '',
                        'bairro_id' => isset($escola->bairro_id)
                                    ? $escola->bairro_id
                                    : '',
                        'bairros' => ($this->bairroModel->getBairros())
                                    ? $this->bairroModel->getBairros()
                                    : '',
                        'logradouro' => isset($escola->logradouro)
                                    ? $escola->logradouro
                                    : '',
                        'numero' => isset($escola->numero) 
                                    ? $escola->numero 
                                    : '',
                        'emAtividade' => isset($escola->emAtividade)
                                    ? $escola->emAtividade
                                    : '',
                        'nome_err' => '',
                        'bairro_id_err' => '',
                        'logradouro_err' => '',                   
                        'emAtividade_err' => '',
                        'numero_err' => '',
                        'nav' => 'Cadastros\\Unidades\\Editar uma unidade\\'                      
                    ];         
                } else {
                    die('Erro ao tentar recuperar os dados da escola! Tente novamente');
                }                   
                $this->view('escolas/edit', $data);
            } 
        }      

        public function delete($id){                
            
             //VALIDAÇÃO DO ID
             if(!is_numeric($id)){
                $erro = 'ID Inválido!'; 
            } else if (!$escolaRemover = $this->escolaModel->getEscolaById($id)){
                $erro = 'ID inexistente';
            } else {
                $erro = '';
            }           

            if($escolas = $this->escolaModel->getEscolas()){
                               
                foreach($escolas as $row){                    
                    $listaEscolas[] = [
                        'id' => $row->id,
                        'nome' => isset($row->nome)
                                        ? $row->nome
                                        : '',
                        'bairro_id' => isset($row->bairro_id)
                                        ? $row->bairro_id
                                        : '',
                        'bairro' => ($this->bairroModel->getBairroById($row->bairro_id))
                                        ? $this->bairroModel->getBairroById($row->bairro_id)->nome
                                        : '',
                        'logradouro' => isset($row->logradouro)
                                        ? $row->logradouro
                                        : '',                    
                        'numero' => ($row->numero) ? $row->numero : '',
                        'emAtividade' => ($row->emAtividade == 1) 
                                        ? 'Sim' 
                                        : 'Não'
                    ];       
                }              
           
            } else {
                $escolas = '';
            }              
            
             //esse $_POST['delete'] vem lá do view('confirma');
            if(isset($_POST['delete'])){  
                
                if($erro){
                    flash('message', $erro , 'error');                     
                    $this->view('escolas/index',$data);
                    die();
                }                   

                try { 
                    if($this->escolaModel->delete($id)){                        
                        flash('message', 'Registro excluido com sucesso!', 'success'); 
                        redirect('escolas/index');
                    } else {
                        throw new Exception('Ops! Algo deu errado ao tentar excluir os dados!');
                    }
                } catch (Exception $e) {                    
                    $erro = 'Erro: '.  $e->getMessage();                   
                    flash('message', $erro,'error');                    
                    redirect('escolas/index');
                    die();
                }                
           } else {  
            //se existe protocolos na fila dessa etapa aviso o usuário        
            if($this->escolaModel->escolaRegFila($id)){
                $alerta = 'Alerta.: Existem registros na fila com a escola '.$escolaRemover->nome. ' como opção! Todos os protocolos com esta escola ficarão sem esta opção!';                   
            } else {
                $alerta = '';
            }           

            $data = [   
                'id' => $id,
                'alerta' => $alerta,
                'escolas' => $listaEscolas,
                'escolaRemover' => $escolaRemover,
                'nav' => 'Cadastros\\Unidades\\Excluir uma unidade\\'   
            ];            
            
            $this->view('escolas/confirma',$data);
            exit();
           }                 
        }

        // Atualiza a situação da unidade em listado e não listado
        public function atualizasituacao(){             
           try{
                if($this->escolaModel->atualizaSituacao($_POST['escolaId'],$_POST['situacao'])){
                    //para acessar esses valores no jquery
                    //exemplo responseObj.message
                    $json_ret = array(
                                        'classe'=>'success', 
                                        'message'=>'Dados gravados com sucesso',
                                        'error'=>false
                                    );                     
                    
                    echo json_encode($json_ret); 
                } else {
                    throw new Exception('Erro ao tentar atualizar os dados!');  
                }    
            } catch (Exception $e) {
                $json_ret = array(
                        'classe'=>'error', 
                        'message'=>$e->getMessage(),
                        'error'=>true,
                        );                     
                echo json_encode($json_ret); 
            }
        }        
}   
?>
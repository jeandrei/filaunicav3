<?php
    class Escolavagas extends Controller{
        public function __construct(){

            if((!isLoggedIn())){ 
                flash('message', 'Você deve efetuar o login para ter acesso a esta página', 'error'); 
                redirect('users/login');
                die();
            } else if ((!isAdmin()) && (!isSec())){                
                flash('message', 'Você não tem permissão de acesso a esta página', 'error'); 
                redirect('pages/sistem'); 
                die();
            }  

            //vai procurar na pasta model um arquivo chamado User.php e incluir
            $this->escolaModel = $this->model('Escola');
            $this->escolaVagasModel = $this->model('Escolavaga');
            $this->usuarioEscolaModel = $this->model('Usuarioescola');
            $this->etapaModel = $this->model('Etapa');;
        }

        public function index() { 
            
            $user_id = $_SESSION[DB_NAME . '_user_id'];

            //se o usuário for admin ou user eu pego todas as escolas
            if(isAdmin()){                    
                $escolasUser = $this->usuarioEscolaModel->getAllEscolas();                 
            // se não eu pego só as escolaspages/login cadastradas para o usuário    
            } else if(isSec()) {
                $escolasUser = $this->usuarioEscolaModel->getEscolasDoUsuario($user_id);
            } else {
                $escolasUser = '';
            }

            if($_SERVER['REQUEST_METHOD'] == 'POST'){                
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                $post = [
                    'escola_id' => isset($_POST['escola_id'])
                                ? ($_POST['escola_id'])
                                : '',                 
                    'escola_id_err' => ''                   
                ];                                
                
                // Valida escola_id
                if(empty($post['escola_id']) || $post['escola_id'] == 'NULL'){
                    $post['escola_id_err'] = 'Por favor informe a escola';
                } 
                
                if(                    
                    empty($post['escola_id_err'])
                ){
                    if($escola_vaga = $this->escolaVagasModel->getEscolaVagas($_POST['escola_id'])){
                        foreach ($escola_vaga as $row){
                            $etapas[] = [
                                'id' => $row->id,
                                'descricao' => isset($row->descricao)
                                            ? $row->descricao
                                            : '',
                                'matutino' => isset($row->matutino)
                                            ? $row->matutino
                                            : '',
                                'vespertino' => isset($row->vespertino)
                                            ? $row->vespertino
                                            : '',
                                'integral' => isset($row->integral)
                                            ? $row->integral
                                            : ''
                            ];     
                        }
                    } else {
                        if(!$etapas = $this->etapaModel->getEtapas()){
                            $etapas = '';
                        }
                    }                      
                    $data = [
                        'post' => isset($post)
                                    ? $post
                                    : '',
                        'etapas' => isset($etapas)
                                    ? $etapas
                                    : '',
                        'nav' => 'CEI\\Quadro de Vagas'
                    ];  
                    $this->view('escolavagas/vagas', $data);
                } else { 
                    $data = [
                        'post' => isset($post)
                                    ? $post
                                    : '',
                        'etapas' => isset($etapas)
                                    ? $etapas
                                    : '',
                        'escolas' => isset($escolasUser)
                                ? $escolasUser
                                : '',
                        'nav' => 'CEI\\Quadro de Vagas'
                    ];                     
                    $this->view('escolavagas/index', $data);
                }
            } else {
                $data = [
                    'escolas' => isset($escolasUser)
                                ? $escolasUser
                                : '',
                    'nav' => 'CEI\\Quadro de Vagas'
                ];
                if($data['escolas']){                    
                    $this->view('escolavagas/index', $data);
                } else {                                 
                    $this->view('usuarioescolas/index');
                }  
            }         
             
        }        

        public function vagas($escola_id){ 

            if(!is_numeric($escola_id)){
                die('Erro ao recuperar o id! Tente novamente');
            }  

            if($_SERVER['REQUEST_METHOD'] == 'POST'){
             
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                $post = [
                    'escola_id' => $escola_id,                 
                    'escola_id_err' => '',
                    'nav' => 'CEI\\Quadro de Vagas'                                      
                ]; 
                
                $erro = false;

                /*Vai verificar para cada post se foi passado a quantidade e se é numérico*/ 
                if($etapas = $this->etapaModel->getEtapas()){
                    foreach($etapas as $etapa){
                        $matutino = $_POST['matutino_'.$etapa['id']];
                        $vespertino = $_POST['vespertino_'.$etapa['id']];
                        $integral = $_POST['integral_'.$etapa['id']];
                                           
                                            
                        if($matutino == ""){
                            $erro = true;
                        } else if(!is_numeric($matutino)){
                            $erro = true;
                        } else if ((intval($matutino)<0)){
                            $erro = true;
                        }
                        
                        if($vespertino == ""){
                            $erro = true;
                        } else if(!is_numeric($vespertino)){
                            $erro = true;
                        } else if ((intval($vespertino)<0)){
                            $erro = true;
                        }
                         
                        if($integral == ""){
                            $erro = true;
                        } else if(!is_numeric($integral)){
                            $erro = true;
                        } else if ((intval($integral)<0)){
                            $erro = true;
                        }                   
    
                    }
                } else {
                    $etapas = '';
                }                               
               
                if($erro == true){
                    $post['escola_id_err'] = 'Valor inválido informado!';
                }
                         

                if(                    
                    empty($post['escola_id_err']) 
                   
                ){
                    try { 
                        foreach($etapas as $etapa){                          
                          if(!$this->escolaVagasModel->register($escola_id,$etapa['id'],$_POST['matutino_'.$etapa['id']],$_POST['vespertino_'.$etapa['id']],$_POST['integral_'.$etapa['id']])){
                                throw new Exception('Ops! Algo deu errado ao tentar gravar os dados!');
                            }  
                          
                        }  
                      
                        flash('message', 'Dados gravados com sucesso!','success');

                        if($escola_vaga = $this->escolaVagasModel->getEscolaVagas($escola_id)){
                            unset($etapas);
                            foreach ($escola_vaga as $row){
                                $etapas[] = [
                                    'id' => $row->id,
                                    'descricao' => isset($row->descricao)
                                                ? $row->descricao
                                                : '',
                                    'matutino' => isset($row->matutino)
                                                ? $row->matutino
                                                : '',
                                    'vespertino' => isset($row->vespertino)
                                                ? $row->vespertino
                                                : '',
                                    'integral' => isset($row->integral)
                                                ? $row->integral
                                                : ''
                                ];     
                            }
                        } 
                        $data = [
                            'post' => isset($post)
                                        ? $post
                                        : '',
                            'etapas' => isset($etapas)
                                        ? $etapas
                                        : '',
                            'nav' => 'CEI\\Quadro de Vagas'
                        ];
                        
                        $this->view('escolavagas/vagas', $data);

                    } catch (Exception $e) {                        
                        $erro = 'Erro: '.  $e->getMessage();
                        flash('message', $erro,'error');
                        $this->view('escolasvagas/vagas',$data);
                    }                      
                } else {   
                    $data = [
                        'etapas' => ($this->etapaModel->getEtapas())
                                    ? $this->etapaModel->getEtapas()
                                    : '',
                        'nav' => 'CEI\\Quadro de Vagas'
                    ];                                   
                    $this->view('escolavagas/vagas',$data);
                }

            } else {                
                if($escola_vaga = $this->escolaVagasModel->getEscolaVagas($escola_id)){
                    foreach ($escola_vaga as $row){
                        $etapas[] = [
                            'id' => $row->id,
                            'descricao' => isset($row->descricao)
                                        ? $row->descricao
                                        : '',
                            'matutino' => isset($row->matutino)
                                        ? $row->matutino
                                        : '',
                            'vespertino' => isset($row->vespertino)
                                        ? $row->vespertino
                                        : '',
                            'integral' => isset($row->integral)
                                        ? $row->integral
                                        : '' 
                        ];     
                    }
                } else {
                    if(!$etapas = $this->etapaModel->getEtapas()){
                        $etapas = '';
                    }
                }      
                
                $data = [
                    'etapas' => isset($etapas)
                                ? $etapas
                                : ''
                ];
                $this->view('escolavagas/vagas',$data);
            }  //IF POST         
        }

              
}   
?>
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

            //pego o id do usuário
            $user_id = $_SESSION[DB_NAME . '_user_id'];

            //se o usuário for admin ou user eu pego todas as escolas
            if(isAdmin()){                    
                $data['escolas'] = $this->usuarioEscolaModel->getAllEscolas();                 
            // se não eu pego só as escolaspages/login cadastradas para o usuário    
            } else if(isSec()) {
                $data['escolas'] = $this->usuarioEscolaModel->getEscolasDoUsuario($user_id);
            } else {
                $data['escolas'] = '';
            }

            //debug($data);

            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                //init data
                $data['post'] = [
                    'escola_id' => ($_POST['escola_id']),                 
                    'escola_id_err' => ''                   
                ];   
                
                              
                
                // Valida escola_id
                if(empty($data['post']['escola_id']) || $data['post']['escola_id'] == 'NULL'){
                    $data['post']['escola_id_err'] = 'Por favor informe a escola';
                } 

                
                if(                    
                    empty($data['post']['escola_id_err'])
                ){
                    if($escola_vaga = $this->escolaVagasModel->getEscolaVagas($_POST['escola_id'])){
                        foreach ($escola_vaga as $row){
                            $data['etapas'][] = [
                                'id' => $row->id,
                                'descricao' => $row->descricao,
                                'matutino' => $row->matutino,
                                'vespertino' => $row->vespertino,
                                'integral' => $row->integral
                            ];     
                        }
                    } else {
                        $data['etapas'] = $this->etapaModel->getEtapas();
                    }  
                    $this->view('escolavagas/vagas', $data);
                } else { 
                    $this->view('escolavagas/index', $data);
                }


            } else {
                if($data['escolas']){                    
                    $this->view('escolavagas/index', $data);
                } else {                                 
                    $this->view('usuarioescolas/index');
                }  
            }         
             
        }


        

        public function vagas($escola_id){   

            if($_SERVER['REQUEST_METHOD'] == 'POST'){
             
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                $data['post'] = [
                    'escola_id' => $escola_id,                 
                    'escola_id_err' => ''                                       
                ]; 
                

                /*Vai verificar para cada post se foi passado a quantidade e se é numérico*/ 
                               
                $etapas = $this->etapaModel->getEtapas();
                $erro = false;
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
                
                if($erro == true){
                    $data['post']['escola_id_err'] = 'Valor inválido informado!';
                }
                         

                if(                    
                    empty($data['post']['escola_id_err']) 
                   
                ){
                    try { 
                        foreach($etapas as $etapa){                          
                          if(!$this->escolaVagasModel->register($escola_id,$etapa['id'],$_POST['matutino_'.$etapa['id']],$_POST['vespertino_'.$etapa['id']],$_POST['integral_'.$etapa['id']])){
                                throw new Exception('Ops! Algo deu errado ao tentar gravar os dados!');
                            }  
                          
                        }  

                      
                        flash('message', 'Dados gravados com sucesso!','success');
                        $escola_vaga = $this->escolaVagasModel->getEscolaVagas($escola_id); 
                        
                        foreach ($escola_vaga as $row){
                            $data['etapas'][] = [
                                'id' => $row->id,
                                'descricao' => $row->descricao,
                                'matutino' => $row->matutino,
                                'vespertino' => $row->vespertino,
                                'integral' => $row->integral
                            ];     
                        }

                        $this->view('escolavagas/vagas', $data);

                    } catch (Exception $e) {                        
                        $erro = 'Erro: '.  $e->getMessage();
                        flash('message', $erro,'error');
                        $this->view('escolasvagas/vagas',$data);
                    }                      
                } else {   
                    $data['etapas'] = $this->etapaModel->getEtapas();                 
                    $this->view('escolavagas/vagas',$data);
                }

            } else {                
                if($escola_vaga = $this->escolaVagasModel->getEscolaVagas($escola_id)){
                    foreach ($escola_vaga as $row){
                        $data['etapas'][] = [
                            'id' => $row->id,
                            'descricao' => $row->descricao,
                            'matutino' => $row->matutino,
                            'vespertino' => $row->vespertino,
                            'integral' => $row->integral 
                        ];     
                    }
                } else {
                    $data['etapas'] = $this->etapaModel->getEtapas(); 
                }               
                $this->view('escolavagas/vagas',$data);
            }  //IF POST

            
         
        }

              
}   
?>
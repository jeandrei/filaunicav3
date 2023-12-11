<?php
    class Listaunidades extends Controller{
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
            $this->bairroModel = $this->model('Bairro')            ;
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
                        'bairro' => ($this->bairroModel->getBairroById($row->bairro_id))
                                    ? $this->bairroModel->getBairroById($row->bairro_id)->nome
                                    : '',
                        'logradouro' => ($row->logradouro)
                                    ? $row->logradouro
                                    :'',                    
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
                    'nav' => 'Registros\\Lista de Unidades\\'
                ];

                $this->view('listaunidades/index', $data);
            } else {                                 
                $this->view('listaunidades/index');
            }   
        }

        
}   
?>
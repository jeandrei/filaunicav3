<?php
    class Pages extends Controller{
        public function __construct(){
            // 1 Chama o model
          //$this->postModel = $this->model('Post');
        }





        // INDEX PÁGINA INICIAL LANDING PAGE
        public function index(){
           
            // Posso passar valores aqui pois no view está definido um array para isso
            // public function view($view, $data = []){
            // 2 Chama um método
            //$posts = $this->postModel->getPosts();
            
            // 3 coloca os valores no array
            $data = [
            'title' => 'Fila Única',
            'description'=> 'Fila Única'
            ];

            // 4 Chama o view passando os dados
            $this->view('pages/index', $data);
        }
      



        // PÁGINA INICIAL DO SISTEMA DEPOIS DE EFETUAR O LOGIN
        public function sistem(){  
            
            if((!isLoggedIn())){ 
                flash('message', 'Você deve efetuar o login para ter acesso a esta página', 'error'); 
                redirect('users/login');
                die();
              }              

            // Posso passar valores aqui pois no view está definido um array para isso
            // public function view($view, $data = []){
                // 2 Chama um método
                //$posts = $this->postModel->getPosts();
                
                // 3 coloca os valores no array
                $data = [
                'title' => 'Fila Única',
                'description'=> 'Sistema de fila única de Penha/SC'
            ];

            // 4 Chama o view passando os dados
            $this->view('pages/sistem', $data);
        }






        // PÁGINA ABOUT
        public function about(){

            if((!isLoggedIn())){ 
                flash('message', 'Você deve efetuar o login para ter acesso a esta página', 'error'); 
                redirect('users/login');
                die();
            } 

            $data = [
                'title' => 'Sobre Nós',
                'description'=> 'Sistema de gerenciamento de fila única'
            ];
            $this->view('pages/about', $data);           
        }
        
}
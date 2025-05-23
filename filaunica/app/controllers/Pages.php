<?php
	class Pages extends Controller{
		public function __construct(){
				// 1 Chama o model
			$this->configModel = $this->model('Config');
		}

		public function info(){		
			$this->view('pages/info');
		}
	
		public function index(){			
			$data = [
				'title' => 'Fila Única',
				'description'=> 'Fila Única'					 										
			];				
			$this->view('pages/index', $data);
		}
		
		// PÁGINA INICIAL DO SISTEMA DEPOIS DE EFETUAR O LOGIN
		public function sistem(){ 
			if((!isLoggedIn())){ 
				flash('message', 'Você deve efetuar o login para ter acesso a esta página', 'error'); 
				redirect('users/login');
				die();
			}   
			$data = [
				'title' => 'Fila Única',
				'description'=> 'Sistema de fila única de Penha/SC'
			];					
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
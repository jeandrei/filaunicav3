<?php
    class Adm extends Controller{
        public function __construct(){         
            // 1 Chama o model               
            if((!isLoggedIn())){               
              redirect('users/login');
              die();
            }                
        }

        public function index(){  
                      
            $data = [
              'name' => '',
              'email' => '',
              'password' => '',
              'confirm_password' => '',
              'name_err' => '',
              'email_err' => '',
              'password_err' => '',
              'confirm_password_err' => '',
              'title' => 'Fila Única',
              'description'=> 'Sistema de fila única de Penha/SC'
            ]; 
                  
            $this->view('pages/sistem', $data);   
          }              
          
}
<!-- Apenas para poder redirecionar para a administração do sistema com o endereço filaunica/adm -->

<?php
    class Adm extends Controller{
        public function __construct(){
            // 1 Chama o model         
        }

        public function index(){ 
            
          if((!isLoggedIn())){ 
            flash('message', 'Você deve efetuar o login para ter acesso a esta página', 'error');
            
            $data = [
              'name' => '',
              'email' => '',
              'password' => '',
              'confirm_password' => '',
              'name_err' => '',
              'email_err' => '',
              'password_err' => '',
              'confirm_password_err' => ''
            ]; 

            $this->view('users/login',$data);
            die();
          } else {
            $data = [
              'title' => 'Fila Única',
              'description'=> 'Sistema de fila única de Penha/SC'
            ];          
            $this->view('pages/sistem', $data);   
          }              
          
        }       
        

      

}
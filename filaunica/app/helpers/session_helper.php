<?php
    // para ter sessão tem que ter session_start();
    session_start();
    
		//Função para criar as notificações do sistema
    function flash($name = '', $message = '', $class = 'alert alert-success'){
			if(!empty($name)){
				if(!empty($message) && empty($_SESSION[$name])){
					if(!empty($_SESSION[$name])){
						unset($_SESSION[$name]);
					}
					if(!empty($_SESSION[$name. '_class'])){
						unset($_SESSION[$name. '_class']);
					}
					$_SESSION[$name] = $message;
					$_SESSION[$name. '_class'] = $class;
				} elseif(empty($message) && !empty($_SESSION[$name])){
					$class = !empty($_SESSION[$name. '_class']) ? $_SESSION[$name. '_class'] : '';
					//echo '<div class="'.$class.'" id="msg-flash">'.$_SESSION[$name].'</div>';  
					echo '<script>createNotification("'.$_SESSION[$name].'", "'.$class.'")</script>';                    
					unset($_SESSION[$name]);
					unset($_SESSION[$name. '_class']);
				}
			}
    }

		//Retorna se o usuário está logado ou não
		function isLoggedIn(){
			if(isset($_SESSION[DB_NAME . '_user_id'])){       
				return true;
			} else {
				return false;
			}
    }

		//Retorna o id do usuário logado
    function getUserId(){
			if(isset($_SESSION[DB_NAME . '_user_id'])){       
				return $_SESSION[DB_NAME . '_user_id'];
			} else {
				return false;
			}
    }

		//Retorna se o usuário é um tipo admin
    function isAdmin(){
			if((isset($_SESSION[DB_NAME . '_user_type'])) && ($_SESSION[DB_NAME . '_user_type']) == 'admin'){
				return true;
			} else {
				return false;
			}
    }

		//Retorna se o usuáro é um tipo user
    function isUser(){
			if((isset($_SESSION[DB_NAME . '_user_type'])) && ($_SESSION[DB_NAME . '_user_type']) == 'user'){
				return true;
			} else {
				return false;
			}
    }

		//Retorna se o usuário é um tipo sec
    function isSec(){
			if((isset($_SESSION[DB_NAME . '_user_type'])) && ($_SESSION[DB_NAME . '_user_type']) == 'sec'){
				return true;
			} else {
				return false;
			}
    }
?>
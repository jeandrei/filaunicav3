<?php require APPROOT . '/views/inc/header.php'; ?>
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card card-body bg-light mt-2">
                <h2>Criar uma conta de administrador.</h2>
                <p>Por favor informe os dados do novo cadastro.</p>                               
                <form id="register" action="<?php echo URLROOT; ?>/users/register" method="post">  
                    
                    <!--NAME-->
                    <div class="form-group">   
                        <label 
                            for="name">Nome: <sup>*</sup>
                        </label>                        
                        <input 
                            type="text" 
                            name="name"
                            id="name"
                            class="form-control form-control-lg <?php echo (!empty($data['name_err'])) ? 'is-invalid' : ''; ?>" 
                            value="<?php echo $data['name'];?>"
                        >
                        <span class="invalid-feedback">
                            <?php echo $data['name_err']; ?>
                        </span>
                    </div>
                   
                
                    
                     <!--EMAIL-->
                     <div class="form-group">   
                        <label 
                            for="email">Email: <sup>*</sup>
                        </label>                        
                        <input 
                            type="text" 
                            name="email"
                            id="email" 
                            class="form-control form-control-lg <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>"                             
                            value="<?php echo $data['email'];?>"
                        >
                        <span class="invalid-feedback">
                            <?php echo $data['email_err']; ?>
                        </span>
                    </div>

                     <!--PASSWORD-->
                     <div class="form-group">   
                        <label 
                            for="password">Senha: <sup>*</sup>
                        </label>                        
                        <input 
                            type="password" 
                            name="password"
                            id="password" 
                            class="form-control form-control-lg <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>"                             
                            value="<?php echo $data['password'];?>"
                        >
                        <span class="invalid-feedback">
                            <?php echo $data['password_err']; ?>
                        </span>
                    </div>

                     <!--CONFIRM PASSWORD-->
                     <div class="form-group">   
                        <label 
                            for="confirm_password">Confirma senha: <sup>*</sup>
                        </label>                        
                        <input 
                            type="password" 
                            name="confirm_password" 
                            id="confirm_password"
                            class="form-control form-control-lg <?php echo (!empty($data['confirm_password'])) ? 'is-invalid' : ''; ?>"                             
                            value="<?php echo $data['password'];?>"
                        >
                        <span class="invalid-feedback">
                            <?php echo $data['confirm_password_err']; ?>
                        </span>
                    </div>

                    <!--BUTTONS-->
                    <div class="row">
                        <div class="col">
                            <input type="submit" value="Register" class="btn btn-success btn-block">                           
                        </div>
                        <div class="col">
                            <a href="<?php echo URLROOT ;?>/users/login" class="btn btn-light btn-block">Já tem uma conta? Login</a>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
<?php require APPROOT . '/views/inc/footer.php'; ?>

<script>  
 $(document).ready(function(){
	$('#register').validate({
		rules : {
			name : {
				required : true,
				minlength : 3
			},
			email : {
				required : true,
				email : true
			},
			password : {
				required : true,
				minlength : 6,
				maxlength : 30
			},
			confirm_password : {
				required : true,
				equalTo : '#password'
            }   
		},
		messages : {
			name : {
				required : 'Por favor informe seu nome.',
				minlength : 'O seu nome deve ter no mínimo 3 caracteres.'
			},
			email : {
				required : 'Por favor informe o seu e-mail.',
				email : 'Informe um e-mail válido.'
			},
			password : {
				required : 'Por favor informe sua senha.',
				minlength : 'A senha deve ter, no mínimo, 3 caracteres.',
				maxlength : 'A senha deve ter, no máximo, 20 caracteres.'
			},
			confirm_password : {
				required : 'Confirme a sua senha.',
				equalTo : 'As senhas não se correspondem.'
            }
        }
    });
});
</script>
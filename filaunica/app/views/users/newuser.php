<?php require APPROOT . '/views/inc/header.php';?>

<?php flash('message');?>

<div class="alert alert-secondary" role="alert">
  <?php echo isset($data['nav']) ? $data['nav'] : ''; ?>
</div>

<div class="row">
    <div class="col-md-6 mx-auto">    
    <a href="<?php echo URLROOT; ?>/users" class="btn btn-light mt-3"><i class="fa fa-backward"></i>Voltar</a>
        <div class="card card-body bg-ligth mt-5">
            <h2>Registrar um usuário</h2>
            <p>Por favor informe os dados do novo usuário</p>
            <form id="newuser_t" action="<?php echo URLROOT; ?>/users/new" method="post">                
                
                <!--NOME-->
                <div class="form-group">
                    <label for="name"><b class="obrigatorio">*</b>Nome: </label>
                    <!--is-invalid é uma classe do bootstrap que deixa o texto em vermelho então verificamos se tem valor no name_err se sim aplicamos essa classe-->
                    <input 
                        type="text" 
                        name="name" 
                        class="form-control form-control-lg <?php echo (!empty($data
                ['name_err'])) ? 'is-invalid' : ''; ?>" 
                        value="<?php echo $data['name']; ?>">
                    <span class="text-danger">
                        <?php echo $data['name_err']; ?>
                    </span>                
                </div>
                
                <!--EMAIL-->
                <div class="form-group">
                    <label for="email"><b class="obrigatorio">*</b>Email: </label>               
                    <input 
                        type="email" 
                        name="email" 
                        class="form-control form-control-lg <?php echo (!empty($data
                ['email_err'])) ? 'is-invalid' : ''; ?>" 
                        value="<?php echo $data['email']; ?>">
                    <span class="text-danger">
                        <?php echo $data['email_err']; ?>
                    </span>
                </div>
                
                <!--PASSWORD-->
                <div class="form-group">
                    <label for="password"><b class="obrigatorio">*</b>Senha: </label>               
                    <input 
                        type="password" 
                        name="password" 
                        id="password"
                        class="form-control form-control-lg <?php echo (!empty($data
                ['password_err'])) ? 'is-invalid' : ''; ?>" 
                        value="<?php echo $data['password']; ?>">
                    <span class="text-danger">
                        <?php echo $data['password_err']; ?>
                    </span>
                </div>
                
                <!--CONFM PASSWORD-->                
                <div class="form-group">
                    <label for="confirm_password"><b class="obrigatorio">*</b>Confirma: </label>                
                    <input 
                        type="password" 
                        name="confirm_password" 
                        id="confirm_password"
                        class="form-control form-control-lg <?php echo (!empty($data
                ['confirm_password_err'])) ? 'is-invalid' : ''; ?>" 
                        value="<?php echo $data['confirm_password']; ?>">
                    <span class="text-danger">
                        <?php echo $data['confirm_password_err']; ?>
                    </span>
                </div>

                <!--TYPE-->
                <div class="row">
                
            
                    <div class="form-group col-md-12">               
                        
                        <strong><b class="obrigatorio">*</b>Tipo do usuário</strong>
                    

                        <div class="form-check">
                        <input class="form-check-input" type="radio" name="type" id="admin" value='admin' <?php echo ($data['type']=='admin') ? 'checked' : '';?>>
                        <label class="form-check-label" for="admin">
                            Admin
                        </label>
                        </div>
                        
                        <div class="form-check">
                        <input class="form-check-input" type="radio" name="type" id="user" value='user'<?php echo ($data['type']=='user') ? 'checked' : '';?>>
                        <label class="form-check-label" for="user">
                            Usuário
                        </label>
                        </div>

                        <div class="form-check">
                        <input class="form-check-input" type="radio" name="type" id="sec" value='sec'<?php echo ($data['type']=='sec') ? 'checked' : '';?>>
                        <label class="form-check-label" for="sec">
                            Secretário
                        </label>
                        </div>

                        <!-- ONDE QUERO QUE APAREÇA O ERRO -->
                        <label for="type" class="error text-danger"><?php echo $data['type_err'];?></label>  

                    </div><!-- col -->

                </div><!-- row --> 

                <br>

                 <!--BOTÕES-->
                 <div class="row">
                    <div class="col">                    
                        <input type="submit" value="Registrar" class="btn btn-success btn-block">                        
                    </div>                    
                 </div>
            </form>
        </div>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php';?>

<script>  
 $(document).ready(function(){
        $('#newuser').validate({
            rules : {	
                name : {
                    required : true,
                    minlength : 6,
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
                },
                type : {
                    required: true
                }
            },

            messages : {
                name : {
                    required : 'Por favor informe o nome do usuário.',
                    minlength : 'A senha deve ter, no mínimo, 6 caracteres.'
                },			
                email : {
                    required : 'Por favor informe seu email.',
                    email : 'Informe um e-mail válido.'
                },
                password : {
                    required : 'Por favor informe sua senha.',
                    minlength : 'A senha deve ter, no mínimo, 3 caracteres.',
                    maxlength : 'A senha deve ter, no máximo, 20 caracteres.'
                },
                confirm_password : {
                    required : 'Por favor confirme sua senha.',
                    equalTo : 'As senhas não se correspondem.'
                },
                type : {
                    required : 'Por favor o tipo do usuário.'
                }	
            }
        });
});
</script>
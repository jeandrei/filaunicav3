<?php ini_set('default_charset', 'utf-8');?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title><?php echo SITENAME; ?></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
   
   <!--Bootstrap CSS CDN-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
   
   <!--Font Awesome CDN-->
   <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
   
   <!--CSS MIDIFICAÇÕES SOBESCREVER Botstrap-->
   <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">   
    
    <!--jquery-->
    <script src="<?php echo URLROOT; ?>/js/jquery-3.1.1.js"></script> 

    <!--jquery validation-->
    <script src="<?php echo URLROOT; ?>/js/jquery.validate.js"></script> 

    <!--jquery mask-->
    <script src="<?php echo URLROOT; ?>/js/jquery.mask.js" data-autoinit="true"></script> 

    <!--Botstrap main CDN-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    
    <!--Javascript funções-->
    <script src="<?php echo URLROOT; ?>/js/main.js"></script>
      
</head>
<body>
<?php //require APPROOT . '/views/inc/navbar.php'; ?>
<!-- a linha abaixo inicia um container do bootstrap ela vai fechr no arquivo footer.php-->

  <div class="container">   
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card card-body bg-light mt-5">
                <?php // Segunda parte da menságem     
                flash('message', 'Registro excluido com sucesso!', 'success');    
                flash('message');
                ?>
                <h2>Login</h2>
                <p>Por favor informe suas credenciais</p>                               
                <form id="login" action="<?php echo URLROOT; ?>/users/login" method="post">  
                         
                     <!--EMAIL-->
                     <div class="form-group mb-3">   
                        <label 
                            for="email">Email: <sup>*</sup>
                        </label>                        
                        <input 
                            type="text" 
                            name="email" 
                            class="form-control form-control-lg <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>"                             
                            value="<?php echo $data['email'];?>"
                        >
                        <span class="invalid-feedback">
                            <?php echo $data['email_err']; ?>
                        </span>
                    </div>

                     <!--PASSWORD-->
                     <div class="form-group mb-3">   
                        <label 
                            for="password">Senha: <sup>*</sup>
                        </label>                        
                        <input 
                            type="password" 
                            name="password" 
                            class="form-control form-control-lg <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>"                             
                            value="<?php echo $data['password'];?>"
                        >
                        <span class="invalid-feedback">
                            <?php echo $data['password_err']; ?>
                        </span>
                    </div>                     

                    <!--BUTTONS-->
                    <div class="row">
                        <div class="col">
                            <input type="submit" value="Login" class="btn btn-success btn-block">                           
                        </div>                        
                    </div>

                </form>
            </div>
        </div>
    </div>
<?php require APPROOT . '/views/inc/footer.php'; ?>


<script>  
 $(document).ready(function(){
        $('#login').validate({
            rules : {			
                email : {
                    required : true,
                    email : true
                },
                password : {
                    required : true,
                    minlength : 6,
                    maxlength : 30
                }
            },

            messages : {			
                email : {
                    required : 'Por favor informe seu email.',
                    email : 'Informe um e-mail válido.'
                },
                password : {
                    required : 'Por favor informe sua senha.',
                    minlength : 'A senha deve ter, no mínimo, 3 caracteres.',
                    maxlength : 'A senha deve ter, no máximo, 20 caracteres.'
                }
            }
        });
});
</script>
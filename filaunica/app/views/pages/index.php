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
    
    <style>
      .float{
          position:fixed;
          width:60px;
          height:60px;
          bottom:40px;
          right:40px;
          background-color:#25d366;
          color:#FFF;
          border-radius:50px;
          text-align:center;
          font-size:30px;
          box-shadow: 2px 2px 3px #999;
          z-index:100;
        }

        .my-float{
          margin-top:16px;
        }
  </style>
</head>
<body>


<!-- IMAGEM HEADER -->

<div class="container">  
<img src="<?php echo URLROOT; ?>/img/LOGO.png" class="img-fluid" alt="Responsive image">


<div class="container text-center">

            <div class="row justify-content-center align-items-center">
              <div class="col-lg-12">
                  <div class="alert alert-success text-center" role="alert">
                      Fila Única <a href="<?php echo URLROOT; ?>/downloads/Lei da Fila Única.pdf" target="_blank" class="alert-link"><i class="fa fa-external-link" aria-hidden="true"></i> Lei de criação.</a>
                            
                        <a href="https://educapenha.com.br/fila-unica/" target="_blank" class="alert-link"><i class="fa fa-external-link" aria-hidden="true"></i> Orientações.</a>
                  </div>
              </div>
            </div>
           
            
            <!-- FILA ÚNICA DESCRIÇÃO-->
         

          <div class="row mb-3" id="box-search">
              <div class="thumbnail text-center">
                  <img src="<?php echo URLROOT; ?>/img/home_img.jpg" alt="" class="img-fluid">                 
              </div>
          </div>
            

    
          <div class="row justify-content-center align-items-center">         
              <div class="col-lg-4">
                    <a href="<?php echo URLROOT; ?>/filas/cadastrar" class="btn btn-success btn-lg btn-block" role="button">Cadastrar</a>                         
                    <a href="<?php echo URLROOT; ?>/listas/listachamada" class="btn btn-default btn-lg btn-block" role="button">Lista de Chamada</a>                                      
              </div>
          </div>

        <hr>        
        
        <!--  -->
        <form action="<?php echo URLROOT; ?>/filas/consultar" class="form-inline" method="post" enctype="multipart/form-data" onsubmit="return validation()"> 
          <div class="row justify-content-center align-items-center">            
              <div class="col-lg-4">                                              
                    <div class="form-group mx-sm-3 mb-2">
                      <label for="protocolo" class="sr-only"></label>                                 
                      <input 
                          type="number" 
                          class="form-control onlynumbers <?php echo (!empty($data['protocolo_err'])) ? 'is-invalid' : ''; ?>" 
                          id="protocolo" 
                          name="protocolo" 
                          placeholder="Protocolo"
                      >               
                    </div> 
              </div>
              
              <div class="col-lg-1">
                      <button type="submit" class="btn btn-primary btn-lg mb-2">Consultar</button>
              </div>  

          </div>
        </form>   
        
        
        <span id="protocolo_err" class="text-danger"> 
              <?php if(!empty($data['protocolo_err']))
                {
                  echo $data['protocolo_err'];
                }
              ?>
        </span>
</div> 


<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<a href="https://web.whatsapp.com/send?phone=554733454025" class="float" target="_blank">
<i class="fa fa-whatsapp my-float"></i>
</a>

 
</div><!--fecha div container lá do header-->
</body>
</html>

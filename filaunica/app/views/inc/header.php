<?php ini_set('default_charset', 'utf-8');?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title><?php echo SITENAME; ?></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
   
   <!--Bootstrap CSS-->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
   
   <!--Font Awesome CDN-->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />
   
   <!--CSS MIDIFICAÇÕES SOBESCREVER Botstrap-->
   <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">   
    
    <!--jquery-->
    <script src="<?php echo URLROOT; ?>/js/jquery-3.1.1.js"></script> 

    <!--jquery validation-->
    <script src="<?php echo URLROOT; ?>/js/jquery.validate.js"></script> 

    <!--jquery mask-->
    <script src="<?php echo URLROOT; ?>/js/jquery.mask.js" data-autoinit="true"></script> 

    <!--Botstrap main-->
    <script src="<?php echo URLROOT; ?>/js/bootstrap.min.js"></script>
    
    <!--Javascript funções-->
    <script src="<?php echo URLROOT; ?>/js/main.js"></script>
      
</head>
<body>

<!-- as mensagens são adicionadas pelo javascript nesse elemento toasts -->
<div id="toasts"></div>

<?php //require APPROOT . '/views/inc/navbar.php'; ?>
<!-- a linha abaixo inicia um container do bootstrap ela vai fechr no arquivo footer.php-->
<?php include APPROOT . '/views/inc/navbar.php'; ?>
  <div class="container">   
 

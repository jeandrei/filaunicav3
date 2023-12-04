<?php require APPROOT . '/views/inc/header.php';?>

<?php flash('message'); ?>


<!-- ADD NEW -->
<div class="row mb-3">
    <div class="col-md-12 text-center">
        <h1><?php echo $data['title']; ?></h1>
    </div>  
</div>

<ul class="list-group">
  <li class="list-group-item"><a href="<?php echo URLROOT; ?>/configs/configCad">Configuração de cadastros da fila</a></li>
</ul>



<?php require APPROOT . '/views/inc/footer.php'; ?>
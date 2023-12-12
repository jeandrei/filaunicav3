<?php require APPROOT . '/views/inc/header.php';?>

<?php flash('message'); ?>


<div class="alert alert-secondary" role="alert">
  <?php echo isset($data['nav']) ? $data['nav'] : ''; ?>
</div>

<ul class="list-group">
  <li class="list-group-item"><a href="<?php echo URLROOT; ?>/configs/configCad">Configuração de cadastros da fila</a></li>
</ul>



<?php require APPROOT . '/views/inc/footer.php'; ?>
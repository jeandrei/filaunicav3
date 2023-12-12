<?php require APPROOT . '/views/inc/header.php';?>

<div class="alert alert-secondary" role="alert">
  <?php echo isset($data['nav']) ? $data['nav'] : ''; ?>
</div>

<main>
  
    <h2 class="mt-2">Excluir Usuário</h2>

    <form action="<?php echo URLROOT; ?>/users/delete/<?php echo $data['user']->id;?>" method="post" enctype="multipart/form-data">
        
        <div class="form-group">
            <p>Você deseja realmente excluir o Usuário <strong><?php echo $data['user']->name; ?>?</strong></p>
        </div>  
        
        <div class="form-group mt-3">
        
            <a class="btn btn-success" href="<?php echo URLROOT ?>/users">
            Cancelar
            </a>
        
            <button type="submit" name="delete" id="delete" class="btn btn-danger">Excluir</button>
        </div>

    </form>

</main>
<?php require APPROOT . '/views/inc/footer.php'; ?>
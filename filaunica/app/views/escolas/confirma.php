<?php require APPROOT . '/views/inc/header.php';?>

<main>
  
    <h2 class="mt-2">Excluir Escola</h2>

    <form action="<?php echo URLROOT; ?>/escolas/delete/<?php echo $data['escola']->id;?>" method="post" enctype="multipart/form-data">
        
        <div class="form-group">
            <p>Você deseja realmente excluir a Escola <strong><?php echo $data['escola']->nome; ?>?</strong></p>           
            <?php if($data['alerta']){
                echo $data['alerta'];
            }?>
            <p>Só execute esta ação se você realmente sabe o que está fazendo.</p>
        </div>  
        
        <div class="form-group mt-3">
        
            <a class="btn btn-success" href="<?php echo URLROOT ?>/escolas">
            Cancelar
            </a>
        
            <button type="submit" name="delete" id="delete" class="btn btn-danger">Excluir</button>
        </div>

    </form>

</main>
<?php require APPROOT . '/views/inc/footer.php'; ?>
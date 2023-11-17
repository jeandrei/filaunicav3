<?php require APPROOT . '/views/inc/header.php';?>

<main>
  
    <h2 class="mt-2">Excluir Situação</h2>

    <form action="<?php echo URLROOT; ?>/situacoes/delete/<?php echo $data->id;?>" method="post" enctype="multipart/form-data">
        
        <div class="form-group">
            <p>Você deseja realmente excluir a Situação <strong><?php echo $data->descricao; ?>?</strong></p>
            <p>Todos os protocolos com a situação <?php echo $data->descricao; ?> serão <strong>ARQUIVADOS.</strong></p>
            <p>Só execute esta ação se você realmente sabe o que está fazendo.</p>
        </div>  
        
        <div class="form-group mt-3">
        
            <a class="btn btn-success" href="<?php echo URLROOT ?>/situacoes">
            Cancelar
            </a>
        
            <button type="submit" name="delete" id="delete" class="btn btn-danger">Excluir</button>
        </div>

    </form>

</main>
<?php require APPROOT . '/views/inc/footer.php'; ?>
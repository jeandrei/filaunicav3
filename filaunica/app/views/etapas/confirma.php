<?php require APPROOT . '/views/inc/header.php';?>

<div class="alert alert-light" role="alert">
  <?php echo isset($data['nav']) ? $data['nav'] : ''; ?>
</div>

<main> 
  

    <form action="<?php echo URLROOT; ?>/etapas/delete/<?php echo $data['etapa']->id;?>" method="post" enctype="multipart/form-data">
        
        <div class="form-group">
            <p><strong><?php echo $data['alerta']; ?></strong></p>
            <p>Você deseja realmente excluir a Etapa <strong><?php echo $data['etapa']->descricao; ?>?</strong></p>
            <p>Todos os protocolos com a etapa <?php echo $data['etapa']->descricao; ?> ficarão <strong>fora da fila.</strong></p>
            <p>Só execute esta ação se você realmente sabe o que está fazendo.</p>
        </div>  
        
        <div class="form-group mt-3">
        
            <a class="btn btn-success" href="<?php echo URLROOT ?>/etapas">
            Cancelar
            </a>
        
            <button type="submit" name="delete" id="delete" class="btn btn-danger">Excluir</button>
        </div>

    </form>

</main>
<?php require APPROOT . '/views/inc/footer.php'; ?>
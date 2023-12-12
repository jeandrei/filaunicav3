<?php require APPROOT . '/views/inc/header.php';?>

<div class="alert alert-secondary" role="alert">
  <?php echo isset($data['nav']) ? $data['nav'] : ''; ?>
</div>

<main> 

    <form action="<?php echo URLROOT; ?>/escolas/delete/<?php echo $data['escolaRemover']->id;?>" method="post" enctype="multipart/form-data">
        
        <div class="form-group">
            <p>Você deseja realmente excluir a Escola <strong><?php echo $data['escolaRemover']->nome; ?>?</strong></p>   

            <!--ALERTA QUE JÁ EXISTEM CADASTROS NA FILA COM A ESCOLA DE OPÇÃO-->
            <?php if(isset($data['alerta']) && $data['alerta'] != '') :?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="alert alert-warning" role="alert">
                        <p><?php echo $data['alerta']; ?></p>
                    </div>
                </div>                    
            </div>
            <?php endif; ?>
            <!--ALERTA QUE JÁ EXISTEM CADASTROS NA FILA COM A ESCOLA DE OPÇÃO-->

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
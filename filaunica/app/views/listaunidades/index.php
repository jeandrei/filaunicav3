<?php require APPROOT . '/views/inc/header.php'; ?>
 
 <?php flash('message');?>

 <div class="alert alert-secondary" role="alert">
  <?php echo isset($data['nav']) ? $data['nav'] : ''; ?>
</div>

<table class="table table-striped">
    <thead>
        <tr class="text-center">      
            <th class="col-sm-3">Nome</th>
            <th class="col-sm-3">Logradouro</th>
            <th class="col-sm-1">Número</th>
            <th class="col-sm-2">Bairro</th>
            <th class="col-sm-1">Listado</th>            
        </tr>
    </thead>
    <tbody>
    <?php if($data['results']) : ?>
        <?php foreach($data['results'] as $escola) : ?>
            <tr class="text-center">
                <td><?php echo $escola['nome'];?></td>
                <td><?php echo $escola['logradouro'];?></td>
                <td><?php echo $escola['numero'];?></td>   
                <td><?php echo $escola['bairro'];?></td>                                
                <td>       

                    <!-- Listado -->
                    <div class="form-check form-switch form-check-inline">
                        <input 
                            id="listado" 
                            name="listado"
                            type="checkbox" 
                            class="form-check-input"
                            onChange="atualiza(<?php echo $escola['id'];?>,this)"
                            <?php echo (($escola['emAtividade'])== 'Sim') ? 'checked' : ''; ?>
                        >                   
                    </div>
                    <!-- Listado -->

                </td>
            </tr>
        <?php endforeach; ?>  
    <?php else: ?> 
        <tr>
            <td colspan="6" class="text-center">
                Nenhuma escola cadastrada
            </td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>
<?php require APPROOT . '/views/inc/footer.php'; ?>

<script>
    let timer;
    const waitTimer = 1000;//atualiza a busca a cada 1 segundos
    function atualiza(escolaId,val){
        clearTimeout(timer);
        timer = setTimeout(function(){  
            console.log(val.checked);
            $(document).ready(function(){
                $.ajax({ 
                    url: '<?php echo URLROOT; ?>/escolas/atualizasituacao',                
                    method:'POST',
                    data:{
                        escolaId:escolaId,
                        situacao:val.checked
                    }, 
                    success: function(retorno_php){   
                    let responseObj = JSON.parse(retorno_php)                  
                    createNotification(responseObj.message,responseObj.classe);
                    }
                });//Fecha o ajax     
            });
        },waitTimer);
    }
</script>
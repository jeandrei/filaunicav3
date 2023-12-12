<?php require APPROOT . '/views/inc/header.php';?>

<?php flash('message'); ?>

<div class="alert alert-secondary" role="alert">
  <?php echo isset($data['nav']) ? $data['nav'] : ''; ?>
</div>


<table class="table table-striped">
    <thead>
        <tr class="text-center">      
            <th class="col-sm-3">Descrição</th>
            <th class="col-sm-3">Ativo/Inativo</th>                     
        </tr>
    </thead>
    <tbody>
      <tr class="text-center">

        <td>Permite cadastros duplicados?</td>
        <td>  
         <!-- Listado -->
          <div class="form-check form-switch form-check-inline">
              <input 
                  id="listado" 
                  name="listado"
                  type="checkbox" 
                  class="form-check-input"
                  onChange="atualiza(this)"
                  <?php echo (($data['permiteCadDuplicado']) == 'sim') ? 'checked' : ''; ?>
              >                   
          </div>
          <!-- Listado -->
        </td>

      </tr>
    </tbody>
</table>
<?php require APPROOT . '/views/inc/footer.php'; ?>

<script>
    let timer;
    const waitTimer = 1000;//atualiza a busca a cada 1 segundos
    function atualiza(val){
        clearTimeout(timer);
        timer = setTimeout(function(){ 
            $(document).ready(function(){
                $.ajax({ 
                    url: '<?php echo URLROOT; ?>/configs/atualizConfigCad',                
                    method:'POST',
                    data:{                        
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
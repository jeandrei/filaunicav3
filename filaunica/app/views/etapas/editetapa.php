<?php require APPROOT . '/views/inc/header.php';?>

<div class="alert alert-secondary" role="alert">
  <?php echo isset($data['nav']) ? $data['nav'] : ''; ?>
</div>

<?php flash('message');?>

<div class="row">
    <div class="col-md-6 mx-auto">    
    <a href="<?php echo URLROOT; ?>/etapas" class="btn btn-light mt-3"><i class="fa fa-backward"></i> Voltar</a>
        <div class="card card-body bg-ligth mt-5">
            <h2>Editar uma etapa</h2>
            <p>Por favor informe os dados da etapa</p>            
            <form id="editetapa" action="<?php echo URLROOT; ?>/etapas/edit/<?php echo $data['id']; ?>" method="post">                
                <!--DESCRIÇÃO-->
                <div class="form-group">
                <label for="descricao"><b class="obrigatorio">*</b>Descrição: </label>
                <!--is-invalid é uma classe do bootstrap que deixa o texto em vermelho então verificamos se tem valor no name_err se sim aplicamos essa classe-->
                <input type="text" name="descricao" class="form-control form-control-lg <?php echo (!empty($data
                ['descricao_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['descricao']; ?>">
                <span class="invalid-feedback"><?php echo $data['descricao_err']; ?></span>
                </div>
                <!--DATA INICIAL-->
                <div class="form-group">
                <label for="data_ini"><b class="obrigatorio">*</b>Data Inicial: </label>               
                <input type="date" name="data_ini" class="form-control form-control-lg <?php echo (!empty($data
                ['data_ini_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['data_ini']; ?>">
                <span class="invalid-feedback"><?php echo $data['data_ini_err']; ?></span>
                </div>
                <!--DATA FINAL-->
                <div class="form-group">
                <label for="data_fin"><b class="obrigatorio">*</b>Data Final: </label>               
                <input type="date" name="data_fin" class="form-control form-control-lg <?php echo (!empty($data
                ['data_fin_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['data_fin']; ?>">
                <span class="invalid-feedback"><?php echo $data['data_fin_err']; ?></span>
                </div>      
                <br>
                 <!--BOTÕES-->
                 <div class="row">
                    <div class="col">                    
                        <input type="submit" value="Atualizar" class="btn btn-success btn-block">                        
                    </div>                    
                 </div>
            </form>
        </div>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php';?>

<script>  
 $(document).ready(function(){
        $('#editetapa').validate({
            rules : {	
                descricao : {
                    required : true,
                    minlength : 3,
                },		
                data_ini : {
                    required : true
                },
                data_fin : {
                    required : true                    
                }
            },

            messages : {
                descricao : {
                    required : 'Por favor informe a descrição da etapa.',
                    minlength : 'A descrição deve ter, no mínimo, 3 caracteres.'
                },			
                data_ini : {
                    required : 'Por favor informe a data inicial.'
                },
                data_fin : {
                    required : 'Por favor informe sua data final.'                    
                }
            }
        });
});
</script>
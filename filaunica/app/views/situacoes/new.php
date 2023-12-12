<?php require APPROOT . '/views/inc/header.php';?>

<?php flash('message');?>

<div class="alert alert-secondary" role="alert">
  <?php echo isset($data['nav']) ? $data['nav'] : ''; ?>
</div>

<div class="row">
    <div class="col-md-6 mx-auto">    
    <a href="<?php echo URLROOT; ?>/situacoes" class="btn btn-light mt-3"><i class="fa fa-backward"></i>Voltar</a>
        <div class="card card-body bg-ligth mt-5">
            <h2>Registrar uma situação</h2>
            <p>Por favor informe os dados da nova situação</p>
            <form id="newsit" action="<?php echo URLROOT; ?>/situacoes/new" method="post">                
                
                
                <!--situacao-->        
                <div class="form-group">  
                    <label 
                        for="descricao"><b class="obrigatorio">*</b> Situação: 
                    </label>                        
                    <input 
                        type="text" 
                        name="descricao" 
                        id="descricao" 
                        class="form-control <?php echo (!empty($data['descricao_err'])) ? 'is-invalid' : ''; ?>"                             
                        value="<?php echo htmlout($data['descricao']);?>"
                    >
                    <span class="text-danger">
                        <?php echo $data['descricao_err']; ?>
                    </span>
                </div>
                <!-- situacao -->

                <!-- ativo na fila -->
                <div class="row">
                    
                    <!--SITUACAO-->
                    <div class="form-group col-12">               
                        
                        <strong><b class="obrigatorio">*</b> Ativo na fila?</strong>

                        <div class="form-check">
                        <input class="form-check-input" type="radio" name="ativo" id="sim" value='1' <?php echo ($data['ativo']=='1') ? 'checked' : '';?>>
                        <label class="form-check-label" for="sim">
                            Sim
                        </label>
                        </div>
                        
                        <div class="form-check">
                        <input class="form-check-input" type="radio" name="ativo" id="nao" value='0'<?php echo ($data['ativo']=='0') ? 'checked' : '';?>>
                        <label class="form-check-label" for="nao">
                            Não
                        </label>
                        </div> 
                    <label for="ativo" class="error text-danger"><?php echo $data['ativo_err'];?></label>
                    </div><!-- col -->  
                     

                </div><!-- row -->
                <!-- ativo na fila --> 

                <!--COR--> 
                <label 
                        for="cor"><b class="obrigatorio">*</b> Cor: 
                    </label>       
                <div class="form-group">  
                                            
                    <input 
                        type="color" 
                        name="cor"
                        id="cor"
                        value="<?php echo htmlout($data['cor']);?>" 
                    />
                    <span class="text-danger">
                        <?php echo $data['cor_err']; ?>
                    </span>
                </div>
                <!-- COR -->

                
                
                 <!--BOTÕES-->
                 <div class="row">
                    <div class="col">                    
                        <input type="submit" value="Registrar" class="btn btn-success btn-block">                        
                    </div>                    
                 </div>
            </form>
        </div>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php';?>

<script>  
 $(document).ready(function(){
        $('#newsit').validate({
            rules : {	
                descricao : {
                    required : true,
                    minlength : 6,
                },		
                ativo : {
                    required : true
                }
            },

            messages : {
                descricao : {
                    required : 'Por favor informe a situação.',
                    minlength : 'A situação deve ter, no mínimo, 6 caracteres.'
                },			
                ativo : {
                    required : 'Por favor se ativo na fila.'
                }
            }
        });
});
</script>


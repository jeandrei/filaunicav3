<?php require APPROOT . '/views/inc/header.php';?>
<div class="row">
    <div class="col-md-6 mx-auto">
    <?php flash('message');?>
    <a href="<?php echo URLROOT; ?>/users" class="btn btn-light mt-3"><i class="fa fa-backward"></i>Voltar</a>
        <div class="card card-body bg-ligth mt-5">
            <h4>Vincular usuário <?php echo $data['user']->name;?> a escola</h4>
            <p>Por favor selecione a escola a ser vinculada</p>
            <form action="<?php echo URLROOT; ?>/usuarioescolas/new/<?php echo $data['user']->id;?>" method="post">                
                
               
                 <!-- ESCOLA-->
                 <div class="form-row">    
                        <div class="form-group col-md-12">
                            <label for="opcao1" class="help-block">
                                <span class="obrigatorio">*</span><strong>Escola</strong>
                            </label>
                            <select 
                                name="escolaid" 
                                id="escolaid" 
                                class="form-control <?php echo (!empty($data['escolaid_err'])) ? 'is-invalid' : ''; ?>"                                       
                            >
                            <option value="NULL">Selecione a Escola</option>
                                <?php                                                    
                                foreach($data['escolas'] as $escola) : ?> 
                                    <option value="<?php echo $escola->id; ?>"
                                                <?php echo $data['escolaid'] == $escola->id ? 'selected':'';?>                                                                                                                                   
                                    >
                                        <?php echo $escola->nome;?>
                                    </option>
                                <?php endforeach; ?>  
                            </select>                                           
                            <span class="text-danger">
                                    <?php echo $data['escolaid_err']; ?>
                            </span>
                        </div>
                    </div>
                    <!-- ESCOLA -->
                
                          
                
                
                <br>
                 <!--BOTÕES-->
                 <div class="row">
                    <div class="col">                    
                        <input type="submit" value="Gravar" class="btn btn-success btn-block">                        
                    </div>                    
                 </div>
            </form>
        </div>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php';?>
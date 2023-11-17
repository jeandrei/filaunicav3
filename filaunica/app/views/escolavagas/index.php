<?php require APPROOT . '/views/inc/header.php';?>

<div class="row">
    <div class="col-md-6 mx-auto">
    <?php flash('message');?>
    <a href="<?php echo URLROOT; ?>/pages/sistem" class="btn btn-light mt-3"><i class="fa fa-backward"></i>Voltar</a>
        <div class="card card-body bg-ligth mt-5">
            <h2>Vagas por etapa</h2>
            <p>Por favor selecione uma CEI</p>
            <form action="<?php echo URLROOT; ?>/escolavagas" method="post">                
                
                
                <!-- ESCOLA -->
                <div class="form-row">    
                    <div class="form-group">
                        <label for="escola_id" class="help-block">
                            <span class="obrigatorio">*</span><strong>Escola</strong>
                        </label>
                        <select 
                            name="escola_id" 
                            id="escola_id" 
                            class="form-control <?php echo (!empty($data['post']['escola_id_err'])) ? 'is-invalid' : ''; ?>"                                       
                        >
                        <option value="NULL">Selecione a Escola</option>
                            <?php                                                    
                            foreach($data['escolas'] as $escola) : ?> 
                                <option value="<?php echo $escola->escolaid; ?>"
                                            <?php echo $_POST['escola_id'] == $escola->escolaid ? 'selected':'';?>                                                                                                                                   
                                >
                                    <?php echo $escola->nome;?>
                                </option>
                            <?php endforeach; ?>  
                        </select>                                           
                        <span class="text-danger">
                                <?php echo $data['post']['escola_id_err']; ?>
                        </span>
                    </div>
                </div>
                <!-- ESCOLA -->

                
                
                 <!--BOTÕES-->
                 <div class="row mt-3">
                    <div class="col">                    
                        <input type="submit" value="Selecionar" class="btn btn-success btn-block">                        
                    </div>                    
                 </div>
            </form>
        </div>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php';?>


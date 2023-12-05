

<?php require APPROOT . '/views/inc/header.php'; ?>

<h3>Relatório de alunos especiais</h3> 

<form action="<?php echo URLROOT; ?>/admins/relatorioAlunoEspecial" target="_blank" method="post" enctype="multipart/form-data">

    <!-- COLUNA 1 ESCOLA -->
    <div class="col-md-4">
            <label for="escola_id">
                Selecione a Unidade
            </label>                               
            <select 
                name="escola_id" 
                id="escola_id" 
                class="form-control"                                        
            >
                    <option value="Todos">Todos</option>
                    <?php 
                    $escolas = $this->filaModel->getEscolas();                    
                    foreach($escolas as $escola) : ?> 
                        <option value="<?php echo $escola->id; ?>"
                                    <?php if(isset($_POST['escola_id'])){
                                    echo $_POST['escola_id'] == $escola->id ? 'selected':'';
                                    }
                                    ?>
                        >
                            <?php echo $escola->nome;?>
                        </option>
                    <?php endforeach; ?>  
            </select>
        </div>    
    
        <div class="col-md-6 align-self-end mt-2" style="padding-left:5;">            
            <input type="submit" class="btn btn-primary" value="Emitir">
        </div>
        
    </div>
</form>
</body>
</html>




<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="alert alert-secondary" role="alert">
  <?php echo isset($data['nav']) ? $data['nav'] : ''; ?>
</div>

<form action="<?php echo URLROOT; ?>/admins/relatorioMensal" target="_blank" method="post" enctype="multipart/form-data">

    <!-- 1ª LINHA E COLUNAS PARA OS CAMPOS DE BUSCA -->
    <div class="row mb-2">
        
        <!-- COLUNA 1 PROTOCOLO-->
        <div class="col-md-2">
            <label for="ano">
                Ano
            </label>
            <input 
                type="number" 
                name="ano" 
                id="ano" 
                maxlength="60"
                class="form-control"
                value="<?php if(isset($_POST['ano'])){htmlout($_POST['ano']);} ?>"                   
                ><span class="invalid-feedback">
                    <?php // echo $data['nome_err']; ?>
                </span>
        </div>
        
        
        <!-- COLUNA 2 NOME-->
        <div class="col-md-1">
            <label for="mes">
                Mês
            </label>
            <input 
                type="number" 
                name="mes" 
                id="mes" 
                maxlength="60"
                class="form-control"
                value="<?php if(isset($_POST['mes'])){htmlout($_POST['mes']);} ?>"                  
                ><span class="invalid-feedback">
                    <?php // echo $data['nome_err']; ?>
                </span>
        </div>
    
        <div class="col-md-6 align-self-end mt-2" style="padding-left:5;">            
            <input type="submit" class="btn btn-primary" value="Emitir">
        </div>
    </div>
</form>
</body>
</html>


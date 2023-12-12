<?php require APPROOT . '/views/inc/header.php';?>

<?php flash('message');?>

<div class="alert alert-secondary" role="alert">
  <?php echo isset($data['nav']) ? $data['nav'] : ''; ?>
</div>

<div class="row">
    <div class="col-md-6 mx-auto">    
    <a href="<?php echo URLROOT; ?>/escolavagas" class="btn btn-light mt-3"><i class="fa fa-backward"></i>Voltar</a>
        <div class="card card-body bg-ligth mt-5">
          <h2>Vagas por etapa</h2>
          <p>Informe a quantidade de vagas por etapa</p>
          <form action="<?php echo URLROOT; ?>/escolavagas/vagas/<?php echo $data['post']['escola_id'];?>" method="post"> 
              <table class="table table-striped">
                <thead>
                  <tr>                  
                    <th class="w-65">Etapa</th>
                    <th class="w-25 text-left">Matutino</th>                  
                    <th class="w-25 text-left">Vespertino</th> 
                    <th class="w-25 text-left">Integral</th> 
                  </tr>
                </thead>
                <tbody>                            
                    <?php foreach($data['etapas'] as $key => $etapa) : ?>
                      <tr>                      
                        <td>
                          <input type="hidden" id="<?php echo $etapa['id'];?>" name="<?php echo $etapa['id'];?>" value="<?php echo $etapa['id'];?>" />
                            <?php echo $etapa['descricao'];?>
                        </td>
                        <td>
                          <!-- MATUTINO -->
                          <input 
                            type="number"
                            name="matutino_<?php echo $etapa['id'];?>"
                            id="matutino_<?php echo $etapa['id'];?>"
                            class="form-control form-control-sm col-2"
                            value="<?php 
                                      if ($etapa['matutino'] || $etapa['matutino'] == '0'){
                                          echo ($etapa['matutino']);
                                      } else {
                                          echo ($_POST['matutino_'.$etapa['id']]);
                                      }?>" 
                          >
                        </td>
                        <td>
                          <!-- VESPERTINO -->
                          <input 
                            type="number"
                            name="vespertino_<?php echo $etapa['id'];?>"
                            id="vespertino_<?php echo $etapa['id'];?>"
                            class="form-control form-control-sm col-2"
                            value="<?php 
                                      if ($etapa['vespertino'] || $etapa['vespertino'] == '0'){
                                          echo ($etapa['vespertino']);
                                      } else {
                                        echo ($_POST['vespertino_'.$etapa['id']]);
                                      }?>" 
                          >
                        </td>
                        <td>
                          <!-- INTEGRAL -->
                          <input 
                            type="number"
                            name="integral_<?php echo $etapa['id'];?>"
                            id="integral_<?php echo $etapa['id'];?>"
                            class="form-control form-control-sm col-2"
                            value="<?php 
                                      if ($etapa['integral'] || $etapa['integral'] == '0'){
                                          echo ($etapa['integral']);
                                      } else {
                                        echo ($_POST['integral_'.$etapa['id']]);
                                      }?>" 
                          >
                        </td>                      
                      </tr>      
                    <?php endforeach; ?>                
                </tbody>
                </table>    
                
                <span class="text-danger">
                      <?php echo $data['post']['escola_id_err']; ?>
                </span>
                
                <!--BOTÕES-->
                <div class="row mt-3">
                    <div class="col">                    
                        <input type="submit" value="Gravar" class="btn btn-success btn-block">                        
                    </div>                    
                </div>
                <!--BOTÕES-->
          </form>
        </div>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php';?>


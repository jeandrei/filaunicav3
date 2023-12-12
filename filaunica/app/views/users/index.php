<?php require APPROOT . '/views/inc/header.php'; ?>

<script>
/**
 * Funções para manipulação do formulário
 * limpar - limpa os campos com valores do formulário
 * focofield - seta o foco em um campo do formulário
 * 
 */
function limpar(){
        document.getElementById('name').value = "";                
        focofield("name");
        document.getElementById('type').value = "";  
    }    
    
    window.onload = function(){
        focofield("name");
    }     

</script>

 <?php flash('message');?>

 <div class="alert alert-secondary" role="alert">
  <?php echo isset($data['nav']) ? $data['nav'] : ''; ?>
</div>

 <div class="row">
    <div class="col">
        <div class="text-end">
            <a href="<?php echo URLROOT; ?>/users/new" class="btn btn-primary pull-right">
                <i class="fa fa-pencil"></i> Adicionar
            </a>
        </div>
    </div>
</div>

<!-- FORMULÁRIO -->
<form id="filtrar" action="<?php echo URLROOT; ?>/users/index" method="get" enctype="multipart/form-data">
  <div class="row mt-2">
    <div class="col-md-3">
      <label for="name">
        Buscar por Nome:
      </label>
      <input
        type="text"
        name="name"
        id="name"
        class="form-control"
        value="<?php echo $_GET['name'];?>"
      >
      <span class="invalid-feedback">

      </span>
    </div>


    <div class="col-md-3">
      <label for="type">
        Buscar tipo:
      </label>
      <select 
        name="type" 
        id="type" 
        class="form-control"                                       
      >
        <option value="">Selecione o tipo</option>
        <option value="admin" <?php echo $_GET['type'] == 'admin' ? 'selected':'';?>>Administrador</option>
        <option value="sec" <?php echo $_GET['type'] == 'sec' ? 'selected':'';?>>Secretario</option>                                                                                                                   
        <option value="user" <?php echo $_GET['type'] == 'user' ? 'selected':'';?>>User</option> 
                
    </select>      
    </div>
  </div> 
  
  <div class="col-md-6 align-self-end mt-2" style="padding-left:5;">
           
      <input type="submit" class="btn btn-primary" value="Atualizar">                   
      <input type="button" class="btn btn-primary" value="Limpar" onClick="limpar()">       
                                                       
  </div>  

</form>
<!-- FORMULÁRIO -->

<table class="table table-striped">
    <thead>
            <tr class="text-center">      
            <th class="col-sm-4">Nome</th>
            <th class="col-sm-2">Email</th>
            <th class="col-sm-2">Tipo</th>
            <th class="col-sm-3">Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php if($data['results']) : ?>
            <?php foreach($data['results'] as $user) : ?>
                <tr class="text-center">
                    <td><?php echo $user['name'];?></td>
                    <td><?php echo $user['email'];?></td>
                    <td><?php  echo $user['type'];?></td>  

                    <td>       

                        <a 
                            href="<?php echo URLROOT; ?>/users/edit/<?php echo $user['id']; ?>" class="fa fa-edit btn btn-success pull-right btn-sm">Editar
                        </a>

                        <a 
                            href="<?php echo URLROOT; ?>/users/delete/<?php echo $user['id'];?>" 
                            class="fa fa-remove btn btn-danger pull-left btn-sm"
                        >                        
                            Remover
                        </a>

                    </td>                
                    
                </tr>
            <?php endforeach; ?> 
        <?php else : ?>  
        <tr>
            <td colspan="4" class="text-center">
                Nenhuma usuário encontrado
            </td>
        </tr>
        <?php endif; ?>
    </tbody>
</table>

<!-- PAGINAÇÃO -->
<?php
    $pagination = $data['pagination'];     
    // no index a parte da paginação é só essa    
    echo '<p>'.$pagination->links_html.'</p>';   
    echo '<p style="clear: left; padding-top: 10px;">Total de Registros: '.$pagination->total_results.'</p>';   
    echo '<p>Total de Paginas: '.$pagination->total_pages.'</p>';
    echo '<p style="clear: left; padding-top: 10px; padding-bottom: 10px;">-----------------------------------</p>';
?>

<?php require APPROOT . '/views/inc/footer.php'; ?>
<?php require APPROOT . '/views/inc/header.php'; ?>
 <div class="row align-items-center mb-3"> 
    <div class="col-md-10">
        <h1>Usuários do sistema</h1>
    </div>
    <div class="col-md-2">
        <a href="<?php echo URLROOT; ?>/users/new" class="btn btn-primary pull-right">
            <i class="fa fa-pencil"></i> Adicionar
        </a>
    </div>
 </div> 
 <?php flash('message');?>
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
        <?php foreach($data as $user) : ?>
            <tr class="text-center">
                <td><?php echo $user->name;?></td>
                <td><?php echo $user->email;?></td>
                <td><?php  echo $user->type;?></td>  

                <td>       

                    <a 
                        href="<?php echo URLROOT; ?>/users/edit/<?php echo $user->id; ?>" class="fa fa-edit btn btn-success pull-right btn-sm">Editar
                    </a>

                    <a 
                        href="<?php echo URLROOT; ?>/users/delete/<?php echo $user->id;?>" 
                        class="fa fa-remove btn btn-danger pull-left btn-sm"
                    >                        
                        Remover
                    </a>

                </td>                
                
            </tr>
        <?php endforeach; ?>   
    </tbody>
</table>
<?php require APPROOT . '/views/inc/footer.php'; ?>
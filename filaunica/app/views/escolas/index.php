<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="alert alert-secondary" role="alert">
  <?php echo isset($data['nav']) ? $data['nav'] : ''; ?>
</div> 

 <div class="row">
    <div class="col">
        <div class="text-end">
            <a href="<?php echo URLROOT; ?>/escolas/new" class="btn btn-primary pull-right">
                <i class="fa fa-pencil"></i> Adicionar
            </a>
        </div>
    </div>
</div>

<?php flash('message');?>

<table class="table table-striped">
    <thead>
        <tr class="text-center">      
            <th class="col-sm-3">Nome</th>
            <th class="col-sm-3">Logradouro</th>
            <th class="col-sm-1">Número</th>
            <th class="col-sm-2">Bairro</th>
            <th class="col-sm-1">Em Atividade</th>
            <th class="col-sm-2">Ações</th>
        </tr>
    </thead>
    <tbody>
    <?php if($data) : ?>
        <?php foreach($data['results'] as $escola) : ?>
            <tr class="text-center">
                <td><?php echo $escola['nome'];?></td>
                <td><?php echo $escola['logradouro'];?></td>
                <td><?php echo $escola['numero'];?></td>   
                <td><?php echo $escola['bairro'];?></td>  
                <td><?php echo $escola['emAtividade'];?></td>              
                <td>       

                    <a 
                        href="<?php echo URLROOT; ?>/escolas/edit/<?php echo $escola['id']; ?>" class="fa fa-edit btn btn-success pull-right btn-sm">Editar
                    </a>

                    <a 
                        href="<?php echo URLROOT; ?>/escolas/delete/<?php echo $escola['id'];?>" 
                        class="fa fa-remove btn btn-danger pull-left btn-sm"
                    >                        
                        Remover
                    </a>

                </td>
            </tr>
        <?php endforeach; ?>  
    <?php else: ?> 
        <tr>
            <td colspan="6" class="text-center">
                Nenhuma escola cadastrada
            </td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>
<?php require APPROOT . '/views/inc/footer.php'; ?>
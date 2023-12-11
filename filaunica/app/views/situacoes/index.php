<?php require APPROOT . '/views/inc/header.php'; ?>


<?php flash('message');?>

<div class="alert alert-light" role="alert">
  <?php echo isset($data['nav']) ? $data['nav'] : ''; ?>
</div>

 <div class="row">
    <div class="col">
        <div class="text-end">
            <a href="<?php echo URLROOT; ?>/situacoes/new" class="btn btn-primary pull-right">
                <i class="fa fa-pencil"></i> Adicionar
            </a>
        </div>
    </div>
</div>



<table class="table table-striped">
    <thead>
        <tr class="text-center">      
            <th class="col-sm-2">Descrição</th>
            <th class="col-sm-2">Permanece na fila</th>
            <th class="col-sm-2">Cor</th>
            <th class="col-sm-3">Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($data['results'] as $row) : ?>
            <tr class="text-center">
                <td><?php echo $row['descricao'];?></td>
                <td><?php echo $row['ativo'];?></td>
                <td style="background-color:<?php echo $row['cor'];?>;"></td>
                
                <?php if($row['descricao'] <> 'Arquivado') :?>
                <td>
                    <a 
                        href="<?php echo URLROOT; ?>/situacoes/edit/<?php echo $row['id']; ?>" class="fa fa-edit btn btn-success pull-right btn-sm">Editar
                    </a>
                
                    <a 
                        href="<?php echo URLROOT; ?>/situacoes/delete/<?php echo $row['id'];?>" 
                        class="fa fa-remove btn btn-danger pull-left btn-sm"
                    >                        
                        Remover
                    </a>
                </td>
                <?php else: ?>
                    <td>Ações não permitidas.</td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>   
    </tbody>
</table>
<?php require APPROOT . '/views/inc/footer.php'; ?>
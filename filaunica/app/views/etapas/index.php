<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="alert alert-secondary" role="alert">
  <?php echo isset($data['nav']) ? $data['nav'] : ''; ?>
</div>

 <div class="row">
    <div class="col">
        <div class="text-end">
            <a href="<?php echo URLROOT; ?>/etapas/new" class="btn btn-primary pull-right">
                <i class="fa fa-pencil"></i> Adicionar
            </a>
        </div>
    </div>
</div>

<?php flash('message');?>

<table class="table table-striped">
    <thead>
        <tr class="text-center">      
            <th class="col-sm-2">Descrição</th>
            <th class="col-sm-2">Data Inicial</th>
            <th class="col-sm-2">Data Final</th>
            <th class="col-sm-3">Ações</th>
        </tr>
    </thead>
    <tbody>
    <?php if($data['etapas']) : ?>
        <?php foreach($data['etapas'] as $etapa) : ?>
            <tr class="text-center">
                <td><?php echo $etapa->descricao;?></td>
                <td><?php echo date('d/m/Y', strtotime($etapa->data_ini));?></td>
                <td><?php echo date('d/m/Y', strtotime($etapa->data_fin));?></td>                  
                <td>       

                    <a 
                        href="<?php echo URLROOT; ?>/etapas/edit/<?php echo $etapa->id; ?>" class="fa fa-edit btn btn-success pull-right btn-sm">Editar
                    </a>

                    <a 
                        href="<?php echo URLROOT; ?>/etapas/delete/<?php echo $etapa->id;?>" 
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
                Nenhuma etapa cadastrada
            </td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>
<?php require APPROOT . '/views/inc/footer.php'; ?>
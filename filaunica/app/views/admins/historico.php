<?php require APPROOT . '/views/inc/header.php'; ?>


<div class="alert alert-secondary" role="alert">
  <?php echo isset($data['nav']) ? $data['nav'] : ''; ?>
</div> 


<a href="<?php echo URLROOT; ?>/admins" class="btn btn-light mt-3" style="margin:2em 0;"><i class="fa fa-backward"></i> Voltar para o início</a>

<br>

<table class="table table-striped">
  <thead>
    <tr>      
      <th scope="col">Registro</th>
      <th scope="col">Usuário</th>
      <th scope="col">Status</th>
      <th scope="col">Histórico</th>
    </tr>
  </thead>
  <tbody>
    
    <?php foreach ($data['results'] as $registro): ?>
        <tr>      
            <td><?php echo $registro['registro']; ?></td>
            <td><?php echo $registro['usuario']; ?></td>
            <td><?php echo $this->situacaoModel->getDescricaoSituacaoById($registro['situacao_id']); ?></td>
            <td><?php echo $registro['historico']; ?></td>
        </tr>
    <?php endforeach; ?> 
    
    
  </tbody>
</table>
<?php require APPROOT . '/views/inc/footer.php'; ?>
<?php require 'header.php'; ?>

<div class="card text-center">
  <div class="card-header">
    Consulta do protocolo número: <b><?php echo $data->protocolo; ?></b>
  </div>
  <div class="card-body">
    <h5 class="card-title">Posição na fila de espera: <b><?php echo $data->posicao; ?></h5>
    <p class="card-text">Protocolo registrado em: <?php echo date('d/m/Y H:i:s', strtotime($data->registro));?></p>
    <p class="card-text">Responsável pelo cadastro:<b> <?php echo $data->responsavel; ?></b></p>
    <p class="card-text">Iniciais do nome da criança:<b> <?php echo iniciais($data->nome); ?></b></p>
    <p class="card-text">Data de nascimento da criança:<b> <?php echo date('d/m/Y', strtotime($data->nascimento)); ?></b>
    <p class="card-text">Etapa: <?php echo $data->etapa;?></p>
    <a href="<?php echo URLROOT; ?>" class="btn btn-primary">Voltar</a>
  </div>
  <div class="card-footer text-muted">
    <p class="card-text">Status atual:<b> <?php echo $data->status; ?></b>
  </div>
</div>

<?php require 'footer.php'; ?>

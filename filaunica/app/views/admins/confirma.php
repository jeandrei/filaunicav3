<?php require APPROOT . '/views/inc/header.php';?>


<?php           $erro = false;
                $titulo = 'Deseja remover uma vaga do quadro de vagas?';
                $msg = 'Você deseja atualizar o quadro de vagas da escola <strong>';
                switch ($data['turno_matricula']) {
                    case 1:
                        if(isset($data['vagas']->matutino) && $data['vagas']->matutino>0){
                            $msg.= $data['unidade_matricula'].'</strong>, etapa <strong>'.$data['etapa'].'</strong> e turno <strong>'.'MATUTINO</strong> para '.($data['vagas']->matutino-1) . ' vagas?';
                        } else {
                            $erro = true;
                            $titulo = 'Ops!';
                            $msg = 'A escola <strong>'.$data['unidade_matricula'].'</strong> não possui vagas disponíveis na etapa <strong>'.$data['etapa'].'</strong> e turno <strong>MATUTINO.</strong><br>A matrícula foi realizada, apesar de não ter vaga disponível para a criança.';
                        }
                        break;
                    case 2:
                        if(isset($data['vagas']->vespertino) && $data['vagas']->vespertino>0){
                            $msg.= $data['unidade_matricula'].'</strong>, etapa <strong>'.$data['etapa'].'</strong> e turno <strong>'.'VESPERTINO</strong> para '.($data['vagas']->vespertino-1) . ' vagas?';
                        } else {
                            $erro = true;
                            $titulo = 'Ops!';
                            $msg = 'A escola <strong>'.$data['unidade_matricula'].'</strong> não possui vagas disponíveis na etapa <strong>'.$data['etapa'].'</strong> e turno <strong>VESPERTINO.</strong><br>A matrícula foi realizada, apesar de não ter vaga disponível para a criança.';
                        }
                        break;
                    case 3:
                        if(isset($data['vagas']->integral) && $data['vagas']->integral>0){
                            $msg.= $data['unidade_matricula'].'</strong>, etapa <strong>'.$data['etapa'].'</strong> e turno <strong>'.'INTEGRAL</strong> para '.($data['vagas']->integral-1) . ' vagas?';
                        } else {
                            $erro = true;
                            $titulo = 'Ops!';
                            $msg = 'A escola <strong>'.$data['unidade_matricula'].'</strong> não possui vagas disponíveis na etapa <strong>'.$data['etapa'].'</strong> e turno <strong>INTEGRAL.</strong><br>A matrícula foi realizada, apesar de não ter vaga disponível para a criança.';
                        }
                        break;
                }
            
            ?>

<main>
  
    <h2 class="mt-2"><?php echo $titulo;?></h2>

    <form action="<?php echo URLROOT; ?>/admins/edit/<?php echo $data['id']; ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" id="escola_id" name="escola_id" value="<?php echo $data['escola_id'];?>" />
        <input type="hidden" id="turno_matricula" name="turno_matricula" value="<?php echo $data['turno_matricula'];?>" />
        <div class="form-group">
            <p><?php echo $msg;?></p>             
        </div>  
        
        <?php if($erro == false) : ?>
        <div class="form-group mt-3">
        
            <a class="btn btn-success" href="<?php echo URLROOT ?>/pages/sistem">
            Cancelar
            </a>
        
            <button type="submit" name="botao" id="botao" value="atualizavaga" class="btn btn-danger">Atualizar</button>
        </div>
        <?php else: ?>
            <a href="<?php echo URLROOT; ?>/admins/edit/<?php echo $data['id']; ?>" class="btn btn-light mt-3"><i class="fa fa-backward"></i>Voltar</a>
        <?php endif;?>

    </form>

</main>
<?php require APPROOT . '/views/inc/footer.php'; ?>
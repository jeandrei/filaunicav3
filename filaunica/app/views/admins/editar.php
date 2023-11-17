
<?php require APPROOT . '/views/inc/header.php';?>
<!--ícones https://fontawesome.com/v4/icons/ -->

<?php flash('message');?>

<style>
 body {
    background-color:#F2F3F4;
 }  
 
</style>


<script>

$(document).ready(function(){

    // quando carrega o documento
    situacao = $("#situacao").val();
    if(situacao == 2 || situacao == 5){
        $( "#div_escola_mat" ).removeClass("invisible");
        $( "#div_escola_mat" ).addClass("visible");    

        $( "#div_turno_matricula" ).removeClass("invisible");
        $( "#div_turno_matricula" ).addClass("visible");    
    } else {
        $( "#div_escola_mat" ).removeClass("visible");
        $( "#div_escola_mat" ).addClass("invisible"); 

        $( "#div_turno_matricula" ).removeClass("visible");
        $( "#div_turno_matricula" ).addClass("invisible");       
    }  

    
    if(situacao == 2){        
        $( "#botao" ).removeClass( "invisible");
        $( "#botao" ).addClass( "visible");
    } else {        
        $( "#botao" ).removeClass( "visible");
        $( "#botao" ).addClass( "invisible");
    }    

 
    // quando altera a situação
    $("#situacao").change(function(){
        situacao = $("#situacao").val();
            if(situacao == 2 || situacao == 5){
                $( "#div_escola_mat" ).removeClass("invisible");
                $( "#div_escola_mat" ).addClass("visible");

                $( "#div_turno_matricula" ).removeClass("invisible");
                $( "#div_turno_matricula" ).addClass("visible");
            } else {
                $( "#div_escola_mat" ).removeClass("visible");
                $( "#div_escola_mat" ).addClass("invisible");

                $( "#div_turno_matricula" ).removeClass("visible");
                $( "#div_turno_matricula" ).addClass("invisible");
            }   
    });



    




});


 //PARA ABRIR EM UMA NOVA ABA CRIO ESSA FUNÇÃO NEWTAB QUE É CHAMADA NO EVENTO ONCLICK DO BOTÃO IMPRIMIR
 function newtab(){
      document.getElementById('editprotocolo').setAttribute('target', '_blank');
    }

</script>

<!-- BOTÃO VOLTAR -->
<a href="<?php echo URLROOT; ?>/admins/index" class="btn btn-light mt-3"><i class="fa fa-backward"></i> Voltar</a>
<!-- BOTÃO VOLTAR -->

<!-- ROW LINHA EDITANDO PROTOCOLO-->
<div class="row row-cols-1 mt-3 gy-2 bg-dark text-white">
    <!-- COL -->
    <div class="col">
        <h3>Nome da criança: <?php echo $data['nomecrianca'];?></h3> 
    </div>
    <!-- COL -->
</div>
<!-- ROW LINHA EDITANDO PROTOCOLO-->


<!-- class="container -->
<div class="container two-col-example">   
    <!-- row -->
    <div class="row">

        <!-- BLOCOS LADO ESQUERDO -->
        <!-- class="col-lg-6 -->
        <div class="col-lg-4 col-xs-12 mt-2">
            <!-- aqui pode ter um h2 -->
            <!-- class="card-deck -->
            <div class="card-deck mb-1 text-center">

            <!-- PROTOCOLO -->
            <div class="card mb-2 box-shadow">
                    <!--  class="card-body -->
                    <div class="card-body">
                        <i class="fa fa-list-alt fa-2x"></i>
                        <h4 class="card-title pricing-card-title">Protocolo</h4>
                        <p class="mt-1 mb-1">Nº: <?php echo $data['protocolo'];?>
                        </p> 
                        <p class="mt-1 mb-1">Registrado em: <?php echo $data['registro'];?>
                        </p>  
                        <p class="mt-1 mb-1">Situação:<b> <?php echo $data['situacao'];?></b>
                        </p>  
                    </div>
                    <!--  class="card-body -->
                </div>
                <!-- PROTOCOLO -->
                
                <!-- NASCIMENTO -->
                <div class="card mb-2 box-shadow">
                    <!--  class="card-body -->
                    <div class="card-body">
                        <i class="fa fa-birthday-cake fa-2x"></i>
                        <h4 class="card-title pricing-card-title">Nascimento</h4>
                        <p class="mt-1 mb-1"><?php echo $data['nascimento'];?>
                        </p>
                        <p class="mt-1 mb-1">Idade: <?php echo CalculaIdade($data['nascimento']);?>
                        </p>
                    </div>
                    <!--  class="card-body -->
                </div>
                <!-- NASCIMENTO -->

                <!-- ETAPA -->
                <div class="card mb-2 box-shadow">
                    <!--  class="card-body -->
                    <div class="card-body">
                        <i class="fa fa-list-ol fa-2x"></i>
                        <h4 class="card-title pricing-card-title">Etapa</h4>
                        <p class="mt-1 mb-1"><?php echo $data['etapa'];?>
                        </p>                        
                    </div>
                    <!--  class="card-body -->
                </div>
                <!-- ETAPA -->

                <!-- TURNO -->
                <div class="card mb-2 box-shadow">
                    <!--  class="card-body -->
                    <div class="card-body">
                        <i class="fa fa-clock fa-2x"></i>
                        <h4 class="card-title pricing-card-title">Turno Desejado</h4>
                        <p class="mt-1 mb-1"><?php echo $data['opcao_turno'];?>
                        </p>                        
                    </div>
                    <!--  class="card-body -->
                </div>
                <!-- TURNO -->

                <!-- ESPECIAL -->
                <div class="card mb-2 box-shadow">
                    <!--  class="card-body -->
                    <div class="card-body">
                        <i class="fa fa-wheelchair fa-2x"></i>
                        <h4 class="card-title pricing-card-title">Espceial</h4>
                        <p class="mt-1 mb-1"><?php echo $data['deficiencia'];?>
                        </p>                        
                    </div>
                    <!--  class="card-body -->
                </div>
                <!-- ESPECIAL -->


            </div>
            <!-- class="card-deck -->
        </div>
        <!-- class="col-lg-6 -->
        <!-- BLOCOS LADO ESQUERDO -->

        <!-- BLOCOS LADO DIREITO -->
        <div class="col-lg-8 col-xs-12 mt-2">
            <h2>Informações do cadastro</h2>
            
            <!-- RESPONSAVEL -->
            <div class="list-group">
                <div class="list-group-item flex-column align-items-start list-com-announcements">
                <!-- <div class="d-flex w-100 -->
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">Responsável</h5>
                </div>
                <!-- <div class="d-flex w-100 -->
                <p class="mb-1"><b>Nome:</b> <?php echo $data['responsavel'];?></p>
                <p class="mb-1"><b>CPF:</b> <?php echo $data['cpfresponsavel'];?></p>
                </div>
            </div>
            <!-- RESPONSAVEL -->

            <!-- RESPONSAVEL -->
            <div class="list-group mt-2">
                <div class="list-group-item flex-column align-items-start list-com-announcements">
                <!-- <div class="d-flex w-100 -->
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">Endereço</h5>
                </div>
                <!-- <div class="d-flex w-100 -->
                <p class="mb-1"><b>Logradouro:</b> <?php echo $data['logradouro'];?></p>
                <p class="mb-1"><b>Número:</b> <?php echo $data['numero'];?></p>
                <p class="mb-1"><b>Bairro:</b> <?php echo $data['bairro'];?></p>
                <p class="mb-1"><b>Complemento:</b> <?php echo $data['complemento'];?></p>
                </div>
            </div>
            <!-- RESPONSAVEL -->

             <!-- CONTATO -->
             <div class="list-group mt-2">
                <div class="list-group-item flex-column align-items-start list-com-announcements">
                <!-- <div class="d-flex w-100 -->
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">Contato</h5>
                </div>
                <!-- <div class="d-flex w-100 -->
                <p class="mb-1"><b>E-mail:</b> <?php echo $data['email'];?></p>
                <p class="mb-1"><b>Telefone:</b> <?php echo $data['telefone'];?></p>
                <p class="mb-1"><b>Celular:</b> <?php echo $data['celular'];?></p>
                </div>
            </div>
            <!-- CONTATO -->

            <!-- OPÇÕES DE MATRÍCULA -->
            <div class="list-group mt-2">
                <div class="list-group-item flex-column align-items-start list-com-announcements">
                <!-- <div class="d-flex w-100 -->
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">Opções de matrícula</h5>
                </div>
                <!-- <div class="d-flex w-100 -->
                <?php if($data['opcao1_id']) : ?>
                    <p class="mb-1"><b>Opção 01:</b> <?php echo $data['opcao1_id'];?></p><p>Vagas: 
                        Mat.(<?php echo ($data['vagas_op1']->matutino)?$data['vagas_op1']->matutino:'NI';?>)
                        Mat.(<?php echo ($data['vagas_op1']->vespertino)?$data['vagas_op1']->vespertino:'NI';?>)
                        Mat.(<?php echo ($data['vagas_op1']->integral)?$data['vagas_op1']->integral:'NI';?>)
                    </p>
                <?php endif; ?>

                <?php if($data['opcao2_id']) : ?>
                    <p class="mb-1"><b>Opção 02:</b> <?php echo $data['opcao2_id'];?></p><p>Vagas: 
                        Mat.(<?php echo ($data['vagas_op2']->matutino)?$data['vagas_op2']->matutino:'NI';?>)
                        Mat.(<?php echo ($data['vagas_op2']->vespertino)?$data['vagas_op2']->vespertino:'NI';?>)
                        Mat.(<?php echo ($data['vagas_op2']->integral)?$data['vagas_op2']->integral:'NI';?>)
                    </p>
                <?php endif; ?>
                <?php if($data['opcao3_id']) : ?>
                    <p class="mb-1"><b>Opção 03:</b> <?php echo $data['opcao3_id'];?></p><p>Vagas: 
                        Mat.(<?php echo ($data['vagas_op3']->matutino)?$data['vagas_op3']->matutino:'NI';?>)
                        Mat.(<?php echo ($data['vagas_op3']->vespertino)?$data['vagas_op3']->vespertino:'NI';?>)
                        Mat.(<?php echo ($data['vagas_op3']->integral)?$data['vagas_op3']->integral:'NI';?>)
                    </p>
                <?php endif; ?>
                
                </div>
            </div>
            <!-- OPÇÕES DE MATRÍCULA -->

             <!-- OBSERVAÇÕES -->
             <div class="list-group mt-2">
                <div class="list-group-item flex-column align-items-start list-com-announcements">
                <!-- <div class="d-flex w-100 -->
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">Observações</h5>
                </div>
                <!-- <div class="d-flex w-100 -->
                <p class="mb-1"><?php echo $data['observacao'];?></p>
                </div>
            </div>
            <!-- OBSERVAÇÕES -->

        </div>        
        <!-- BLOCOS LADO DIREITO -->

    </div>
    <!-- row -->
    

    







<!-- BLOCO DE BAIXO -->
<!-- class="container -->
<div class="container">
    <!-- <div class="card-deck -->
    <div class="card-deck mb-3 text-center">
        <!-- <div class="card-deck -->
        <div class="card mb-4 box-shadow">
            <!-- <div class="card-body -->
            <div class="card-body">                
                <h4 class="card-title pricing-card-title">Editar</h4>
                <form id="editprotocolo" action="<?php echo URLROOT; ?>/admins/edit/<?php echo $data['id']; ?>" method="post"> 
                <!--linha 01 editar-->
                <div class="row">
                    <!-- COLUNA 1 SITUAÇÃO-->
                    <div class="form-group col-lg-3">
                        <label for="situacao">
                            Situação
                        </label>                        

                        <select 
                            name="situacao" 
                            id="situacao" 
                            class="form-control"                                       
                        >                               
                        <?php 
                        $situacoes = $this->situacaoModel->getSituacoes();
                        foreach($situacoes as $row) : ?> 
                            <option value="<?php echo $row->id; ?>"
                                <?php 
                                echo $data['situacao_id'] == $row->id ? 'selected':'';  
                                ?>
                            >
                                <?php echo $row->descricao;?>
                            </option>
                        <?php endforeach; ?>  
                        </select>    
                    </div>
                    <!-- COLUNA 1 SITUAÇÃO-->

                    <!-- COLUNA 2 ESCOLA-->
                    <div id="div_escola_mat" name="div_escola_mat" class="form-group col-lg-6 invisible">
                        <label for="escolamatricula">
                            Escola em que a criança foi matriculada
                        </label> 
                        <select 
                            name="escolamatricula" 
                            id="escolamatricula" 
                            class="form-control" 
                        >                               
                            <?php 
                            $escolas = $this->filaModel->getEscolas();
                            foreach($escolas as $row) : ?> 
                                <option value="<?php echo $row->id; ?>"
                                    <?php 
                                    echo $data['opcao_matricula'] == $row->id ? 'selected':'';
                                    ?>
                                >
                                    <?php echo $row->nome;?>
                                </option>
                            <?php endforeach; ?>  
                        </select>    
                    </div>
                    <!-- COLUNA 2 ESCOLA-->

                    <!--COLUNA 3 TURNO MATRICULA-->                     
                    <div id="div_turno_matricula" class="form-group col-lg-3 invisible">
                        <label for="turno_matricula" class="help-block">
                            Turno da matrícula:
                        </label>
                        <select 
                            name="turno_matricula" 
                            id="turno_matricula" 
                            class="form-control <?php echo (!empty($data['turno_matricula_err'])) ? 'is-invalid' : ''; ?>"                                       
                        >
                            <option value="">Selecione o turno</option>
                            <option value="1" <?php echo $data['turno_matricula'] == '1' ? 'selected':'';?>>Matutino</option>
                            <option value="2" <?php echo $data['turno_matricula'] == '2' ? 'selected':'';?>>Vespertino</option>        
                        </select>                                           
                        <span class="invalid-feedback">
                                <?php echo $data['turno_matricula_err'];?>
                        </span>
                    </div>
                    <!--COLUNA 3 TURNO MATRICULA--> 
                </div>
                <!--linha 01 editar-->

                <!--linha 02 editar-->
                <div class="row">   
                    <div class="form-group col-lg-12">
                        <label for="historico">Histórico</label>
                        <textarea class="form-control rounded-0" name="historico" id="historico" rows="4"><?php echo ($data['historico']) ?  $data['historico'] : $_POST['historico'] ;?></textarea>
                    </div>
                </div>
                <!--linha 02 editar--> 

                <!-- 3ª LINHA PARA OS BOTÕES -->
                <div class="row" style="margin-top:30px;">
                    <div class="col-md-12 text-center">                        
                        <input type="submit" value="Gravar" class="btn btn-success">  
                        <a href="<?php echo URLROOT; ?>/admins/historico/<?php echo  $data['id'];?>" class="btn btn-warning"><i class="fa fa-list"></i> Histórico</a>                           
                        <input type="submit" name="botao" id="botao" class="btn btn-primary" value="Imprimir" onClick="newtab()">
                    </div> 
                </div>
                <!-- 3ª LINHA PARA OS BOTÕES -->

                </form>                
            </div>
            <!-- <div class="card-body -->
        </div>
        <!-- <div class="card-deck -->
    </div>
    <!-- <div class="card-deck -->
</div>
<!-- class="container -->


<?php require APPROOT . '/views/inc/footer.php';?>

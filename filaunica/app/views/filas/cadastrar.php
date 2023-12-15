<!-- HEADER DA PAGINA -->
<?php include 'header.php'; ?>

<?php flash('message');?>

<!-- COLOCO UM BACKGROUND CINZA E CRIAMOS UM CONTAINDER COM MARGEN SUPERIOR DE 90PX -->
<body style="background-color:#DCDCDC">
    <div class="container" style="margin-top: 90px;"> 
    
    <?php if($data['cadastroDuplicado']) : ?>
        <div class="alert alert-warning" role="alert">
        Ops! Já existe um cadastro com esse nome e data de nascimento! Deseja confirmar?
        </div>
    <?php endif; ?>

    
    <?php 
    //==================FLASH MENSAGEM DE ERRO============================
    echo flash('fila-erro'); 
    ?> 


    <!--================PARTE ACIMA IMAGEM GRUPO E BARRA AZUL================-->
    <div class="row">
        <div class="col-lg-12">
            <blockquote style="border-left: 10px solid #0D54AA; margin: 1.5em 10px;padding: 0.5em 10px;">            
                <img style="width:30px; height:30px;margin:15px 10px 10px 0px;" src="<?php echo URLROOT; ?>/img/people-group-team.png">
                <span style="font-size:25px;">Fila Única</span>
            </blockquote>
        </div>    
    </div>



    <!--================BOTÃO VOLTAR=========================================-->
    <div class="row" style="margin-bottom: 10px;">
        <div class="col-lg-2">
            <a href="<?php echo URLROOT; ?>/index" id="voltar" class="btn btn-default btn-block" style="background-color:#FFFAF0">
                <i class="fa fa-chevron-left" aria-hidden="true"></i> Voltar
            </a>
            
        </div>
    </div>



    
       
    
    <!-- ===================FORMULÁRIO DE CADASTRO========================== -->   
    <div class="container mt-3" style="background-color:#FFFAF0">
    <form id="cadastrar_t" action="<?php echo URLROOT; ?>/filas/cadastrar" method="post" enctype="multipart/form-data">
        
        
          
            <?php
            $rand=rand();
            $_SESSION['rand']=$rand;
            ?>
            <input type="hidden" value="<?php echo $rand; ?>" name="randcheck" />
            

    
    
        <!-- ===============LINHA PARA TODO O CONTEÚDO============== -->
        <div class="row">
            
            <!-- ===============BLOCO DA ESQUERDA=================== -->
            <div class="col-sm-6">
                <!-- ==============GRUPO VERDE ======================-->
                <blockquote style="border-left: 10px solid #008a00; margin: 1.5em 10px;padding: 0.5em 10px;">
                    <fieldset>
                        <legend>Dados do Responsável</legend>
                        
                        <!--NOME DO RESPONSÁVEL-->
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="responsavel">
                                    <span class="obrigatorio">*</span>Nome completo
                                </label>
                                <input 
                                    type="text" 
                                    name="responsavel" 
                                    id="responsavel"
                                    class="form-control <?php echo (!empty($data['responsavel_err'])) ? 'is-invalid' : ''; ?>" 
                                    value="<?php htmlout($data['responsavel']); ?>"
                                    onkeydown="upperCaseF(this)"                                            
                                >
                                    <span class="text-danger">
                                        <?php echo $data['responsavel_err']; ?>
                                    </span>
                            </div>                            
                        </div>
                        <!--NOME DO RESPONSÁVEL-->

                        <!--CPF E EMAIL-->
                        <div class="form-row">
                            <!-- CPF -->
                            <div class="form-group col-md-4">
                                <label for="cpf">
                                    <span class="obrigatorio">*</span>CPF
                                </label>
                                <input 
                                    type="text" 
                                    name="cpf" 
                                    id="cpf" 
                                    class="form-control cpf <?php echo (!empty($data['cpf_err'])) ? 'is-invalid' : ''; ?>" 
                                    value="<?php htmlout($data['cpf']); ?>"
                                    maxlength="14"
                                >
                                    <span class="text-danger">
                                        <?php echo $data['cpf_err']; ?>
                                    </span>
                            </div>
                            <!-- CPF -->

                            <!-- EMAIL -->
                            <div class="form-group col-md-8">
                                <label for="email">
                                    E-mail
                                </label>
                                <input 
                                    type="text" 
                                    name="email" 
                                    id="email" 
                                    class="form-control email <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>"
                                    value="<?php htmlout($data['email']); ?>"
                                >
                                <span class="text-danger">
                                    <?php echo $data['email_err']; ?>
                                </span>
                            </div>
                            <!-- EMAIL -->
                        </div>
                        <!--FECHA CPF E EMAIL-->                      

                        <!--CELULAR E TELEFONE FIXO-->
                        <div class="form-row">  
                            
                            <!-- CELULAR 1 -->
                            <div class="form-group col-md-6">
                                <label for="celular">
                                    Celular
                                </label>
                                <input 
                                    type="text" 
                                    name="celular" 
                                    id="celular" 
                                    maxlength="15"
                                    class="form-control celular validacelular <?php echo (!empty($data['celular_err'])) ? 'is-invalid' : ''; ?>"
                                    value="<?php htmlout($data['celular']); ?>"
                                >
                                <span class="text-danger">
                                    <?php echo $data['celular_err']; ?>
                                </span>
                            </div>
                            <!-- CELULAR -->

                            <!-- CELULAR 2 -->
                            <div class="form-group col-md-6">
                                <label for="telefone">
                                    Celular 2
                                </label>
                                <input 
                                    type="text" 
                                    name="telefone" 
                                    id="telefone" 
                                    maxlength="15"
                                    class="form-control celular validacelular<?php echo (!empty($data['telefone_err'])) ? 'is-invalid' : ''; ?>"
                                    value="<?php htmlout($data['telefone']); ?>"
                                >
                                <span class="text-danger">
                                    <?php echo $data['telefone_err']; ?>
                                </span>
                            </div>
                            <!-- TELEFONE FIXO -->

                        </div>
                        <!--FECHA CELULAR E TELEFONE FIXO-->

                        <!--BAIRRO E RUA-->
                        <div class="form-row">
                            
                            <!-- BAIRRO -->
                            <div class="form-group col-md-5">
                                <label for="bairro">
                                    <span class="obrigatorio">*</span>Bairro
                                </label>
                                <select 
                                    name="bairro" 
                                    id="bairro" 
                                    class="form-control <?php echo (!empty($data['bairro_err'])) ? 'is-invalid' : ''; ?>"
                                    >  
                                    <option value="">Selecione o Bairro</option>
                                        <?php                                                    
                                        foreach($data['bairros'] as $bairro) : ?> 
                                            <option value="<?php echo $bairro->id; ?>"
                                                        <?php echo $data['bairro'] == $bairro->id ? 'selected':'';?>                                                                                                                                   
                                            >
                                                <?php echo $bairro->nome;?>
                                            </option>
                                        <?php endforeach; ?>  
                                </select>
                                <span class="text-danger">
                                    <?php echo $data['bairro_err']; ?>
                                </span>
                            </div>
                            <!-- BAIRRO -->

                             <!-- RUA -->
                             <div class="form-group col-md-7">
                                <label for="rua">
                                    <span class="obrigatorio">*</span>Rua
                                </label>
                                <input 
                                    type="text" 
                                    name="rua" 
                                    id="rua"
                                    class="form-control <?php echo (!empty($data['rua_err'])) ? 'is-invalid' : ''; ?>"
                                    value="<?php htmlout($data['rua']); ?>"
                                    onkeydown="upperCaseF(this)" 
                                >
                                <span class="text-danger">
                                    <?php echo $data['rua_err']; ?>
                                </span>
                            </div>
                            <!-- RUA -->
                            
                        </div> 
                        <!--BAIRRO E RUA-->

                        
                        <!--NUMERO E COMPLEMENTO-->
                        <div class="form-row">
                            
                            <!-- NUMERO -->
                            <div class="form-group col-md-4">
                                <label for="numero">
                                    Número
                                </label>
                                <input 
                                    type="number" 
                                    name="numero" 
                                    id="numero" 
                                    class="form-control onlynumbers <?php echo (!empty($data['numero_err'])) ? 'is-invalid' : ''; ?>"                                                                                                                
                                    value="<?php htmlout($data['numero']); ?>"
                                >
                                <span class="text-danger">
                                    <?php echo $data['numero_err']; ?>
                                </span>
                            </div>
                            <!-- NUMERO -->

                             <!-- COMPEMENTO -->
                            <div class="form-group col-md-8">
                                <label for="complemento">
                                    Complemento
                                </label>
                                <input 
                                    type="text" 
                                    name="complemento" 
                                    id="complemento" 
                                    class="form-control"
                                    value="<?php htmlout($data['complemento']); ?>"
                                    onkeydown="upperCaseF(this)" 
                                >
                            </div>
                            <!-- COMPEMENTO -->
                        </div>
                        <!--NUMERO E COMPLEMENTO-->

                    </fieldset>
                </blockquote>
                <!-- ==============FECHA GRUPO VERDE ================-->

                <!-- ====================GRUPO AMARELO ================-->
                <blockquote style="border-left: 10px solid #F4C20B; margin: 1.5em 10px;padding: 0.5em 10px;">
                    <fieldset>
                        <legend>Dados da Criança</legend>
                        
                        <!-- LINHA NOME DA CRIANÇA -->
                        <div class="form-row">
                            
                        <!-- NOME DA CRIANÇA -->
                            <div class="form-group col-md-12">
                                <label for="nome">
                                    <span class="obrigatorio">*</span>Nome completo
                                </label>
                                <input 
                                    type="text" 
                                    name="nome" 
                                    id="nome" 
                                    class="form-control <?php echo (!empty($data['nome_err'])) ? 'is-invalid' : ''; ?>"
                                    value="<?php htmlout($data['nome']); ?>"
                                    onkeydown="upperCaseF(this)" 
                                >
                                <span class="text-danger">
                                    <?php echo $data['nome_err']; ?>
                                </span>
                            </div>
                            <!-- NOME DA CRIANÇA -->  

                        </div>
                        <!-- LINHA NOME DA CRIANÇA -->

                        <!-- NASCIMENTO E CERTIDÃO -->
                        <div class="form-row">
                            
                            <!-- NASCIMENTO -->
                            <div class="form-group col-md-5">
                                <label for="nascimento">
                                    <span class="obrigatorio">*</span>Data de nascimento
                                </label>
                                <input 
                                    type="date" 
                                    name="nascimento" 
                                    id="nascimento"
                                    class="form-control <?php echo (!empty($data['nascimento_err'])) ? 'is-invalid' : ''; ?>"
                                    value="<?php htmlout($data['nascimento']); ?>"
                                    maxlength="10"
                                >
                                <span class="text-danger">
                                    <?php echo $data['nascimento_err']; ?>
                                </span>
                            </div>
                            <!-- NASCIMENTO -->

                            <!-- CERTIDÃO -->
                            <div class="form-group col-md-7">
                                <label for="certidao">
                                    Certidão de nascimento
                                </label>
                                <input 
                                    type="text" 
                                    name="certidao" 
                                    id="certidao" 
                                    class="form-control <?php echo (!empty($data['certidao_err'])) ? 'is-invalid' : ''; ?>"
                                    value="<?php htmlout($data['certidao']); ?>"
                                >
                                <span class="text-danger">
                                    <?php echo $data['certidao_err']; ?>
                                </span>
                            </div>
                            <!-- CERTIDÃO -->

                        </div>
                        <!-- NASCIMENTO E CERTIDÃO -->

                         <!-- LINHA DEFICIÊNCIA -->
                         <div class="form-row">
                            
                            <!-- DEFICIÊNCIA -->
                            <div class="form-group col-md-12">
                            <div class="alert alert-warning" role="alert">
                                <div class="checkbox checkbox-primary checkbox-inline">
                                <input id="portador" type="checkbox" name="portador" value="1" >
                                <label for="portador">
                                    <strong>Criança com necessidades especiais?</strong>
                                </label>
                            </div>
                            <!-- DEFICIÊNCIA -->                           

                        </div>
                        <!-- LINHA DEFICIÊNCIA -->

                    </fieldset>
                </blockquote>
                <!-- ==============FECHA GRUPO AMARELO ================-->

            </div>
            <!-- ===============FECHA BLOCO DA ESQUERDA============== -->
            



            <!-- ===============BLOCO DA DIREITA=================== -->
            <div class="col-sm-6">
                <!--=================GRUPO AZUL======================-->
                <blockquote style="border-left: 10px solid #0c85d0; margin: 1.5em 10px;padding: 0.5em 10px;">   
                    
                    <!--INFORMATIVO DE OPÇÕES DE ESCOLHA-->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="alert alert-info" role="alert">
                            <p>Quando chegar a vez da criança, a equipe da Secretaria da Educação entrará em contato para oferecer a vaga independente das opções escolhidas.</p>
                                <p>Selecione abaixo ao menos a <strong>primeira</strong> opção.</p>
                            </div>
                        </div>                    
                    </div>
                    <!--INFORMATIVO DE OPÇÕES DE ESCOLHA-->

                    <fieldset>
                        <legend>Opções de matrícula</legend>

                         <!-- PRIMEIRA OPÇÃO -->
                         <div class="form-row">    
                            <div class="form-group col-md-12">
                                <label for="opcao1" class="help-block">
                                    <span class="obrigatorio">*</span><strong>Primeira Opção</strong>
                                </label>
                                <select 
                                    name="opcao1" 
                                    id="opcao1" 
                                    class="form-control <?php echo (!empty($data['opcao1_err'])) ? 'is-invalid' : ''; ?>"                                       
                                >
                                <option value="null">Selecione a Escola</option>
                                    <?php                                                    
                                    foreach($data['escolas'] as $escola) : ?> 
                                        <option value="<?php echo $escola->id; ?>"
                                                    <?php echo $data['opcao1'] == $escola->id ? 'selected':'';?>                                                                                                                                   
                                        >
                                            <?php echo $escola->nome;?>
                                        </option>
                                    <?php endforeach; ?>  
                                </select>                                           
                                <span class="text-danger">
                                        <?php echo $data['opcao1_err']; ?>
                                </span>
                            </div>
                        </div>
                        <!-- PRIMEIRA OPÇÃO -->

                        <!-- SEGUNDA OPÇÃO -->
                        <div class="form-row">    
                            <div class="form-group col-md-12">
                                <label for="opcao2" class="help-block">
                                    Segunda Opção
                                </label>
                                <select 
                                    name="opcao2" 
                                    id="opcao2" 
                                    class="form-control"                                        
                                >
                                <option value="null">Selecione a Escola</option>
                                    <?php                                                    
                                    foreach($data['escolas'] as $escola) : ?> 
                                        <option value="<?php echo $escola->id; ?>"
                                                    <?php echo $data['opcao2'] == $escola->id ? 'selected':'';?>                                                                                                                                   
                                        >
                                            <?php echo $escola->nome;?>
                                        </option>
                                    <?php endforeach; ?>    
                                </select>                                           
                                <span class="text-danger">
                                        <?php echo $data['opcao2_err']; ?>
                                </span>
                            </div>
                        </div>
                        <!-- SEGUNDA OPÇÃO -->

                        <!-- TERCEIRA OPÇÃO -->
                        <div class="form-row">    
                            <div class="form-group col-md-12">
                                <label for="opcao3" class="help-block">
                                    Terceira Opção
                                </label>
                                <select 
                                    name="opcao3" 
                                    id="opcao3" 
                                    class="form-control"                                        
                                >
                                <option value="null">Selecione a Escola</option>
                                    <?php                                                    
                                    foreach($data['escolas'] as $escola) : ?> 
                                        <option value="<?php echo $escola->id; ?>"
                                                    <?php echo $data['opcao3'] == $escola->id ? 'selected':'';?>                                                                                                                                   
                                        >
                                            <?php echo $escola->nome;?>
                                        </option>
                                    <?php endforeach; ?>    
                                </select>                                           
                                <span class="text-danger">
                                        <?php echo $data['opcao2_err']; ?>
                                </span>
                            </div>
                        </div>
                        <!-- TERCEIRA OPÇÃO -->
                        

                        <!-- TURNO DESEJADO -->
                        <div class="alert alert-info" role="alert">
                            <p>Para o turno <strong>INTEGRAL</strong> o processo de inscrição é realizado somente na <strong>Secretaria de Educação.</strong></p>
                        </div>
                        <div class="form-row">    
                            <div class="form-group col-md-12">
                                <label for="opcao_turno" class="help-block">
                                    <span class="obrigatorio">*</span>Turno Desejado
                                </label>
                                <select 
                                    name="opcao_turno" 
                                    id="opcao_turno" 
                                    class="form-control <?php echo (!empty($data['opcao_turno_err'])) ? 'is-invalid' : ''; ?>"                                       
                                >
                                    <option value="null">Selecione o turno desejado</option>
                                    <option value="1" <?php echo $data['opcao_turno'] == '1' ? 'selected':'';?>>Matutino</option>
                                    <option value="2" <?php echo $data['opcao_turno'] == '2' ? 'selected':'';?>>Vespertino</option> 
                                    <option value="3" <?php echo $data['opcao_turno'] == '3' ? 'selected':'';?>>Integral</option>                                        
                                            
                                </select>                                           
                                <span class="text-danger">
                                        <?php echo $data['opcao_turno_err'];?>
                                </span>
                            </div>
                        </div>
                        <!-- TURNO DESEJADO -->


                         <!-- OBSERVAÇÃO -->
                         <div class="form-row">    
                            <div class="form-group col-md-12">
                                <label for="obs">
                                    Observação
                                </label>
                                <textarea 
                                    class="form-control" 
                                    id="obs"  
                                    name="obs"                                                                          
                                ><?php if(!empty($_POST['obs'])){
                                        htmlout($data['obs']);
                                    }?></textarea>
                            </div>
                        </div>
                         <!-- OBSERVAÇÃO -->                         
                        

                    </fieldset>
                </blockquote>
                <!--=================FECHA GRUPO AZUL================--> 
            </div>
            <!-- ===============FECHA BLOCO DA DIREITA=================== -->
                    
        </div>
        <!-- ===============FECHA LINHA PARA TODO O CONTEÚDO============= -->
         

        <?php if($data['cadastroDuplicado']) : ?>
            <!--BOTÃO ENVIAR DADOS-->
        <div class="row mb-2">            
            <button 
                class="btn btn-success btn-block btn-lg" 
                name="btn_enviar"  
                type="submit"
                value="confirmaDuplicado">
                Confirmar cadastro duplicado
            </button>
        </div>
        <!--BOTÃO ENVIAR DADOS-->
        <?php else: ?>
        
        <!--BOTÃO ENVIAR DADOS-->
        <div class="row mb-2">            
            <button 
                class="btn btn-success btn-block btn-lg" 
                name="btn_enviar"  
                type="submit"
                value="confirma">
                Enviar dados
            </button>
        </div>
        <!--BOTÃO ENVIAR DADOS-->
        <? endif ?>

    </form>
    </div>
    <!-- ===================FORMULÁRIO DE CADASTRO========================== -->






<?php include 'footer.php'; ?> 

<script>

 $(document).ready(function(){
    $('#cadastrar').validate({
        rules : {			
            responsavel : {
                required : true,
                minlength : 6
            },                 
            bairro : {
                required : true                    
            },     
            rua : {
                required : true                    
            },
            nome : {
                required : true                    
            },         
            nascimento : {
                required : true                    
            },     
            opcao1 : {
                required : true                    
            },     
            opcao_turno : {
                required : true                    
            },
            cpf : {
                required : true
            }                
        },

        messages : {			
            responsavel : {
                required : 'Por favor informe o responsável.',
                minlength : 'Nome inválido, mínimo 6 Caracteres'
            },                
            bairro : {
                required : 'Por favor informe o bairro'                 
            },     
            rua : {
                required : 'Por favor informe a rua'                    
            },
            nome : {
                required : 'Por favor informe o nome da criança'                       
            },       
            nascimento : {
                required : 'Por favor informe o nascimento'                  
            },     
            opcao1 : {
                required : 'Por favor informe ao menos uma opção de escola'                    
            },     
            opcao_turno : {
                required : 'Por favor informe o turno desejado'                    
            },
            cpf : {
                required : 'CPF Inválido'
            }                            
        }
    });
});
</script> 

<?php //die(var_dump($data['results'][0]['vagas_op1']));?>
<style>

* {
  box-sizing: border-box;
}

body {
  font-family: 'Muli', sans-serif;
  background-color: #f0f0f0;
}

h1 {
  margin: 50px 0 30px;
  text-align: center;
}

.faq-container {
  max-width: auto;
  margin: 10 10;
}

.faq {
  background-color: transparent;
  border: 1px solid #9fa4a8;
  border-radius: 10px;
  margin: 5px 0;
  padding: 30px;
  position: relative;
  overflow: hidden;
  transition: 0.3s ease;
}

.faq.active {
  background-color: #fff;
  box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1), 0 3px 6px rgba(0, 0, 0, 0.1);
}


.faq-title {
  margin: 0 35px 0 0;
}

.faq-text {
  display: none;
  margin: 30px 0 0;
}

.faq.active .faq-text {
  display: block;
}


.faq-toggle {
  background-color: transparent;
  border: 0;
  border-radius: 50%;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 16px;
  padding: 0;
  position: absolute;
  top: 30px;
  right: 30px;
  height: 30px;
  width: 30px;
}

.faq-toggle:focus {
  outline: 0;
}

.faq-toggle .fa-times {
  display: none;
}

.faq.active .faq-toggle .fa-times {
  color: #fff;
  display: block;
}

.faq.active .faq-toggle .fa-chevron-down {
  display: none;
}

.faq.active .faq-toggle {
  background-color: #9fa4a8;
}



.historico{    
    display: none;
    clear: both;
}

.historico.active {
    display: block;      
}

   
</style>
<?php require APPROOT . '/views/inc/header.php'; ?>

<?php  

//$situacoes = $this->situacaoModel->getSituacoes(); 
//die(var_dump($situacoes));
//var_dump($_GET);

?>


<!-- LINHA PARA A MENSÁGEM DO JQUERY -->
<div class="container">
    <?php flash('message');?>
</div>

<div class="alert alert-secondary" role="alert">
  <?php echo isset($data['nav']) ? $data['nav'] : ''; ?>
</div>



<!-- FORMULÁRIO COM OS CAMPOS DE PESQUISA -->
<form id="filtrar" action="<?php echo URLROOT; ?>/admins/index" method="GET" enctype="multipart/form-data">

    <!-- 1ª LINHA E COLUNAS PARA OS CAMPOS DE BUSCA -->
    <div class="row mb-2">
        
        <!-- COLUNA 1 PROTOCOLO-->
        <div class="col-md-2">
            <label for="protocolo">
                Buscar Protocolo
            </label>
            <input 
                type="number" 
                name="protocolo" 
                id="protocolo" 
                maxlength="60"
                class="form-control"
                value="<?php if(isset($_GET['protocolo'])){htmlout($_GET['protocolo']);} ?>"
                onkeydown="upperCaseF(this)"   
                ><span class="invalid-feedback">
                    <?php // echo $data['nome_err']; ?>
                </span>
        </div>
        
        
        <!-- COLUNA 2 NOME-->
        <div class="col-md-3">
            <label for="nome">
                Buscar por Nome
            </label>
            <input 
                type="text" 
                name="nome" 
                id="nome" 
                maxlength="60"
                class="form-control"
                value="<?php if(isset($_GET['nome'])){htmlout($_GET['nome']);} ?>"
                onkeydown="upperCaseF(this)"   
                ><span class="invalid-feedback">
                    <?php // echo $data['nome_err']; ?>
                </span>
        </div>


        <!-- COLUNA 3 ETAPA -->
        <div class="col-md-3">
            <label for="etapa_id">
                Busca por Etapa
            </label>                               
            <!-- 1 BOTÃO BUSCA POR ETAPA VAI JOGAR PARA controlers/Admins.php-->
            <select 
                name="etapa_id" 
                id="etapa_id" 
                class="form-control"                                        
            >
                    <option value="null">Todos</option>
                    <?php 
                    $etapas = $this->etapaModel->getEtapas();                     
                    foreach($etapas as $etapa) : ?> 
                        <option value="<?php echo $etapa['id']; ?>"
                                    <?php if(isset($_GET['etapa_id'])){
                                    echo $_GET['etapa_id'] == $etapa['id'] ? 'selected':'';
                                    }
                                    ?>
                        >
                            <?php echo $etapa['descricao'];?>
                        </option>
                    <?php endforeach; ?>  
            </select>
        </div>

        
        <!-- COLUNA 3 ESCOLA -->
        <div class="col-md-4">
            <label for="escola_id">
                Busca por Escola
            </label>                               
            <select 
                name="escola_id" 
                id="escola_id" 
                class="form-control"                                        
            >
                    <option value="null">Todos</option>
                    <?php 
                    $escolas = $this->filaModel->getEscolas();                    
                    foreach($escolas as $escola) : ?> 
                        <option value="<?php echo $escola->id; ?>"
                                    <?php if(isset($_GET['escola_id'])){
                                    echo $_GET['escola_id'] == $escola->id ? 'selected':'';
                                    }
                                    ?>
                        >
                            <?php echo $escola->nome;?>
                        </option>
                    <?php endforeach; ?>  
            </select>
        </div>
    
    <!-- FECHA A 1ª LINHA -->
    </div>


    <!-- 2ª LINHA E COLUNAS PARA OS CAMPOS DE BUSCA E BOTÕES-->
    <div class="row">
        
        <!-- COLUNA 1 SITUAÇÃO-->
        <div class="col-md-3">
            <label for="situacao_id">
                Busca por Status
            </label>             

            <select 
                name="situacao_id" 
                id="situacao_id" 
                class="form-control"                                        
            >
                    <option value="null">Todos</option>
                    <option value="FE" <?php echo $_GET['situacao_id'] == 'FE' ? 'selected':'';?>>Fora de Todas as Etapas</option>
                    <?php 
                    $situacoes = $this->situacaoModel->getSituacoes();                       
                    foreach($situacoes as $row) : ?> 
                        <option value="<?php echo $row->id; ?>"
                                    <?php if(isset($_GET['situacao_id'])){
                                    echo $_GET['situacao_id'] == $row->id ? 'selected':'';
                                    }
                                    ?>
                        >
                            <?php echo $row->descricao;?>
                        </option>
                    <?php endforeach; ?>  
            </select>    
        </div>

        <div class="col-md-6 align-self-end mt-2" style="padding-left:5;">
           
                <input type="submit" class="btn btn-primary" value="Atualizar" onClick="salfTab()">                   
                <input type="button" class="btn btn-primary" value="Limpar" onClick="limpar()"> 
                <input type="submit" name="botao" class="btn btn-primary" value="Imprimir" onClick="newtab()">
                                                      
        </div>
                                    
                                    
    <!-- FECHA A 2ª LINHA -->
    </div>  

</form>

</div><!--fecha div container lá do header-->
<?


// Arquivos da paginação
// controller/Admins/index passando a paginação assim $paginate = $this->adminModel->getFilaBusca($page, $options);
// e o resultado da pesquisa pelo foreach $data['results']
// $paginate essa variável tem que ser a mesma lá embaixo na paginação
// getFilaBusca($page, $options) está lá no model ele retorna a busca com a paginação
// lá no controller em  $options = array( passamos os parâmetros de busca

$paginate = $data['paginate'];
$result = $data['results'];

//die(var_dump($result));

// la no controller admins se o resultado da pesquisa não trazer nehuma linha
// eu retorno false daí se retornar false é que não tem dados para emitir 
// interrompo o código
if($data['results'] == false){ die('<div class="container alert alert-warning">Sem dados para emitir</div>');} 

?>
<br>
<!-- AQUI VOU MONTAR OS CARDS -->
<div class="faq-container">
    <?php foreach ($result as $registro): ?>
        <div class="faq"
        id="linha_<?php echo $registro['id'];?>"
        style="border-left: solid 10px <? echo $this->situacaoModel->getCorSituacaoById($registro['situacao_id']);?>"
        >
        
        
        <h class="faq-title">
            <div class="row">
                <div class="col-8">
                <?php echo $registro['posicao'] .' '.$registro['nomecrianca'] .' protocolo nº<b> '. $registro['protocolo'] .'</b>';?>
                </div>
                <div class="col-2">
                    <?php echo $registro['situacao'];?> 
                </div>                             
            </div>
            
        </h>

        <div class="faq-text">

            <div class="row">
                <div class="col-3">
                    <b>Registro:</b> <?php echo $registro['registro']; ?>
                </div>     
                <div class="col-5">
                    <b>Logradouro:</b> <?php echo $registro['logradouro']; ?>
                </div>
                <div class="col-3">
                    <b>Bairro:</b> <?php echo $registro['bairro']; ?>
                </div>                
            </div>  

            <div class="row">
                <div class="col-sm-3">
                    <b>Nascimento:</b> <?php echo $registro['nascimento']; ?>
                </div>
                <div class="col-sm-5">
                    <b>Idade:</b> <?php echo CalculaIdade($registro['nascimento']);?>
                </div>
                <div class="col-sm-2">
                    <b>Etapa:</b> <?php echo $registro['etapa']; ?>
                </div> 
                <div class="col-sm-2">
                    <b>Especial:</b> <?php echo $registro['deficiencia']; ?>
                </div>  
            </div>   
            <div class="row">
                <div class="col-sm-6">
                    <b>Responsável:</b> <?php echo $registro['responsavel']; ?>
                </div>
                <div class="col-sm-2">
                    <b>Telefone:</b> <?php echo $registro['telefone']; ?>
                </div> 
                <div class="col-sm-2">
                    <b>Celular:</b> <?php echo $registro['celular']; ?>
                </div>  
                <div class="col-sm-2">
                    <b>Turno:</b> <?php echo $registro['opcao_turno']; ?>
                </div> 
            </div>  
            <div class="row">
                <div class="col-sm-4">
                    <b>Opção 1:</b> <?php echo $registro['opcao1_id']; ?>    
                </div>
                <div class="col-sm-4">
                    <b>Opção 2:</b> <?php echo $registro['opcao2_id']; ?>
                </div> 
                <div class="col-sm-4">
                    <b>Opção 3:</b> <?php echo $registro['opcao3_id']; ?>
                </div>  
            </div> 

            <div class="row">
                <div class="col-sm-4">
                    <b>Vagas</b>
                    <?php if($registro['opcao1_id']) : ?>                        
                        Mat. (<?php echo ($registro['vagas_op1'])?$registro['vagas_op1']->matutino:'NI'?>)  
                        Vesp. (<?php echo ($registro['vagas_op1'])?$registro['vagas_op1']->vespertino:'NI'?>)
                        Int. (<?php echo ($registro['vagas_op1'])?$registro['vagas_op1']->integral:'NI'?>)
                    <?php endif; ?>
                </div>
                <div class="col-sm-4">
                <b>Vagas</b>
                    <?php if($registro['opcao2_id']) : ?>
                        Mat. (<?php echo ($registro['vagas_op2'])?$registro['vagas_op2']->matutino:'NI'?>)  
                        Vesp. (<?php echo ($registro['vagas_op2'])?$registro['vagas_op2']->vespertino:'NI'?>)
                        Int. (<?php echo ($registro['vagas_op2'])?$registro['vagas_op2']->integral:'NI'?>)
                    <?php endif; ?>
                </div> 
                <div class="col-sm-4">
                <b>Vagas</b>
                    <?php if($registro['opcao3_id']) : ?>
                        Mat. (<?php echo ($registro['vagas_op3'])?$registro['vagas_op3']->matutino:'NI'?>)  
                        Vesp. (<?php echo ($registro['vagas_op3'])?$registro['vagas_op3']->vespertino:'NI'?>)
                        Int. (<?php echo ($registro['vagas_op3'])?$registro['vagas_op3']->integral:'NI'?>)
                    <?php endif; ?>
                </div>  
            </div> 
            <div class="row">
                <div class="col-12">
                    <b>Último registro do histórico:</b> <?php echo $registro['ultimo_historico']; ?>    
                </div>                 
            </div>
            <div class="row">
                <div class="col-12">
                    <b>Observação:</b> 
                    <input 
                        type="text" 
                        name="observacao" 
                        id="<?php echo $registro['id'];?>" 
                        maxlength="50"
                        class="form-control"
                        value="<?php if(isset($registro['obs_admin'])){htmlout($registro['obs_admin']);} ?>"
                        onkeydown="upperCaseF(this)"   
                        onkeyup="update(this.id,this.value)"
                    >
                    <span id="<?php echo $registro['id'];?>_msg">
                            
                    </span>    
                </div>                  
            </div>
            <div class="row mt-3">
                <div class="col-12">
                    <a href="<?php echo URLROOT; ?>/admins/edit/<?php echo  $registro['id'];?>" class="btn btn-primary btn-sm"><i class="fa fa-pen"></i> Editar</a>   
                    <button type='button' class='btn btn-info btn-sm btn-historico'><i class="fa fa-eye"></i> Histórico</button>
                </div>                 
            </div>                             
            <!-- HISTÓRICO -->            
            <div class="historico">
                <!-- ROW -->
                <div class="row mt-3">
                    <!-- COL -->
                    <div class="col-12">
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
                            <?php if($registro['historico']) : ?>
                                <?php $i = 0; ?>
                                <?php foreach($registro['historico'] as $row) :?>
                                <tr>
                                    <td><?php echo $registro['historico'][$i]['registro'];?></td>
                                    <td><?php echo $registro['historico'][$i]['usuario'];?></td>
                                    <td><?php echo $this->situacaoModel->getDescricaoSituacaoById( $registro['historico'][$i]['situacao_id']);?></td>
                                    <td><?php echo $registro['historico'][$i]['historico'];?></td>
                                </tr> 
                                <?php $i++;?>
                                <?php endforeach; ?> 
                            <?php else : ?>                      
                            <tr>
                                <td colspan="4" class="text-center">
                                    Nenhum histórico registrado
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>  
                    </div>
                    <!-- COL -->
                </div>
                <!-- ROW -->           
            </div>            
            <!-- HISTÓRICO -->            
        </div>
            
           

        <button class="faq-toggle">
          <i class="fas fa-chevron-down"></i>
          <i class="fas fa-times"></i>
        </button>
        
      </div>
        
    <?php endforeach; ?>
</div><!-- faq-containers -->
<!-- FIM DOS CARDS -->

<?php
    // no index a parte da paginação é só essa    
    echo '<p>'.$paginate->links_html.'</p>';   
    echo '<p style="clear: left; padding-top: 10px;">Total de Registros: '.$paginate->total_results.'</p>';   
    echo '<p>Total de Paginas: '.$paginate->total_pages.'</p>';
    echo '<p style="clear: left; padding-top: 10px; padding-bottom: 10px;">-----------------------------------</p>';
?>


<!-- AQUI NÃO COLOCO O FOOTER DO INC POIS PRECISO FECHAR O div do container antes da tabela -->  
</body>
</html>

<script>
    

const toggles = document.querySelectorAll('.faq-toggle');

toggles.forEach(toggle => {
    toggle.addEventListener('click', () => {
        toggle.parentNode.classList.toggle('active')
    })
})

const toggleshistorico = document.querySelectorAll('.btn-historico');


toggleshistorico.forEach(toggle => {
    toggle.addEventListener('click', () => {        
        toggle.parentNode.parentNode.parentNode.lastElementChild.classList.toggle('active')
    })
})




/* script executa a cada 3 segundos a variavel timer e a 
    constante waitTimer tem que ficar fora da função */
    let timer;
    const waitTimer = 3000;
    function update(id,data){    
        clearTimeout(timer);    
        /* depois de 3 segundos executa a função */
        timer = setTimeout(function(){            
            $(document).ready(function() { 
                $.ajax({
                    url: '<?php echo URLROOT; ?>/admins/gravaobsadmin',
                    method:'POST', 
                    data:{
                        id:id,
                        data:data
                    },
                    success: function(retorno_php){
                        var responseObj = JSON.parse(retorno_php);                       
                        $("#"+id+"_msg")
                        .removeClass()
                        .addClass(responseObj.classe) 
                        .html(responseObj.message) 
                        .fadeIn(2000).fadeOut(4000);
                       
                    }//sucess
                });//Fecha o ajax       
            });//Fecha document ready function
        }, waitTimer);
    }


    function limpar(){        
        document.getElementById('nome').value = "";
        document.getElementById('protocolo').value = "";        
        document.getElementById('etapa_id').value = "Todos";
        document.getElementById('situacao_id').value = "Todos";
        document.getElementById('escola_id').value = "Todos";        
        focofield("nome");
    }   


    window.onload = function(){
        focofield("nome");
    }  

    function newtab(){
      document.getElementById('filtrar').setAttribute('target', '_blank');
    }

    function salfTab(){
      document.getElementById('filtrar').setAttribute('target', '_self');
    }
</script>


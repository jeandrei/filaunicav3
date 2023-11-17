<?php
    // TEM QUE SER EM UM HEADER E FOOTER DIFERENTE POIS SE NÃO VAI TRAZER O NAVBAR JUNTO
    include 'header.php';
    //var_dump($data);
?>

<div class="container" style="margin-top: 50px;"> 

<div class="principal">
    <!-- Primeira linha -->
    <div class="row alert alert-success" role="alert">

        <!-- Primeira coluna da primeira linha -->
        <div class="col text-center">
            <h4 class="alert-heading">Cadastro realizado com sucesso!</h4>
        </div>       

    </div>

    <div class="row">

        <!-- Primeira coluna da primeira linha -->
        <div class="col text-center">
        <h4> Anote o número do seu protocolo:</h4><h1><?php echo $data['protocolo']; ?></h1>
          <p style="font-style:italic;">Quando da disponibilidade de uma vaga para a sua solicitação e respeitando a ordem de inscrição, a Secretaria de Educação entrará em contato
            para o processo de matrícula do aluno.
            Dúvidas podem ser sanadas nos telefones:<br>
            <br>(47) 3345-4025
            <br>(47) 3345-2388            
          </p>
        </div>       

    </div>             
    <hr>
    Informações do seu cadastro:

    <!-- BLOCO PARA INFORMAÇÕES -->
    <div class="bloco" style="margin-top:20px;">
        
        <div class="row">
            
            <div class="col text-center" style="color:green; font-size:25px">
                Nome da Criança: <?php echo $data['nome']; ?>
            </div> 
        </div>
        
        <div class="row">
            <div class="col text-center" style="color:green; font-size:25px">
                Etapa: <?php echo $data['desc_etapa']->descricao; ?>
            </div> 
        </div>

       
        <div class="row">             

           
            <div class="col text-center" style="color:green; font-size:25px">
               Turno escolhido: <?php  switch ($data['opcao_turno']) {
                                            case 1:
                                                echo "Matutino";
                                                break;
                                            case 2:
                                                echo "Vespertino";
                                                break;
                                            case 3:
                                                echo "Integral";
                                                break;
                                        }?>
            </div> 

        </div>

        <div class="row">             

           
            <div class="col text-center" style="color:green; font-size:25px">
                Posição na fila: <?php echo $data['posicao'];?>
            </div> 

        </div>


        <hr>     
        <!-- linha para tabela com as escolas escolhidas -->
        <div class="row">
             <div class="col">
                <table class="table table-striped table-dark">
                    <thead>
                        <tr>                        
                        <th scope="col">Estabelecimentos de Ensino</th>                        
                        </tr>
                    </thead>
                    <tbody>
                        
                        <?php if(!empty($data['unidade1'])): ?> 
                            <tr>                       
                                <td><?php  if(!empty($data['unidade1'])){echo $data['unidade1']->nome;} ?></td>                                
                            </tr>
                        <?php endif; ?>
                        
                        <?php if(!empty($data['unidade2'])): ?> 
                            <tr>                       
                                <td><?php  if(!empty($data['unidade2'])){echo $data['unidade2']->nome;} ?></td>                                
                            </tr>
                        <?php endif; ?>
                      

                        <?php if(!empty($data['unidade3'])): ?> 
                            <tr>                       
                                <td><?php  if(!empty($data['unidade3'])){echo $data['unidade3']->nome;} ?></td>                                
                            </tr>
                        <?php endif; ?>
                        </tr>
                    </tbody>
                </table>
            </div>   
        </div>
    </div>
        <div class="row p-4 justify-content-center align-items-center">         
              <div class="col-lg-4">
                    <a href="<?php echo URLROOT; ?>/filas/cadastrar" class="btn btn-success btn-lg btn-block" role="button">Novo Cadastro</a>                       
              </div>
        </div>  
</div>

</div>
<?php 
    include 'footer.php';
?>

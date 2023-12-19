<?php require APPROOT . '/views/inc/header.php'; ?>

<style>
  * {
    box-sizing: border-box;
  }
  
  .coluna{
    float: left;
    padding: 10px;    
    height: 50px;
    border: 1px solid #D3D3D3;      
  }

  .coluna-20{
    width: 20px;
  }

  .coluna-50{
    width: 50px;
  }

  .coluna-60{
    width: 60px;
  }
 
  .coluna-100{
    width: 100px;
  }

  .coluna-110{
    width: 141px;
  }

  .coluna-120{
    width: 120px;
  }  

  .coluna-150{
    width: 150px;
  }

  .coluna-200{
    width: 200px;
  }   

  .coluna-400{
    width: 400px;
  }

 
  .linha:after {
    content: "";
    display: table;
    clear: both;
  }

  .label{
    margin-left:3px;
    height:14px; 
    font-size:12px;
  }

  .valor{
    font-size:15px;
    margin-left:3px;
  }

  .sublinha{    
    display: none;
    clear: both;
  }

  .sublinha.active {
    display: block;      
  }

  .sublinha .coluna{   
    background-color: #DCDCDC;
  }

 
</style>
 
<div class="alert alert-secondary" role="alert">
  <?php echo isset($data['nav']) ? $data['nav'] : ''; ?>
</div>
  
  <?php $currentDuplicado = 0; $cores = ['#ff0000','#8000ff','#00bfff','#ffbf00','#ffff00','#80ff00','#4d4d4d']; $currentCor = 0;?>
  <?php foreach($data['results'] as $row) : ?>
    <?php 
          if($currentDuplicado <> $row['indiceDuplicado']){
            $currentDuplicado = $row['indiceDuplicado'];
            $currentCor++;
            if($currentCor>6){
              $currentCor = 0;
            }
          } 
    ?>
    <!-- cada linha -->
    <div class="linha" style="border-left: 10px solid <?php echo $cores[$currentCor];?>">
      
      <div class="coluna coluna-50">      
        <button type='button' class='btn btn-info btn-sm faq-toggle'><i class="fa fa-eye"></i></button>
      </div> 

      <div class="coluna coluna-50">      
        <button type='button' class='btn btn-danger btn-sm' onClick=arquivar(this,<?php echo $row['id'];?>)><i class="fa fa-trash" aria-hidden="true"></i></button>
      </div>

      <div class="coluna coluna-10">
        <div class="label">Posição:</div>
        <div class="valor"><?php echo $row['posicao'];?></div>
      </div> 
      
      <div class="coluna coluna-200">
        <div class="label">Registro:</div>
        <div class="valor"><?php echo $row['registro'];?></div>
      </div>

      <div class="coluna coluna-120">
        <div class="label">Protocolo:</div>
        <div class="valor"><?php echo $row['protocolo'];?></div>
      </div>
      
      <div class="coluna coluna-400">
        <div class="label">Nome:</div>
        <div class="valor"><?php echo $row['nomecrianca'];?></div>
      </div>

      <div class="coluna coluna-100">
        <div class="label">Nascimento:</div>
        <div class="valor"><?php echo $row['nascimento'];?></div>
      </div>

      <div class="coluna coluna-100">
        <div class="label">Situação:</div>
        <div class="valor"><?php echo $row['situacao'];?></div>
      </div>
      
     

     <div class="sublinha">

        <div class="coluna coluna-150">
          <div class="label">CPF Resp:</div>
          <div class="valor"><?php echo $row['cpfresponsavel'];?></div>
        </div>

        <div class="coluna coluna-400">
          <div class="label">Responsavel:</div>
          <div class="valor"><?php echo $row['responsavel'];?></div>
        </div>

        <div class="coluna coluna-400">
          <div class="label">Logradouro:</div>
          <div class="valor"><?php echo $row['logradouro'];?></div>
        </div>

        <div class="coluna coluna-110">
          <div class="label">Celular:</div>
          <div class="valor"><?php echo $row['celular'];?></div>
        </div>

      </div> 
       
    </div>
    <!-- fim da linha -->

  <?php endforeach;?>   
  </tbody>
</table>
<?php require APPROOT . '/views/inc/footer.php'; ?>

<script>
  const toggles = document.querySelectorAll('.faq-toggle');

  toggles.forEach(toggle => {
      toggle.addEventListener('click', () => {
          toggle.parentNode.parentNode.lastElementChild.classList.toggle('active');          
      })
  });

</script>


<script>

/* delete a linha da tabela sem relação com o banco de dados */
function deleteRow(btn) {
  var row = btn.parentNode.parentNode;
  row.parentNode.removeChild(row);
}

/* retorna os dados de um registro do banco de dados para o javascript */
function getRegistro(id){    
  $.ajax({
    url: `<?php echo URLROOT; ?>/filas/getRegistro/${id}`,
      method:'POST',         
      async: false,
      dataType: 'json'
    }).done(function (response){
      ret_val = response;
    }).fail(function (jqXHR, textStatus, errorThrown) {
      ret_val = null;
    });
   return ret_val;
}
   
    
   
// Remove um registro da fila e remove a linha da tabela   
function arquivar(rowToDelete,id) {
  if(typeof id != 'undefined'){
    //pego o registro a partir do id lá do banco de dados
    let registro = getRegistro(id);      
    
    const confirma = confirm(`Tem certeza que deseja arquivar o protocolo ${registro.protocolo} da criança ${registro.nomecrianca}?`);
    if(confirma){
      $.ajax({  
          url: `<?php echo URLROOT; ?>/filas/arquiva/${id}`,                
          method:'POST',
          success: function(retorno_php){   
              //console.log(retorno_php);               
              var responseObj = JSON.parse(retorno_php);               
               if(responseObj.error == false){
                deleteRow(rowToDelete);
                createNotification(responseObj['message'], responseObj['class']);
              }  else {
                createNotification(responseObj['message'], responseObj['class']);
              }  
                              
          }     
      });//Fecha o ajax      
    } 
  }     
}

// Remove um registro da fila e remove a linha da tabela   
function remover(rowToDelete,id) {
  if(typeof id != 'undefined'){
    //pego o registro a partir do id lá do banco de dados
    let registro = getRegistro(id);      
    
    const confirma = confirm(`Tem certeza que deseja excluir o protocolo ${registro.protocolo} da criança ${registro.nomecrianca}?`);
    if(confirma){
      $.ajax({  
          url: `<?php echo URLROOT; ?>/filas/delete/${id}`,                
          method:'POST',
          success: function(retorno_php){                     
              var responseObj = JSON.parse(retorno_php);               
               if(responseObj.error == false){
                deleteRow(rowToDelete);
                createNotification(responseObj['message'], responseObj['class']);
              } else {
                createNotification(responseObj['message'], responseObj['class']);
              } 
                              
          }     
      });//Fecha o ajax      
    } 
  }     
}

  
</script>
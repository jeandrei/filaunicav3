<?php
    class Admins extends Controller{
        public function __construct(){
            // 1 Chama o model
          $this->adminModel = $this->model('Admin'); 
          $this->filaModel = $this->model('Fila'); 
          $this->etapaModel = $this->model('Etapa');           
          $this->situacaoModel = $this->model('Situacao'); 
          $this->escolaVagasModel = $this->model('Escolavaga');
          $this->escolaModel = $this->model('Escola');
        }

        /*INDEX*/
        public function index(){  

          //se o usuário não estiver logado redirecionamos para o index  
          if((!isLoggedIn())){ 
            flash('message', 'Você deve efetuar o login para ter acesso a esta página', 'error'); 
            redirect('users/login');
            die();
          } else if ((!isAdmin()) && (!isUser())){                
            flash('message', 'Você não tem permissão de acesso a esta página', 'error'); 
            redirect('pages/sistem'); 
            die();
          }  

          // passa a página da paginação
           if(isset($_GET['page']))
          {
            //ENTRA AQUI SE FOR CLICADO PELO LINK DA PAGINAÇÃO
            $page = $_GET['page'];                 
          }
          else
          {        
            $page = 1;
          }                
            

          /*inicialização dos dados da paginação */
         if(!isset($_GET['protocolo'])){$_GET['protocolo'] = '';}
         if(!isset($_GET['situacao_id'])){$_GET['situacao_id'] = 'null';}
         if(!isset($_GET['etapa_id'])){$_GET['etapa_id'] = 'null';}
         if(!isset($_GET['escola_id'])){$_GET['escola_id'] = 'null';}
         if(!isset($_GET['nome'])){$_GET['nome'] = '';}         
         

          //valores e atributos da paginação
          $options = array(
            'results_per_page' => 10,
            'url' => URLROOT . '/admins/index.php?page=*VAR*&protocolo=' . $_GET['protocolo'] . '&situacao_id=' . $_GET['situacao_id'] . '&etapa_id=' . $_GET['etapa_id'] . '&escola_id=' . $_GET['escola_id'] . '&nome=' . $_GET['nome'],
            'using_bound_params' => true,
            'named_params' => array(
                                    ':protocolo' => $_GET['protocolo'],
                                    ':situacao_id' => $_GET['situacao_id'],
                                    ':etapa_id' => $_GET['etapa_id'],
                                    ':escola_id' => $_GET['escola_id'],
                                    ':nome' => $_GET['nome']
                                    )     
          );
          
          //se o usuário clicar em imprimir
          if(isset($_GET['botao']) && $_GET['botao'] == "Imprimir"){
            
            //pego os resultados da pesquisa
            $result = $this->filaModel->getFilaBusca($relatorio=true, $page=NULL, $options);

            if(!empty($result)){
              //faço o foreach para poder utilizar os métodos
              foreach($result as $row){
                $data[] = array(
                  'id' => $row->id,
                  'posicao' => ($this->filaModel->buscaPosicaoFila($row->protocolo)) ? $this->filaModel->buscaPosicaoFila($row->protocolo) : "-",
                  'etapa' => ($this->etapaModel->getEtapaDescricao($row->nascimento)) ? $this->etapaModel->getEtapaDescricao($row->nascimento) : "FORA ETAPAS",
                  'nomecrianca' => isset($row->nomecrianca) 
                                    ? $row->nomecrianca 
                                    : 'Sem informação de Nome',
                  'nascimento' => isset($row->nascimento)
                                    ? date('d/m/Y', strtotime($row->nascimento))
                                    : 'Sem informação de Nascimento',
                  'responsavel' => isset($row->responsavel)
                                    ? $row->responsavel
                                    : 'Sem informação de Responsável',
                  'protocolo' => isset($row->protocolo)
                                    ? $row->protocolo
                                    : 'Registro com erro na geraçao de protocolo',
                  'registro' => isset($row->registro)
                                    ? date('d/m/Y H:i:s', strtotime($row->registro))
                                    : 'Sem informação de registro',
                  'telefone' => isset($row->telefone)
                                    ? $row->telefone
                                    : 'Sem informação de telefone',
                  'celular' => isset($row->celular)
                                    ? $row->celular
                                    : 'Sem informação de celular',
                  'situacao' => isset($row->situacao_id)
                                    ? $this->situacaoModel->getDescricaoSituacaoById($row->situacao_id)
                                    : 'Registro com erro na situação informada',                  
                  'situacao_id' => isset($row->situacao_id)
                                    ? $row->situacao_id
                                    : 'Registro com erro na situação informada',
                  'opcao1_id' => isset($row->opcao1_id) 
                                    ? $this->filaModel->getEscolasById($row->opcao1_id)->nome 
                                    : '',
                  'opcao2_id' => isset($row->opcao2_id) 
                                    ? $this->filaModel->getEscolasById($row->opcao2_id)->nome 
                                    : '',
                  'opcao3_id' => isset($row->opcao3_id)
                                    ? $this->filaModel->getEscolasById($row->opcao3_id)->nome
                                    : '',
                  'opcao_matricula' => isset($row->opcao_matricula)
                                    ? $this->filaModel->getEscolasById($row->opcao_matricula)->nome
                                    : '',
                  'opcao_turno' => isset($row->opcao_turno)
                                    ? $this->filaModel->getTurno($row->opcao_turno)
                                    : 'Sem opção de turno informada',
                  'turno_matricula' => isset($row->turno_matricula)
                                    ? $this->filaModel->getTurno($row->turno_matricula)
                                    : 'Sem informação de turno para a matrícula'
                );
              }
            } else {
              $data = false;
            }  
            // E AQUI CHAMO O RELATÓRIO             
            $this->view('relatorios/relatorioconsulta' ,$data);
          //fim se o usuário clicar em imprimir
          } else {
          //se o usuário clicar em atualizar
            $paginate = $this->filaModel->getFilaBusca($relatorio=false, $page, $options);
            /* PAGINAÇÃO SUCESSO */
            if($paginate->success == true)
            {             
              // $data['paginate'] é só a parte da paginação tem que passar os dois arraya paginate e result
              //$data['paginate'] = $paginate;
              // $result são os dados propriamente dito depois eu fasso um foreach para passar
              // os valores como posição que utilizo um métido para pegar
              $pagresults = $paginate->resultset->fetchAll();
              if(!empty($pagresults)){
                //faço o foreach para poder utilizar os métodos
                foreach($pagresults as $row){
                  $results[] = [
                    'id' => ($row['id']) 
                              ? $row['id'] 
                              : '',
                    'posicao' => ($this->filaModel->buscaPosicaoFila($row['protocolo'])) 
                              ? $this->filaModel->buscaPosicaoFila($row['protocolo']) 
                              : "-",
                    'etapa' => ($this->etapaModel->getEtapaDescricao($row['nascimento'])) 
                              ? $this->etapaModel->getEtapaDescricao($row['nascimento']) 
                              : "FE",
                    'nomecrianca' => ($row['nomecrianca']) 
                              ? html($row['nomecrianca'] )
                              : '',
                    'nascimento' => ($row['nascimento']) 
                              ? formatadata($row['nascimento']) 
                              : '',
                    'responsavel' => ($row['responsavel']) 
                              ? html($row['responsavel']) 
                              : '',
                    'protocolo' => ($row['protocolo']) 
                              ? html($row['protocolo'])
                              : '',
                    'registro' => ($row['registro']) 
                              ? date('d/m/Y H:i:s', strtotime($row['registro'])) 
                              : '',
                    'telefone' => ($row['telefone']) 
                              ? html($row['telefone'])
                              : '',
                    'celular' => ($row['celular']) 
                              ? html($row['celular']) 
                              : '',
                    'situacao' => ($row['situacao_id']) 
                              ? $this->situacaoModel->getDescricaoSituacaoById($row['situacao_id']) 
                              : '',                  
                    'situacao_id' => ($row['situacao_id']) 
                              ? $row['situacao_id'] 
                              : '',
                    'opcao1_id' => ($row['opcao1_id'] && $row['opcao1_id'] != 'null') 
                              ? html($this->filaModel->getEscolasById($row['opcao1_id'])->nome)
                              : '',
                    'vagas_op1' => ($row['opcao1_id']) 
                              ? $this->escolaVagasModel->getEscolaVagasEtapa($row['opcao1_id'],$this->etapaModel->getEtapaId($row['nascimento'])) 
                              : '',
                    'opcao2_id' => ($row['opcao2_id'] && $row['opcao2_id'] != 'null') 
                              ? html($this->filaModel->getEscolasById($row['opcao2_id'])->nome)
                              : '',
                    'vagas_op2' => ($row['opcao2_id'])
                              ? $this->escolaVagasModel->getEscolaVagasEtapa($row['opcao2_id'],$this->etapaModel->getEtapaId($row['nascimento']))
                              : '',
                    'opcao3_id' => ($row['opcao3_id'] && $row['opcao3_id'] != 'null') 
                              ? html($this->filaModel->getEscolasById($row['opcao3_id'])->nome)
                              : '',
                    'vagas_op3' => ($row['opcao3_id']) 
                              ? $this->escolaVagasModel->getEscolaVagasEtapa($row['opcao3_id'],$this->etapaModel->getEtapaId($row['nascimento'])) 
                              : '',
                    'opcao_matricula' => ($row['opcao_matricula']) 
                              ? html($this->filaModel->getEscolasById($row['opcao_matricula'])->nome)
                              : '',
                    'opcao_turno' => ($row['opcao_turno']) 
                              ? $this->filaModel->getTurno($row['opcao_turno']) 
                              : '',
                    'turno_matricula' => ($row['turno_matricula']) 
                              ? $this->filaModel->getTurno($row['turno_matricula']) 
                              : '',
                    'ultimo_historico' => ($this->filaModel->getLastHistorico($row['id'])) 
                              ? html($this->filaModel->getLastHistorico($row['id'])->historico)
                              : '',
                    'obs_admin' => ($row['obs_admin']) 
                              ? html($row['obs_admin'])
                              : '',
                    'deficiencia' => ($row['deficiencia'] == 0)
                              ?'NÃO'
                              :'SIM',
                    'logradouro' => ($row['logradouro']) 
                              ? html($row['logradouro'])
                              : '',
                    'bairro' => ($row['bairro_id']) 
                              ? $this->filaModel->getBairroByid($row['bairro_id']) 
                              : '',
                    'historico' => ($this->adminModel->getHistoricoById($row['id'])) 
                              ? $this->adminModel->getHistoricoById($row['id']) 
                              : ''
                  ];
                }
              } else {
                $results = false;
              }             
            }       
            /* PAGINAÇÃO SUCESSO */     
          }
          //fim se o usuáro clicar em atualizar     
          $data = [
            'paginate' => $paginate,
            'results' => $results
          ];
          $this->view('admins/index', $data);
        }
        /*INDEX*/
        
        

      //aqui é o método chamado pelo jquery lá no index, verifico se o id tem algum valor se sim eu chamo o método changeStatus no model
      public function gravar(){

            if((!isLoggedIn())){                              
              die('Usuário não está logado!');
            } else if((!isAdmin()) && (!isUser())){
              die('Usuário sem permissão para realizar esta operação!');
            }
              

            try{
                    
              // DEPOIS TEM QUE TIRAR ESSE 1 AÍ DA FRENTE E COLOCAR A VARIÁVEL POST COM O ID DO MUNICIPIO
              // IMPORTANTE lá na função changeStatus se executar tem que retornar true para funcionar aqui
              
              if($this->adminModel->gravaHistorico($_POST['id'],$_POST['status'],$_POST['txthist'], $_SESSION[DB_NAME . '_user_name'])){
                  
                  /* aqui passo a classe da mensagem e a mensagem de sucesso */
                  $json_ret = array('classe'=>'alert alert-success', 'mensagem'=>'Dados gravados com sucesso');                     
                  echo json_encode($json_ret);                     
              } else {
                  $json_ret = array('classe'=>'alert alert-danger', 'mensagem'=>'Erro ao tentar gravar os dados');                     
                  echo json_encode($json_ret);                     
              }                

          } catch (Exception $e) 
          {
              $json_ret = array('classe'=>'alert alert-danger', 'mensagem'=>'Erro ao gravar os dados');                     
              echo json_encode($json_ret);
          } 
       
      }
       
      public function historico($id){  
        
        if((!isLoggedIn())){                              
          die('Usuário não está logado!');
        } else if((!isAdmin()) && (!isUser())){
          die('Usuário sem permissão para realizar esta operação!');
        } 

        if($data = $this->adminModel->getHistoricoById($id)){     
          $this->view('admins/historico', $data);
        } else {
          $data['erro'] = "Sem dados de histórico.";
          $this->view('admins/historico', $data);
        }
      }


      /*PRECISA MELHORAR ESSE CÓDIGO AQUI */
      public function edit($id){         
     
      //se o usuário não tiver feito login redirecionamos para o index
      if((!isLoggedIn())){ 
        redirect('index');
      } else if((!isAdmin()) && (!isUser())){
        redirect('index');
      }  

      // se o usuário tiver clicado em gravar
      if($_SERVER['REQUEST_METHOD'] == 'POST'){        
      
        
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
      
        //pego os dados do registro da fila
        $fila = $this->filaModel->buscaFilaById($id);
              
        $data = [
          'id' => $id,                        
          'situacao_id' => $_POST['situacao'],         
          'opcao_matricula' => $_POST['escolamatricula'],
          'unidade_matricula' => $this->filaModel->getEscolasById($_POST['escolamatricula'])->nome,
          'escola_id' => $_POST['escolamatricula'],
          'historico' => $_POST['historico'],
          'usuario' => $_SESSION[DB_NAME . '_user_name'],
          'etapa' => ($this->etapaModel->getEtapaDescricao($fila->nascimento)) ? $this->etapaModel->getEtapaDescricao($fila->nascimento) : "FORA DE TODAS AS ETAPAS",
          'etapa_id' => ($this->etapaModel->getEtapaId($fila->nascimento)) ? $this->etapaModel->getEtapaId($fila->nascimento) : false,
          'nomecrianca' => $fila->nomecrianca,
          'nascimento' => date('d/m/Y', strtotime($fila->nascimento)),
          'responsavel' => $fila->responsavel,
          'protocolo' => $fila->protocolo, 
          'telefone' => $fila->telefone,
          'celular' => $fila->celular,
          'email' => $fila->email, 
          'logradouro' => $fila-> logradouro,
          'bairro' => $this->filaModel->getBairroByid($fila->bairro_id),
          'numero' => $fila->numero,
          'complemento' => $fila->complemento,
          'situacao' => ($_POST['situacao']) ? ($this->situacaoModel->getDescricaoSituacaoById($_POST['situacao'])) : $this->situacaoModel->getDescricaoSituacaoById($fila->situacao_id), 
          'turno_descricao' => $this->filaModel->getTurno($fila->turno_matricula),
          'turno_matricula' => $_POST['turno_matricula'],
          'opcao_turno' => $this->filaModel->getTurno($fila->opcao_turno),
          'observacao' => $fila->observacao,
          'deficiencia' => $fila->deficiencia == 1 ? 'Sim':'Não',
          'cpfresponsavel' => $fila-> cpfresponsavel,
          'certidaonascimento' => $fila-> certidaonascimento 
        ];


          //SE O BOTÃO CLICADO FOR O IMPRIMIR EU CHAMO A FUNÇÃO EU IMPRIMO O ENCAMINHAMENTO          
          if($_POST['botao'] == "Imprimir"){             
            // E AQUI CHAMO O RELATÓRIO          
            $this->view('relatorios/relatoriomatricula' ,$data);
             //CASO NÃO FOR O BOTÃO IMPRIMIR EU ATUALIZO OS DADOS DO CADASTRO E REGISTRO NO HISTÓRICO
             die();
          } 
          
          if ($_POST['botao'] == 'atualizavaga'){ 
              switch ($_POST['turno_matricula']){
                case 1:
                  $turno = "matutino";
                  break;
                case 2:
                  $turno = "vespertino";
                  break;
                case 3:
                  $turno = "integral";
                  break;
              }              
              $this->escolaVagasModel->atualizaVaga($_POST['escola_id'], $data['etapa_id'],$turno);
              redirect('admins/edit/' . $data['id']);
              die();
           }
           
           
           if (($this->filaModel->update($data)) &&  ($this->adminModel->gravaHistorico($data['id'],$data['situacao_id'],$data['historico'],$data['usuario']))){            
            if($data['situacao'] == 'Matriculado') {
              $data['vagas'] = $this->escolaVagasModel->getEscolaVagasEtapa($data['escola_id'],$data['etapa_id']);
              $this->view('admins/confirma',$data);
              die();
              //$this->escolaVagasModel->atualizaVaga($data['escola_id'],$data['etapa_id']);
            }                                
            flash('message', 'Protocolo atualizado com sucesso!','success');                        
            redirect('admins/edit/' . $data['id']);
          }             
           else {    
            die('Ops! Algo deu errado.');
          }


            
              
      } else { 
        // se o usuário não clicou em gravar carrega os dados atuais       
        $fila = $this->filaModel->buscaFilaById($id);
        $data = [
          'id' => $id,
          'posicao' =>  ($this->filaModel->buscaPosicaoFila($fila->protocolo)) ? $this->filaModel->buscaPosicaoFila($fila->protocolo) : "-",
          'etapa' => ($this->etapaModel->getEtapaDescricao($fila->nascimento)) ? $this->etapaModel->getEtapaDescricao($fila->nascimento) : "FORA DE TODAS AS ETAPAS",
          'nomecrianca' => $fila->nomecrianca,
          'nascimento' => date('d/m/Y', strtotime($fila->nascimento)),
          'responsavel' => $fila->responsavel,
          'protocolo' => $fila->protocolo,
          'registro' => date('d/m/Y H:i:s', strtotime($fila->registro)),
          'telefone' => $fila->telefone,
          'celular' => $fila->celular,
          'email' => $fila->email, 
          'logradouro' => $fila-> logradouro,
          'bairro' => $this->filaModel->getBairroByid($fila->bairro_id),
          'numero' => $fila->numero,
          'complemento' => $fila->complemento,
          'situacao' => $this->situacaoModel->getDescricaoSituacaoById($fila->situacao_id),                  
          'situacao_id' => $fila->situacao_id,
          'opcao1_id' => $this->filaModel->getEscolasById($fila->opcao1_id)->nome,
          'vagas_op1' => $this->escolaVagasModel->getEscolaVagasEtapa($fila->opcao1_id,$this->etapaModel->getEtapaId($fila->nascimento)),
          'opcao2_id' => $this->filaModel->getEscolasById($fila->opcao2_id)->nome,
          'vagas_op2' => $this->escolaVagasModel->getEscolaVagasEtapa($fila->opcao2_id,$this->etapaModel->getEtapaId($fila->nascimento)),
          'opcao3_id' => $this->filaModel->getEscolasById($fila->opcao3_id)->nome,
          'vagas_op3' => $this->escolaVagasModel->getEscolaVagasEtapa($fila->opcao3_id,$this->etapaModel->getEtapaId($fila->nascimento)),
          'turno_descricao' => $this->filaModel->getTurno($fila->turno_matricula),
          'turno_matricula' => $fila->turno_matricula,
          'opcao_turno' => $this->filaModel->getTurno($fila->opcao_turno),
          'opcao_matricula' => $fila->opcao_matricula,
          'observacao' => $fila->observacao,
          'deficiencia' => $fila->deficiencia == 1 ? 'Sim':'Não',
          'cpfresponsavel' => $fila-> cpfresponsavel,
          'certidaonascimento' => $fila-> certidaonascimento


        ];

        $this->view('admins/editar', $data);
      }
         
    }

    public function relatorioMensal(){

      if((!isLoggedIn())){ 
        flash('message', 'Você deve efetuar o login para ter acesso a esta página', 'error'); 
        redirect('users/login');
        die();
      } else if ((!isAdmin()) && (!isUser())){                
        flash('message', 'Você não tem permissão de acesso a esta página', 'error'); 
        redirect('pages/sistem'); 
        die();
      }  

      if($_SERVER['REQUEST_METHOD'] == 'POST') {
          $fila = $this->filaModel->getMatriculadosAnoMes($_POST['ano'],$_POST['mes']);     
          
                    
          foreach($fila as $row){
            $data[] = array(             
              'etapa' => ($this->etapaModel->getEtapaDescricao($row->nascimento)) ? $this->etapaModel->getEtapaDescricao($row->nascimento) : "FORA ETAPAS",
              'nomecrianca' => substr($row->nomecrianca,0,40),
              'nascimento' => date('d/m/Y', strtotime($row->nascimento)),
              'responsavel' => substr($row->responsavel,0,40),
              'protocolo' => $row->protocolo,
              'registro' => date('d/m/Y H:i:s', strtotime($row->registro)),
              'telefone' => $row->telefone,
              'celular' => $row->celular,
              'situacao' => $this->situacaoModel->getDescricaoSituacaoById($row->situacao_id),                  
              'situacao_id' => $row->situacao_id,
              'opcao1_id' => $this->filaModel->getEscolasById($row->opcao1_id)->nome,
              'opcao2_id' => $this->filaModel->getEscolasById($row->opcao2_id)->nome,
              'opcao3_id' => $this->filaModel->getEscolasById($row->opcao3_id)->nome,
              'opcao_matricula' => substr($this->filaModel->getEscolasById($row->opcao_matricula)->nome,0,40),
              'opcao_turno' => $this->filaModel->getTurno($row->opcao_turno),
              'turno_matricula' => $this->filaModel->getTurno($row->turno_matricula),              
              'ultimo_historico' => $this->filaModel->getLastHistorico($row->id)->historico              
            );       
          }

          //$data = array_merge($data, ['ano' => 2021, 'mes' => 01]);         
                      
          $this->view('relatorios/relatoriomatriculamensal',$data);
      } else {
          $this->view('admins/relatoriomatriculamensal');
      }      
      
  }

  public function relatorioDemanda(){
    
    if((!isLoggedIn())){ 
      flash('message', 'Você deve efetuar o login para ter acesso a esta página', 'error'); 
      redirect('users/login');
      die();
    } else if ((!isAdmin()) && (!isUser())){                
      flash('message', 'Você não tem permissão de acesso a esta página', 'error'); 
      redirect('pages/sistem'); 
      die();
    }  

    if($_SERVER['REQUEST_METHOD'] == 'POST') {       
        $fila = $this->filaModel->getDemandaEscola($_POST['escola_id']); 
        $totalOpcao1 = $this->filaModel->getDemandaOpcao1Rel($_POST['escola_id']);       
    
        
                  
        foreach($fila as $row){
          $dados[] = array(             
            'etapa' => ($this->etapaModel->getEtapaDescricao($row->nascimento)) ? $this->etapaModel->getEtapaDescricao($row->nascimento) : "FORA ETAPAS",
            'nomecrianca' => substr($row->nomecrianca,0,40),
            'nascimento' => date('d/m/Y', strtotime($row->nascimento)),
            'responsavel' => substr($row->responsavel,0,40),
            'protocolo' => $row->protocolo,
            'registro' => date('d/m/Y H:i:s', strtotime($row->registro)),
            'telefone' => $row->telefone,
            'celular' => $row->celular,
            'situacao' => $this->situacaoModel->getDescricaoSituacaoById($row->situacao_id),                  
            'situacao_id' => $row->situacao_id,
            'opcao1_id' => substr($this->filaModel->getEscolasById($row->opcao1_id)->nome,0,20),
            'opcao2_id' => substr($this->filaModel->getEscolasById($row->opcao2_id)->nome,0,20),
            'opcao3_id' => substr($this->filaModel->getEscolasById($row->opcao3_id)->nome,0,20),
            'opcao_matricula' => substr($this->filaModel->getEscolasById($row->opcao_matricula)->nome,0,40),
            'opcao_turno' => $this->filaModel->getTurno($row->opcao_turno),
            'turno_matricula' => $this->filaModel->getTurno($row->turno_matricula),              
            'ultimo_historico' => $this->filaModel->getLastHistorico($row->id)->historico              
          );       
        }

        $escolas = $this->filaModel->getEscolas();

        
        foreach($escolas as $escola){
          $totais[] = array (
            'escola' => $escola->nome,
            'totalOpcao1' => $this->filaModel->getDemandaOpcaoEscola($escola->id, 1)->total,
            'totalOpcao2' => $this->filaModel->getDemandaOpcaoEscola($escola->id, 2)->total,
            'totalOpcao3' => $this->filaModel->getDemandaOpcaoEscola($escola->id, 3)->total

          );          
          
        }

        
        //para poder passar os totais junto eu recrio o array mas dessa vez multidimensional
        $data = array(
          "dados" => $dados,
          
          "totalOp1" => array(
            "totalOpcao1" => $totalOpcao1->total
          ),

          "totais" => $totais
          
        );

                    
        $this->view('relatorios/relatoriodemandaporunidade',$data);
    } else {        
        $this->view('admins/relatoriodemandaporunidade');
    }      
    
}

  public function relatorioAlunoEspecial(){

    if((!isLoggedIn())){ 
      flash('message', 'Você deve efetuar o login para ter acesso a esta página', 'error'); 
      redirect('users/login');
      die();
    } else if ((!isAdmin()) && (!isUser())){                
      flash('message', 'Você não tem permissão de acesso a esta página', 'error'); 
      redirect('pages/sistem'); 
      die();
    }  

    if($_SERVER['REQUEST_METHOD'] == 'POST') {       
        $fila = $this->filaModel->getAlunoEspecialEscola($_POST['escola_id']);
              
    
        
                  
        foreach($fila as $row){
          $data[] = array(             
            'etapa' => ($this->etapaModel->getEtapaDescricao($row->nascimento)) ? $this->etapaModel->getEtapaDescricao($row->nascimento) : "FORA ETAPAS",
            'nomecrianca' => substr($row->nomecrianca,0,40),
            'nascimento' => date('d/m/Y', strtotime($row->nascimento)),
            'responsavel' => substr($row->responsavel,0,40),
            'protocolo' => $row->protocolo,
            'registro' => date('d/m/Y H:i:s', strtotime($row->registro)),
            'telefone' => $row->telefone,
            'celular' => $row->celular,
            'situacao' => $this->situacaoModel->getDescricaoSituacaoById($row->situacao_id),                  
            'situacao_id' => $row->situacao_id,
            'opcao1_id' => substr($this->filaModel->getEscolasById($row->opcao1_id)->nome,0,20),
            'opcao2_id' => substr($this->filaModel->getEscolasById($row->opcao2_id)->nome,0,20),
            'opcao3_id' => substr($this->filaModel->getEscolasById($row->opcao3_id)->nome,0,20),
            'opcao_matricula' => substr($this->filaModel->getEscolasById($row->opcao_matricula)->nome,0,40),
            'opcao_turno' => $this->filaModel->getTurno($row->opcao_turno),
            'turno_matricula' => $this->filaModel->getTurno($row->turno_matricula),              
            'ultimo_historico' => $this->filaModel->getLastHistorico($row->id)->historico              
          );       
        }       

                    
        $this->view('relatorios/relatorioalunoespecial',$data);
    } else {        
        $this->view('admins/relatorioalunoespecial');
    }      
    
  }



  public function relatorioAguardandoAlfabetica(){    
    
      if((!isLoggedIn())){ 
        flash('message', 'Você deve efetuar o login para ter acesso a esta página', 'error'); 
        redirect('users/login');
        die();
      } else if ((!isAdmin()) && (!isUser())){                
        flash('message', 'Você não tem permissão de acesso a esta página', 'error'); 
        redirect('pages/sistem'); 
        die();
      }  
     
      $fila = $this->filaModel->getAguardandoAlfabetica();        
      
                  
        foreach($fila as $row){
          $data[] = array( 
            'etapa' => ($this->etapaModel->getEtapaDescricao($row->nascimento)) ? $this->etapaModel->getEtapaDescricao($row->nascimento) : "FORA ETAPAS",
            'nomecrianca' => substr($row->nomecrianca,0,40),
            'nascimento' => date('d/m/Y', strtotime($row->nascimento)),
            'responsavel' => substr($row->responsavel,0,40),
            'protocolo' => $row->protocolo,
            'registro' => date('d/m/Y H:i:s', strtotime($row->registro)),
            'telefone' => $row->telefone,
            'celular' => $row->celular,
            'situacao' => $this->situacaoModel->getDescricaoSituacaoById($row->situacao_id),                  
            'situacao_id' => $row->situacao_id,
            'opcao1_id' => substr($this->filaModel->getEscolasById($row->opcao1_id)->nome,0,20),
            'opcao2_id' => substr($this->filaModel->getEscolasById($row->opcao2_id)->nome,0,20),
            'opcao3_id' => substr($this->filaModel->getEscolasById($row->opcao3_id)->nome,0,20),
            'opcao_matricula' => substr($this->filaModel->getEscolasById($row->opcao_matricula)->nome,0,40),
            'opcao_turno' => $this->filaModel->getTurno($row->opcao_turno)
              
          );       
        } 
        $this->view('relatorios/relatorioaguardandoalfabetica',$data);
  }  


  public function relatorioQuadrodeVagas(){    
    
    if((!isLoggedIn())){ 
      flash('message', 'Você deve efetuar o login para ter acesso a esta página', 'error'); 
      redirect('users/login');
      die();
    } else if ((!isAdmin()) && (!isUser())){                
      flash('message', 'Você não tem permissão de acesso a esta página', 'error'); 
      redirect('pages/sistem'); 
      die();
    }  
   
    $escolas = $this->escolaModel->getEscolas();
    $etapas = $this->etapaModel->getEtapas();
    

    foreach($escolas as $escola){ 
      foreach($etapas as $etapa){        
        $quadroVagas = $this->escolaVagasModel->getEscolaVagasEtapa($escola->id,$etapa['id']);
        $data[] = [
          'escola_id' => $escola->id,
          'escola' => $escola->nome,
          'etapa' => $this->etapaModel->getEtapaById($etapa['id'])->descricao, 
          'matutino' => $quadroVagas->matutino,
          'vespertino' => $quadroVagas->vespertino,
          'integral' => $quadroVagas->integral
        ];
      }                
    }     
    $this->view('relatorios/relatorioQuadrodeVagas',$data);
}  
    

  public function gravaobsadmin(){

    if((!isLoggedIn())){                              
      die('Usuário não está logado!');
    } else if((!isAdmin()) && (!isUser())){
      die('Usuário sem permissão para realizar esta operação!');
    }

    $id = $_POST['id'];
    $data= $_POST['data']; 

    //Se não teve nenhum erro grava os dados
    try{

      if($this->filaModel->gravaObsAdmin($id,$data)){
          //para acessar esses valores no jquery
          //exemplo responseObj.message
          $json_ret = array(
                              'classe'=>'text-success', 
                              'message'=>'Dados gravados com sucesso',
                              'error'=>false
                          );                     
          
          echo json_encode($json_ret); 
      } else {
        throw new Exception('Ops! Algo deu errado ao tentar gravar os dados!');
      }    
    } catch (Exception $e) {
      $erro = 'Erro: '.  $e->getMessage();
      $json_ret = array(
              'classe'=>'text-danger', 
              'message'=>$erro,
              'error'=>true
              );                     
      echo json_encode($json_ret); 
    }
  }


  public function analiseDeRegistrosDuplicados(){
    
    if((!isLoggedIn())){ 
      flash('message', 'Você deve efetuar o login para ter acesso a esta página', 'error'); 
      redirect('users/login');
      die();
    } else if ((!isAdmin()) && (!isUser())){                
      flash('message', 'Você não tem permissão de acesso a esta página', 'error'); 
      redirect('pages/sistem'); 
      die();
    }  

    $duplicados = $this->filaModel->getDuplicados();
   
    $indiciDuplicado = 0;
    if($duplicados){
      foreach($duplicados as $row){
        $indiciDuplicado++;
        $registrosDuplicados = $this->filaModel->getRegistroByNomeNascimento($row->nomecrianca, $row->nascimento);
        foreach($registrosDuplicados as $registro){
          $data[] = array(
            'id' => $registro->id,
            'indiceDuplicado' => $indiciDuplicado,
            'protocolo' => $registro->protocolo,
            'posicao' =>  ($this->filaModel->buscaPosicaoFila($registro->protocolo)) ? $this->filaModel->buscaPosicaoFila($registro->protocolo) : "-",
            'nomecrianca' => $registro->nomecrianca,
            'nascimento' => formatadata($registro->nascimento), 
            'responsavel' => $registro->responsavel,
            'cpfresponsavel' => $registro->cpfresponsavel,
            'logradouro' => $registro->logradouro,           
            'registro' => formatadatempo($registro->registro),
            'celular' => $registro->celular,
            'situacao' => $registro->descricao
          );         
        }
      }
    } else {
      die('Sem cadastros duplicados no momento.');
    }
    $this->view('analiseduplicados/index',$data);
  }






    

}
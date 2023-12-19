<?php 
	class Filas extends Controller{
		public function __construct(){		
			//vai procurar na pasta model um arquivo chamado Fila.php e incluir
			$this->filaModel = $this->model('Fila');
			$this->etapaModel = $this->model('Etapa');
			$this->userModel = $this->model('User');
			$this->configModel = $this->model('Config');
		}		

		/* Registra um cadastro na fila mesmo duplicados. emite alerta mas permite cadastros duplicados*/        
		public function cadastrar(){ 

			//pega todos os bairros
			$bairros = ($this->filaModel->getBairros())
						? $this->filaModel->getBairros()
						: 'null';
			//pega todas as escolas
			$escolas = ($this->filaModel->getEscolas())
						? $this->filaModel->getEscolas()
						: 'null'; 
			
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				/*verifico se a session protocolo tem algum valor se sim o formulário já foi enviado e redireciono para
				um novo cadastro caso contrário lá no else eu dou um unset na session protocolo para permitir que seja enviado o formulário*/
				if(isset($_SESSION['protocolo'])){
					redirect('filas/cadastrar');
				}
				$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING); 
				$data = [
					'bairros' => $bairros,
					'escolas' => $escolas,
					'responsavel' => isset($_POST['responsavel'])
												? html($_POST['responsavel'])
												: '',
					'cpf' => isset($_POST['cpf'])
												? html($_POST['cpf'])
												: '', 
					'email' => isset($_POST['email'])
												? html($_POST['email'])
												: '', 
					'telefone' => isset($_POST['telefone'])
												? html($_POST['telefone'])
												: '',
					'celular' => isset($_POST['celular'])
												? html($_POST['celular'])
												: '',
					'bairro' => isset($_POST['bairro'])
												? html($_POST['bairro'])
												: '',
					'rua' => isset($_POST['rua'])
												? html($_POST['rua'])
												: '',
					'numero' => isset($_POST['numero'])
												? html($_POST['numero'])
												: '',
					'complemento' => isset($_POST['complemento'])
												? html($_POST['complemento'])
												: '',
					'nome' => isset($_POST['nome'])
												? html($_POST['nome'])
												: '',
					'nascimento' => isset($_POST['nascimento'])
												? trim($_POST['nascimento'])
												: '',
					'certidao' => isset($_POST['certidao'])
												? html($_POST['certidao'])
												: '',
					'opcao1' => isset($_POST['opcao1'])
												? html($_POST['opcao1'])
												: '',                    
					'opcao2' => isset($_POST['opcao2'])
												? html($_POST['opcao2'])
												: '', 
					'opcao3' => isset($_POST['opcao3'])
												? html($_POST['opcao3'])
												: '',                    
					'opcao_turno' => isset($_POST['opcao_turno'])
												? $_POST['opcao_turno']
												: '',                           
					'obs'  => isset($_POST['obs'])
												? html($_POST['obs'])
												: '',
					'responsavel_err' => '',
					'cpf_err' => '',
					'email_err' => '',
					'telefone_err' => '',
					'celular_err' => '',
					'bairro_err' => '',
					'rua_err' => '',
					'numero_err' => '',
					'nome_err' => '',
					'nascimento_err' => '',
					'certidao_err' => '',
					'opcao_turno_err' => '',
					'opcao1_err' => '',
					'opcao2_err' => '',
					'opcao3_err' => '',
					'cadastroDuplicado' => false,
					'urlForm' => URLROOT . '/filas/cadastrar'
				];
				/*
				checkbox não manda valor no post se não for marcado por isso tem que verificar se foi marcado caso contrário o php vai acusar o erro undefined index*/              
				if(isset($_POST['portador'])){
					$data['portador'] = $_POST['portador'];
				}    

				//valida responsável
				if(empty($data['responsavel'])){
					$data['responsavel_err'] = 'Por favor informe o responsável';       
				}else{
					$data['responsavel_err'] = '' ;       
				}

				//valida telefone fixo                 
				if((!empty($data['telefone'])) && (!validatelefone($data['telefone']))){
					$data['telefone_err'] = 'Telefone inválido';        
				}else{
					$data['telefone_err'] = '';
				}
													
				//valida celular
				if((!empty($data['celular'])) && (!validatelefone($data['celular']))){
					$data['celular_err'] = 'Telefone inválido';        
				}else{
					$data['celular_err'] = '';
				}

				if(empty($data['telefone']) && empty($data['celular'])){
					$data['telefone_err'] = 'Informe ao menos um telefone';  
					$data['celular_err'] = 'Informe ao menos um telefone';   
				}

				//valida nome
				if(empty($data['nome'])){
					$data['nome_err'] = 'Por favor informe o nome da criança';
				}              

				//valida nascimento
				if(empty($data['nascimento'])){        
					$data['nascimento_err'] = 'Por favor informe a data de nascimento';       
				}                    
				elseif(!$this->filaModel->validaNascimento($data['nascimento'])){
					$data['nascimento_err'] = 'Data inválida';       
				}else{
					$data['nascimento_err'] = '';
				}    
					
				//SÓ PERMITE INSCRIÇÃO COM IDADE DENTRO DE ALGUMA ETAPA
				if(!empty($data['nascimento'])){
					if($this->etapaModel->getEtapa($data['nascimento'])){
						$data['etapa_id'] = $this->etapaModel->getEtapa($data['nascimento']);
					} else {
						$data['nascimento_err'] = 'A data informada não corresponde a nenhuma etapa da fila.';                                           
						flash('fila-erro','Ops! A data de nascimento não corresponde a nenhuma etapa da Fila Única','alert alert-danger');                        
					}
				}
					
				//valida email
				if((!empty($data['email'])) && (!filter_var($data['email'], FILTER_VALIDATE_EMAIL))){
					$data['email_err'] = 'Email inválido';        
				}else{
					$data['email_err'] = '';
				}

				//valida cpf
				if((empty($data['cpf'])) || (!validaCPF($data['cpf']))){
					$data['cpf_err'] = 'CPF inválido';  							
				} else {
					$data['cpf_err'] = '';
				}
					
				//valida o bairro
				if(empty($data['bairro'])){       
					$data['bairro_err'] = 'Por favor selecione um bairro';
				}

				//valida a rua
				if(empty($data['rua'])){       
					$data['rua_err'] = 'Por favor informe a rua';
				}                           
		
				//valida opcao1 tem que informar ao menos a opção 1
				if(empty($data['opcao1']) || $data['opcao1'] == 'null'){
					$data['opcao1_err'] = 'Por favor informe ao menos uma opção';
				}
				
				//valida turno
				if(empty($data['opcao_turno']) || $data['opcao_turno'] == 'null'){
					$data['opcao_turno_err'] = 'Por favor informe o turno desejado';        
				}
				if(     
					empty($data['responsavel_err']) && 
					empty($data['telefone_err']) && 
					empty($data['celular_err']) && 
					empty($data['nome_err']) && 
					empty($data['nascimento_err']) && 
					empty($data['email_err']) && 
					empty($data['cpf_err']) && 
					empty($data['bairro_err']) && 
					empty($data['rua_err']) && 
					empty($data['opcao1_err']) && 
					empty($data['opcao_turno_err'])                                    
				){
						/*CONFIRMA REGISTRO PARA CADASTRO EXISTENTE 
						COLOQUEI DEPOIS DA VALIDAÇÃO PARA QUE VALIDE TUDO E SÓ DEPOIS DE ENVIAR VERIFIQUE SE TEM CADASTRO DUPLICADO */
						if ($this->filaModel->nomeCadastrado($data['nome'],$data['nascimento'])) {
							$data['nome_err'] = 'Já existe um cadastro com esse nome e data de nascimento!';	
							if($this->configModel->getPermiteDuplicado() !== 'sim') {
								$this->view('filas/cadastrar',$data);
								die();
							}
						} 
						if($data['nome_err'] && $_POST['btn_enviar'] !== "confirmaDuplicado"){
							$data['cadastroDuplicado'] = true;
							$confirmaDuplicado = false;
							$this->view('filas/cadastrar', $data);
						} else {
							if(!$data['unidade1'] = $this->filaModel->getEscolasById($data['opcao1'])){
								$data['unidade1'] = '';    
							} 
							if(!$data['unidade2'] = $this->filaModel->getEscolasById($data['opcao2'])){
									$data['unidade2'] = '';    
							} 
							if(!$data['unidade3'] = $this->filaModel->getEscolasById($data['opcao3'])){
									$data['unidade3'] = '';    
							}		
							try {   
								if($lastId = $this->filaModel->register($data)){									 
									$protocolo = $this->filaModel->getProtocoloByid($lastId);
									//$_SESSION['protocolo'] é para impedir o reenvio do formulário
									$_SESSION['protocolo'] = $protocolo;
									$data['protocolo'] = $protocolo;
									$data['posicao'] = $this->filaModel->buscaPosicaoFila($protocolo);
									$id_etapa = $this->etapaModel->getEtapa($data['nascimento']);
									//a partir do id da etapa pego a descrição
									$data['desc_etapa'] = $this->etapaModel->getDescricaoEtapa($id_etapa);		
									$this->view('relatorios/protocolo', $data); 
								} else {                        
									throw new Exception('Ops! Algo deu errado ao tentar realizar o cadastro!');
								}
							} catch (Exception $e) {                         
								$erro = 'Erro: '.  $e->getMessage(); 									
								flash('message', $erro,'error');
								$this->view('filas/cadastrar',$data);
								die();
							}  
						}
				} else {
					$this->view('filas/cadastrar', $data);
				}
			
			} else { //else if POST
				//livro a session protocolo para permitir um novo cadastro
				unset($_SESSION['protocolo']);
				$data = [
					'bairros' => $bairros,
					'escolas' => $escolas,
					'responsavel' => '',
					'cpf' => '', 
					'email' => '', 
					'telefone' => '',
					'celular' => '',
					'bairro' => '',
					'rua' => '',
					'numero' => '',
					'complemento' => '',
					'nome' => '',
					'nascimento' => '',
					'etapa_id' => '',
					'certidao' => '',
					'opcao1' => 'null',                                        
					'opcao2' => 'null',                    
					'opcao3' => '',
					'opcao_turno' => '',        
					'obs'  => '',
					'responsavel_err' => '',
					'cpf_err' => '',
					'email_err' => '',
					'telefone_err' => '',
					'celular_err' => '',
					'bairro_err' => '',
					'rua_err' => '',
					'numero_err' => '',
					'nome_err' => '',
					'nascimento_err' => '',
					'certidao_err' => '',
					'opcao1_err' => '',
					'opcao2_err' => '',
					'opcao3_err' => '',
					'opcao_turno_err' => '',
					'cadastroDuplicado' => false,
					'urlForm' => URLROOT . '/filas/cadastrar'
				];                
				$this->view('filas/cadastrar', $data);
			}//fim if POST

			
		}
			
		//Consulta um protocolo
		public function consultar(){
			// aqui pego os dados do protocolo
			// se existir o protocolo chamo o formulário de consulta se não chamo o cadastrar novamente
			if($this->filaModel->buscaProtocolo($_POST['protocolo'])) {
				$data = $this->filaModel->buscaProtocolo($_POST['protocolo']);
				if($this->filaModel->buscaPosicaoFila($_POST['protocolo'])) {
					$data->posicao = $this->filaModel->buscaPosicaoFila($_POST['protocolo']);                    
				} else {
					$data->posicao = "-";
				}
				$this->view('filas/consultar', $data);
			} else {   
				$data['protocolo_err'] = 'Ops! Protocolo não encontrado.';
				$this->view('pages/index', $data);
			}					
		}

		//Imprime a lista de chamadas
		public function listachamada(){
			if((!isLoggedIn())){ 
					redirect('users/login');
			} 
			$data['etapas'] = $this->filaModel->getEtapas();           
			$this->view('filas/listachamada', $data);
		}          
        
		//não uso essa função antes eu removia o protocolo mas mudamos para apenas arquivá-lo
		public function delete($id){
			if((!isLoggedIn())){                
					redirect('users/login');
			} 
			$registro = $this->filaModel->getRegistroById($id);
			$registrosIguais = $this->filaModel->getRegistroByNomeNascimento($registro->nomecrianca,$registro->nascimento);
			$numRegistros = count($registrosIguais);
			//só permito remover se tem mais de um registro igual
			if($numRegistros > 1){
				try{
						if($this->filaModel->delete($id)){                        
							$json_ret = array(                                            
															'class'=>'success', 
															'message'=>'Registro removido com com sucesso!',
															'error'=>false
															);                     
							
							echo json_encode($json_ret); 
						} else {                        
							throw new Exception('Erro ao gravar os dados!');  
						}      
				} catch (Exception $e) {
					$json_ret = array(
									'class'=>'error',
									'message'=> $e->getMessage(),
									'error'=>true
									);                     
					echo json_encode($json_ret); 
				}
			} else {
				$json_ret = array(
						'classe'=>'alert alert-danger', 
						'message'=>'Ops! Existe apenas um registro para este cadastro.',
						'error'=>$data
						);                     
				echo json_encode($json_ret); 
			}              
		}

		//Arquiva um protocolo
		public function arquiva($id){
			if((!isLoggedIn())){                
					redirect('users/login');
			} 
			$registro = $this->filaModel->getRegistroById($id);
			$registrosIguais = $this->filaModel->getRegistroByNomeNascimento($registro->nomecrianca,$registro->nascimento);
			if(!$numRegistros = count($registrosIguais)){
					$json_ret = array(                                            
							'class'=>'error', 
							'message'=>'Erro ao tentar recuperar o número de registros duplicados!',
							'error'=>true
					);                     

					echo json_encode($json_ret);
					die();
			}
			$userId = getUserId();
			$userName = $this->userModel->getUserById($userId)->name;

			//só permito remover se tem mais de um registro igual
			if($numRegistros > 1){
				try{
					if($this->filaModel->arquiva($id,$userName)){                        
						$json_ret = array(                                            
														'class'=>'success', 
														'message'=>'Registro arquivado com com sucesso!',
														'error'=>false
														);                     
						
						echo json_encode($json_ret); 
					} else {                        
						throw new Exception('Erro tentar arquivar o registro!');  
					}      
				} catch (Exception $e) {
					$json_ret = array(
									'class'=>'error',
									'message'=> $e->getMessage(),
									'error'=>true
									);                     
					echo json_encode($json_ret); 
				}
			} else {
				$json_ret = array(
						'class'=>'error', 
						'message'=>'Ops! Existe apenas um registro para este cadastro.',
						'error'=>true
						);                     
				echo json_encode($json_ret); 
			}              
		}

		public function getRegistro($id){
				$registro = $this->filaModel->getRegistroById($id);
				echo json_encode($registro);
		}

	}
?>
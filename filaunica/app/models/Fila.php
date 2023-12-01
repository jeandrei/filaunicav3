<?php
// Início classe Fila
class Fila {
    private $db;
    private $pag;

    public function __construct(){      
        $this->db = new Database;
    }
        
    // Retorna todos os bairros
    public function getBairros(){
        $this->db->query("SELECT * FROM bairro");
        return $this->db->resultSet();
    }

    // Busca etapa por id
    public function getBairroByid($id){
        $this->db->query('SELECT * FROM bairro WHERE id = :id');
        // Bind value
        $this->db->bind(':id', $id);
        $row = $this->db->single();
        // Check row
        if($this->db->rowCount() > 0){
            return $row->nome;
        } else {
            return false;
        }
    } 

    // Retorna todas as escolas em atividade
    public function getEscolas(){
        $this->db->query("SELECT id, nome FROM escola WHERE emAtividade = 1");
        return $this->db->resultSet();
    }

    // Retorna uma escola a partir do id
    public function getEscolasById($id){
        $this->db->query("SELECT nome FROM escola WHERE id = :id");
        $this->db->bind(':id',$id);
        $row = $this->db->single();  
        if($this->db->rowCount() > 0){
            return $row;
        } else {
            return false;
        }           
    } 

   
    
            
    //retorna se já existe um nome e data de nascimento cadastrado
    public function nomeCadastrado($nome,$nasc){
        
        $sql = "SELECT * FROM fila where nomecrianca = :nomecrianca AND nascimento = :nascimento";

        if($situacoesFicamFila = $this->getSituacaoQueFicamNaFila()){
            $sql .= " AND (";
            foreach($situacoesFicamFila as $key=>$situacao){ 
                if($key == 0) {
                    $sql .= "fila.situacao_id = $situacao->id";
                } else {
                    $sql .= " OR fila.situacao_id = $situacao->id";
                }
            }
            $sql .= ")";
        }  
        $this->db->query($sql);
        $this->db->bind(':nomecrianca',$nome);
        $this->db->bind(':nascimento',$nasc);
        $row = $this->db->single();   
        if($this->db->rowCount() > 0){
            return true;
        } else {
            return false;
        }           
    }
       
    //Valida data de nascimento retorna false se for data maior que data atual e se tem mais de 5 anos
    public function validaNascimento($data){
        $formatado = date('Y-m-d',strtotime($data));
        $ano = date('Y', strtotime($formatado));
        $mes = date('m', strtotime($formatado));
        $dia = date('d', strtotime($formatado));
        $anominimo = date('Y', strtotime('-5 year'));            
            if ( !checkdate( $mes , $dia , $ano )                   // se a data for inválida
                    || $ano < $anominimo                                // ou o ano menor que a data mínima
                    || mktime( 0, 0, 0, $mes, $dia, $ano ) > time() )  // ou a data passar de hoje
                {
                    return false;
                }else{
                    return true;
                }
    }  
    
    // Grava na fila
    public function register($data){  
        $this->db->query('INSERT INTO fila SET                    
                            responsavel = :responsavel,  
                            email = :email, 
                            telefone = :telefone, 
                            celular = :celular, 
                            bairro_id = :bairro_id, 
                            logradouro = :logradouro,
                            numero = :numero, 
                            complemento = :complemento, 
                            nomecrianca = :nomecrianca,
                            nascimento = :nascimento,                                
                            certidaonascimento = :certidaonascimento,
                            opcao1_id = :opcao1_id,
                            opcao2_id = :opcao2_id,
                            opcao3_id = :opcao3_id,
                            opcao_turno = :opcao_turno,                                   
                            cpfresponsavel = :cpfresponsavel,
                            protocolo = :protocolo,                                                   
                            observacao = :observacao,                                
                            deficiencia = :deficiencia         
                        ');
                            
        // Bind values
        $this->db->bind(':responsavel', $data['responsavel']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':telefone', $data['telefone']);
        $this->db->bind(':celular', $data['celular']);
        $this->db->bind(':bairro_id', $data['bairro']);
        $this->db->bind(':logradouro', $data['rua']);        

        if(empty($data['numero'])){
            $this->db->bind(':numero', 0);
        }
        else
        {
            $this->db->bind(':numero', $data['numero']);   
        }
        
        $this->db->bind(':complemento', $data['complemento']);
        $this->db->bind(':nomecrianca', $data['nome']);
        $this->db->bind(':nascimento', $data['nascimento']);            
        $this->db->bind(':certidaonascimento', $data['certidao']);
        $this->db->bind(':opcao1_id', $data['opcao1']);
        $this->db->bind(':opcao2_id', $data['opcao2']);
        $this->db->bind(':opcao3_id', $data['opcao3']);
        $this->db->bind(':opcao_turno', $data['opcao_turno']);             
        $this->db->bind(':cpfresponsavel', $data['cpf']);
        $this->db->bind(':protocolo', $data['protocolo']);        
        $this->db->bind(':observacao', $data['obs']);             
        
        if(isset($data['portador']) && ($data['portador'] == '1'))
        {
            $this->db->bind(':deficiencia', '1');
        }else{
            $this->db->bind(':deficiencia', '0');
        }                
            
        // Execute            
        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }  

    //FUNÇÃO QUE GERA O PROTOCOLO
    public function generateProtocol(){
        $lastid = $this->getLastid();
        $id = $lastid + 1;
        $year = date('Y');           
        $protocol = $id . $year; 
        return $protocol;
    }

    //FUNÇÃO QUE BUSCA OS DADOS DE UM PROTOCOLO
    public function buscaProtocolo($protocolo) {
        $this->db->query("
                            SELECT      
                                fila.registro as registro, 
                                fila.responsavel as responsavel, 
                                fila.nomecrianca as nome, 
                                fila.nascimento as nascimento,
                                fila.protocolo as protocolo,
                                fila.situacao_id as situacao_id,
                                (SELECT descricao FROM situacao WHERE fila.situacao_id = id) as status,
                                (SELECT descricao FROM etapa WHERE fila.nascimento>=data_ini AND fila.nascimento<=data_fin) as etapa
                                    
                            FROM                               
                                fila 
                            WHERE 
                                fila.protocolo=:protocolo
                            "
                        );   
        $this->db->bind(':protocolo', $protocolo);
        $row = $this->db->single(); 
        if($this->db->rowCount() > 0){
            return $row;
        } else {
            return false;
        }  
    }

    // RETORNA O ÚLTIMO ID REGISTRADO NA FILA
    public function getLastid(){
        $this->db->query("SELECT max(id) as id FROM fila");             
        $lastId = $this->db->single();
        return $lastId->id;            
    }

    // RETORNA O ÚLTIMO HISTÓRICO O REGISTRO DA FILA
    public function getLastHistorico($id){
        $this->db->query("SELECT 
                            * 
                            FROM 
                            historico_id_fila 
                            WHERE 
                            fila_id = $id 
                            ORDER BY 
                            registro 
                            DESC 
                            LIMIT 
                            1"
                        );             
        $result = $this->db->single();          
        if($this->db->rowCount() > 0){
            return $result;   
        } else {
            return false;
        }      
    }

    // Retorna a fila de uma etapa
    public function getFilaPorEtapaRelatorio($etapa_id) { 
        $this->db->query("
                SELECT                                           
                    fila.registro as registro, 
                    fila.responsavel as responsavel, 
                    fila.nomecrianca as nome, 
                    fila.nascimento as nascimento,
                    fila.protocolo as protocolo,  
                    (SELECT descricao FROM situacao WHERE fila.situacao_id = id) as status,               
                    (SELECT descricao FROM etapa WHERE fila.nascimento>=etapa.data_ini AND fila.nascimento<=etapa.data_fin) as etapa
                FROM 
                    fila, situacao
                WHERE
                    (SELECT id FROM etapa WHERE fila.nascimento>=etapa.data_ini AND fila.nascimento<=etapa.data_fin) = :etapa_id                     
                AND 
                    fila.situacao_id = situacao.id
                AND 
                    situacao.ativonafila = 1
                ORDER BY
                    fila.registro        
                ");   
        $this->db->bind(':etapa_id', $etapa_id);         
        $result = $this->db->resultSet();     
        //verifica se obteve algum resultado
        if($this->db->rowCount() > 0)
        {
            foreach ($result as $row){
                $aguardando[] = array(
                    "posicao" => $this->buscaPosicaoFila($row->protocolo),
                    "registro" => date('d/m/Y H:i:s', strtotime($row->registro)),
                    "responsavel" => $row->responsavel,
                    "nome" => $row->nome,
                    "nascimento" => date('d/m/Y', strtotime($row->nascimento)), 
                    "etapa" => $row->etapa,
                    "protocolo" => $row->protocolo                        
                );
            }        
        return $aguardando;
        }
        else
        {
            return false;
        } 
    }      
       
    // Retorna a posição na fila de um protocolo
    function buscaPosicaoFila($protocolo) {
        /* SE NÃO TIVER NENHUMA SITUAÇÃO ATIVA NA FILA RETORNO SAF SEM ATIVO NA FILA */
        if(!$this->getSituacaoQueFicamNaFila()){
            return 'SAF - ';
        }
        $this->db->query(' 
        SELECT 
                count(fila.id) as posicao,
                (SELECT situacao.ativonafila FROM situacao, fila WHERE situacao.id = fila.situacao_id AND fila.protocolo = :protocolo) as ativo
            FROM 
                fila, situacao
            WHERE 
                fila.situacao_id = situacao.id
            AND 
                fila.nascimento >= (SELECT etapa.data_ini FROM etapa WHERE etapa.data_ini <= (SELECT fila.nascimento FROM fila WHERE fila.protocolo = :protocolo) AND etapa.data_fin >= (SELECT fila.nascimento FROM fila WHERE fila.protocolo = :protocolo))
            AND 
                fila.nascimento <= (SELECT etapa.data_fin FROM etapa WHERE etapa.data_ini <= (SELECT fila.nascimento FROM fila WHERE fila.protocolo = :protocolo) AND etapa.data_fin >= (SELECT fila.nascimento FROM fila WHERE fila.protocolo = :protocolo))
            AND 
                fila.registro <= (SELECT fila.registro FROM fila WHERE fila.protocolo = :protocolo)
            AND 
                situacao.ativonafila = 1
            AND 
                fila.situacao_id = situacao.id                              
        ');     
        $this->db->bind(':protocolo',$protocolo); 
        $row = $this->db->single();                 
        if($row->ativo == 0){
            return false;
        } elseif($row->ativo == 1 && $row->posicao > 0){
            return $row->posicao . 'º';  
        }else{
            if($row->posicao == 0)
            {
                return "FE";
            }
        }              
    }

    // Retorna um registro da fila a partir do id e não o protocolo
    function buscaFilaById($id) {
        $this->db->query(' 
                            SELECT 
                                    *
                            FROM 
                                    fila
                            WHERE 
                                    fila.id = :id                                                            
    
                        ');    
        $this->db->bind(':id',$id); 
        $row = $this->db->single(); 
        if($this->db->rowCount() > 0){
            return $row;
        } else {
            return false;
        }  
    }

    // Converte o código do turno em texto
    public function getTurno($num){
        if ($num == 1){
            $turno = "Matutino";
        }
        if ($num == 2){
            $turno = "Vespertino";
        }
        if ($num == 3){
            $turno = "Integral";
        }
        return $turno;
    }


    // Atualiza um registro da fila
    public function update($data){             
        $this->db->query('UPDATE fila SET opcao_matricula = :opcao_matricula, situacao_id = :situacao_id, turno_matricula = :turno_matricula WHERE id = :id');
        // Bind values
        $this->db->bind(':id',$data['id']);
        $this->db->bind(':opcao_matricula',$data['opcao_matricula']);            
        $this->db->bind(':situacao_id',$data['situacao_id']);            
        $this->db->bind(':turno_matricula',$data['turno_matricula']); 
        // Execute
        if($this->db->execute()){
            return true;                
        } else {
            return false;
        }
    }

    // Retorna as situações que permanecem ativos na fila Exemplo: Aguardando e Convocado
    public function getSituacaoQueFicamNaFila(){
        $this->db->query('SELECT * FROM situacao s WHERE ativonafila = 1');
        $result = $this->db->resultSet();             
        
        if($this->db->rowCount() > 0){
            return $result;
        } else {
            return false;
        }       
    }
              
    // Retorna a classificação na fila a partir de uma etapa
    public function classificacaoPorEtapa($etapa_id){
        $situacoes = $this->getSituacaoQueFicamNaFila();
        $sql = ' 
                SELECT 
                @rownum := @rownum + 1 as posicao,
                f.registro,
                f.responsavel,
                f.nomecrianca,
                f.nascimento,                                
                f.protocolo                                
                
                FROM 
                        fila f ,
                        (select @rownum := 0) r 
                WHERE 
                        f.nascimento >= (SELECT etapa.data_ini FROM etapa WHERE etapa.id = :etapa_id)
                AND 
                        f.nascimento <= (SELECT etapa.data_fin FROM etapa WHERE etapa.id = :etapa_id)
                                                
        ';
        //pega somente as situações ativonafila = 1
        if($situacoes){
            $sql.= ' AND ';
            foreach($situacoes as $key=>$situacao){
                
                if($key == 0){
                    $sql .= '(f.situacao_id = ' . $situacao->id;
                } else {
                    $sql .= ' OR f.situacao_id = ' . $situacao->id;
                }                      
            }
            
            $sql .= ')';
            
        } else {
            return false;
        }

        $this->db->query($sql);

        $this->db->bind(':etapa_id',$etapa_id);
        $result = $this->db->resultSet(); 
        return $result;  
    }  
         
              

    //FUNÇÃO QUE EXECUTA A SQL PAGINATE
    //quando for para relatório usar getFilaBusca($relatorio=true,$page=NULL,$options)
    public function getFilaBusca($relatorio,$page,$options){            
        $bind = [];      

        // SQL base
        $sql = "SELECT *,  (SELECT descricao FROM etapa WHERE fila.nascimento>=data_ini AND fila.nascimento<=data_fin) as etapa FROM fila";
        $where = ' WHERE 1';
        $order = " ORDER BY registro ASC"; 

        //SE FOR INFORMADO O PROTOCOLO VOU DIRETO PARA O RESULTADO
        if(isset($options['named_params'][':protocolo']) && $options['named_params'][':protocolo'] !== '' && $options['named_params'][':protocolo'] !== 'null'){
            $where .= " AND fila.protocolo = :protocolo";
            array_push($bind,':protocolo');
        } else {
        //SE NÃO FOR INFORMADO O PROTOCOLO MONTO A SQL            
            if(($options['named_params'][':situacao_id']) == "FE"){
                // pego as situações que o cadastro permanece na fila
                $situacoes = $this->getSituacaoQueFicamNaFila();            
                //monto a sql com base nas situações que permanece na fila
                if($situacoes){                        
                    foreach($situacoes as $key=>$situacao){
                        
                        if($key == 0){
                            $where .= " AND (fila.situacao_id = " . $situacao->id;
                        } else {
                            $where .= " OR fila.situacao_id = " . $situacao->id;
                        }                      
                    }                    
                    $where .= ") AND (SELECT descricao FROM etapa WHERE fila.nascimento>=data_ini AND fila.nascimento<=data_fin) IS NULL";
                    //se nenhuma situação permanece na fila o que é só em casos de testes ou início da implantação do sistema, eu busco por situação id = null que não vai ter nenhum registro, se ninguém fica na fila não posso mostrar ninguém no caso de nenhuma situação for ativa na fila
                }
            }

            //SE FOI INFORMADO O NOME
            if(isset($options['named_params'][':nome']) && $options['named_params'][':nome'] !== '' && $options['named_params'][':nome'] !== 'null'){
                $where .= " AND nomecrianca LIKE CONCAT('%',:nome,'%')";
                array_push($bind,':nome');
            }
            //SE FOR INFORMADO A ETAPA                
            if(isset($options['named_params'][':etapa_id']) && $options['named_params'][':etapa_id'] !== '' && $options['named_params'][':etapa_id'] !== 'null'){
                $where .= " AND (SELECT id FROM etapa WHERE fila.nascimento>=etapa.data_ini AND fila.nascimento<=etapa.data_fin) = :etapa_id";
                array_push($bind,':etapa_id');
            }
            //SE FOR INFORMADO A ESCOLA  
            if(
                isset($options['named_params'][':escola_id']) &&
                $options['named_params'][':escola_id'] !== 'null' && 
                $options['named_params'][':escola_id'] !== '' && 
                $options['named_params'][':situacao_id'] !== 'FE'                    
            )
            {   $where .= " AND (opcao1_id = :escola_id";
                $where .= " OR opcao2_id = :escola_id";
                $where .= " OR opcao3_id = :escola_id".")";
                $order = " ORDER BY registro, opcao1_id ASC"; 
                array_push($bind,':escola_id');
            } 
            /* SE FOR INFORMADO A SITUAÇÃO */
            if(
                isset($options['named_params'][':situacao_id']) && 
                ($options['named_params'][':situacao_id']) !== 'null' && 
                ($options['named_params'][':situacao_id']) !== '' 
                && $options['named_params'][':situacao_id'] !== "FE"
            )  
            {
                $where .= " AND situacao_id = :situacao_id";
                array_push($bind,':situacao_id');
            } 
        }
        //FIM SE NÃO FOR INFORMADO O PROTOCOLO MONTO A SQL

            //monta a sql        
        $sql .= $where .$order;            
        
        //TENTA EXECUTAR A PAGINAÇÃO 
        try
        {
            $this->pag = new Pagination($page,$sql,$options);  
        }
        catch(paginationException $e)
        {
            echo $e;
            exit();
        }
        
        
        if($relatorio == false){
            /**BIND VALUES */  
            foreach($bind as $row){
                $this->pag->bindParam($row, $options['named_params'][$row], PDO::PARAM_STR, 12); 
            }               
            //EXECUTA A PAGINAÇÃO
            $this->pag->execute();
            //RETORNA A PAGINAÇÃO            
            return $this->pag;   
        } else { 
            $this->db->query($sql);
            /**BIND VALUES */
            foreach($bind as $row){
                $this->db->bind($row, $options['named_params'][$row]);
            }     
            $result = $this->db->resultSet();                 
            return  $result;
        }        
        
    }//public function getFilaBusca  
        
    // Retorna as matrículas feitas em um determinado ano e mês
    public function getMatriculadosAnoMes($ano, $mes){
        $this->db->query('
                        SELECT 
                            f.id as id, 
                            f.responsavel, 
                            f.telefone, 
                            f.celular, 
                            f.nomecrianca, 
                            f.protocolo, 
                            f.nascimento,
                            f.turno_matricula,
                            f.opcao_matricula,
                            hif.id as id_historico,
                            hif.fila_id,
                            hif.registro,
                            hif.situacao_id,
                            hif.historico 
                        FROM 
                            fila f, 
                            historico_id_fila hif  
                        WHERE 
                            hif.fila_id = f.id 
                            AND 
                            YEAR(hif.registro) = :ano
                        AND 
                            MONTH(hif.registro) = :mes
                        AND 
                            hif.situacao_id = 2
                        AND 
                            hif.id = (SELECT MAX(id) FROM historico_id_fila WHERE fila_id = f.id)
                        ORDER BY 
                            f.nascimento    
                        ');
        $this->db->bind(':ano',$ano);
        $this->db->bind(':mes',$mes);
        $result = $this->db->resultSet(); 
        return $result;
    }

    // Retorna os cadastros aguardando em ordem alfabética
    public function getAguardandoAlfabetica(){
        $this->db->query('
                        SELECT
                            f.registro, 
                            f.protocolo,
                            f.responsavel, 
                            f.telefone, 
                            f.celular, 
                            f.nomecrianca, 
                            f.protocolo, 
                            f.nascimento,
                            f.opcao_turno, 
                            f.opcao1_id,
                            f.opcao2_id,
                            f.opcao3_id
                        FROM 
                            fila f                                  
                        WHERE 
                            f.situacao_id = 1
                        ORDER BY 
                            f.nomecrianca ASC
                        ');           
        $result = $this->db->resultSet(); 
        return $result;
    }       

    // Retorna a demanda de uma escola
    public function getDemandaEscola($escola_id){            
        $sql = 'SELECT * FROM fila f WHERE f.situacao_id = 1';        
        if($escola_id <> "Todos"){
            $sql.= ' AND f.opcao1_id = :escola_id';
        }
        $sql.= ' ORDER BY f.nascimento';  
        $this->db->query($sql);        
        if($escola_id <> "Todos"){
            $this->db->bind(':escola_id',$escola_id);
        }         
        $result = $this->db->resultSet(); 
        return $result;
    }

    // RETORNA O TOTAL DE DEMANDA OPÇÃO1 DE UMA ESCOLA
    public function getDemandaOpcao1Rel($escola_id){           
        $sql = 'SELECT COUNT(id) as total FROM fila f WHERE f.situacao_id = 1';
        if($escola_id <> "Todos"){
            $sql.= ' AND f.opcao1_id = :escola_id';
        }                    
        $this->db->query($sql);        
        if($escola_id <> "Todos"){
            $this->db->bind(':escola_id',$escola_id);
        }         
        $count = $this->db->single();
        return $count;            
    }

    /*  Retorna a demanda de uma escola a partir da opção informada no cadastro. exemplo todos os registros onde foi selecionado como opção 01 a escola Anjos */
    public function getDemandaOpcaoEscola($escola_id, $opcao){ 
        if($opcao == 1){
            $this->db->query('SELECT COUNT(id) as total FROM fila WHERE situacao_id = 1 AND opcao1_id = :escola_id');
        }

        if($opcao == 2){
            $this->db->query('SELECT COUNT(id) as total FROM fila WHERE situacao_id = 1 AND opcao2_id = :escola_id');
        }

        if($opcao == 3){
            $this->db->query('SELECT COUNT(id) as total FROM fila WHERE situacao_id = 1 AND opcao3_id = :escola_id');
        }       
        
        $this->db->bind(':escola_id',$escola_id);            

        $count = $this->db->single();
        return $count;            
    }

    // Retorna os alunos especiais de uma escola
    public function getAlunoEspecialEscola($escola_id){            
        $sql = 'SELECT * FROM fila f WHERE f.situacao_id = 1 AND f.deficiencia = 1';        
        if($escola_id <> "Todos"){
            $sql.= ' AND (f.opcao1_id = :escola_id OR f.opcao2_id = :escola_id OR f.opcao3_id = :escola_id)';
        }
        $sql.= ' ORDER BY f.nascimento';
        $this->db->query($sql);        
        if($escola_id <> "Todos"){
            $this->db->bind(':escola_id',$escola_id);
        }         
        $result = $this->db->resultSet(); 
        return $result;
    }     

    // Grava as observações do admin
    public function gravaObsAdmin($id,$data){                    
        $this->db->query('UPDATE fila SET fila.obs_admin = :obs_admin WHERE id=:id');
        $this->db->bind(':id',$id); 
        $this->db->bind(':obs_admin',$data);                        
        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }

    // Retorna cadastros que tem registro duplicado
    public function getDuplicados(){
        $situacoes = $this->getSituacaoQueFicamNaFila();
        $sql = "SELECT 		
                        f.nomecrianca ,
                        COUNT(f.nomecrianca) AS nRep,
                        f.nascimento ,
                        COUNT(f.nascimento) 
                FROM 
                        fila f ";
        //pega somente as situações ativonafila = 1
        if($situacoes){
            $sql.= ' WHERE ';
            foreach($situacoes as $key=>$situacao){
                
                if($key == 0){
                    $sql .= '(f.situacao_id = ' . $situacao->id;
                } else {
                    $sql .= ' OR f.situacao_id = ' . $situacao->id;
                }                      
            }
            
            $sql .= ')';        
        }
        $sql .= " GROUP BY
                        f.nomecrianca ,
                        f.nascimento 
                HAVING 
                        COUNT(f.nomecrianca) > 1 
                AND
                        COUNT(f.nascimento) > 1" ;
        
        $this->db->query($sql); 
        $result = $this->db->resultSet();           
        if($this->db->rowCount() > 0){
            return $result;
        } else {
            return false;
        }
    }

    // Retorna um registro a partir do nome e data de nascimento
    public function getRegistroByNomeNascimento($nome, $nascimento){
        
        // Verifico se existe a situação Arquivado
        if(!$this->existeSitArquivado()){
            // Se não existe eu crio ela
            if(!$this->criaSitArquivado()){
                return false;
            }
        }

        if(!$idSitArquivado = $this->getIdSitArquivado()){
            return false;
        }
        $this->db->query("SELECT 
                                f.id as id,
                                f.protocolo,
                                f.nomecrianca,
                                f.nascimento,
                                f.responsavel,
                                f.cpfresponsavel,
                                f.logradouro,
                                f.registro,
                                f.celular,
                                s.descricao
                        FROM 
                                fila f,
                                situacao s
                        WHERE 
                                f.situacao_id = s.id
                        AND
                                f.nomecrianca = :nome
                        AND 	
                                f.nascimento = :nascimento
                        AND 
                                f.situacao_id != $idSitArquivado
                        ORDER BY 
                                f.registro
                        ASC");
        // Bind value
        $this->db->bind(':nome', $nome);
        $this->db->bind(':nascimento', $nascimento);
        $result = $this->db->resultSet();           
        if($this->db->rowCount() > 0){
            return $result;
        } else {
            return false;
        }
    }

    // Deleta um registro da fila
    public function delete($id){        
        $this->db->query('DELETE from fila WHERE id=:id');
        $this->db->bind(':id',$id);                                         
        if($this->db->execute()){
            return true;
        } else {
            return false;
        } 
    }

    // Verifica se existe a situação arquivado
    public function existeSitArquivado(){
        $sql = "SELECT * FROM situacao WHERE descricao = 'Arquivado'";
        $this->db->query($sql);  
        $result = $this->db->single();
        if($this->db->rowCount() > 0){
            return true;
        } else {
            return false;
        }        
    }

    // Cria a situação arquivado na tabela situação
    public function criaSitArquivado(){
        $this->db->query("INSERT INTO situacao (descricao, cor) VALUES ('Arquivado', '#A9A9A9')");  // Execute
        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }

    // Retorna o id da situação arquivado
    public function getIdSitArquivado(){
        $this->db->query("SELECT id FROM situacao WHERE descricao = 'Arquivado'");          
        $row = $this->db->single();   
        if($this->db->rowCount() > 0){
            return $row->id;
        } else {
            return false;
        } 
    }

    // Altera um registro no banco para arquivado
    public function setToArquivado($id){        
        // Verifico se existe a situação Arquivado
        if(!$this->existeSitArquivado()){
            // Se não existe eu crio ela
            if(!$this->criaSitArquivado()){
                return false;
            }
        }

        if(!$idSitArquivado = $this->getIdSitArquivado()){
            return false;
        }

        $this->db->query("UPDATE fila SET situacao_id = $idSitArquivado WHERE id = :id");
        // Bind values
        $this->db->bind(':id',$id);            
        // Execute
        if($this->db->execute()){
            return true;                
        } else {
            return false;
        }
    }

    //Atualiza o histórico do registro para ficar registrado quando o registro foi arquivado
    public function setHistoricoArquivado($id,$userName){        
        if(!$idSitArquivado = $this->getIdSitArquivado()){
            return false;
        }
        $this->db->query("INSERT INTO historico_id_fila (fila_id,usuario,situacao_id,historico) VALUES ($id,'$userName',$idSitArquivado,'Arquivado através da analise de registros duplicados')");
        // Bind values
        $this->db->bind(':id',$id);            
        // Execute
        if($this->db->execute()){
            return true;                
        } else {
            return false;
        }
    }

    // Arquiva um registro da fila
    public function arquiva($id,$userName){            
        if(!$this->setToArquivado($id)){
            return false;
        } else {
            if(!$this->setHistoricoArquivado($id,$userName)){
                return false;
            } else {
                return true;
            }
        }   
    }    


    // Retorna um registro a partir do id
    public function getRegistroById($id){
        $sql = 'SELECT * FROM fila f WHERE id = :id';
        $this->db->query($sql);            
        $this->db->bind(':id',$id);
        $result = $this->db->single();
        return $result;
    }
}
// Fim classe Fila

    //DESATIVEI PARA VER ACHO QUE NÃO PRECISA
    //FUNÇÃO QUE EXECUTA A SQL PAGINATE
    /* public function getFilaTodos($page, $options){              
        $paginate = new pagination($page, "SELECT * FROM fila ORDER BY id", $options);
        return  $paginate;
    }  */
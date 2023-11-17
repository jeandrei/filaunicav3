<nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark md-3" style="margin-bottom:10px;">
    <div class="container">
        
        <a class="navbar-brand" href="<?php echo URLROOT; ?>/pages/sistem"><?php echo SITENAME; ?></a>
        
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
          
              <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                      <a class="nav-link" href="<?php echo URLROOT; ?>/pages/sistem">Início</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="<?php echo URLROOT; ?>/pages/about">Sobre</a>
                    </li>

                    
                    <?php if(isAdmin() || isUser() || isSec()) : ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownPortfolio" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        CEI
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownPortfolio">
                          <a class="dropdown-item" href="<?php echo URLROOT; ?>/escolavagas">Quadro de Vagas</a>
                        </div>
                    </li>
                  <?php endif; ?> 
                    

                  <?php if(isAdmin() || isUser()) : ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownPortfolio" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Registros
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownPortfolio">
                          <a class="dropdown-item" href="<?php echo URLROOT; ?>/admins">Fila de Espera</a> 
                          <a class="dropdown-item" href="<?php echo URLROOT; ?>/listaunidades">Lista de Unidades</a> 
                          <a class="dropdown-item" href="<?php echo URLROOT; ?>/admins/analiseDeRegistrosDuplicados">Análise de Registros Duplicados</a>
                        </div>
                    </li>
                  <?php endif; ?> 

                  <?php if(isAdmin() || isUser()) : ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownPortfolio" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Relatórios
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownPortfolio">
                          <a class="dropdown-item" href="<?php echo URLROOT; ?>/admins/relatorioMensal">Relatorio de Matrículas Mensal</a> 
                          
                          <a class="dropdown-item" href="<?php echo URLROOT; ?>/admins/relatorioDemanda">Relatorio de Demanda por Unidade</a>                                                            
                          <a class="dropdown-item" href="<?php echo URLROOT; ?>/admins/relatorioAlunoEspecial">Relatorio de Alunos Especiais</a>
                          
                          <a class="dropdown-item" href="<?php echo URLROOT; ?>/admins/relatorioAguardandoAlfabetica" target="_blank">Relatorio Aguardando Alfabética</a>
                          
                          <a class="dropdown-item" href="<?php echo URLROOT; ?>/admins/relatorioQuadrodeVagas" target="_blank">Quadro de Vagas</a>
                        </div>
                      </li>
                  <?php endif; ?>  
                            

                <!--FAZ A VERIFICAÇÃO SE O USUÁRIO É ADMINISTRADOR, SE SIM CARREGA OS MENUS DE CADASTRO-->
                  <?php if(isAdmin()) : ?>           
                      <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownPortfolio" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Cadastros
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownPortfolio">
                          <a class="dropdown-item" href="<?php echo URLROOT; ?>/users">Usuários</a>
                          <a class="dropdown-item" href="<?php echo URLROOT; ?>/etapas">Etapas</a> 
                          <a class="dropdown-item" href="<?php echo URLROOT; ?>/situacoes">Situações</a>
                          <a class="dropdown-item" href="<?php echo URLROOT; ?>/escolas">Unidades</a>                                  
                        </div>
                      </li>
                  <?php endif; ?>         
              
              
              </ul>


              <ul class="navbar-nav ml-auto">
                  <?php if(isset($_SESSION[DB_NAME . '_user_id'])) : ?>
                    <li class="nav-item">
                      <a class="nav-link" href="#">Bem vindo <?php echo $_SESSION[DB_NAME . '_user_name']; ?></a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="<?php echo URLROOT; ?>/users/logout">Sair</a>
                    </li>
                  <?php else : ?>          
                    <li class="nav-item">                      
                    </li> 
                    <li class="nav-item">                      
                    </li>
                  <?php endif; ?>         
              </ul>

        </div>
    </div>
</nav>
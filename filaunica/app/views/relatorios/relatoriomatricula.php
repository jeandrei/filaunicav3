<?php

require APPROOT . '/views/inc/fpdf/fpdf.php'; 



class PDF extends FPDF
{            
            
            // Page header
            function Header()
            {   $currentdate = date("d-m-Y");
                // Logo
                $this->Image(APPROOT . '/views/inc/logo.png',10,6,110);
                // Date
                $this->SetFont('Arial','B',10); 
                $this->Cell(120);
                $this->Cell(60,10, utf8_decode('Data de impressão: ' . $currentdate),0,0,'C');
                // Arial bold 15
                $this->SetFont('Arial','B',15);    
                // Title
                $this->Ln(20);
                // Move to the right
                $this->Cell(80);                
                $this->Cell(30,10, utf8_decode("PROTOCOLO DE VAGA PARA EDUCAÇÃO INFANTIL"),0,0,'C');
                // Line break
                $this->Ln(10);                
            }

            // Page footer
            function Footer()
            {
                // Position at 1.5 cm from bottom
               // $this->SetY(-25);
                // Arial italic 8
                //$this->SetFont('Arial','I',8);
                // Page number
               // $this->Cell(0,10,utf8_decode('Página ').$this->PageNo(),0,0,'C');
            }
}

            // Instanciation of inherited class
            $pdf = new PDF();   
            $pdf->SetFont('Arial','',8);                        

                //se $data é falso não tem dados para emitir
                if($data == false){
                    $error = "Sem dados para emitir!";                   
                }
                // caso contrário monta o relatório
                else
                {
                     $error = "";
                     //adiciona uma nova pagina                     
                     $pdf->AddPage('P');                                          

                     $pdf->SetFont('Arial','',18); 
                     $pdf->Cell(70,10,utf8_decode("Protocolo: "),0,0,'R');      
                     $pdf->Cell(120,10,utf8_decode($data["protocolo"]),0,0,'L');
                     $pdf->Ln(); 
                     $pdf->SetFont('Arial','',14); 
                     $pdf->Cell(70,10,utf8_decode("Unidade de encaminhamento: "),0,0,'R');  
                     $pdf->Cell(120,10,utf8_decode($data["unidade_matricula"]),0,0,'L');                     
                     
                     $pdf->Ln();
                     
                     $pdf->SetFont('Arial','',12);
                     $pdf->Cell(45,10,utf8_decode("Nome da Criança: "),1,0,'R');      
                     $pdf->Cell(150,10,utf8_decode($data["nomecrianca"]),1,0,'L');

                     $pdf->Ln();
                     $pdf->Cell(45,10,utf8_decode("Nascimento: "),1,0,'R');     
                     $pdf->Cell(25,10,utf8_decode($data["nascimento"]),1,0,'L');  
                     $pdf->Cell(25,10,utf8_decode("Etapa: "),1,0,'R');      
                     $pdf->Cell(50,10,utf8_decode($data["etapa"]),1,0,'L');
                     $pdf->Cell(20,10,utf8_decode("Turno: "),1,0,'R');      
                     $pdf->Cell(30,10,utf8_decode($data["turno_descricao"]),1,0,'L');
                     
                     $pdf->Ln();  
                     $pdf->Cell(45,10,utf8_decode("Responsável: "),1,0,'R');      
                     $pdf->Cell(150,10,utf8_decode($data["responsavel"]),1,0,'L');

                     $pdf->Ln();  
                     $pdf->Cell(45,10,utf8_decode("Endereço: "),1,0,'R');      
                     $pdf->Cell(150,10,utf8_decode($data["logradouro"] . ", " . $data["numero"] . ", " . $data["bairro"]),1,0,'L');
                    
                     $pdf->Ln();  
                     $pdf->Cell(45,10,utf8_decode("E-mail: "),1,0,'R');      
                     $pdf->Cell(150,10,utf8_decode($data["email"]),1,0,'L');

                     $pdf->Ln();  
                     $pdf->Cell(45,10,utf8_decode("Telefone: "),1,0,'R');      
                     $pdf->Cell(50,10,utf8_decode($data["telefone"]),1,0,'L');                     
                     $pdf->Cell(50,10,utf8_decode("Celular: "),1,0,'R');      
                     $pdf->Cell(50,10,utf8_decode($data["celular"]),1,0,'L');


                     $pdf->Ln();  
                     $pdf->Cell(45,10,utf8_decode("Recebeu da SEDUC: "),1,0,'R'); 
                     
                     $pdf->Cell(150,10,utf8_decode('(   ) Uniforme (   ) Mochila  (   ) Agenda Escolar'),1,0,'L');

                     
                     
                     $pdf->Ln();  
                     $pdf->Cell(45,10,utf8_decode("Aluno especial: "),1,0,'R');   
                     
                     $pdf->Cell(150,10,utf8_decode($data["deficiencia"]),1,0,'L');
                     
                     
                     $pdf->Ln();  
                     $pdf->Cell(95,10,utf8_decode("Usuário responsável pelo encaminhamento: "),1,0,'R');      
                     $pdf->Cell(100,10,utf8_decode($data["usuario"]),1,0,'L');
                        
                     $pdf->Ln();
                     $pdf->SetFont('Arial','',12);
                     $pdf->Cell(195,5,utf8_decode("Documentos para Matrícula: "),0,0,'L');
                     $pdf->Ln(); 
                     $pdf->SetFont('Arial','',10);
                     $pdf->Cell(195,5,utf8_decode("-Cópia da certidão de nascimento do aluno;"),0,0,'L'); 
                     $pdf->Ln(); 
                     $pdf->Cell(195,5,utf8_decode("-Cópia do comprovante de residência atualizado (somente talão do IPTU, fatura de água ou energia);"),0,0,'L'); 
                     $pdf->Ln(); 
                     $pdf->Cell(195,5,utf8_decode("-Declaração de vacinação em dia (levar a carteirinha de vacinação até a Unidade de Saúde"),0,0,'L');  
                     $pdf->Ln(); 
                     $pdf->Cell(195,5,utf8_decode("mais próxima para retirar esta declaração);"),0,0,'L');  
                     
                     $pdf->Ln(); 
                     $pdf->Cell(195,5,utf8_decode("-Carteira, contrato ou declaração de trabalho dos pais ou responsáveis pela criança(se estiver trabalhando);"),0,0,'L'); 
                     $pdf->Ln(); 
                     $pdf->Cell(195,5,utf8_decode("-Cópia dos documentos dos pais ou responsáviel (RG, CPF e Título de Eleitor);"),0,0,'L'); 
                     $pdf->Ln(); 
                     $pdf->Cell(195,5,utf8_decode("-Cartão ou carteira de benefício (Bolsa Família), quando a família é beneficiária;"),0,0,'L'); 
                     $pdf->Ln(); 
                     $pdf->Cell(195,5,utf8_decode("-Para aluno com necessidade nutricional específica (alergia, intolerância e outras) apresentar o diagnóstico médico;"),0,0,'L'); 
                     $pdf->Ln(); 
                     $pdf->Cell(195,5,utf8_decode("-Para o aluno com deficiência, transtorno de espectro autista, altas habilidades ou superdotação,"),0,0,'L'); 
                     $pdf->Ln(); 
                     $pdf->Cell(195,5,utf8_decode("deverão apresentar laudo médico."),0,0,'L');
                     $pdf->Ln(); 
                                       
                     $pdf->SetFont('Arial','B',10);  
                     $pdf->Cell(195,5,utf8_decode("DECLARAÇÃO"),0,0,'C');
                     $pdf->Ln(); 
                     $pdf->SetFont('Arial','',10);  
                     $pdf->Cell(195,5,utf8_decode("Declaro que as informações são verdadeiras e estou ciente de que a omissão de informações ou a"),0,0,'L');
                     $pdf->Ln(); 
                     $pdf->Cell(195,5,utf8_decode("apresentação de dados ou documentos falsos e/ou divergentes implicam em perda da matrícula no"),0,0,'L');
                     $pdf->Ln(); 
                     $pdf->Cell(195,5,utf8_decode("Plano de ampliação do período integral e em crime de falsidade ideológica, conforme Código Penal."),0,0,'L');
                     $pdf->Ln(); 
                     $pdf->Cell(195,5,utf8_decode("- Decreto-Lei nº 2.848, de 7 de dezembro de 1940. O crime de falsidade ideológica foi instituído"),0,0,'L');
                     $pdf->Ln(); 
                     $pdf->Cell(195,5,utf8_decode("no art. 299 do Código Penal e refere-se à omissão e alteração de documentos, públicos e privados,"),0,0,'L');
                     $pdf->Ln(); 
                     $pdf->Cell(195,5,utf8_decode("com o intuito de obter qualquer tipo de vantagem."),0,0,'L');
                     $pdf->Ln(); 
                     $pdf->Cell(195,5,utf8_decode("Autorizo a visitação ao endereço para confirmar residência e domicílio."),0,0,'L');
                     $pdf->Ln(); 
                     $pdf->Cell(195,5,utf8_decode(""),0,0,'L');
                    
                                       
                     
                     $pdf->Ln(); 
                     $pdf->Cell(195,5,utf8_decode("Observações: Este protocolo tem validade somente até o dia           /          /" . date("Y")),0,0,'L');
                       
                     $pdf->Ln();  
                     $pdf->Cell(190,10,utf8_decode("________________________________________________ "),0,0,'C');  
                     $pdf->Ln();    
                     $pdf->Cell(190,10,utf8_decode("Assinatura"),0,0,'C');
                }   


            if($error == "" && $pdf->Output())
            {
                $pdf->Output();  
            }
            else{
                $data['erro'] = $error;
                $this->view('relatorios/erroAoGerarRelatorio',$data);
                
            }            
?>


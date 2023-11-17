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
                $this->Cell(260,10, utf8_decode('Data de impressão: ' . $currentdate),0,0,'C');
                // Arial bold 15
                $this->SetFont('Arial','B',15);    
                // Title
                $this->Ln(20);
                // Move to the right
                $this->Cell(120);
                $this->Cell(30,10, utf8_decode("Relatório de Alunos Especiais"),0,0,'C');
                // Line break
                $this->Ln(20);                
            }

            // Page footer
            function Footer()
            {
                // Position at 1.5 cm from bottom
                $this->SetY(-15);
                // Arial italic 8
                $this->SetFont('Arial','I',8);
                // Page number
                $this->Cell(0,10,utf8_decode('Página ').$this->PageNo(),0,0,'C');
            }
}

            // Instanciation of inherited class
            $pdf = new PDF();
            //$pdf->AliasNbPages();
            $pdf->SetFont('Times','',12);
            //$pdf = new FPDF();
            //AddPage('P') RETRATO AddPage('L') PAISAGEM
            //$pdf->AddPage('L');            
            $pdf->SetFont('Arial','B',8);
            $colunas =array("Nº","Nome da Criança", "Nasc", "Responsável","Contato", "Etapa", "Turno", "Opção 1", "Opção 2", "Opção 3");
            //largura das colunas
            $larguracoll = array(1 => 10, 2 => 55, 3 => 15, 4 => 55, 5 => 20, 6 => 20, 7 => 15, 8 => 31, 9 => 31, 10 => 31);

            $tam_fonte = 10;    
                        
               

                //se $data é falso não tem dados para emitir
                if($data == false){
                    $error = "Sem dados para emitir!";                   
                }
                // caso contrário monta o relatório
                else
                {
                     $error = "";
                     //adiciona uma nova pagina
                     $pdf->AddPage('L');
                                      
                     $i=0;
                     
                     //coloca as colunas com os títulos da tabela
                     foreach($colunas as $coluna){
                         $i++;
                         $pdf->SetFont('Arial','B',7);                   
                         $pdf->Cell($larguracoll[$i],$tam_fonte,utf8_decode($coluna),1);
                     }
                    
                     $contador = 0;
                     foreach($data as $row) { 
                         $contador++;      
                         $pdf->SetFont('Arial','',7);  
                         $pdf->Ln();    
                         $pdf->Cell($larguracoll[1],$tam_fonte,utf8_decode($contador),1,0,'C');                      
                         $pdf->Cell($larguracoll[2],$tam_fonte,utf8_decode($row["nomecrianca"]),1,0,'C');
                         $pdf->Cell($larguracoll[3],$tam_fonte,utf8_decode($row["nascimento"]),1,0,'C'); 
                         $pdf->Cell($larguracoll[4],$tam_fonte,utf8_decode($row["responsavel"]),1,0,'C'); 
                         if($row["celular"]){
                            $pdf->Cell($larguracoll[5],$tam_fonte,utf8_decode($row["celular"]),1,0,'C');
                         } elseif ($row["telefone"]){
                            $pdf->Cell($larguracoll[5],$tam_fonte,utf8_decode($row["telefone"]),1,0,'C');

                         } else {
                            $pdf->Cell($larguracoll[5],$tam_fonte,utf8_decode("Sem Contato"),1,0,'C');
                         }                                          
                         $pdf->Cell($larguracoll[6],$tam_fonte,utf8_decode($row["etapa"]),1,0,'C');
                         $pdf->Cell($larguracoll[7],$tam_fonte,utf8_decode($row["opcao_turno"]),1,0,'C');
                         $pdf->Cell($larguracoll[8],$tam_fonte,utf8_decode($row["opcao1_id"]),1,0,'C'); 
                         $pdf->Cell($larguracoll[9],$tam_fonte,utf8_decode($row["opcao2_id"]),1,0,'C'); 
                         $pdf->Cell($larguracoll[10],$tam_fonte,utf8_decode($row["opcao3_id"]),1,0,'C'); 
                         
                        
                     }  
                    
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


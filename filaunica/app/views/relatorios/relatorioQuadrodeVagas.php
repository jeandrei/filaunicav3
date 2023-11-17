<?php

require APPROOT . '/views/inc/fpdf/fpdf.php'; 

//die(var_dump($data));

/* $contador = 0;
foreach($data as $row){
    var_dump($row["quadroVagas"][$contador]->descricao);
    echo("<hr>");
    $contador++;
}
die(); */


//$numEscolas = ((count($data)));

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
                $this->Cell(30,10, utf8_decode("Relatório de Quadro de Vagas"),0,0,'C');
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
            $colunas =array("Escola", "Etapa", "Matutino","Vespertino", "Integral");
            //largura das colunas
            //$larguracoll = array(1 => 80, 2 => 80, 3 => 20, 4 => 25, 5 => 25, 6 => 30);
            $larguracoll = array(1 => 150, 2 => 50, 3 => 20, 4 => 20, 5 => 20);

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
                         $pdf->SetFont('Arial','B',10);                   
                         $pdf->Cell($larguracoll[$i],$tam_fonte,utf8_decode($coluna),1);
                     }
                    
                                          
                        foreach($data as $row) {                             
                            $pdf->SetFont('Arial','',$tam_fonte);  
                            $pdf->Ln();                          
                            $pdf->Cell($larguracoll[1],$tam_fonte,utf8_decode($row["escola"]),1,0,'C'); 
                             $pdf->Cell($larguracoll[2],$tam_fonte,utf8_decode($row["etapa"]),1,0,'C');                          
                            $pdf->Cell($larguracoll[3],$tam_fonte,utf8_decode($row["matutino"]),1,0,'C');   
                            $pdf->Cell($larguracoll[4],$tam_fonte,utf8_decode($row["vespertino"]),1,0,'C');                   
                            $pdf->Cell($larguracoll[5],$tam_fonte,utf8_decode($row["integral"]),1,0,'C'); 
                            
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


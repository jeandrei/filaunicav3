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
                $this->Cell(30,5, utf8_decode("Protocolo de inscrição"),0,0,'C');
                // Line break
                $this->Ln(5);                
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
            
            //adiciona uma nova pagina
            $pdf->AddPage('P');

            //imprime o protocolo
            $pdf->Cell(80);
            $pdf->Cell(30,10,utf8_decode($data["protocolo"]),0,0,'C');
            $pdf->Ln(20);  

            //define as colunas de cabeçalho
            $pdf->SetFont('Arial','B',8);
            $colunas =array("Posição","Nome da Criança", "Nascimento", "Etapa","Turno");
            //largura das colunas
            $larguracoll = array(1 => 15, 2 => 100, 3 => 20, 4 => 35, 5 => 20);

            $tam_fonte = 10;  
               

            //se $data é falso não tem dados para emitir
            if($data == false){
              $error = "Sem dados para emitir!";                   
            }
            // caso contrário monta o relatório
            else
            {
              $error = ""; 
                  
              //coloca as colunas com os títulos da tabela
              foreach($colunas as $coluna){
                  $i++;
                  $pdf->SetFont('Arial','B',9);                   
                  $pdf->Cell($larguracoll[$i],$tam_fonte,utf8_decode($coluna),1,0,'C');
              }
                
              //dados de da tabela      
              $pdf->SetFont('Arial','',9);  
              $pdf->Ln();            
              $pdf->Cell($larguracoll[1],$tam_fonte,utf8_decode($data["posicao"]),1,0,'C');
              $pdf->Cell($larguracoll[2],$tam_fonte,utf8_decode($data["nome"]),1,0,'C'); 
              $pdf->Cell($larguracoll[3],$tam_fonte,utf8_decode(formatadata($data["nascimento"])),1,0,'C');
              $pdf->Cell($larguracoll[4],$tam_fonte,utf8_decode($data['desc_etapa']->descricao),1,0,'C');                
                
              //switch para imprimir o turno ao invés do código
              switch ($data['opcao_turno']) {
                case 1:
                    $turno = "Matutino";
                    break;
                case 2:
                    $turno = "Vespertino";
                    break;
                case 3:
                    $turno = "Integral";
                    break;
              }
                
              $pdf->Cell($larguracoll[5],$tam_fonte,utf8_decode($turno),1,0,'C');                  
            }
            $pdf->SetFont('Arial','B',12);  
            $pdf->Ln(20);
            $pdf->Cell(60);
            $pdf->Cell(80,10,utf8_decode('Unidades escolares de preferência:'),0,0,'C');

            $pdf->SetFont('Arial','',12); 

            //Se foi selecionado a unidade 1
            if($data['unidade1']){                
              $pdf->Ln(10);
              $pdf->Cell(60);
              $pdf->Cell(80,10,utf8_decode($data['unidade1']->nome),0,0,'C');              
            }

            //Se foi selecionado a unidade 2
            if($data['unidade2']){                
              $pdf->Ln(10);
              $pdf->Cell(60);
              $pdf->Cell(80,10,utf8_decode($data['unidade2']->nome),0,0,'C');              
            }

            //Se foi selecionado a unidade 3
            if($data['unidade3']){                
              $pdf->Ln(10);
              $pdf->Cell(60);
              $pdf->Cell(80,10,utf8_decode($data['unidade3']->nome),0,0,'C');              
            }
            


            $pdf->Ln(20); 
            $pdf->SetFont('Arial','',10);
            $pdf->Cell(195,5,utf8_decode("Quando da disponibilidade de uma vaga para a sua solicitação e respeitando a ordem de inscrição, a Secretaria de"),0,0,'L');

            $pdf->Ln();
            $pdf->Cell(195,5,utf8_decode("Educação entrará em contato para o processo de matrícula do aluno."),0,0,'L');

            $pdf->Ln();
            $pdf->Cell(195,5,utf8_decode("Dúvidas podem ser sanadas nos telefones: (47) 3345-4025 ou (47) 3345-2388."),0,0,'L');

            $pdf->Ln();
            $pdf->Cell(195,5,utf8_decode("Com o número do protocolo, você pode acompanhar a posição na fila de espera a qualquer momento através do site"),0,0,'L');

            $pdf->Ln();
            $pdf->Cell(195,5,utf8_decode("da fila única: " . URLROOT),0,0,'L');
                      


            if($error == "" && $pdf->Output())
            {
                $pdf->Output();  
            }
            else{
                $data['erro'] = $error;
                $this->view('relatorios/erroAoGerarRelatorio',$data);
                
            }            
?>


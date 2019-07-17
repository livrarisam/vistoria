<?php 

$pdf->AddPage();
$pdf->Image('images/logo_ci_topo.jpg',80,10,50);
$pdf->Image('images/rodape_email.jpg',10,255,190);

$pdf->SetFont('Arial','B',12);
$pdf->setFillColor(163,183,208);

$pdf->Ln(50);
$pdf->Cell(0,8,utf8_decode("3.$ordem. SISTEMA DE DETECÇÃO E ALARME DE INCÊNDIO: I.T. N°19/2011"),0,0,'C',1);

$pdf->SetFont('Arial','',10);
$pdf->Ln(12);
$pdf->MultiCell(0,6,utf8_decode("Esta instrução técnica estabelece os requisitos mínimos dos sistemas de detecção e alarme de incêndio para edificações e áreas de risco, atendendo ao previsto no Regulamento do Corpo de Bombeiros."),0,'J');

$pdf->Ln(6);
$pdf->Cell(5,6,"a.",0,0);
$pdf->MultiCell(0,6,utf8_decode("Todo o sistema deve ser alimentado por duas fontes de alimentação, sendo a principal a rede de tensão alternada e a auxiliar constituída por baterias ou \"no break\" com autonomia de 24h para regime de supervisão e 15 minutos para regime de alarmes sonoros e visuais. Os mesmos parâmetros devem ser adotados para alimentação auxiliar por gerador;"),0,'J');
$pdf->Cell(5,6,"b.",0,0);
$pdf->MultiCell(0,6,utf8_decode("As centrais de alarme devem possuir dispositivo para testes de indicadores e sinalizadores;"),0,'J');
$pdf->Cell(5,6,"c.",0,0);
$pdf->MultiCell(0,6,utf8_decode("As centrais devem estar localizadas em locais de permanência humana e fácil visualização;"),0,'J');
$pdf->Cell(5,6,"d.",0,0);
$pdf->MultiCell(0,6,utf8_decode("O percurso máximo de qualquer ocupante do imóvel até um acionador manual mais próximo do alarme deve ser de no máximo 30,00m, sendo que preferencialmente os acionadores manuais devem estar locados próximos aos hidrantes;"),0,'J');
$pdf->Cell(5,6,"e.",0,0);
$pdf->MultiCell(0,6,utf8_decode("Nos edifícios com mais de 01 pavimento deve existir pelo menos 01 acionador manual por andar;"),0,'J');

$pdf->Image('images/it19_01.jpg',20,160,50);
$pdf->Image('images/it19_02.jpg',80,170,50);
$pdf->Image('images/it19_03.jpg',150,170,50);

$pdf->Ln(80);
$pdf->Cell(60,8,utf8_decode("DETECTOR DE FUMAÇA"),0,0,'C');
$pdf->Cell(60,8,utf8_decode("CENTRAL DE ALARME"),0,0,'C');
$pdf->Cell(60,8,utf8_decode("SIRENE"),0,0,'C');


$pdf->AddPage();
$pdf->Image('images/logo_ci_topo.jpg',80,10,50);
$pdf->Image('images/rodape_email.jpg',10,255,190);

$starty = 73;
$tamanho = 180;
$it = "19";

include("pdf-irregularidades.php");

$ordem++;
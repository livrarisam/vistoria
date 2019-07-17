<?php 

$pdf->AddPage();
$pdf->Image('images/logo_ci_topo.jpg',80,10,50);
$pdf->Image('images/rodape_email.jpg',10,255,190);

$pdf->SetFont('Arial','B',12);
$pdf->setFillColor(163,183,208);

$pdf->Ln(50);
$pdf->Cell(0,8,utf8_decode("3.$ordem. CONTROLE DE FUMAÇA: I.T. N°15/2018"),0,0,'C',1);

$pdf->SetFont('Arial','',10);
$pdf->Ln(12);
$pdf->MultiCell(0,6,utf8_decode("Esta Instrução Técnica estabelece parâmetros para implementação de sistemas de controle de fumaça, atendendo ao previsto no Decreto Estadual n°{$info['decreto']} - Regulamento de segurança contra incêndio das edificações do Estado de São Paulo."),0,'J');

$pdf->SetFont('Arial','B',12);
$pdf->Ln(12);
$pdf->Cell(0,8,utf8_decode("- Procedimentos"),0,0);
$pdf->SetFont('Arial','',10);
$pdf->Ln(8);
$pdf->Cell(20,6,"",0,0);
$pdf->MultiCell(0,6,utf8_decode("As edificações devem ser dotadas de meios de controle de fumaça que promovem a extração (mecânica ou natural) dos gases e da fumaça do local de origem do incêndio, controlando a entrada de ar (ventilação) e prevenindo a migração de fumaça e gases quentes para as áreas adjacentes não sinistradas."),0,'J');

$pdf->Image('images/it15.jpg',45,150,120);

$pdf->AddPage();
$pdf->Image('images/logo_ci_topo.jpg',80,10,50);
$pdf->Image('images/rodape_email.jpg',10,255,190);

$starty = 73;
$tamanho = 180;
$it = "15";

include("pdf-irregularidades.php");

$ordem++;
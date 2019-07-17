<?php 

$pdf->AddPage();
$pdf->Image('images/logo_ci_topo.jpg',80,10,50);
$pdf->Image('images/rodape_email.jpg',10,255,190);

$pdf->SetFont('Arial','B',12);
$pdf->setFillColor(163,183,208);

$pdf->Ln(50);
$pdf->Cell(0,8,utf8_decode("3.$ordem. Brigada de incêndio: I.T. N°17/2018"),0,0,'C',1);

$pdf->SetFont('Arial','',10);
$pdf->Ln(12);
$pdf->MultiCell(0,6,utf8_decode("Esta Instrução Técnica estabelece parâmetros para controle de Brigada de incêndio, atendendo ao previsto no Decreto Estadual n°{$info['decreto']} - Regulamento de segurança contra incêndio das edificações do Estado de São Paulo."),0,'J');

$starty = 100;
$linha = 4;
$it = "17";

include("pdf-irregularidades.php");

$ordem++;
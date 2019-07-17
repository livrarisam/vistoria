<?php 

$pdf->AddPage();
$pdf->Image('images/logo_ci_topo.jpg',80,10,50);
$pdf->Image('images/rodape_email.jpg',10,255,190);

$pdf->SetFont('Arial','B',12);
$pdf->setFillColor(163,183,208);

$pdf->Ln(50);
$pdf->Cell(0,8,utf8_decode("3.$ordem. Sistemas Elétricos de para raio - IT 41"),0,0,'C',1);

$pdf->SetFont('Arial','',10);
$pdf->Ln(12);
$pdf->MultiCell(0,6,utf8_decode("Esta instrução técnica estabelece os parâmetros para a realização de inspeção visual (básica) das instalações elétricas de para raios das edificações e áreas de risco, atendendo às exigências do Decreto Estadual nº {$info['decreto']}."),0,'J');
$pdf->Ln(4);
$pdf->MultiCell(0,6,utf8_decode("O sistema de proteção contra descargas atmosféricas (SPDA) deve estar em conformidade com a NBR 5419/15."),0,'J');

$starty = 73;
$it = "41";

include("pdf-irregularidades.php");

$ordem++;
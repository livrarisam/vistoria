<?php
$pdf->AddPage();
$pdf->Image('images/logo_ci_topo.jpg',80,10,50);
$pdf->Image('images/rodape_email.jpg',10,255,190);

$pdf->SetFont('Arial','B',12);

$pdf->Ln(50);
$pdf->Cell(0,8,utf8_decode("3.	ADEQUAÇÕES A SEREM REALIZADAS CONFORME INSTRUÇÕES TÉCNICAS VIGENTES"),0,0,'C');

$pdf->setFillColor(163,183,208);
$pdf->Ln(12);
$pdf->Cell(0,8,utf8_decode("3.$ordem.	ACESSO DE VIATURA NA EDIFICAÇÃO E ÁREAS DE RISCO: I.T. N°06/2018"),0,0,'C',1);

$pdf->SetFont('Arial','',10);
$pdf->Ln(12);
$pdf->MultiCell(0,6,utf8_decode("Esta Instrução Técnica tem como objetivo estabelecer e assegurar as condições mínimas para o acesso de viaturas do Corpo de Bombeiros da Polícia Militar do Estado de São Paulo à edificação e a todas as suas áreas de risco, visando a segurança, previamente estabelecida no Decreto Estadual n° {$info['decreto']} - Regulamento de segurança contra incêndio das edificações de risco do Estado de São Paulo."),0,'J');

$pdf->Image('images/it06.jpg',65,120,90);

$pdf->AddPage();
$pdf->Image('images/logo_ci_topo.jpg',80,10,50);
$pdf->Image('images/rodape_email.jpg',10,255,190);

$starty = 73;
$tamanho = 180;
$it = "06";

include("pdf-irregularidades.php");

$ordem++;
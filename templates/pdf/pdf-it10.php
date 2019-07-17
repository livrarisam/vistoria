<?php 

$pdf->AddPage();
$pdf->Image('images/logo_ci_topo.jpg',80,10,50);
$pdf->Image('images/rodape_email.jpg',10,255,190);

$pdf->SetFont('Arial','B',12);
$pdf->setFillColor(163,183,208);

$pdf->Ln(50);
$pdf->Cell(0,8,utf8_decode("3.$ordem. CONTROLE DE MATERIAIS DE ACABAMENTO E REVESTIMENTO: I.T. N°10/2018"),0,0,'C',1);

$pdf->SetFont('Arial','',10);
$pdf->Ln(12);
$pdf->MultiCell(0,6,utf8_decode("Esta Instrução Técnica tem por objetivo estabelecer as condições a serem atendidas pelos materiais de acabamento e de revestimento empregados nas edificações, para restringirem a propagação de fogo e o desenvolvimento de fumaça, atendendo ao previsto no Decreto Estadual n°{$info['decreto']} - Regulamento de segurança contra incêndio das edificações a áreas de risco do Estado de São Paulo."),0,'J');

$starty = 110;
$linha = 2;
$tamanho = 155;
$it = "10";

include("pdf-irregularidades.php");

$ordem++;
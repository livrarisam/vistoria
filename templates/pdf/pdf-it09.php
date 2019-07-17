<?php

$pdf->AddPage();
$pdf->Image('images/logo_ci_topo.jpg',80,10,50);
$pdf->Image('images/rodape_email.jpg',10,255,190);

$pdf->SetFont('Arial','B',12);
$pdf->setFillColor(163,183,208);

$pdf->Ln(50);
$pdf->Cell(0,8,utf8_decode("3.$ordem. COMPARTIMENTAÇÃO VERTICAL: I.T. N°09/2018"),0,0,'C',1);

$pdf->SetFont('Arial','',10);
$pdf->Ln(12);
$pdf->MultiCell(0,6,utf8_decode("Esta Instrução Técnica tem por objetivo estabelecer as condições a serem atendidas para a compartimentação horizontal e a compartimentação vertical do Decreto n°{$info['decreto']} - Regulamento de segurança contra incêndio do Estado de São Paulo."),0,'J');

$pdf->SetFont('Arial','B',10);
$pdf->Ln(6);
$pdf->Cell(0,8,utf8_decode("3.$ordem.1. ELEMENTOS DE COMPARTIMENTAÇÃO: "),0,0,'C');

$pdf->Ln(8);
$pdf->Cell(90,10,utf8_decode("Paredes corta-fogo"),0,0,'C');
$pdf->Cell(90,10,utf8_decode("Portas corta-fogo"),0,0,'C');

$pdf->Image('images/it09_01.jpg',10,115,90);
$pdf->Image('images/it09_02.jpg',105,115,90);

$pdf->Ln(70);
$pdf->Cell(90,10,utf8_decode("Vedadores corta-fogo"),0,0,'C');
$pdf->Cell(90,10,utf8_decode("Registros corta-fogo"),0,0,'C');

$pdf->Image('images/it09_03.jpg',10,185,90);
$pdf->Image('images/it09_04.jpg',105,185,90);

$pdf->AddPage();
$pdf->Image('images/logo_ci_topo.jpg',80,10,50);
$pdf->Image('images/rodape_email.jpg',10,255,190);

$pdf->SetFont('Arial','B',10);

$pdf->Ln(50);
$pdf->Cell(90,10,utf8_decode("Selos corta-fogo"),0,0,'C');
$pdf->Cell(90,10,utf8_decode("Cortina corta-fogo"),0,0,'C');

$pdf->Image('images/it09_05.jpg',10,70,90);
$pdf->Image('images/it09_06.jpg',105,70,90);

$pdf->Ln(90);
$pdf->Cell(90,10,utf8_decode("Afastamento horizontal entre aberturas"),0,0,'C');
$pdf->Cell(90,10,utf8_decode("Entrepisos não inflamáveis"),0,0,'C');

$pdf->Image('images/it09_07.jpg',10,165,90);
$pdf->Image('images/it09_08.jpg',105,165,90);

$pdf->AddPage();
$pdf->Image('images/logo_ci_topo.jpg',80,10,50);
$pdf->Image('images/rodape_email.jpg',10,255,190);

$starty = 73;
$tamanho = 180;
$it = "09";

include("pdf-irregularidades.php");

$ordem++;
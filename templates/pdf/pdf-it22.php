<?php 

$pdf->AddPage();
$pdf->Image('images/logo_ci_topo.jpg',80,10,50);
$pdf->Image('images/rodape_email.jpg',10,255,190);

$pdf->SetFont('Arial','B',12);
$pdf->setFillColor(163,183,208);

$pdf->Ln(50);
$pdf->Cell(0,8,utf8_decode("3.$ordem.	SISTEMA DE PROTEÇÃO POR EXTINTORES DE INCÊNDIO: I.T. N°22/2011"),0,0,'C',1);

$pdf->SetFont('Arial','',10);
$pdf->Ln(12);
$pdf->MultiCell(0,6,utf8_decode("Esta instrução técnica estabelece as condições necessárias exigíveis para o dimensionamento, instalação, manutenção, aceitação e manuseio, bem como as características dos componentes do sistema de hidrantes para uso exclusivo do Combate a Incêndio em edificações e áreas de risco, atendendo ao previsto no Regulamento do Corpo de Bombeiros. A composição dos hidrantes deve atender aos seguintes critérios de instalação:"),0,'J');

$pdf->Image('images/it22_01.jpg',10,110,80);
$pdf->Image('images/it22_02.jpg',110,110,80);


$pdf->AddPage();
$pdf->Image('images/logo_ci_topo.jpg',80,10,50);
$pdf->Image('images/rodape_email.jpg',10,255,190);

$pdf->Ln(50);
$pdf->Cell(0,8,utf8_decode("As mangueiras devem estar acondicionadas nas caixas dos hidrantes em uma das maneiras exemplificadas abaixo:"),0,0);
$pdf->Image('images/it22_03.jpg',10,70,190);

$pdf->Ln(95);
$pdf->MultiCell(0,6,utf8_decode("Detalhe de alguns dos itens que devem ser observados periodicamente, pois são de suma importância para o bom funcionamento do sistema de hidrante:"),0,'J');

$pdf->Image('images/it22_04.jpg',30,170,140);

$pdf->AddPage();
$pdf->Image('images/logo_ci_topo.jpg',80,10,50);
$pdf->Image('images/rodape_email.jpg',10,255,190);

$starty = 73;
$tamanho = 180;
$it = "22";

include("pdf-irregularidades.php");

$ordem++;
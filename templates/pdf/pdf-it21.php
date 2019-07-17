<?php 

$pdf->AddPage();
$pdf->Image('images/logo_ci_topo.jpg',80,10,50);
$pdf->Image('images/rodape_email.jpg',10,255,190);

$pdf->SetFont('Arial','B',12);
$pdf->setFillColor(163,183,208);

$pdf->Ln(50);
$pdf->Cell(0,8,utf8_decode("3.$ordem.	SISTEMA DE PROTEÇÃO POR EXTINTORES DE INCÊNDIO: I.T. N°21/2011"),0,0,'C',1);

$pdf->SetFont('Arial','',10);
$pdf->Ln(12);
$pdf->MultiCell(0,6,utf8_decode("Esta instrução técnica estabelece os critérios para proteção contra incêndio em edificações e áreas de risco por meio de extintores de incêndio (portáteis ou sobre rodas), para o combate a princípios de incêndio, atendendo às exigências do Regulamento do Corpo de Bombeiros."),0,'J');
$pdf->Ln(4);
$pdf->MultiCell(0,6,utf8_decode("Os extintores portáteis devem atender às especificações a seguir: "),0,'J');
$pdf->Ln(6);
$pdf->Cell(5,6,"a.",0,0);
$pdf->MultiCell(0,6,utf8_decode("É proibido acondicionar materiais e/ou utensílios junto aos extintores, obstruindo sua plena utilização."),0,'J');
$pdf->Cell(5,6,"b.",0,0);
$pdf->MultiCell(0,6,utf8_decode("Os extintores devem ser remanejados para locais prescritos no Projeto, visando à segurança do local e o devido atendimento à legislação vigente, Decreto {$info['decreto']};"),0,'J');
$pdf->Cell(5,6,"c.",0,0);
$pdf->MultiCell(0,6,utf8_decode("Atentar-se às especificações e instruções que garantem a certificação do equipamento, sendo obrigatórios os itens relacionados abaixo:"),0,'J');

$pdf->Ln(95);
$pdf->Image('images/it21.jpg',30,135,150);
$pdf->Cell(5,6,"d.",0,0);
$pdf->MultiCell(0,6,utf8_decode("Deve-se verificar periodicamente a validade da carga de todos os extintores portáteis e providenciar a recarga com empresa especializada. Cabe ressaltar que a validade dos extintores é anual, porém, não obstante a esta verificação rotineira, deve-se atentar ao manômetro do equipamento, pois se estiver acusando perda de pressão, o mesmo deve ser recarregado imediatamente."),0,'J');

$pdf->AddPage();
$pdf->Image('images/logo_ci_topo.jpg',80,10,50);
$pdf->Image('images/rodape_email.jpg',10,255,190);

$pdf->SetFont('Arial','B',12);
$pdf->setFillColor(163,183,208);

$starty = 73;
$tamanho = 180;
$it = "21";

include("pdf-irregularidades.php");

$ordem++;